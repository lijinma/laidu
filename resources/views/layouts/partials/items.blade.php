<div class="col-md-12">
    <div class="row">
        @if($books->isEmpty())
            <p class="text-center"> 你还没有任何书籍，你可以<a href="/books/create">手动上传</a>，或者<a href="/books/public">选择免费书籍</a></p>
        @endif
        @foreach($books as $book)
            <div class="col-md-2 col-xs-6">
                <div class="thumbnail">
                    <div class="box" style="background-image:url('{{ $book->image }}');">
                    </div>
                    <div class="caption">
                        <span class="label label-success">{{ \App\Book::TYPE_LABELS[$book->type] }}</span>
                        <h4>{!! $book->title !!}</h4>
                        <p>
                            @if($book->isStatusSuccess())
                                <a href="/books/{!! $book->md5 !!}/index"
                                   class="btn btn-sm btn-primary" role="button">
                                    立即阅读
                                </a>
                                <a class="btn btn-sm btn-danger pull-right" href="/books/remove/{!! $book->md5 !!}"
                                   onclick="return confirm('你确定要删除《{{ $book->title }}》吗？')">
                                    删除
                                </a>
                            @else
                                <button class="btn btn-sm btn-danger">正在处理...</button>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>