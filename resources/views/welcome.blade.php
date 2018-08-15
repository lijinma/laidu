<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>来读 - 你的私人图书搜索引擎</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/landpage.css?1492588676" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
<nav id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
        <li class="sidebar-brand">
            <a href="/">来读</a>
        </li>
        <li>
            <a href="/users/plans" onclick=$("#menu-close").click();>会员服务</a>
        </li>
        @if (!Auth::guest())
            <li>
                <a href="/search" onclick=$("#menu-close").click();>搜索书籍</a>
            </li>
        @else
            <li>
                <a href="/register" onclick=$("#menu-close").click();>注册</a>
            </li>
            <li>
                <a href="/login" onclick=$("#menu-close").click();>登录</a>
            </li>
        @endif
        <li>
            <a href="#about" onclick=$("#menu-close").click();>为什么使用「来读」？</a>
        </li>
        <li>
            <a href="#services" onclick=$("#menu-close").click();>你可以</a>
        </li>
        <li>
            <a href="#portfolio" onclick=$("#menu-close").click();>如何理解这个产品</a>
        </li>
        <li>
            <a href="#contact" onclick=$("#menu-close").click();>关于我们</a>
        </li>
    </ul>
</nav>

<!-- Header -->
<header id="top" class="header">
    <div class="text-vertical-center">
        <h1>快速搭建你的个人知识体系</h1>
        <br>
        <h3>给自己一个图书馆，提高输入质量，成为一个知识创造者</h3>
        <br>
        <h3>「来读」——你的私人图书搜索引擎</h3>
        <br>
        <a href="/register" class="btn btn-lg btn-light">立即注册</a><a href="/login" class="btn btn-lg btn-dark">登陆</a>
    </div>
</header>

<!-- About -->
<section id="about" class="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>你是否也有这样的苦恼？</h3>
                <hr class="small">
                <h4>读了那么多书，可是却想不起来喜欢的故事出现在哪本书的哪个章节？</h4>
                <h4>看了那么多微信公众号文章，可是某个片段却再也找不回来？</h4>
                <h4>微信公众号的文章只能零散的阅读吗？</h4>
                <h4>...</h4>
                <a href="#services" class="btn btn-dark btn-lg">「来读」帮你解决上面的苦恼</a>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Services -->
<!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
<section id="services" class="services bg-primary">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-10 col-lg-offset-1">
                <h2>你可以</h2>
                <hr class="small">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-cloud-upload fa-stack-1x text-primary"></i>
                            </span>
                            <h4>
                                <strong>上传书籍</strong>
                            </h4>
                            <p>支持 Epub 和 Mobi 格式，打造永久的私人图书馆</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="service-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-book fa-stack-1x text-primary"></i>
                            </span>
                            <h4>
                                <strong>阅读书籍</strong>
                            </h4>
                            <p>使用 GitBook 高效阅读每一本书籍</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-weixin fa-stack-1x text-primary"></i>
                            </span>
                            <h4>
                                <strong>阅读微信公众号</strong>
                            </h4>
                            <p>每一个微信公众号都是一本书，每一篇文章都是一个章节</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-search fa-stack-1x text-primary"></i>
                            </span>
                            <h4>
                                <strong>搜索</strong>
                            </h4>
                            <p>一个"关键字"就可以把书籍和微信公众号相关的内容完全检索出来</p>
                        </div>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Callout -->
<aside class="callout">
    <div class="text-vertical-center btn-dark">
        <h1>送给"李笑来"老师</h1>
    </div>
</aside>

<!-- Portfolio -->
<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <h2>如何理解这个产品</h2>
                <hr class="small">
                <div class="row">
                    <div class="col-md-6">
                        <div class="portfolio-item-1">
                            <div class="text-vertical-center btn-dark">
                                <h1>升级版"笑来搜"</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="portfolio-item-2">
                            <div class="text-vertical-center btn-dark">
                                <h1>Mac 上的 Spotlight</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="portfolio-item-3">
                            <div class="text-vertical-center btn-dark">
                                <h1>Windows 上的 Everything</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="portfolio-item-4">
                            <div class="text-vertical-center btn-dark">
                                <h1>微信公众号文章任你搜</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Call to Action -->
