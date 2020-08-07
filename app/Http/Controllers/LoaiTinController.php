<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;

class LoaiTinController extends Controller
{
    public function getList()
    {
        $loaitin = LoaiTin::all();
    	return view('admin.loaitin.list',['loaitin'=>$loaitin]);
    }

    public function getAdd()
    {
        $theloai = TheLoai::all();

    	return view('admin.loaitin.add', ['theloai'=>$theloai]);
    }

    public function postAdd(Request $request)
    {
        $this->validate($request, 
            [
                'txtTen' => 'required|unique:loaitin,Ten|min:3|max:100',
                'TheLoai' => 'integer'
            ], 
            [
                'txtTen.required' => 'Bạn chưa nhập tên loại tin',
                'txtTen.unique' => 'Tên loại tin đã tồn tại',
                'txtTen.min' => 'Tên loại tin phải có ít nhất 3 kí tự',
                'txtTen.max' => 'Tên loại tin không được quá 100 kí tự',
                'TheLoai.integer' => 'Bạn chưa chọn tên thể loại',
            ]);
        $loaitin = new LoaiTin;
        $loaitin->Ten = $request->txtTen;
        $loaitin->TenKhongDau = str_slug($request->txtTen,'-');
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();

        return redirect('admin/loaitin/add')->with('thongbao', 'Thêm thành công');
    }

    public function getEdit($id)
    {
        $loaitin = LoaiTin::find($id);
        $theloai = TheLoai::all();
    	return view('admin.loaitin.edit',['loaitin'=>$loaitin,'theloai'=>$theloai]);
    }

    public function postEdit(Request $request, $id)
    {
        $this->validate($request, 
            [
                'txtTen' => 'required|unique:loaitin,Ten|min:3|max:100',
                'TheLoai' => 'integer'
            ], 
            [
                'txtTen.required' => 'Bạn chưa nhập tên loại tin',
                'txtTen.unique' => 'Tên loại tin đã tồn tại',
                'txtTen.min' => 'Tên loại tin phải có ít nhất 3 kí tự',
                'txtTen.max' => 'Tên loại tin không được quá 100 kí tự',
                'TheLoai.integer' => 'Bạn chưa chọn tên thể loại',
            ]);
        $loaitin = LoaiTin::find($id);
        $loaitin->Ten = $request->txtTen;
        $loaitin->TenKhongDau = str_slug($request->txtTen,'-');
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();

        return redirect('admin/loaitin/edit/'.$id)->with('thongbao', 'Cập nhật thành công');

    }
    public function getDel($id)
    {
        $loaitin = LoaiTin::find($id);
        $loaitin->delete();
        return redirect('admin/loaitin/list')->with('thongbao', 'Xóa thành công');

    }
}
