<?php

namespace App\Http\Controllers\Api;

use App\Course;
use App\Http\Resources\StudentCategoryListResource;
use App\Point;
use App\Student;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentCategoryResource;
use App\Http\Resources\StudentSearchResource;
use App\StudentCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GraphsController extends Controller
{

    /**
     * student categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentCategories () {
        $categories = StudentCategory::orderBy('name', 'ASC')->get();
        return response()->json(StudentCategoryResource::collection($categories));
    }

    /**
     * get students and courses
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentGraphItems () {
        $data = [
            'students' => StudentSearchResource::collection(Student::orderBy('first_name', 'ASC')->get()),
            'courses' => CourseResource::collection(Course::orderBy('name', 'ASC')->get())
        ];

        return response()->json($data);
    }

    /**
     * get graph data for student
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentGraphData (Request $request) {

        $query = Point::query();
        $query->selectRaw('SUM(points) as total_points, SUM(hours) as total_hours, SUM(minutes) as total_minutes, date(created_at) as date');

        if ($request->has('student_id') && !empty($request->input('student_id'))) {
            $query->where('student_id', $request->input('student_id'));
        }

        if ($request->has('course_id') && !empty($request->input('course_id'))) {
            $query->where('course_id', $request->input('course_id'));
        }

        if ($request->has('from_date') && !empty($request->input('from_date'))) {
            $query->whereRaw("date(created_at) >= '". $request->input('from_date') ."'");
        } else {
            $start_date = new Carbon('first day of this month');
            $query->whereRaw("date(created_at) >= '". $start_date->format('Y-m-d') ."'");
        }

        if ($request->has('to_date') && !empty($request->input('to_date'))) {
            $query->whereRaw("date(created_at) <= '". $request->input('to_date') ."'");
        } else {
            $end_date = new Carbon('last day of this month');
            $query->whereRaw("date(created_at) <= '". $end_date->format('Y-m-d') ."'");
        }

        $query->groupBy(DB::raw('date(created_at) ASC'));

        $points = $query->get();

        return response()->json($points);
    }

    /**
     * students for category graphs
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoryGraphItems ($id) {
        $category = StudentCategory::find($id);
        return response()->json([
            'name' => $category->name,
            'students' => StudentCategoryListResource::collection($category->students)
        ]);
    }

    /**
     * get graph data for category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoryGraphData (Request $request) {
        $query = Point::query();
        $query->selectRaw('SUM(points) as total_points, SUM(hours) as total_hours, SUM(minutes) as total_minutes, date(created_at) as date');

        if ($request->has('student_id') && !empty($request->input('student_id'))) {
            $query->where('student_id', $request->input('student_id'));
        } else {
            $category = StudentCategory::findOrfail($request->input('category_id'));
            $student_ids = $category->students()->pluck('id')->toArray();
            $query->whereIn('student_id', $student_ids);
        }

        if ($request->has('from_date') && !empty($request->input('from_date'))) {
            $query->whereRaw("date(created_at) >= '". $request->input('from_date') ."'");
        } else {
            $start_date = new Carbon('first day of this month');
            $query->whereRaw("date(created_at) >= '". $start_date->format('Y-m-d') ."'");
        }

        if ($request->has('to_date') && !empty($request->input('to_date'))) {
            $query->whereRaw("date(created_at) <= '". $request->input('to_date') ."'");
        } else {
            $end_date = new Carbon('last day of this month');
            $query->whereRaw("date(created_at) <= '". $end_date->format('Y-m-d') ."'");
        }

        $query->groupBy(DB::raw('date(created_at) ASC'));

        $points = $query->get();

        return response()->json($points);
    }
}

