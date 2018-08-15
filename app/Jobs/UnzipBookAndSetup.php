<?php

namespace App\Jobs;

use App\Book;
use App\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use ZipArchive;

class UnzipBookAndSetup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Book
     */
    public $book;

    /**
     * Create a new job instance.
     *
     * @param Book $book
     */
    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->book->isMobi()) {
            $file = $this->convertMobiToEpub($this->book->file);
        } else {
            $file = $this->book->file;
        }
        $zip = new ZipArchive;
        $storageFolder = storage_path('app/public/') . $this->book->md5;
        $publicFolder = public_path('books/') . $this->book->md5;
        if ($zip->open($file) === true) {
            $zip->extractTo($storageFolder);
            $zip->extractTo($publicFolder);
            $zip->close();
            $this->setup();
        } else {
            \Log::error('解压出错', ['book_id' => $this->book->id]);
        }
    }

    protected function convertMobiToEpub($file)
    {
        $epubFile = storage_path('app/epubs/') . $this->book->md5 . '.epub';
        $cmd = env('EBOOK_CONVERT') . ' ' . $file . ' ' . $epubFile;
        exec($cmd, $output, $return);
        \Log::info(__FUNCTION__, [$cmd, $output, $return]);
        if ($return) {
            return '';
        }

        return $epubFile;
    }

    protected function setup()
    {
        $containerXml = storage_path('app/public/') . $this->book->md5 . '/META-INF/container.xml';
        if (!file_exists($containerXml)) {
            \Log::error('container.xml 不存在', ['book_id' => $this->book->id]);
        }
        $result = $this->parseTocAndSavePages();
        if ($result) {
            $this->removePagesInPublicFolder();
            $this->updateBookCover();
            $this->updateBookStatus();
        }
    }

    protected function getRootFile()
    {
        $containerXml = storage_path('app/public/') . $this->book->md5 . '/META-INF/container.xml';
        //这里比较特殊
        $dirName = dirname(dirname($containerXml));
        $xmlArray = $this->getArrayFromXml($containerXml);
        if (!isset($xmlArray['rootfiles']['rootfile']['@attributes']['full-path'])) {
            \Log::error('container.xml 没有 root file', [
                'book_id' => $this->book->id,
                'container.xml' => $xmlArray
            ]);
        } else {
            return $dirName . '/' . $xmlArray['rootfiles']['rootfile']['@attributes']['full-path'];
        }
    }

    protected function getTocFile()
    {
        $rootFile = $this->getRootFile();
        \Log::error('rootFile', [$rootFile]);
        if (!$rootFile) {
            return;
        }
        $dirName = dirname($rootFile);
        $xmlArray = $this->getArrayFromXml($rootFile);
        if (!isset($xmlArray['manifest']['item'])) {
            \Log::error('content.ofp 没有 manifest/item', [
                'book_id' => $this->book->id,
                'ofp' => $xmlArray
            ]);
        }
        $toc = '';
        foreach ($xmlArray['manifest']['item'] as $item) {
            if (isset($item['@attributes']['id'])
                && $item['@attributes']['id'] == 'ncx'
            ) {
                $toc = $dirName . '/' . $item['@attributes']['href'];
            }
        }

        return $toc;
    }

    protected function parseTocAndSavePages()
    {
        $toc = $this->getTocFile();
        $dirName = dirname($toc);
        if (!$toc) {
            return false;
        }
        $xmlArray = $this->getArrayFromXml($toc);
        if (isset($xmlArray['navMap']['navPoint'])) {
            $navPoint = $xmlArray['navMap']['navPoint'];
            $this->getPageFromNavPoint($navPoint, $dirName);

            return true;
        } else {
            \Log::error('navMap/navPoint 不存在', ['book_id' => $this->book->id, 'xmlArray' => $xmlArray]);

            return false;
        }
    }

    protected function getPageFromNavPoint(array $navPoint, $dirName)
    {
        foreach ($navPoint as $point) {
            if (isset($point['content']['@attributes']['src']) &&
                isset($point['navLabel']['text'])
            ) {
                $pagePath = $point['content']['@attributes']['src'];
                $pageRealPath = $dirName . '/' . $pagePath;
                $pageRealFile = strtok($pageRealPath, "#");
                if (!file_exists($pageRealFile)) {
                    continue;
                }
                $pageRelativePath = str_replace(storage_path('app/public/') . $this->book->md5 . '/', '',
                    $pageRealPath);
                $this->savePage(
                    $pageRelativePath,
                    $point['navLabel']['text']
                );
                if (isset($point['navPoint'])) {
                    $this->getPageFromNavPoint($point['navPoint'], $dirName);
                }
            } else {
                \Log::error('url 或 title 不存在', ['book_id' => $this->book->id]);
            }
        }
    }

    protected function savePage($url, $title)
    {
        if (Page::whereBookId($this->book->id)->whereUrl($url)->exists()) {
            return;
        }
        $hash = '';
        if (strpos($url, '#') !== false) {
            list($url, $hash) = explode('#', $url);
        }
        $page = new Page();
        $page->url = $url;
        $page->url_hash = $hash;
        $page->title = $title;
        $page->book_id = $this->book->id;
        $page->save();
    }

    protected function removePagesInPublicFolder()
    {
        $pages = Page::whereBookId($this->book->id)
            ->get();
        /** @var Page $page */
        foreach ($pages as $page) {
            $file = public_path('books/') . $this->book->md5 . '/' . $page->url;
            $file = strtok($file, "#");
            @unlink($file);
        }
    }

    protected function getBookCover()
    {
        $cover = '';
        $rootFile = $this->getRootFile();
        $dirName = dirname($rootFile);
        $xmlArray = $this->getArrayFromXml($rootFile);

        if (!isset($xmlArray['metadata']['meta'])) {
            \Log::error('content.ofp 没有 metadata', [
                'book_id' => $this->book->id,
                'ofp' => $xmlArray
            ]);

            return $cover;
        }
        $coverId = '';
        foreach ($xmlArray['metadata']['meta'] as $meta) {
            if (isset($meta['@attributes']['name'])
                && $meta['@attributes']['name'] == 'cover'
            ) {
                $coverId = $meta['@attributes']['content'];
            }
        }
        if (!$coverId) {
            \Log::error('content.ofp meta 里面没有 cover', [
                'book_id' => $this->book->id,
                'ofp' => $xmlArray
            ]);

            return $cover;
        }

        if (!isset($xmlArray['manifest']['item'])) {
            \Log::error('content.ofp 没有 manifest/item', [
                'book_id' => $this->book->id,
                'ofp' => $xmlArray
            ]);

            return $cover;
        }
        foreach ($xmlArray['manifest']['item'] as $item) {
            if (isset($item['@attributes']['id'])
                && $item['@attributes']['id'] == $coverId
            ) {
                $cover = $item['@attributes']['href'];
            }
        }
        if (!$cover) {
            \Log::error('manifest/item 里面没有 coverId', [
                'coverId' => $coverId,
                'book_id' => $this->book->id,
                'ofp' => $xmlArray
            ]);

            return $cover;
        }

        $cover = $dirName . '/' . $cover;
        $cover = '/books/' . str_replace(storage_path('app/public/'), '', $cover);

        return $cover;
    }

    public function updateBookCover()
    {
        $cover = $this->getBookCover();
        if ($cover) {
            $this->book->image = $cover;
            $this->book->save();
        }
    }

    public function getArrayFromXml($file)
    {
        $xmlString = file_get_contents($file);
        $xmlObject = simplexml_load_string($xmlString);

        return $this->objectsIntoArray($xmlObject);
    }

    public function objectsIntoArray($arrObjData, $arrSkipIndices = array())
    {
        $arrData = array();

        // if input is object, convert into array
        if (is_object($arrObjData)) {
            $arrObjData = get_object_vars($arrObjData);
        }

        if (is_array($arrObjData)) {
            foreach ($arrObjData as $index => $value) {
                if (is_object($value) || is_array($value)) {
                    $value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call
                }
                if (in_array($index, $arrSkipIndices)) {
                    continue;
                }
                $arrData[$index] = $value;
            }
        }

        return $arrData;
    }

    public function updateBookStatus()
    {
        $this->book->status = Book::STATUS_SUCCESS;
        $this->book->save();
    }
}
