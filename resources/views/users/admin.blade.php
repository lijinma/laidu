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
            <div class="col-md-4">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control" name="query" placeholder="用户的 email" value="{{ $q }}">
                        <span class="input-group-btn"><button class="btn btn-primary"
                                                              type="submit">搜索用户</button><a href="/admin" class="btn btn-success">全部用户</a></span>

                    </div>
                </form>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading">用户管理：共 {{ $users->total() }} 个用户</div>
                    <div class="panel-body">
                        <p>这里解释如何管理用户</p>
                    </div>

                    <!-- Table -->
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>邮箱</th>
                            <th>是否是会员</th>
                            <th>会员到期时间</th>
                            <th>会员添加记录</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th>{{ $user->email }}</th>
                                <td>{{ $user->is_vip ? '是' : '否'}}</td>
                                <td>{{ $user->is_vip ? $user->expired_in : '' }}</td>
                                <td>
                                    <table class="table table-bordered">
                                        @foreach ($user->vipLogs as $vipLog)
                                            <tr>
                                                <td>{{ \App\User::ADMIN_NAMES[$vipLog->operation_user_id] }}</td>
                                                <td>在 {{ $vipLog->created_at->toDateString() }}</td>
                                                <td>添加 {{ $vipLog->months }} 个月</td>
                                                <td>备注：{{ $vipLog->remark }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <button class="btn btn-success add-vip" data-email="{{ $user->email }}"
                                            data-id="{{ $user->id }}" data-months="6">
                                        添加6个月
                                    </button>
                                    <button class="btn btn-success add-vip" data-email="{{ $user->email }}" data-id="{{ $user->id }}" data-months="12">
                                        添加一年
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form id="vip-form" action="{{ url('/admin/vip/add') }}" method="POST">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                    </div>
                                    <div class="modal-body">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="email"> Email:</label>
                                            <input required="required" placeholder="email" name="email" type="text"
                                                   class="form-control" readonly>
                                        </div>
                                        <input type="hidden" name="user_id">
                                        <div class="form-group">
                                            <label for="months"> 添加月个数:</label>
                                            <input required="required" placeholder="6" name="months" type="text"
                                                   class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">备注:<span class="text-danger">[写清楚是邀请朋友还是付费用户]</span>
                                            </label>
                                            <textarea class="form-control" name="remark" id="" cols="30" rows="3"
                                                      required>
                                            </textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary">提交</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function () {
            $('.add-vip').click(function () {
                var months = $(this).data('months');
                var userId = $(this).data('id');
                var email = $(this).data('email');
                $('input[name=user_id]').val(userId);
                $('input[name=months]').val(months);
                $('input[name=email]').val(email);
                $('#myModal').modal();
//            $('#vip-form').submit();
            });
        });
    </script>
@endsection