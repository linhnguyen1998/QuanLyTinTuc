@extends('admin.layouts.index')

@section('content')
<!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User
                        <small>{{$user->name}}</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                                {{$err}}<br>
                            @endforeach
                        </div>
                    @endif

                    @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                    @endif
                    <form action="admin/user/edit/{{$user->id}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Họ tên</label>
                            <input class="form-control" name="txtHoten" value="{{$user->name}}" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="txtEmail" disabled="" value="{{$user->email}}" />
                        </div>
                        <div class="form-group">
                            <input id="checkPassword" type="checkbox" name="changePassword">
                            <label>Đổi mật khẩu</label>
                            <input type="password" class="form-control password" name="txtPass" disabled="" placeholder="Mật khẩu mới"/>
                        </div>
                        <div class="form-group">
                            <label>Nhập lại mật khẩu</label>
                            <input type="password" class="form-control password" name="txtPassAgain" disabled="" placeholder="Nhập lại mật khẩu" />
                        </div>
                        <div class="form-group">
                            <label>Quyền người dùng </label>
                            <label class="radio-inline">
                                <input name="rdoQuyen" value="1"
                                       @if($user->quyen == 1)
                                               {{"checked"}}
                                       @endif
                                       type="radio">Admin
                            </label>
                            <label class="radio-inline">
                                <input name="rdoQuyen" value="0"
                                       @if($user->quyen == 0)
                                       {{"checked"}}
                                       @endif
                                       type="radio">Normal
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Cập nhật</button>
                        <button type="reset" class="btn btn-default">Làm mới</button>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#checkPassword").change(function(){
                if ($(this).is(":checked"))
                {
                    $(".password").removeAttr('disabled');
                }
                else
                {
                    $(".password").attr('disabled','');
                }
            });
        });
    </script>
@endsection