@extends('layouts.landing-layout')

@section('title', 'Materi Online - Platform E-Learning')

@section('content')
    @include('landing.hero')
    @include('landing.fitur')
    @include('landing.kelas')
    @include('landing.alur')
    @include('landing.cta')
@endsection
