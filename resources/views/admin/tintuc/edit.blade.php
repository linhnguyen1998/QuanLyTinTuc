@extends('admin.layouts.index')

@section('content')
<!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tin Tức
                        <small>{{$tintuc->TieuDe}}</small>
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
                    <form action="admin/tintuc/edit/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Thể loại</label>
                            <select class="form-control" name="TheLoai" id="TheLoai">
                                <option>Hãy chọn tên thể loại</option>
                                @foreach($theloai as $tl)
                                    <option
                                            @if($tintuc->loaitin->theloai->id == $tl->id)
                                                {{"selected"}}
                                            @endif
                                            value="{{$tl->id}}">{{$tl->Ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Loại tin</label>
                            <select class="form-control" name="LoaiTin" id="LoaiTin">
                                @foreach($loaitin as $lt)
                                    <option
                                            @if($tintuc->loaitin->id == $lt->id)
                                            {{"selected"}}
                                            @endif
                                            value="{{$lt->id}}">{{$lt->Ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input class="form-control" name="txtTieuDe" value="{{$tintuc->TieuDe}}" />
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea class="form-control ckeditor" rows="1" name="txtNoiDung">{{$tintuc->NoiDung}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Tóm tắt</label>
                            <textarea class="form-control ckeditor" rows="3" name="txtTomTat">{{$tintuc->TomTat}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <br>
                            <img width="400px" src="upload/tintuc/{{$tintuc->Hinh}}">
                            <input type="file" name="picture" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nổi bật </label>
                            <label class="radio-inline">
                                <input name="rdoNoiBat" value="1"
                                       @if($tintuc->NoiBat == 1)
                                               {{"checked"}}
                                       @endif
                                       type="radio">Có
                            </label>
                            <label class="radio-inline">
                                <input name="rdoNoiBat"
                                       @if($tintuc->NoiBat == 0)
                                       {{"checked"}}
                                       @endif
                                       value="0" type="radio">Không
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Thêm</button>
                        <button type="reset" class="btn btn-default">Làm mới</button>
                        </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Bình Luận
                    <small>Danh sách</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            @if(session('thongbao'))
                <div class="alert alert-success">
                    {{session('thongbao')}}
                </div>
            @endif
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr align="center">
                    <th>ID</th>
                    <th>Người dùng</th>
                    <th>Nội dung</th>
                    <th>Ngày đăng</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tintuc->comment as $cmt)
                    <tr class="odd gradeX" align="center">
                        <td>{{$cmt->id}}</td>
                        <td>{{$cmt->user->name}}</td>
                        <td>{{$cmt->NoiDung}}</td>
                        <td>{{$cmt->created_at}}</td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/delete/{{$cmt->id}}/{{$tintuc->id}}"> Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection