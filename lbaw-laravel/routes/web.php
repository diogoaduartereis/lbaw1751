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


Route::get('about', 'PagesController@about');
Route::get('', 'PagesController@frontpageHotQuestion');
Route::get('/hot', 'PagesController@frontpageHotQuestion');
Route::get('/new', 'PagesController@frontpageNewQuestions');
Route::get('faq', 'PagesController@faq');
Route::get('404/Auth', 'PagesController@error404Auth');
Route::get('404/NotAuth', 'PagesController@error404Auth');
Route::get('404', 'PagesController@error404');

//Get First X questions (used for viewing more questions using infinite scrolling)
Route::get('getMostRecentPosts', 'PostController@getXMostRecentQuestionsAsHTML');

//Login
Route::get('login', 'PagesController@login');

Route::get('register', 'PagesController@register');

//Get user points
Route::get('userself/getPoints', 'UserController@getSelfCurrentPoints');

//View Profile
Route::get('users/{id}', 'UserController@show');

//Edit profile
Route::get('users/{id}/edit', 'UserController@edit');
Route::post('users/{id}/edit', 'UserController@editProfile');

//Delete profile
Route::post('users/{id}/delete', 'UserController@deleteUser');

//Ban user
Route::get('users/{id}/ban', 'UserController@banUserForm');
Route::post('users/{id}/ban', 'UserController@banUserAction');

//UnBan user
Route::post('users/{id}/unban', 'UserController@unbanUserAction');

//Posts
Route::get('post/{id}', 'PostController@index');
Route::post('poster', 'PostController@test');
Route::post('post/{id}/close', 'PostController@test');

//Delete Posts
Route::post('post/{id}/delete', 'PostController@delete');

//Post new Question
Route::get('postNewQuestion', 'PostController@postQuestionPage');
Route::post('postNewQuestion', 'PostController@postQuestion');

//Search
Route::post('tags/searchForTag', 'TagController@searchForTag');
Route::get('search/question', 'PostController@searchForQuestion');

//View Administration page searching for user
Route::get('admin', 'UserController@searchForUser');
Route::get('admin/{username}', 'UserController@searchForUser');

//View Question
Route::get('questions/{id}', 'PostController@showQuestionPage');

//Post Answer
Route::post('postNewAnswer/{id}', 'PostController@postAnswer');

//Close Question
Route::post('questions/{id}/close', 'PostController@closeQuestion');

//Open Question
Route::post('questions/{id}/open', 'PostController@openQuestion');

//Post Vote
Route::post('post/{id}/vote', 'PostController@postVote');

//Delete Vote
Route::post('post/{id}/deletevote', 'PostController@deleteVote');

//Get Report Post Page
Route::get('report/post/{id}', 'PagesController@reportPost');

//Get Reports Of A Post
Route::get('/post/{id}/reports', 'PostController@reports');

//Get Reports Of A User
Route::get('/users/{id}/reports','UserController@reports');

//Get Latest Reports
Route::get('/reports','PagesController@reports');

//Report Post
Route::post('post/{id}/report', 'PostController@reportPost');

Route::get('/home', 'HomeController@index')->name('home');

//Tags
Route::get('tags', 'PagesController@tags');

//Contacts
Route::get('contacts', 'ContactsController@contacts');
Route::post('contacts/submit', 'ContactsController@submitContactRequest');
Route::get('contactsList', 'ContactsController@contactsList');
Route::post('contacts/{id}/markAsProcessed', 'ContactsController@markContactAsProcessed');

//Auth::routes();
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->post('register', 'Auth\RegisterController@register');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset/', 'Auth\ResetPasswordController@reset')->name('password.reset');

//mark answer as correct
Route::post('answer/{id}/correct','PostController@markCorrect');