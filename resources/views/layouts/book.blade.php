<!DOCTYPE HTML>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>Introduction · GitBook</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="">
    <meta name="generator" content="GitBook 3.2.2">
    <link rel="stylesheet" href="/gitbook/style.css">
    <link rel="stylesheet" href="/gitbook/gitbook-plugin-highlight/website.css">
    <link rel="stylesheet" href="/gitbook/gitbook-plugin-search/search.css">
    <link rel="stylesheet" href="/gitbook/custom.css">
    <link rel="stylesheet" href="/gitbook/gitbook-plugin-fontsettings/website.css">
    <link rel="stylesheet" href="/gitbook/gitbook-plugin-back-to-top-button/plugin.css">
    <meta name="HandheldFriendly" content="true"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="apple-touch-icon-precomposed" sizes="152x152"
          href="/gitbook/images/apple-touch-icon-precomposed-152.png">
    <link rel="icon" sizes="192x192" href="/images/ico.png" />
    <link rel="shortcut icon" href="/images/ico.png" type="image/png" />
</head>
<body>

<div class="book">
    <div class="book-summary">
        <div class="title">
            @yield('title')
        </div>
        <nav role="navigation">
            <ul class="summary">
                @yield('summary')
                <li class="divider"></li>
                <li>
                    <a href="javascript:void(0)">性能原因，只显示600个章节</a>
                    <a href="javascript:void(0)">剩余部分按键盘 → 查看</a>
                </li>
            </ul>
        </nav>


    </div>

    <div class="book-body">
        <div class="body-inner">
            <div class="book-header" role="navigation">
                <!-- Title -->
                @yield('book_header')
            </div>

            <div class="page-wrapper" tabindex="-1" role="main">
                <div class="page-inner">
                    <section class="normal markdown-section">
                        @yield('book_body')
                    </section>
                </div>
            </div>

        </div>
        @yield('nav')
    </div>
    <script>
        var gitbook = gitbook || [];
        gitbook.push(function () {
            gitbook.page.hasChanged({
                "page": {
                },
                "config": {
                    "gitbook": "*",
                    "theme": "default",
                    "variables": {},
                    "plugins": [],
                    "pluginsConfig": {
                        "livereload": {},
                        "highlight": {},
                        "lunr": {"maxIndexSize": 1000000, "ignoreSpecialCharacters": false},
                        "sharing": {
                        },
                        "fontsettings": {"theme": "white", "family": "sans", "size": 2},
                        "theme-default": {
                        }
                    },
                    "structure": {
                        "langs": "LANGS.md",
                        "readme": "README.md",
                        "glossary": "GLOSSARY.md",
                        "summary": "SUMMARY.md"
                    },
                    "pdf": {
                        "pageNumbers": true,
                        "fontSize": 12,
                        "fontFamily": "Arial",
                        "paperSize": "a4",
                        "chapterMark": "pagebreak",
                        "pageBreaksBefore": "/",
                        "margin": {"right": 62, "left": 62, "top": 56, "bottom": 56}
                    },
                    "styles": {
                        "website": "styles/website.css",
                        "pdf": "styles/pdf.css",
                        "epub": "styles/epub.css",
                        "mobi": "styles/mobi.css",
                        "ebook": "styles/ebook.css",
                        "print": "styles/print.css"
                    }
                },
                "file": {"path": "README.md", "mtime": "2017-03-08T16:04:14.000Z", "type": "markdown"},
                "gitbook": {"version": "3.2.2", "time": "2017-04-06T14:25:10.158Z"},
                "basePath": ".",
                "book": {"language": ""}
            });
        });
    </script>
</div>

<script src="/gitbook/gitbook.js"></script>
<script src="/gitbook/theme.js"></script>
<script src="/gitbook/gitbook-plugin-livereload/plugin.js"></script>
<script src="/gitbook/gitbook-plugin-search/search-engine.js"></script>
<script src="/gitbook/gitbook-plugin-search/search.js"></script>
<script src="/gitbook/gitbook-plugin-lunr/lunr.min.js"></script>
<script src="/gitbook/gitbook-plugin-lunr/search-lunr.js"></script>
<script src="/gitbook/gitbook-plugin-sharing/buttons.js"></script>
<script src="/gitbook/gitbook-plugin-fontsettings/fontsettings.js"></script>
<script src="/gitbook/gitbook-plugin-back-to-top-button/plugin.js"></script>
@include('layouts.partials.tongji')
</body>
</html>

