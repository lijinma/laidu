<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>笑来书</title>

    <!-- Bootstrap Core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="/css/freelancer.min.css" rel="stylesheet">
    <link href="/css/book.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">
<div id="screen">
    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <a class="navbar-brand" href="#page-top">《通往财富自由之路》留言成就榜</a>
            </div>
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container" id="maincontent" tabindex="-1">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive avatar" src="/images/jinma.jpg" alt=""
                         style="max-width: 150px;">
                    <div class="intro-text">
                        <h1>金马</h1>
                        <h2>总计留言 100 条</h2>
                        <h2>总计留言 100000 字</h2>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>

<div id="screen-img"></div>
<!-- Footer -->
<footer class="text-center">
    <div class="footer-below">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    Copyright &copy; 来读 2016
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
<div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
    <a class="btn btn-primary" href="#page-top">
        <i class="fa fa-chevron-up"></i>
    </a>
</div>
<script src="http://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- Theme JavaScript -->
<script src="/js/freelancer.min.js"></script>
<script src="/js/dom-to-image.min.js"></script>
<script src="/js/html2canvas.min.js"></script>
<script>
    $(function () {
//        var node = $('#screen').get(0);
//        domtoimage.toPng(node)
//            .then(function (dataUrl) {
//                var img = new Image();
//                img.src = dataUrl;
//                $('#screen-img').append(img);
//                $('#screen').hide();
//            })
//            .catch(function (error) {
//                console.error('oops, something went wrong!', error);
//            });
        html2canvas($('#screen').get(0), {
            onrendered: function(canvas) {
                var image = new Image();
                image.src = canvas.toDataURL("image/png"); // This should be image/png as browsers (only) support it (to biggest compatibilty)
                $('#screen-img').append(image);
                $('#screen').hide();
                // Append image (yes, it is a DOM element!) to the DOM and etc here..
            }
        });
    });
</script>

</body>

</html>
