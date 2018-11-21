<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Role;
use Illuminate\Support\Facades\Hash;

class GraphsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name', 'ASC')->paginate(25);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User;
        $roles = Role::orderBy('name', 'ASC')->get();
        $students = Student::orderBy('first_name', 'ASC')->get();
        return view('admin.users.create', compact('user','students', 'roles'));
    }

    /**
     * @param StudentValidate $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email||unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'role_id' => 'required'
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');
        $user->student_id = $request->input('student_id');
        $user->save();

        return redirect()->route('admin.users.create')->with('save', 'User saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        $students = Student::orderBy('first_name', 'ASC')->get();
        return view('admin.users.edit', compact('user','students', 'roles'));
    }

    /**
     * @param Request $request
     * @param User $student
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'confirm_password' => 'sometimes|same:password',
            'role_id' => 'required'
        ]);
        $user->name = $request->input('name');
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');
        $user->student_id = $request->input('student_id');
        $user->save();

        return redirect()->route('admin.users.edit', $user)->with('update', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('warning', 'User deleted');
    }

}