<aside class="call-to-action bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>不要错过，现在使用"邀请码"注册，可以免费体验1个月会员服务</h3>
                <a href="/register" class="btn btn-lg btn-light">注册</a>
                <a href="/login" class="btn btn-lg btn-dark">登录</a>
            </div>
        </div>
    </div>
</aside>

<section class="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>灵感来源</h2>
                <p class="lead text-left">李笑来老师在《七年就是一辈子》中写过一篇文章 <a href="http://zhibimo.com/read/xiaolai/reborn-every-7-years/A30.html">什么是更好的知识？</a>中这样说：</p>
                <blockquote class="lead text-left">在硬盘越来越大越来越便宜，云存储满天飞的时代里，“博闻”更重要，“强识”却早已不再是什么优势了。</blockquote>
                <blockquote class="lead text-left">我已经有很长的时间读书不写笔记了。为什么？因为有更大的硬盘了，有无限大的云存储了，更为关键的是 MacOS 有系统级内嵌的全文检索功能。于是，我尽量只买电子书，然后转换成 epub 格式存在硬盘里。读书的时候专心读，有用的地方刻意记住几个关键字，将来用得到的时候，全文检索一下，就可以轻松找到出处 —— 当然也有偶尔死活想不起来关键字要隔上好几天才想起来的情况…… 随着时间的推移，写上一两句批注的需求越来越少，若是真有启发，干脆写篇完整的文章算了。也就是说， 把大量用来“牢记”的时间，直接输入到“践行”之中，好像更为牢靠，更为划算。</blockquote>
                <hr>
                <p class="lead text-left">
                    金马：
                </p>
                <blockquote class="lead text-left">
                    我在 2017 年春节花了2天的时间写了一个小工具"笑来搜"，结果竟然给大家带来那么大的帮助，那如果我做一个更通用的工具呢？会不会帮助更多的人？
                </blockquote>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>为什么收费</h2>
                <p class="lead text-left">李笑来老师在微信公众号《学习学习再学习》中写过一篇文章 <a href="https://mp.weixin.qq.com/s?__biz=MzAxNzI4MTMwMw==&mid=400487407&idx=1&sn=1738bf05fca2e073fd3e3dab57303905&scene=4#wechat_redirect">最好从一开始就要玩真的</a> 中这样说：</p>
                <blockquote class="lead text-left">
                    如果你做一件事情，是公益的，是免费的，你得到的只能是赞扬——哪怕你做得并不好。这是关键，你可能做得并不好，但由于你是免费的、公益的，所以人家只能对你客气 —— 这其实是不真实的反应。
                </blockquote>
                <blockquote class="lead text-left">
                    反过来，你收哪怕一分钱试试？只要你出了问题就会有人骂你，甚至不出问题的时候都有人骂你。
                </blockquote>
                <blockquote class="lead text-left">
                    不会回避商业，该收钱就收钱，不能免费、不能公益——这是为了得到真实的反馈。
                </blockquote>
                <blockquote class="lead text-left">
                    如果在你做得并不好的时候，依然得到赞扬，你最终只能被麻痹。而你不可能一辈子回避商业的，一旦开始玩真的，你就傻了，因为真实的世界（商业世界）全然不是你过往经历的样子。你被麻痹得越久，你越难以从瘫痪状态恢复过来。
                </blockquote>
                <blockquote class="lead text-left">
                    在你做的其实很好的时候，依然被骂，这其实是好事，会让你心理上更成熟，承受能力更强。
                </blockquote>
                <p class="lead text-left">「来读」从发布开始就是一个收费工具，因为我确实要玩真的了，只有收费这个工具才会走的更长久，我也铁了心要把这个工具做得更好；另外，收费也会筛选出来真正喜欢这个工具的同学。事实上，工具会很有价值，但是「来读」社群可能会更有价值。</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>电子书版权问题？</h2>
                <p class="lead text-left">这里不存在版权问题，因为你只能看到你自己上传的书籍，在这里除了免费书籍，其他的书籍不会被传播，不会被分享，我们只想来"搜索"。</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>愿景</h2>
                <p class="lead text-left">我们立志成为知识创造者的最贴心的工具，通过工具来提升大家的检索效率和写作效率。</p>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Map -->
