<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TinTuc;
use App\TheLoai;
use App\LoaiTin;
use App\Comment;

class TinTucController extends Controller
{
    public function getList()
    {
        $tintuc = TinTuc::orderBy('id','DESC')->get();
    	return view('admin.tintuc.list', ['tintuc'=>$tintuc]);
    }

    public function getAdd()
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
    	return view('admin.tintuc.add', ['theloai'=>$theloai, 'loaitin'=>$loaitin]);
    }

    public function getLoaiTin($idTheLoai)
    {
        $loaitin = LoaiTin::where('idTheLoai', $idTheLoai)->get();
        foreach($loaitin as $lt)
        {
            echo "<option value='".$lt->id."'>".$lt->Ten."</option>";
        }
    }

    public function postAdd(Request $request)
    {
        $this->validate($request,
            [
                'LoaiTin'=>'required',
                'txtTieuDe'=>'required|min:3|unique:TinTuc,TieuDe',
                'txtTomTat'=>'required',
                'txtNoiDung'=>'required',
                'picture'=>'required|image|mimes:jpg,jpeg,png',
            ],
            [
                'txtLoaiTin.required'=>'Bạn chưa chọn loại tin',
                'txtTieuDe.required'=>'Bạn chưa nhập tiêu đề',
                'txtTieuDe.min'=>'Tiêu đề không được bé hơn 3 kí tự',
                'txtTieuDe.unique'=>'Tiêu đề đã tồn tại',
                'txtTomTat.required'=>'Bạn chưa nhập tóm tắt',
                'txtNoiDung.required'=>'Bạn chưa nhập nội dung',
                'picture.required'=>'Bạn chưa thêm hình ảnh',
                'picture.image'=>'Đây không phải là file hình ảnh',
                'picture.mimes'=>'Hình ảnh phải có đuôi là jpg,jpeg,png',
            ]);
        $tintuc = new TinTuc;
        $tintuc->TieuDe= $request->txtTieuDe;
        $tintuc->TieuDeKhongDau = str_slug($request->txtTieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->txtTomTat;
        $tintuc->NoiDung = $request->txtNoiDung;
        $tintuc->NoiBat = $request->rdoNoiBat;
        $tintuc->SoLuotXem = 0;
        if($request->hasFile('picture'))
        {
            $file = $request->file('picture');
            $name = $file->getClientOriginalName();
            $file->move("upload/tintuc/",$name);
            $tintuc->Hinh = $name;
        }
        else
        {
            $tintuc->Hinh = "";
        }
        $tintuc->save();
        return redirect("admin/tintuc/add")->with('thongbao','Thêm tin tức thành công');

    }

    public function getEdit($id)
    {
        $tintuc = TinTuc::find($id);
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
    	return view('admin.tintuc.edit', ['tintuc'=>$tintuc, 'theloai'=>$theloai, 'loaitin'=>$loaitin]);
    }

    public function postEdit(Request $request, $id)
    {

        $tintuc = TinTuc::find($id);
        $this->validate($request,
            [
                'LoaiTin'=>'required',
                'txtTieuDe'=>'required|min:3',
                'txtTomTat'=>'required',
                'txtNoiDung'=>'required',
                'picture'=>'required|image|mimes:jpg,png,jpeg',
            ],
            [
                'txtLoaiTin.required'=>'Bạn chưa chọn loại tin',
                'txtTieuDe.required'=>'Bạn chưa nhập tiêu đề',
                'txtTieuDe.min'=>'Tiêu đề không được bé hơn 3 kí tự',
                'txtTomTat.required'=>'Bạn chưa nhập tóm tắt',
                'txtNoiDung.required'=>'Bạn chưa nhập nội dung',
               'picture.required'=>'Bạn chưa thêm hình ảnh',
               'picture.image'=>'Đây không phải là hình ảnh',
               'picture.mimes'=>'Đuôi file hình ảnh phải thuộc jpg, png, jpeg',
            ]);
        echo $tintuc->TieuDe= $request->txtTieuDe;
        $tintuc->TieuDeKhongDau = str_slug($request->txtTieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->txtTomTat;
        $tintuc->NoiDung = $request->txtNoiDung;
        $tintuc->NoiBat = $request->rdoNoiBat;
        if($request->hasFile('picture'))
        {
            $file = $request->file('picture');
            $name = $file->getClientOriginalName();
            $duoi = strtolower($file->getClientOriginalExtension());
            $file->move("upload/tintuc/",$name);
            unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh = $name;
        }
        $tintuc->save();
        return redirect('admin/tintuc/edit/'.$id)->with('thongbao','Cập nhật thành công');
    }

    public function getDel($id)
    {
        $tintuc = TinTuc::find($id);
        $tintuc->delete();
        return redirect('admin/tintuc/list')->with('thongbao','Đã xóa thành công');
    }
}
