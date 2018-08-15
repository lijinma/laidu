@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('flash::message')
                @include('layouts.partials.errors')
                {!! Form::open(['method' => 'post', 'files' => true, 'id' => 'upload_form']) !!}
                <div class="form-group">
                    <label for="title"><span class="text-danger">[必填]</span> 书籍名称（填写后不可修改）:</label>
                    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => '...']) !!}
                </div>
                <div class="form-group">
                    <label for="book"><span class="text-danger">[必选]</span> Epub 或 Mobi 文件:</label>
                    <input name="book" type="file">
                    <p class="help-block">1. 只有 .epub 和 mobi 格式的文件才能上传</p>
                    <p class="help-block">2. 文件不超过 10 M</p>
                </div>
                <!-- 提交 Form Input -->
                <div class="form-group">
                    {!! Form::button('提交', ['class' => 'btn btn-primary', 'id' => 'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="//cdn.bootcss.com/bootstrap-fileinput/4.3.5/css/fileinput.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="//cdn.bootcss.com/bootstrap-fileinput/4.3.5/js/fileinput.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap-fileinput/4.3.5/js/locales/zh.min.js"></script>
    <script>
        $(document).ready(function () {
            var title = $('input[name=title]').val();
            $("input[name=book]").fileinput({
                language: "zh",
                uploadUrl: "/books/create",
                allowedFileExtensions: ["epub", "mobi"],
                maxFileCount: 1,
                maxFileSize: 10240,
                showUploadedThumbs: false,
                allowedPreviewTypes: null,
                initialPreviewShowDelete: false,
                showUpload: false,
                dropZoneEnabled: false,
                uploadExtraData: function () {
                    return {
                        'title': $('input[name=title]').val(),
                        '_token': '{{csrf_token()}}'
                    }
                }
            });
            $('#submit').click(function (e) {
                var title = $('input[name=title]').val();
                if (!title) {
                    alert('请填写"书籍名称"');
                    e.preventDefault();
                    return
                }
                var file = $('input[name=book]').val();
                if (!file) {
                    alert('请选择 Epub 或者 Mobi 文件');
                    e.preventDefault();
                    return
                }
                $("input[name=book]").fileinput('upload');
            });
            $("input[name=book]").on("fileuploaded", function (event, data, previewId, index) {
                window.location.replace("/search");
            });
        });

    </script>
@endsection