<?php
$sourcePath = 'C:\laragon\www\guruverse\backend\resources\views\member\pages\Guru_Belajar\modul.php';
$destPath = 'C:\laragon\www\guruverse\backend\resources\views\member\modul.blade.php';

$content = file_get_contents($sourcePath);

$bladeContent = "@extends('layouts.member')

@section('title', ucwords(str_replace('_', ' ', 'modul')))

@section('content')

" . $content . "

@endsection
";

file_put_contents($destPath, $bladeContent);
echo "Done.";
