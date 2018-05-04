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


Route::get('/', function () {
    session()->put('test', 1234);
    return redirect('');
});

Route::get('about','PagesController@about');
Route::get('','PagesController@frontpage');
Route::get('faq','PagesController@faq');
Route::get('contacts','PagesController@contacts');
Route::get('404','PagesController@error404');

/*//Register
Route::get('register','PagesController@register');
Route::post('register','UserController@register');
Route::get('logout','UserController@logout');
Route::post('logout','UserController@logout');

//Login*/
//Route::post('login','UserController@login');
Route::get('login','PagesController@login');

Route::get('register','PagesController@register');

//View Profile
Route::get('users/{id}', 'UserController@show');

//Edit profile
Route::get('users/{id}/edit','UserController@edit');
Route::post('users/{id}/edit','UserController@editProfile');

//Delete profile
Route::post('users/{id}/delete','UserController@deleteUser');

//Posts
Route::get('post/{id}','PostController@index');
Route::post('poster','PostController@test');

//Delete Posts
Route::post('post/{id}/delete','PostController@delete');

//Post new Question
Route::get('postNewQuestion', 'PostController@postQuestionPage');
Route::post('postNewQuestion', 'PostController@postQuestion');
Route::post('tags/searchForTag', 'TagController@searchForTag');

//View Question
Route::get('questions/{id}', 'PostController@showQuestionPage');

//Post Answer
Route::post('postNewAnswer/{id}', 'PostController@postAnswer');

//Close Question
Route::post('questions/{id}/close', 'PostController@closeQuestion');

//Post Vote
Route::post('post/{id}/vote', 'PostController@postVote');


Route::get('/home', 'HomeController@index')->name('home');

Route::get('test', function() {
    return view('layouts.app');
});

//Tags
Route::get('tags','PagesController@tags');

//Auth::routes();

//auth routes
//$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');
