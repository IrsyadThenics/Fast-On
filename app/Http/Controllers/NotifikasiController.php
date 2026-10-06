<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        return view('notifikasi.index', [
            'notifications' => AppNotification::where('user_id', auth()->id())->orderByDesc('id')->paginate(30),
            'unread' => AppNotification::where('user_id', auth()->id())->whereNull('read_at')->count(),
        ]);
    }

    public function read(AppNotification $notification)
    {
        abort_unless((int) $notification->user_id === (int) auth()->id(), 403);
        $notification->update(['read_at' => now()]);

        return $notification->url ? redirect($notification->url) : back();
    }

    public function readAll()
    {
        AppNotification::where('user_id', auth()->id())->whereNull('read_at')->update(['read_at' => now()]);
        return back()->with('success', 'Semua notifikasi sudah dibaca.');
    }
}
