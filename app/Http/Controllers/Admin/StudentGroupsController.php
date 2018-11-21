<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\StudentGroup;
use Illuminate\Http\Request;

class StudentGroupsController extends Controller
{

    /**
     * Student Groups
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groups()
    {
        $student_groups = StudentGroup::orderBy('name', 'ASC')->paginate(25);
        return view('admin.students.groups.groups', compact('student_groups'));
    }

    /**
     * New Student Group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groups_new()
    {
        $student_group = new StudentGroup;
        return view('admin.students.groups.groups_new', compact('student_group'));
    }

    /**
     * Edit Student Group
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groups_edit($id)
    {
        $student_group = StudentGroup::findOrFail($id);
        return view('admin.students.groups.groups_edit', compact('student_group'));
    }

    /**
     * Add new student group
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function groups_add(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:student_groups,name',
        ]);

        $student_group = new StudentGroup;
        $student_group->name = $request->name;
        $student_group->save();

        return redirect()->route('admin.students.groups.new')->with('save', 'Group saved successfully');
    }

    /**
     * Update student group
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function groups_update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:student_groups,name,'.$request->id,
        ]);

        $student_group = StudentGroup::findOrFail($request->id);
        $student_group->name = $request->name;
        $student_group->save();

        return redirect()->route('admin.students.groups.edit', ['id' => $student_group->id])->with('update', 'Group updated successfully');
    }

    /**
     * Delete Record
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy (Request $request) {
        $student_category = StudentGroup::findOrFail($request->id);
        $student_category->delete();
        return redirect()->route('admin.students.groups')->with('info', 'Group deleted!');
    }
}

