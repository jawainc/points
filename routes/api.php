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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function(){
    Route::post('/points/find/students', 'Api\PointsController@loadStudentName');
    Route::post('/points/find/sessions', 'Api\PointsController@loadSessions');
    Route::post('/points/save', 'Api\PointsController@savePoints');
    Route::post('/points/graph', 'Api\PointsController@studentGraphData');
    Route::post('/points/graph/student', 'Api\PointsController@studentCourseData');
    Route::post('/points/student/password', 'Api\PointsController@studentVerifyPassword');

    Route::get('/graphs/categories', 'Api\GraphsController@getStudentCategories');
    Route::get('/graphs/students/loadItems', 'Api\GraphsController@getStudentGraphItems');
    Route::post('/graphs/students/loadGraphData', 'Api\GraphsController@getStudentGraphData');
    Route::get('/graphs/category/loadItems/{id}', 'Api\GraphsController@getCategoryGraphItems');
    Route::post('/graphs/category/loadGraphData', 'Api\GraphsController@getCategoryGraphData');
});

Route::post('/login', 'Api\LoginController@authenticate');
Route::get('/logout', 'Api\LoginController@logout');