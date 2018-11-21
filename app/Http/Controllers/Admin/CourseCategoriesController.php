<?php

namespace App\Http\Controllers\Admin;

use App\CourseCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CourseCategory::orderBy('name', 'ASC')->paginate(25);
        return view('admin.courses.categories.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courseCategory = new CourseCategory;
        return view('admin.courses.categories.categories_new', compact('courseCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:course_categories,name',
        ]);

        $course_category = new CourseCategory;
        $course_category->name = $request->name;
        $course_category->save();

        return redirect()->route('admin.categories.course.create')->with('save', 'Category saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CourseCategory $courseCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $courseCategory = CourseCategory::findOrFail($id);
        return view('admin.courses.categories.categories_edit', compact('courseCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:course_categories,name,'.$id,
        ]);

        $course_category = CourseCategory::findOrFail($id);
        $course_category->name = $request->name;
        $course_category->save();

        return redirect()->route('admin.categories.course.edit', $course_category)->with('update', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course_category = CourseCategory::findOrFail($id);
        $course_category->delete();
        return redirect()->route('admin.categories.course.index')->with('warning', 'Category deleted');
    }
}
