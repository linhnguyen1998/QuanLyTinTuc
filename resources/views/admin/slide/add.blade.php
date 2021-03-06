@extends('admin.layouts.index')

@section('content')
<!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Slide
                        <small>Thêm</small>
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

                    <form action="admin/slide/add" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Tên</label>
                            <input class="form-control" name="txtTen" placeholder="Nhập tên slide" />
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh cho slide</label>
                            <input type="file" class="form-control" name="picture"/>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea class="form-control ckeditor" name="txtNoiDung"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input class="form-control" name="txtLink" placeholder="Nhập link" />
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
@endsection