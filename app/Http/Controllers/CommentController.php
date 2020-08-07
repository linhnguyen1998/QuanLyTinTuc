<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
class CommentController extends Controller
{
    public function getDel($id_cmt, $id)
    {
        $comment = Comment::find($id_cmt);
        $comment->delete();
        return redirect('admin/tintuc/edit/'.$id)->with('thongbao', 'Đã xóa thành công');
    }
}
