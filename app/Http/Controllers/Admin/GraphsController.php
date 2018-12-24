<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\CourseCategory;
use App\CourseSection;
use App\Http\Controllers\Controller;
use App\Student;
use App\StudentGroup;
use Illuminate\Http\Request;
use App\Point;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GraphsController extends Controller
{
    /**
     * Display Graph.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Point::query();
        $query->selectRaw('SUM(points) as total_points, SUM(hours) as t_hours, SUM(minutes) as total_minutes, date(created_at) as date');

        if ($request->has('student_id') && !empty($request->input('student_id'))) {
            $query->where('student_id', $request->input('student_id'));
        }

        if ($request->has('group_id') && !empty($request->input('group_id'))) {
            $query->where('student_group_id', $request->input('group_id'));
        }

        if ($request->has('section_id') && !empty($request->input('section_id'))) {
            $query->where('course_section_id', $request->input('section_id'));
        }

        if ($request->has('course_id') && !empty($request->input('course_id'))) {
            $query->where('course_id', $request->input('course_id'));
        }

        if ($request->has('from_date') && !empty($request->input('from_date'))) {
            $query->whereRaw("date(created_at) >= '". Carbon::parse($request->input('from_date'))->format('Y-m-d') ."'");
        } else if (!$request->has('student_id') && !$request->has('course_id')) {
            $start_date = new Carbon('first day of this month');
            $query->whereRaw("date(created_at) >= '". $start_date->format('Y-m-d') ."'");
        }

        if ($request->has('to_date') && !empty($request->input('to_date'))) {
            $query->whereRaw("date(created_at) <= '". Carbon::parse($request->input('to_date'))->format('Y-m-d') ."'");
        } else if (!$request->has('student_id') && !$request->has('course_id')) {
            $end_date = new Carbon('last day of this month');
            $query->whereRaw("date(created_at) <= '". $end_date->format('Y-m-d') ."'");
        }

        $query->groupBy(DB::raw('date(created_at) ASC'));

        $points = $query->get();

        $courses = Course::orderBy('name', 'ASC')->get();
        $course_sections = CourseSection::orderBy('name', 'ASC')->get();
        $students = Student::orderBy('first_name', 'ASC')->get();
        $groups = StudentGroup::orderBy('name', 'ASC')->get();
        $categories = CourseCategory::orderBy('name', 'ASC')->get();

        $request->flash();

        return view('admin.graphs.index', compact(
            'points',
            'courses',
            'course_sections',
            'students',
            'groups',
            'categories'
        ));
    }


}
