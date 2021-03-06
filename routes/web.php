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
    return view('welcome');
});

Route::get('/login', 'Admin\LoginController@login')->name('admin.login');
Route::post('/login', 'Admin\LoginController@authLogin')->name('admin.auth.login');
Route::post('/logout', 'Admin\LoginController@logout')->name('admin.logout');

Route::group(['prefix' => 'admin',  'middleware' => 'auth:web'], function() {
    Route::get('/', 'Admin\AdminController@home')->name('admin.home');
    // Students
    Route::resource('students', 'Admin\StudentsController', ['as' => 'admin']);
    Route::get('students/profile/course/{student}/{course}', 'Admin\StudentsController@profileCourse')->name('admin.students.profile.course');
    Route::post('students/add/course', 'Admin\StudentsController@addCourse')->name('admin.students.add.course');
    Route::delete('students/profile/course/point/{point}/destroy', 'Admin\StudentsController@profilePointDestroy')->name('admin.students.profile.point');
    Route::put('students/profile/course/point/update', 'Admin\StudentsController@profilePointUpdate')->name('admin.students.profile.point.update');
    Route::delete('students/profile/course/{enrollment}/destroy', 'Admin\StudentsController@profileEnrollmentDestroy')->name('admin.students.profile.course.destroy');
    // Course
    Route::resource('courses', 'Admin\CoursesController', ['as' => 'admin']);
    Route::get('course/sections/{course}', 'Admin\CoursesController@sectionIndex')->name('admin.course.sections');
    Route::get('course/sections/{course}/add', 'Admin\CoursesController@sectionAdd')->name('admin.course.sections.add');
    Route::post('course/sections/{course}/add', 'Admin\CoursesController@sectionCreate')->name('admin.course.sections.create');
    Route::get('course/sections/{section}/edit', 'Admin\CoursesController@sectionEdit')->name('admin.course.sections.edit');
    Route::put('course/sections/{section}/edit', 'Admin\CoursesController@sectionUpdate')->name('admin.course.sections.edit');
    Route::delete('course/sections/{section}/destroy', 'Admin\CoursesController@sectionDestroy')->name('admin.course.sections.destroy');
    // Course category
    Route::resource('categories/course', 'Admin\CourseCategoriesController', ['as' => 'admin.categories']);

    // Student groups
    Route::get('groups/students', 'Admin\StudentGroupsController@groups')->name('admin.students.groups');
    Route::get('groups/students/new', 'Admin\StudentGroupsController@groups_new')->name('admin.students.groups.new');
    Route::get('groups/students/edit/{id}', 'Admin\StudentGroupsController@groups_edit')->name('admin.students.groups.edit');
    Route::post('groups/students/new/add', 'Admin\StudentGroupsController@groups_add')->name('admin.students.groups.add');
    Route::put('groups/students/new/add', 'Admin\StudentGroupsController@groups_update')->name('admin.students.groups.update');
    Route::delete('groups/students/destroy', 'Admin\StudentGroupsController@destroy')->name('admin.students.groups.destroy');

    // Graphs
    Route::get('graphs', 'Admin\GraphsController@index')->name('admin.graphs');
    Route::post('graphs', 'Admin\GraphsController@index')->name('admin.graphs.search');

    // Users
    Route::resource('users', 'Admin\UsersController', ['as' => 'admin']);

    // Settings
    Route::resource('settings', 'Admin\SettingsController', ['as' => 'admin']);

});


