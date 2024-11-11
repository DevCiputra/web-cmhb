@extends('layouts.app')

@section('content')
<h1>Hasil Skrining Anda</h1>
<p>Total Skor: {{ $totalScore }}</p>
<p>Klasifikasi: {{ $classification->classification_name }}</p>
<p>Keterangan: {{ $classification->description }}</p>
@endsection