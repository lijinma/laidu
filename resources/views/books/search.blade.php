@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row">
            <form class="search-form">
                <div class="col-md-2 col-md-offset-1">
                    <div class="form-group">
                        <select class="form-control h50" name="book">
                            <option value=0>全部书籍</option>
                            @foreach($books as $book)
                                <option @if($book->md5 == app('request')->get('book')) selected="selected" @endif value="{{ $book->md5 }}">{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control h50" name="query" placeholder="关键字..." value="{{ $q }}">
                        <span class="input-group-btn"><button class="btn btn-primary h50"
                                                              type="submit"><i class="fa fa-search"
                                                                               aria-hidden="true"></i>
搜索</button></span>
                    </div>
                </div>
            </form>
        </div>
        @if($q)
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default list-panel search-results">
                        <div class="panel-heading">
                            <h3 class="panel-title ">
                                <i class="fa fa-search"></i> 关于 “<span class="highlight">{{ $q }}</span>” 的搜索结果,
                                共 {{ $pages->total() }} 条
                            </h3>
                        </div>

                        <div class="panel-body ">
                            @foreach($pages as $page)
                                <div class="result">
                                    <h2 class="title">
                                        <a href="/books/{{$page->book->md5}}/{{ $page->url }}" target="_blank">
                                            @if (isset($page->highlight['title']))
                                                @foreach ($page->highlight['title'] as $item)
                                                    {!! $item !!}
                                                @endforeach
                                            @else
                                                {{ $page->title }}
                                            @endif
                                        </a>
                                    </h2>
                                    <div class="info">
                                        <span class="label label-primary">《{{ $page->book->title }}》</span>
                                    </div>
                                    <div class="desc">
                                        @if (isset($page->highlight['content']))
                                            @foreach ($page->highlight['content'] as $item)
                                                ......{!! $item !!}......
                                            @endforeach
                                        @else
                                            {{ mb_substr($page->content, 0, 150) }}......
                                        @endif
                                    </div>
                                    <hr>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    {{ $pages->links() }}
                </div>
            </div>
        @endif
        <br>
        @if(!$q)
            <div class="row">
                <?php $books = $books->slice(0, 18) ?>
                @include('layouts.partials.items')
                    <div class="col-md-12">
                        <h5 class="text-center"><a href="/books/all">全部书籍</a></h5>
                    </div>
            </div>
        @endif
    </div>
@endsection
