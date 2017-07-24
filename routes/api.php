<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/





Route::group(['middleware' => 'auth:api'], function() {
  Route::get('/user', function (Request $request) {
      return $request->user();
  });
  Route::get('/test', function (Request $request) {
      return "art";
  });
});

//TODO move to auth Route group
Route::resource('post', 'PostController', [
  'except' => ['create', 'edit']
]);
Route::resource('type', 'TypeController', [
  'except' => ['create', 'edit']
]);
Route::resource('tag', 'TagController', [
  'except' => ['create', 'edit']
]);
Route::post('image/delete', function (Request $request) {
  if (!is_array($request)) {
    return "please give array of ids";
  }
  return App\Image::whereIn('id', $request)->delete();
});
