@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                @include('layouts.partials.errors')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="/books/public" class="btn {{Request::get('chosen') ? 'btn-default' : 'btn-primary' }}">全部免费电子书</a>
                <a href="/books/public?chosen=1" class="btn {{Request::get('chosen') ? 'btn-primary' : 'btn-default' }}">我选择的免费电子书</a>
                <br>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    @foreach($books as $book)
                        <div class="col-md-2 col-xs-6">
                            <div class="thumbnail">
                                <div class="box" style="background-image:url('{{ $book->image }}');">
                                </div>
                                <div class="caption">
                                    <span class="label label-success">{{ \App\Book::TYPE_LABELS[$book->type] }}</span>
                                    <h4 class="title">{!! $book->title !!}</h4>
                                    @if(in_array($book->id, $userBookIds))
                                        <p>
                                            <a href="/books/{!! $book->md5 !!}/index"
                                               class="btn btn-sm btn-primary" role="button">
                                                立即阅读
                                            </a>
                                            <a href="/search"
                                               class="btn btn-sm btn-success" role="button">
                                                搜索
                                            </a>
                                        </p>
                                    @else
                                        <p>
                                            <a class="btn btn-sm btn-primary" href="/books/add/{!! $book->md5 !!}"
                                               onclick="return confirm('你确定要添加《{{ $book->title }}》吗？添加后可以在搜索结果中出现')">
                                                选择
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $books->links() }}
            </div>
        </div>
    </div>
@endsection
