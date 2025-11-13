@extends('layouts.landing-layout')

@section('title', 'Coding Academy Payakumbuh - Platform E-Learning Terpercaya')

@section('content')
    @include('landing.hero')
    @include('landing.kelas')
    @include('landing.pricing')
    @include('landing.cta')
@endsection
