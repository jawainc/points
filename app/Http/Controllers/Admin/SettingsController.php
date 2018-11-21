<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = new Setting;
        $settings = Setting::orderBy('name', 'ASC')->get();
        return view('admin.settings.index', compact('settings', 'setting'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:settings,name'
        ]);
        $setting = new Setting();
        $setting->name = $request->input('name');
        $setting->value = $request->input('value');
        $setting->type = $request->input('type');
        $setting->save();

        return redirect()->route('admin.settings.index')->with('save', 'Saved successfully');
    }

    /**
     * @param Request $request
     * @param Setting $setting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Setting $setting)
    {
        $setting->value = $request->input('value');
        $setting->save();

        return redirect()->route('admin.settings.index')->with('update', 'Updated successfully');
    }

    /**
     * @param Setting $setting
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('admin.settings.index')->with('warning', 'Setting deleted');
    }

}
