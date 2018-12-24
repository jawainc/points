<?php

namespace App\Http\Controllers\Api;

use App\Course;
use App\CourseEnrollment;
use App\CourseSection;
use App\Http\Resources\PointResource;
use App\Point;
use App\Setting;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentSearchResource;
use Illuminate\Support\Facades\Hash;

class PointsController extends Controller
{
    /**
     * search for student name
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadStudentName(Request $request)
    {
        $search = $this->escape_like($request->input('name'));
        $names = Student::where('first_name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%')->get();

        $student_password = Setting::where('name', 'Enable Student Password')->first();

        return response()->json([
                'students' => StudentSearchResource::collection($names),
                'student_password_enable' => ($student_password && $student_password->value == '1')
            ]
        );

    }

    public function studentVerifyPassword(Request $request)
    {
        $user_student = User::where('student_id', $request->student_id)->first();
        $data = [
            'verified' => false,
            'errorMessage' => 'Invalid password'
        ];
        if ($user_student) {
            if (Hash::check($request->password, $user_student->password)) {
                $data = [
                    'verified' => true,
                    'errorMessage' => ''
                ];
            }
        }

        return response()->json($data);
    }

    /**
     * load sections
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadSessions(Request $request)
    {
        $student_id = $request->input('student_id');
        $course_id = $request->input('course_id');
        $enrollment = CourseEnrollment::where('student_id', $student_id)
            ->where('course_id', $course_id)
            ->firstOrFail();
        $enrollment_points_ids = $enrollment->points()->pluck('course_section_id')->toArray();
        $course_sections = CourseSection::where('course_id', $course_id)
            ->whereNotIn('id', $enrollment_points_ids)
            ->orderBy('name', 'ASC')
            ->get();

        $data = [];
        foreach ($course_sections as $section) {
            array_push($data, [
                'text' => $section->name,
                'value' => [
                    'section_id' => $section->id,
                    'section_name' => $section->name,
                    'student_id' => $student_id,
                    'course_id' => $course_id,
                    'enrollment_id' => $enrollment->id
                ]
            ]);
        }

        return response()->json($data);
    }

    /**
     * save student points
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePoints(Request $request)
    {
        $point = new Point;
        $point->course_id = $request->input('course_id');
        $point->course_enrollment_id = $request->input('enrollment_id');
        $point->course_section_id = $request->input('section_id');
        $point->student_id = $request->input('student_id');
        $point->student_group_id = $request->input('student_group_id');
        $point->points = $request->input('points');
        $point->hours = $request->input('hours');
        $point->minutes = $request->input('minutes');

        $point->save();

        return response()->json(['save' => true]);

    }

    /**
     * get data for student course graph
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentGraphData(Request $request)
    {
        $points_data = Point::where('course_enrollment_id', $request->input('enrollment_id'))->orderBy('created_at', 'ASC')->get();
        $student = CourseEnrollment::find($request->input('enrollment_id'))->student;
        $course = Course::find($request->input('course_id'));

        $data = [
            'course_name' => $course->name,
            'student_name' => $student->full_name,
            'graph_data' => []
        ];

        foreach ($points_data as $point) {
            $temp_ar = [
                'points_hours' => number_format((float)($point->points / ($point->hours . '.' . $point->minutes)), 2, '.', ''),
                'hours' => $point->hours . '.' . $point->minutes,
                'points' => $point->points,
                'date' => $point->created_at->format('m/d/Y')
            ];
            array_push($data['graph_data'], $temp_ar);
        }


        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentCourseData(Request $request)
    {
        $enrollment = CourseEnrollment::find($request->input('enrollment_id'));

        return response()->json([
            'course_name' => $enrollment->course->name,
            'student_name' => $enrollment->student->full_name
        ]);
    }

    /**
     * Escape special characters for a LIKE query.
     *
     * @param string $value
     * @param string $char
     *
     * @return string
     */
    function escape_like(string $value, string $char = '\\'): string
    {
        return str_replace(
            [$char, '%', '_'],
            [$char . $char, $char . '%', $char . '_'],
            $value
        );
    }
}

