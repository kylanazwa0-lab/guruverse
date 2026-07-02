<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class AdminModulController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $q = $request->query('q', '');
        $course_filter = $request->query('course_id', null);
        $msg = session('success', '');

        $courses = Course::orderBy('title', 'asc')->get(['id', 'title'])->toArray();

        $query = Module::query();
        if ($course_filter) {
            $query->where('course_id', $course_filter);
        }
        
        $modul_list = $query->get()->map(function($m) {
            $arr = $m->toArray();
            $course = Course::find($m->course_id);
            $arr['course_title'] = $course ? $course->title : 'Tanpa Kelas';
            return $arr;
        })->toArray();

        return view('admin.modul', compact('admin', 'q', 'course_filter', 'courses', 'modul_list', 'msg'));
    }

    public function store(Request $request)
    {
        $action = $request->input('action');

        if ($action === 'create') {
            $data = $this->prepareData($request);
            Module::create($data);
            return redirect()->route('admin.modul')->with('success', 'Modul berhasil ditambahkan!');
        } elseif ($action === 'update') {
            $id = (int)$request->input('id');
            $data = $this->prepareData($request);
            Module::where('id', $id)->update($data);
            return redirect()->route('admin.modul')->with('success', 'Modul berhasil diperbarui!');
        } elseif ($action === 'delete') {
            $id = (int)$request->input('id');
            Module::where('id', $id)->delete();
            return redirect()->route('admin.modul')->with('success', 'Modul berhasil dihapus!');
        }

        return redirect()->route('admin.modul');
    }

    private function prepareData(Request $request)
    {
        $data = [
            'course_id' => $request->input('course_id'),
            'title' => $request->input('title'),
            'type' => $request->input('type', 'text'),
            'module_number' => $request->input('module_number'),
            'order_index' => $request->input('order_index'),
            'duration_minutes' => $request->input('duration_minutes', 0),
            'video_url' => $request->input('video_url'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'quiz_data' => $request->input('quiz_data'),
        ];

        // Ensure order_index defaults to module_number if not provided
        if (empty($data['order_index'])) {
            $data['order_index'] = $data['module_number'];
        }

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $filename = 'modul_' . time() . '_' . rand(100,999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/modules'), $filename);
            $data['file_path'] = '/uploads/modules/' . $filename;
        }

        return $data;
    }
}
