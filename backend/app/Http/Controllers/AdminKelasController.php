<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class AdminKelasController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $search = $request->query('search', '');
        $msg = session('success', '');

        $query = Course::query();
        if ($search !== '') {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('mentor_name', 'like', "%{$search}%");
        }
        $kelas_list = $query->orderBy('created_at', 'desc')->get()->toArray();

        return view('admin.kelas', compact('admin', 'search', 'kelas_list', 'msg'));
    }

    public function store(Request $request)
    {
        $action = $request->input('action');

        if ($action === 'create') {
            $data = $this->prepareData($request);
            Course::create($data);
            return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil ditambahkan!');
        } elseif ($action === 'update') {
            $id = (int)$request->input('id');
            $data = $this->prepareData($request);
            Course::where('id', $id)->update($data);
            return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil diperbarui!');
        } elseif ($action === 'delete') {
            $id = (int)$request->input('id');
            Course::where('id', $id)->delete();
            return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil dihapus!');
        }

        return redirect()->route('admin.kelas');
    }

    private function prepareData(Request $request)
    {
        $is_paid = $request->input('is_paid', 0);
        $data = [
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'duration_hours' => $request->input('duration_hours'),
            'mentor_name' => $request->input('mentor_name'),
            'description' => $request->input('description'),
            'status' => $request->input('status', 'draft'),
            'is_free' => $is_paid == 1 ? 0 : 1,
            'payment_link' => $is_paid == 1 ? $request->input('payment_link') : null,
            'cert_config' => $request->input('cert_config')
        ];

        if ($request->hasFile('cert_template') && $request->file('cert_template')->isValid()) {
            $file = $request->file('cert_template');
            $filename = 'cert_' . time() . '_' . rand(100,999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/cert_templates'), $filename);
            $data['cert_template'] = $filename;
        }

        return $data;
    }
}
