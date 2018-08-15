<?php namespace App\Lib;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class WechatPostSpider
{
    /**
     * @var Crawler|null
     */
    protected $crawler;

    /**
     * @param Client $client
     * @param $url
     */
    public function __construct(Client $client, $url)
    {
        $this->crawler = $client->request('GET', $url);
    }

    public function getUsername()
    {
        $username = $this->crawler->filter('.profile_meta .profile_meta_value')->text();
        if (!$username) {
            $content = $this->crawler->text();
            preg_match('/var user_name = "(.*?)";/', $content, $matches);
            $username =  isset($matches[1]) ? $matches[1] : '';
        }
        return $username;
    }

    public function getAuthor()
    {
        return $this->crawler->filter('#post-date')->nextAll()->text();
    }

    public function getNickname()
    {
        return $this->crawler->filter('.profile_nickname')->text();
    }

    public function getCover()
    {
        $content = $this->crawler->text();
        preg_match('/var msg_cdn_url = "(.*?)";/', $content, $matches);

        return isset($matches[1]) ? $matches[1] : '';
    }


    /**
     * @return string
     */
    public function getTitle()
    {
        return trim($this->crawler->filter('title')->text());
    }

    public function getContentHtml()
    {
        return trim($this->crawler->filter('.rich_media_content')->html());
    }

    /**
     * @return string
     */
    public function getContentText()
    {
        return trim($this->crawler->filter('.rich_media_content')->text());
    }

    /**
     * @return string
     */
    public function getCreateTime()
    {
        $createTime = $this->crawler->filter('#post-date')->text();
        if (!$createTime) {
            return null;
        }

        return $createTime;
    }

    public function getDigest()
    {
        $content = $this->crawler->text();
        preg_match('/var msg_desc = \"(.*)\"/', $content, $matches);
        if (isset($matches[1])) {
            return html_entity_decode($matches[1]);
        }

        return null;
    }

    public function getAccountImage()
    {
        $content = $this->crawler->text();
        preg_match('/var ori_head_img_url = "(.*?)";/', $content, $matches);

        return isset($matches[1]) ? $matches[1] : '';
    }

    public function getAccountDescription()
    {
        return $this->crawler
            ->filter('.profile_meta')
            ->nextAll()
            ->filter('.profile_meta_value')
            ->text();
    }

    public function getUrl()
    {
        return $this->crawler->getUri();
    }

    public function getHtml()
    {
        return $this->crawler->filter('#js_article')
            ->html();
    }

    public function getBiz()
    {
        $content = $this->crawler->text();
        preg_match('/var appuin = "(.*?)"/', $content, $matches);

        return isset($matches[1]) ? $matches[1] : '';
    }
}