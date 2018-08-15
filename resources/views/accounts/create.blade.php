@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-info">
                    <p class="text-danger">每人可以提交 10 个公众号，已经存在的公众号不用重复提交，请珍惜你的 10 次提交机会</p>
                </div>
                @include('flash::message')
                @include('layouts.partials.errors')
                {!! Form::open(['method' => 'post']) !!}
                <div class="form-group">
                    <label for="nickname"><span class="text-danger">[必填]</span> 公众号名称:</label>
                    {!! Form::text('nickname', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => '学习学习再学习']) !!}
                </div>
                <div class="form-group">
                    <label for="post_content_url"><span class="text-danger">[必填]</span> 公众号任意一篇文章地址:</label>
                    {!! Form::textarea('post_content_url', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'http://...']) !!}
                </div>
                <!-- 提交 Form Input -->
                <div class="form-group">
                    {!! Form::submit('提交', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection