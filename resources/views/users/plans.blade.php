@extends('layouts.app')
@section('content')
    <div class="plan">
        <div class="banner">
            <h2>年费会员</h2>
            <div class="col-md-12 text-center">
                <button class="btn btn-lg btn-primary text-center">仅需 ￥199</button>
            </div>
        </div>
        <div class="alert alert-success">
            <ul>
                <li>新生大学的同学，￥199可额外获得6个月使用时间</li>
                <li>Xdite极速读书群的同学，￥199可额外获得6个月使用时间</li>
                <li>007不写就出局的同学，￥199可额外获得6个月使用时间</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-md-offset-2 col-sm-offset-2">
                <ul class="pricing p-yel">
                    <li>
                        <div class="icon" style="font-size: 30px;">
                            <i class="fa fa-list" aria-hidden="true"></i>
                        </div>
                        <h2>免费用户</h2>
                    </li>
                    <li>可以选择添加三本公共书籍，不可删除</li>
                    <li>或可以上传三本书籍，不可删除</li>
                    <li>或可以选择三本公众号书籍，不可删除</li>
                    <li>不可自定义添加喜欢的公众号书籍</li>
                    <li>不能参加“来读社群”</li>
                    <li>有问题24小时内被回复</li>
                    <li>
                        <h3>￥0</h3>
                        <span>每年</span>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-4">
                <ul class="pricing p-yel">
                    <li>
                        <div class="icon" style="font-size: 30px; color: #468847;">
                            <i class="fa fa-list" aria-hidden="true"></i>
                        </div>
                        <h2>年费会员</h2>
                    </li>
                    <li>无限选择公共书籍，可删除</li>
                    <li>无限上传书籍，可删除</li>
                    <li>可以选择所有的公众号书籍，可删除</li>
                    <li>可以自定义添加 10 个自己喜欢的公众号书籍</li>
                    <li>可以参加"来读"社群</li>
                    <li>有问题 24 小时内优先回复</li>
                    <li>
                        <h3>￥199</h3>
                        <span>每年</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">会员加入流程</div>
                    <div class="panel-body">
                        <h4>第一步，注册</h4>
                        <h4>第二步，扫描二维码，付费，进入小密圈</h4>
                        <img src="/images/member.jpeg" alt="">
                        <h4>第三步，在"小密圈"中发送你的 email 给"金马"</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection