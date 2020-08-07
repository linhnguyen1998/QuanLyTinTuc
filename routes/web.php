<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\TheLoai;

Route::get('/', function () {
    return view('welcome');
});

Route::get('danhsach', function(){
	$theloai = TheLoai::find(1);
	foreach ($theloai->loaitin as $loaitin) {
		echo $loaitin->Ten."<br>";
	}
});

Route::get('admin/login','UserController@getLoginAdmin');
Route::post('admin/login','UserController@postLoginAdmin');
Route::get('admin/logout','UserController@getLogoutAdmin');

Route::group(['prefix'=>'admin','middleware'=>'adminLogin'], function(){
	//Thể loại
	Route::group(['prefix'=>'theloai'], function(){

		//vd: admin/theloai/list
		Route::get('list','TheLoaiController@getList');

		Route::get('add', 'TheLoaiController@getAdd');
		Route::post('add', 'TheLoaiController@postAdd');

		Route::get('edit/{id}','TheLoaiController@getEdit');
		Route::post('edit/{id}','TheLoaiController@postEdit');

		Route::get('delete/{id}','TheLoaiController@getDel');
	});

	//Loại tin
	Route::group(['prefix'=>'loaitin'], function(){

		//vd: admin/theloai/list
		Route::get('list','LoaiTinController@getList');

		Route::get('add', 'LoaiTinController@getAdd');
		Route::post('add', 'LoaiTinController@postAdd');

		Route::get('edit/{id}','LoaiTinController@getEdit');
		Route::post('edit/{id}','LoaiTinController@postEdit');

		Route::get('delete/{id}','LoaiTinController@getDel');
	});

	//Tin tức
	Route::group(['prefix'=>'tintuc'], function(){

		//vd: admin/theloai/list
		Route::get('list','TinTucController@getList');

		Route::get('add', 'TinTucController@getAdd');
		Route::post('add', 'TinTucController@postAdd');
		Route::get('ajax/add/{idTheLoai}', 'TinTucController@getLoaiTin');

		Route::get('edit/{id}','TinTucController@getEdit');
		Route::post('edit/{id}','TinTucController@postEdit');

		Route::get('delete/{id}','TinTucController@getDel');
	});

	//Slide
	Route::group(['prefix'=>'slide'], function(){

		//vd: admin/theloai/list
		Route::get('list','SlideController@getList');

		Route::get('add', 'SlideController@getAdd');
		Route::post('add', 'SlideController@postAdd');

		Route::get('edit/{id}','SlideController@getEdit');
		Route::post('edit/{id}','SlideController@postEdit');

		Route::get('delete/{id}','SlideController@getDel');
	});

	//Bình luận
	Route::group(['prefix'=>'comment'], function(){

		//vd: admin/theloai/list

		Route::get('delete/{id_cmt}/{id}','CommentController@getDel');
	});

	//User

    Route::group(['prefix'=>'user'], function(){

        //vd: admin/user/list
        Route::get('list','UserController@getList');

        Route::get('add', 'UserController@getAdd');
        Route::post('add', 'UserController@postAdd');

        Route::get('edit/{id}','UserController@getEdit');
        Route::post('edit/{id}','UserController@postEdit');

        Route::get('delete/{id}','UserController@getDel');
    });
});