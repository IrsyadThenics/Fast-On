@extends('layouts.app')

@section('title', 'Upload Data PB/PD')
@section('judul', 'Upload Data PB/PD')

@section('isi')
    @if (session('hasil'))
        @php $h = session('hasil'); @endphp
        <div class="box">
            <b>Upload selesai:</b>
            {{ $h['baru'] }} data baru, {{ $h['diperbarui'] }} diperbarui, {{ $h['jml_gagal'] }} dilewati.
            <a class="btn" href="{{ route('pbpd.index', ['import' => $h['import_id']]) }}">
                Lihat &amp; filter data ini
            </a>
            @if ($h['jml_gagal'])
                <ul style="margin-top:10px;color:#a61b1b">
                    @foreach ($h['gagal'] as $g) <li>{{ $g }}</li> @endforeach
                </ul>
            @endif
        </div>
    @endif

    <form class="box filter" method="POST" action="{{ route('pbpd.upload') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".xlsx,.xls,.csv" required>
        <select name="ulp_id">
    <option value="">ULP dari kolom Excel</option>
    @foreach ($ulps as $u)
        <option value="{{ $u->id }}">{{ $u->nama }} (jika kolom ULP kosong)</option>
    @endforeach
</select>
        <button class="btn" type="submit">Upload</button>
        @error('file') <span style="color:#a61b1b">{{ $message }}</span> @enderror
    </form>

    <div class="box">
        <b>Riwayat upload</b>
        <div class="scroll">
            <table class="tabel">
                <thead>
                    <tr>
                        <th style="background:#0b3d6b">Waktu</th>
                        <th style="background:#0b3d6b">File</th>
                        <th style="background:#0b3d6b">Oleh (user id)</th>
                        <th style="background:#0b3d6b"></th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($riwayat as $r)
                    <tr>
                        <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $r->file_name }}</td>
                        <td>{{ $r->uploaded_by }}</td>
                        <td><a href="{{ route('pbpd.index', ['import' => $r->id]) }}">Lihat data</a></td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center">Belum ada upload.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection