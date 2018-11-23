<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\CourseEnrollment;
use App\Point;
use App\Student;
use App\StudentGroup;
use App\StudentCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student as StudentValidate;
class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::orderBy('first_name', 'ASC')->paginate(25);
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $student = new Student;
        $student_categories = StudentCategory::orderBy('name', 'ASC')->get();
        $student_groups = StudentGroup::orderBy('name', 'ASC')->get();
        return view('admin.students.create', compact('student','student_categories', 'student_groups'));
    }

    /**
     * @param StudentValidate $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StudentValidate $request)
    {
        $validated = $request->validated();
        Student::create($validated);

        return redirect()->route('admin.students.create')->with('save', 'Student saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $courses = Course::orderBy('name', 'ASC')->get();
        $enrollments = $student->courses;
        return view('admin.students.show', compact('student', 'enrollments','courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $student_categories = StudentCategory::orderBy('name', 'ASC')->get();
        $student_groups = StudentGroup::orderBy('name', 'ASC')->get();
        return view('admin.students.edit', compact('student','student_categories', 'student_groups'));
    }

    /**
     * @param StudentValidate $request
     * @param Student $student
     */
    public function update(StudentValidate $request, Student $student)
    {
        $validated = $request->validated();
        $student->update($validated);
        return redirect()->route('admin.students.edit', $student)->with('update', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('warning', 'Student deleted');
    }

    /**
     * add course to student
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCourse(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required',
        ]);

        $enrollment_exists = CourseEnrollment::where('course_id', $request->input('course_id'))
            ->where('student_id', $request->input('student_id'))
            ->first();
        $student = Student::find($request->input('student_id'));
        if ($enrollment_exists) {
            return redirect()->route('admin.students.show', $student)->with('warning', 'Course already exists');
        }

        $enrollment = new CourseEnrollment;
        $enrollment->student_id = $request->input('student_id');
        $enrollment->course_id = $request->input('course_id');
        $enrollment->save();

        return redirect()->route('admin.students.show', $student)->with('save', 'Course saved successfully');
    }

    /**
     * show student course details
     * @param Student $student
     * @param Course $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profileCourse (Student $student, Course $course)
    {
        $enrollment = CourseEnrollment::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->first();
        $points = $enrollment->points()->orderBy('created_at', 'ASC')->get();
        $points_calculation = $course->percentage_complete($student->id, $course->id);

        return view('admin.students.course_profile', compact(
            'student',
            'course',
            'enrollment',
            'points',
            'points_calculation'
        ));
    }

    /**
     * delete student points entry
     * @param Point $point
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function profilePointDestroy (Point $point) {
        $point->delete();
        return redirect()->route('admin.students.profile.course', ['student' => $point->student_id, 'course' => $point->course_id])->with('warning', 'Deleted successfully');
    }

    /**
     * update student points/hours/minutes
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profilePointUpdate (Request $request) {
        $validatedData = $request->validate([
            'hours' => 'required',
            'minutes' => 'required',
            'points' => 'required',
        ]);


        $point = Point::findOrFail($request->input('id'));
        $point->hours = $request->input('hours');
        $point->minutes = $request->input('minutes');
        $point->points = $request->input('points');

        $point->save();

        return redirect()->route('admin.students.profile.course', ['student' => $point->student_id, 'course' => $point->course_id])->with('update', 'Updated successfully');
    }
}
