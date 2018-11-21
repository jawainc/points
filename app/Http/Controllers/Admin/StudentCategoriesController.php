<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\StudentCategory;
use Illuminate\Http\Request;

class StudentCategoriesController extends Controller
{

    /**
     * Student Groups
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categories()
    {
        $student_categories = StudentCategory::orderBy('name', 'ASC')->paginate(25);
        return view('admin.students.categories.categories', compact('student_categories'));
    }

    /**
     * New Student Category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categories_new()
    {
        $student_category = new StudentCategory;
        return view('admin.students.categories.categories_new', compact('student_category'));
    }

    /**
     * Edit Student Category
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categories_edit($id)
    {
        $student_category = StudentCategory::findOrFail($id);
        return view('admin.students.categories.categories_edit', compact('student_category'));
    }

    /**
     * Add new student group
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function categories_add(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:student_categories,name',
        ]);

        $student_category = new StudentCategory;
        $student_category->name = $request->name;
        $student_category->save();

        return redirect()->route('admin.students.categories.new')->with('save', 'Category saved successfully');
    }

    /**
     * Update student group
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function categories_update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:student_categories,name,'.$request->id,
        ]);

        $student_category = StudentCategory::findOrFail($request->id);
        $student_category->name = $request->name;
        $student_category->save();

        return redirect()->route('admin.students.categories.edit', ['id' => $student_category->id])->with('update', 'Category updated successfully');
    }

    /**
     * Delete Record
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy (Request $request) {
        $student_category = StudentCategory::findOrFail($request->id);
        $student_category->delete();
        return redirect()->route('admin.students.categories')->with('info', 'Category deleted!');
    }
}