<section id="contact" class="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>关于我们</h2>
                <hr class="small">
                <div class="row">
                    <div class="col-md-2 col-md-offset-2">
                        <div class="portfolio-item">
                            <a href="javascript:void(0)">
                                <img class="img-portfolio img-responsive" src="/images/xiaolai.jpeg">
                            </a>
                            <h3>李笑来老师</h3>
                            <p>创意提供者</p>
                            <p>项目使用者</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-offset-1">
                        <div class="portfolio-item">
                            <a href="javascript:void(0)">
                                <img class="img-portfolio img-responsive" src="/images/jinma.jpg">
                            </a>
                            <h3>金马</h3>
                            <p>产品设计、开发、运维</p>
                            <p><a href="http://xiaolai.co" target="_blank">笑来搜</a> 作者</p>
                            <p><a href="https://github.com/lijinma" target="_blank">GitHub</a></p>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-offset-1">
                        <div class="portfolio-item">
                            <a href="javascript:void(0)">
                                <img class="img-portfolio img-responsive" src="/images/xiaoxi.jpg">
                            </a>
                            <h3>小溪</h3>
                            <p>产品体验官</p>
                            <p>市场、运营</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <h3><a href="/users/plans">成为年费会员[可点击]</a> </h3>
                <hr class="small">
                <img class="img-portfolio img-responsive" src="/images/member.jpeg">
                <br>
                <p class="text-muted">Copyright &copy; 来读 2017 | <a
                            href="http://www.miibeian.gov.cn/">沪ICP备15050624号-3</a></p>
            </div>
        </div>
    </div>
    <a id="to-top" href="#top" class="btn btn-dark btn-lg"><i class="fa fa-chevron-up fa-fw fa-1x"></i></a>
</footer>

<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<!-- Custom Theme JavaScript -->
<script>
    // Closes the sidebar menu
    $("#menu-close").click(function (e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });
    // Opens the sidebar menu
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });
    // Scrolls to the selected menu item on the page
    $(function () {
        $('a[href*=#]:not([href=#],[data-toggle],[data-target],[data-slide])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
    //#to-top button appears after scrolling
    var fixed = false;
    $(document).scroll(function () {
        if ($(this).scrollTop() > 250) {
            if (!fixed) {
                fixed = true;
                // $('#to-top').css({position:'fixed', display:'block'});
                $('#to-top').show("slow", function () {
                    $('#to-top').css({
                        position: 'fixed',
                        display: 'block'
                    });
                });
            }
        } else {
            if (fixed) {
                fixed = false;
                $('#to-top').hide("slow", function () {
                    $('#to-top').css({
                        display: 'none'
                    });
                });
            }
        }
    });
    // Disable Google Maps scrolling
    // See http://stackoverflow.com/a/25904582/1607849
    // Disable scroll zooming and bind back the click event
    var onMapMouseleaveHandler = function (event) {
        var that = $(this);
        that.on('click', onMapClickHandler);
        that.off('mouseleave', onMapMouseleaveHandler);
        that.find('iframe').css("pointer-events", "none");
    }
    var onMapClickHandler = function (event) {
        var that = $(this);
        // Disable the click handler until the user leaves the map area
        that.off('click', onMapClickHandler);
        // Enable scrolling zoom
        that.find('iframe').css("pointer-events", "auto");
        // Handle the mouse leave event
        that.on('mouseleave', onMapMouseleaveHandler);
    }
    // Enable map zooming with mouse scroll when the user clicks the map
    $('.map').on('click', onMapClickHandler);
</script>
@include('layouts.partials.tongji')
</body>

</html>
