@extends('layouts.book')
@section('title')
    <h1><a href="/search" style="color: #000;">返回来读</a></h1>
    <h2>《{{ $book->title }}》</h2>
@endsection
@section('summary')
    <?php $i = 0; ?>
    @foreach($book->pages as $page)
        <?php $i++; $url = $page->url_hash ? $page->url .'#' . $page->url_hash : $page->url ?>
        <li class="chapter @if($page->id == $currentPage->id)active @endif" data-level="1.{{ $i }}" data-path="{{ $url }}">
            <i class="fa fa-check"></i>
            <a href="/books/{{ $book->md5 . '/' . $url }}">
                {{ $page->title }}
            </a>
        </li>
    @endforeach
@endsection
@section('book_header')
    <a class="btn pull-right" style="color:#1995dc;" href="/">返回来读</a>
    <h1>
        <i class="fa fa-circle-o-notch fa-spin"></i>
        <a href="{{ $currentPage->url }}">{{ $currentPage->title }}</a>
    </h1>
@endsection
@section('book_body')
    <?php
    $body = file_get_contents(storage_path() . '/app/public/' . $book->md5 . '/' . $currentPage->url);
    if ($book->isWechat()) {
        $body = str_replace('http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl=', '/image?url=', htmlspecialchars_decode($body));
        $body = str_replace('data-src="', 'src="/image?url=', $body);
        $body = str_replace('src="/image?url=https://v.qq.com/', 'src="https://v.qq.com/', $body);
        $body = str_replace('document.write', 'function()', $body);
        $body = str_replace('<iframe', '<iframe_fake', $body);
        $body = str_replace('<iframe_fake class="video_iframe"', '<iframe class="video_iframe"', $body);
    }
    //echo preg_replace('/<link .*? type=\"text\/css\"\/>/', '', $body);
    echo $body;
    ?>
@endsection
@section('nav')
    @if($previousPage)
        <!-- previous page -->
        <a href="/books/{{ $book->md5 . '/' . $previousPage->url }}" class="navigation navigation-prev " aria-label="Previous page: {{ $previousPage->title }}">
            <i class="fa fa-angle-left"></i>
        </a>
    @endif

    @if($nextPage)
        <!-- next page -->
        <a href="/books/{{ $book->md5 . '/' .  $nextPage->url }}" class="navigation navigation-next navigation-unique"
           aria-label="Next page: {{ $nextPage->title }}">
            <i class="fa fa-angle-right"></i>
        </a>
    @endif
@endsection