<?php

namespace App\Http\Controllers\Api;

use App\Course;
use App\Http\Resources\StudentCategoryListResource;
use App\Http\Resources\StudentGroupResource;
use App\Point;
use App\Student;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentCategoryResource;
use App\Http\Resources\StudentSearchResource;
use App\StudentCategory;
use App\StudentGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GraphsController extends Controller
{

    /**
     * student groups
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentGroups () {
        $groups = StudentGroup::orderBy('name', 'ASC')->get();
        return response()->json(StudentGroupResource::collection($groups));
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
        $query->selectRaw('SUM(points) as total_points, SUM(hours) as t_hours, SUM(minutes) as total_minutes, date(created_at) as date');

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
     * students for group graphs
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGroupGraphItems ($id) {
        $group = StudentGroup::find($id);
        return response()->json([
            'name' => $group->name,
            'students' => StudentCategoryListResource::collection($group->students)
        ]);
    }

    /**
     * get graph data for group
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGroupGraphData (Request $request) {
        $query = Point::query();
        $query->selectRaw('SUM(points) as total_points, SUM(hours) as t_hours, SUM(minutes) as total_minutes, date(created_at) as date');

        if ($request->has('student_id') && !empty($request->input('student_id'))) {
            $query->where('student_id', $request->input('student_id'));
        } else {
            $group = StudentGroup::findOrfail($request->input('group_id'));
            $student_ids = $group->students()->pluck('id')->toArray();
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

