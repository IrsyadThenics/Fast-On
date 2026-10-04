@extends('layouts.app')
@section('title', 'Notifikasi')
@section('judul', 'Notifikasi')
@section('isi')
<div class="box notif-box">
    <div class="notif-head"><h2>Notifikasi</h2><form method="POST" action="{{ route('notifikasi.read-all') }}">@csrf<button type="submit">Tandai semua dibaca</button></form></div>
    @forelse ($notifications as $notification)
        <form method="POST" action="{{ route('notifikasi.read', $notification) }}">@csrf<button type="submit" class="notif-item {{ $notification->read_at ? 'read' : 'unread' }}">
            <strong>{{ $notification->title }}</strong><span>{{ $notification->message }}</span><small>{{ $notification->created_at?->format('d/m/Y H:i') }}</small>
        </button></form>
    @empty <p>Belum ada notifikasi.</p> @endforelse
    <div class="halaman">{{ $notifications->links() }}</div>
</div>
<style>.notif-head{display:flex;justify-content:space-between;align-items:center;gap:12px}.notif-head h2{margin:0;color:#0b3d6b}.notif-item{display:grid;gap:4px;width:100%;padding:14px;margin-top:10px;border:1px solid #d6e2ee;border-radius:8px;color:#223;text-align:left;background:#fff}.notif-item.unread{border-left:4px solid #0b5ea8;background:#eef7ff}.notif-item.read{opacity:.72}.notif-item strong{color:#0b3d6b}.notif-item small{color:#637487}.halaman{margin-top:16px}</style>
@endsection
