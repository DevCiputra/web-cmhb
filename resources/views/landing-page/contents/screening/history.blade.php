@extends('landing-page.layouts.app')

@section('title', 'Riwayat Skrining')

@section('content')
<div class="container mt-5">
    <h4>Riwayat Pengisian Skrining Psikologi</h4>

    @if($histories->isEmpty())
    <p>Anda belum memiliki riwayat pengisian skrining.</p>
    @else
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Tanggal Pengisian</th>
                <th>Skor Total Distres</th>
                <th>Klasifikasi Total Distres</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $history)
            <tr>
                <td>{{ $history->created_at->format('d-m-Y') }}</td>
                <td>{{ $history->total_distress_score }}</td>
                <td>{{ $history->total_distress_classification }}</td>
                <td>
                    <a href="{{ route('showResult', $history->id) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection


@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/consultation.css') }}">
@endpush