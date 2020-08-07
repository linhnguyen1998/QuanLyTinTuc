<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
class SlideController extends Controller
{
    public function getList()
    {
        $slide = Slide::all();
        return view('admin.slide.list',['slide'=>$slide]);
    }
    public function getAdd()
    {
        return view('admin.slide.add');
    }

    public function postAdd(Request $request)
    {
        $this->validate($request,
            [
                'txtTen' => 'required|unique:slide,Ten|min:3|max:100',
                'picture'=>'required|image|mimes:jpg,png,jpeg',
                'txtNoiDung'=>'required',
                'txtLink'=>'required'
            ],
            [
                'txtTen.required' => 'Bạn chưa nhập tên slide',
                'txtTen.unique' => 'Tên slide đã tồn tại',
                'txtTen.min' => 'Tên slide phải có ít nhất 3 kí tự',
                'txtTen.max' => 'Tên slide không được quá 100 kí tự',
                'txtNoiDung.required'=>'Bạn chưa nhập nội dung',
                'txtLink.required'=>'Bạn chưa nhập nội dung',
                'picture.required'=>'Bạn chưa thêm hình ảnh',
                'picture.image'=>'Đây không phải là hình ảnh',
                'picture.mimes'=>'Đuôi file hình ảnh phải thuộc jpg, png, jpeg',
            ]);
        $slide = new Slide;
        $slide->Ten = $request->txtTen;
        if($request->hasFile('picture'))
        {
            $file = $request->file('picture');
            $name = $file->getClientOriginalName();
            $file->move("upload/slide/",$name);
            $slide->Hinh = $name;
        }
        $slide->NoiDung = $request->txtNoiDung;
        if($request->has('txtLink'))
        {
            $slide->Link = $request->txtLink;
        }
        $slide->save();
        return redirect('admin/slide/add')->with('thongbao', 'Thêm thành công');
    }

    public function getEdit($id)
    {
        $slide = Slide::find($id);
        return view('admin.slide.edit', ['slide'=>$slide]);
    }

    public function postEdit(Request $request, $id)
    {
        $slide = Slide::find($id);
        $this->validate($request,
            [
                'txtTen' => 'required|unique:slide,Ten|min:3|max:100',
                'picture'=>'required|image|mimes:jpg,png,jpeg',
                'txtNoiDung'=>'required',
                'txtLink'=>'required'
            ],
            [
                'txtTen.required' => 'Bạn chưa nhập tên slide',
                'txtTen.unique' => 'Tên slide đã tồn tại',
                'txtTen.min' => 'Tên slide phải có ít nhất 3 kí tự',
                'txtTen.max' => 'Tên slide không được quá 100 kí tự',
                'txtNoiDung.required'=>'Bạn chưa nhập nội dung',
                'txtLink.required'=>'Bạn chưa nhập nội dung',
                'picture.required'=>'Bạn chưa thêm hình ảnh',
                'picture.image'=>'Đây không phải là hình ảnh',
                'picture.mimes'=>'Đuôi file hình ảnh phải thuộc jpg, png, jpeg',
            ]);
        $slide->Ten = $request->txtTen;
        if($request->hasFile('picture'))
        {
            $file = $request->file('picture');
            $name = $file->getClientOriginalName();
            $file->move("upload/slide/",$name);
            unlink("upload/slide/".$slide->Hinh);
            $slide->Hinh = $name;
        }
        $slide->NoiDung = $request->txtNoiDung;
        if($request->has('txtLink'))
        {
            $slide->Link = $request->txtLink;
        }
        $slide->save();
        return redirect('admin/slide/edit/'.$id)->with('thongbao', 'Cập nhật thành công');
    }
    public function getDel($id)
    {
        $slide = Slide::find($id);
        $slide->delete();
        return redirect('admin/slide/list')->with('thongbao','Đã xóa thành công');
    }
}
