<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    public function getList()
    {
    	$theloai = TheLoai::all();
    	return view('admin.theloai.list', ['theloai'=>$theloai]);
    }

    public function getAdd()
    {
    	return view('admin.theloai.add');
    }

    public function postAdd(Request $request)
    {
        $this->validate($request, 
            [
                'txtTen' => 'required|unique:theloai,Ten|min:3|max:100'
            ], 
            [
                'txtTen.required' => 'Bạn chưa nhập tên thể loại',
                'txtTen.unique' => 'Tên thể loại đã tồn tại',
                'txtTen.min' => 'Tên thể loại phải có ít nhất 3 kí tự',
                'txtTen.max' => 'Tên thể loại không được quá 100 kí tự',
            ]);
        $theloai = new TheLoai;
        $theloai->Ten = $request->txtTen;
        $theloai->TenKhongDau = str_slug($request->txtTen,'-');
        $theloai->save();

        return redirect('admin/theloai/add')->with('thongbao', 'Thêm thành công');
        
    }

    public function getEdit($id)
    {
        $theloai = TheLoai::find($id);
    	return view('admin.theloai.edit', ['theloai'=>$theloai]);
    }

    public function postEdit(Request $request, $id)
    {
        $theloai = TheLoai::find($id);
        $this->validate($request,
        [
            'txtTen' => 'required|unique:theloai,Ten|min:3|max:100'
        ], 
        [
            'txtTen.required' => 'Bạn chưa nhập tên thể loại',
            'txtTen.unique' => 'Tên thể loại đã tồn tại',
            'txtTen.min' => 'Tên thể loại phải có ít nhất 3 kí tự',
            'txtTen.max' => 'Tên thể loại không được quá 100 kí tự',
        ]);
        //$theloai = new TheLoai;
        $theloai->Ten = $request->txtTen;
        $theloai->TenKhongDau = str_slug($request->txtTen,'-');
        $theloai->save();
        return redirect('admin/theloai/edit/'.$id)->with('thongbao', 'Cập nhật thành công');
    }

    public function getDel($id)
    {
        $theloai = TheLoai::find($id);
        $theloai->delete();
        return redirect('admin/theloai/list')->with('thongbao', 'Xóa thành công');
    }


}
