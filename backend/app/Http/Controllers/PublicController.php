<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class PublicController extends Controller
{
    /**
     * Halaman Beranda Utama (Rekonstruksi dari legacy index.php)
     */
    public function index()
    {
        return view('public.index');
    }

    public function about()
    {
        return view('public.about');
    }

    public function learnMore()
    {
        $products = \App\Models\Product::limit(4)->get();
        return view('public.learn_more', compact('products'));
    }

    public function products()
    {
        $products = \App\Models\Product::all();
        return view('public.products', compact('products'));
    }

    public function artikel()
    {
        return view('public.artikel');
    }

    public function program()
    {
        return view('public.program');
    }

    public function testimoni()
    {
        return view('public.testimoni');
    }

    public function infoGuruInspira()
    {
        return view('public.info_guruinspira');
    }

    public function card(Request $request)
    {
        return view('public.card');
    }

    public function getMember(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json(['success' => false, 'message' => 'Member ID is required']);
        }

        $member = Member::where('member_id', $id)->first();
        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member not found']);
        }

        return response()->json([
            'success' => true,
            'member' => [
                'full_name' => $member->full_name,
                'institution' => $member->institution,
                'member_id' => $member->member_id,
                'email' => $member->email,
                'phone' => $member->phone,
                'joined_at' => $member->created_at,
                'photo_path' => $member->photo_path ?? 'default.png'
            ]
        ]);
    }
}
