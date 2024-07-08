<?php

namespace App\Http\Controllers;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Ambil data aktivitas log yang berhubungan dengan pengguna yang sedang login
        $activityLogs = ActivityLog::where('user_id', Auth::id())
            ->latest()
            ->get();

        // Kembalikan view dengan data aktivitas log
        return view('pages.activitylog', compact('activityLogs'));
    }

    public function store($activity)
    {
        // Simpan aktivitas log baru ke dalam database
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => $activity,
        ]);

        // Redirect atau kembali ke halaman sebelumnya atau ke halaman tertentu
        return back()->with('success', 'Activity logged successfully!');
    }
}
