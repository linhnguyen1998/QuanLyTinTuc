<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    public function getList()
    {
        $user = User::all();
        return view('admin.user.list', ['user'=>$user]);
    }

    public function getAdd()
    {
        return view('admin.user.add');
    }

    public function postAdd(Request $request)
    {
        $this->validate($request,
            [
                'txtHoten' => 'required|min:3',
                'txtEmail' => 'required|email|unique:users,email',
                'txtPass' => 'required|min:8|max:32',
                'txtPassAgain' => 'required|same:txtPass',
            ],
            [
                'txtHoten.required' => 'Bạn chưa nhập họ tên',
                'txtHoten.min' => 'Họ tên không được nhỏ 3 kí tự',
                'txtEmail.required' => 'Bạn phải có Email',
                'txtEmail.email' => 'Eamil không đúng định dạng',
                'txtEmail.unique' => 'Email đã tồn tại',
                'txtPass.required' => 'Mật khẩu không được trống',
                'txtPass.min' => 'Mật khẩu không được ít hơn 6 kí tự',
                'txtPass.max' => 'Mật khẩu vượt quá 32 kí tự',
                'txtPassAgain.required' => 'Bạn phải nhập lại mật khẩu',
                'txtPassAgain.same' => 'Không trùng khớp với mật khẩu',
            ]);
        $user = new User;
        $user->name = $request->txtHoten;
        $user->email = $request->txtEmail;
        $user->password = bcrypt($request->txtPass);
        $user->quyen = $request->rdoQuyen;
        $user->save();

        return redirect('admin/user/add')->with('thongbao', 'Thêm thành công');
    }
    public function getEdit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', ['user' => $user]);
    }

    public function postEdit(Request $request, $id)
    {
        $this->validate($request,
            [
                'txtHoten' => 'required|min:3',
            ],
            [
                'txtHoten.required' => 'Bạn chưa nhập họ tên',
                'txtHoten.min' => 'Họ tên không được nhỏ 3 kí tự',
            ]);
        $user = User::find($id);
        $user->name = $request->txtHoten;
        $user->quyen = $request->rdoQuyen;
        if($request->changePassword == "on")
        {
            $this->validate($request,
                [
                    'txtPass' => 'required|min:8|max:32',
                    'txtPassAgain' => 'required|same:txtPass',
                ],
                [
                    'txtPass.required' => 'Mật khẩu không được trống',
                    'txtPass.min' => 'Mật khẩu không được ít hơn 6 kí tự',
                    'txtPass.max' => 'Mật khẩu vượt quá 32 kí tự',
                    'txtPassAgain.required' => 'Bạn phải nhập lại mật khẩu',
                    'txtPassAgain.same' => 'Không trùng khớp với mật khẩu',
                ]);
            $user->password = bcrypt($request->txtPass);
        }
        $user->save();
        return redirect('admin/user/edit/'.$id)->with('thongbao', 'Cập nhật thành công');
    }

    public function getDel($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('admin/user/list')->with('thongbao', 'Đã xóa thành công');
    }

    public function getLoginAdmin()
    {
        return view('admin.login');
    }

    public function postLoginAdmin(Request $request)
    {
        $this->validate($request,
            [
                'email'=>'required',
                'password'=>'required|min:8|max:32',
            ],
            [
                'email.required'=>'Email không được phép trống',
                'password.required' => 'Mật khẩu không được trống',
                'password.min' => 'Mật khẩu không được ít hơn 6 kí tự',
                'password.max' => 'Mật khẩu vượt quá 32 kí tự',
            ]);
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password]))
        {
            return redirect('admin/theloai/list');
        }
        else
            return redirect('admin/login')->with('thongbao','Đăng nhập thất bại! Vui lòng thử lại');
    }

    public function getLogoutAdmin()
    {
        Auth::logout();
        return redirect('admin/login');
    }
}
