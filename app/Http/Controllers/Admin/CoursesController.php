<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\CourseSection;
use App\CourseCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::orderBy('name', 'ASC')->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $course = new Course();
        $course_categories = CourseCategory::orderBy('name', 'ASC')->get();
        return view('admin.courses.create', compact('course','course_categories'));
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
            'name' => 'required|unique:courses,name',
            'course_category_id' => 'required'
        ]);

        Course::create($request->all());

        return redirect()->route('admin.courses.create')->with('save', 'Course saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $course_categories = CourseCategory::orderBy('name', 'ASC')->get();
        return view('admin.courses.edit', compact('course','course_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:courses,name,'.$course->id,
            'course_category_id' => 'required'
        ]);

        $course->update($request->all());
        return redirect()->route('admin.courses.edit', $course)->with('update', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('warning', 'Course deleted');
    }

    /**********************
     ****** Sections ******
     **********************/

    public function sectionIndex (Course $course)
    {
        $sections = $course->sections()->orderBy('name', 'ASC')->paginate(15);
        return view('admin.courses.sections.index', compact('course','sections'));
    }

    public function sectionAdd (Course $course)
    {
        $section = new CourseSection;
        return view('admin.courses.sections.create', compact('course', 'section'));
    }

    public function sectionEdit (CourseSection $section)
    {
        $course = $section->course;
        return view('admin.courses.sections.edit', compact('course', 'section'));
    }

    public function sectionCreate (Request $request, Course $course)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $section_exists = CourseSection::where('course_id', $course->id)
            ->where('name', $request->input('name'))
            ->first();
        if ($section_exists) {
            return redirect()->route('admin.course.sections.add', $course)->with('warning', 'Section already exists');
        }

        $section = new CourseSection;
        $section->name = $request->input('name');
        $section->details = $request->input('details');

        $course->sections()->save($section);

        return redirect()->route('admin.course.sections.add', $course)->with('save', 'Section save successfully.');
    }

    public function sectionUpdate (Request $request, CourseSection $section)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $section_exists = CourseSection::where('id', '!=', $section->id)
            ->where('name', $request->input('name'))
            ->first();
        if ($section_exists) {
            return redirect()->route('admin.course.sections.edit', $section)->with('warning', 'Section already exists');
        }

        $section->name = $request->input('name');
        $section->details = $request->input('details');

        $section->save();

        return redirect()->route('admin.course.sections.edit', $section)->with('update', 'Section updated successfully.');
    }

    public function sectionDestroy (CourseSection $section)
    {
        $course = $section->course;
        $section->delete();
        return redirect()->route('admin.course.sections', $course)->with('warning', 'Section deleted');
    }

}
