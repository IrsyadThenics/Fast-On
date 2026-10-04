@extends('layouts.app')

@section('title', 'Dashboard')
@section('judul', 'Dashboard')

@section('isi')
    <div class="box">
        <h2>Selamat datang, {{ auth()->user()->role?->name }}</h2>
        <p>Pilih menu di bawah atau di sidebar.</p>
    </div>

    <div class="grid">
        @foreach (config('menu') as $m)
            @continue($m['route'] === 'dashboard')
            @can($m['permission'])
                <a class="card" href="{{ route($m['route']) }}">{{ $m['label'] }}</a>
            @endcan
        @endforeach
    </div>
@endsection