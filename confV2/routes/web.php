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


Route::get('/','postsController@index');

//Get Post On Scroll
Route::post('/getPost/{skip}','postsController@getPost')->where(['skip' => '[0-9]+']);

//Get Full Post
Route::post('/getFullPost/{id}','postsController@getFullPost')->where(['id' => '[0-9]+']);

//Get Post By Category
Route::post('/{id}/{skip?}','postsController@getPostByCat')->where(['id' => '[0-9]+', 'skip' => '[0-9]+']);

//Search
Route::post('/search/{keyword}/{skip?}','postsController@search')->where(['skip' => '[0-9]+']);

//Most Viewed Post    
Route::post('/most/{skip?}','postsController@mostView')->where(['skip' => '[0-9]+']);

//Show Shared Post
Route::get('share/{id}', 'postsController@shared')->where(['id' => '[0-9]+']);

//Privacy Page
Route::get('/privacy',function () {
	return view('privacy');
});


//START roote Reaction (ex: add Like, add comment)
//	like / dislike
Route::post('/like/{id}/{action}','reactionController@like')->where(['id' => '[0-9]+', 'action' => '[a-z]+']);

//Add Comment
Route::post('/addComment/{id}','reactionController@addComment')->where(['id' => '[0-9]+']);

//Add Post
Route::post('/posts/addPost','postsController@addPost');

