@extends('layouts.app')

@section('title', 'Home')

@push('css')
<link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
@endpush

@section('content')

<nav class="navbar navbar-light shadow-sm" style="background:#FFD93D;">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/" class="navbar-brand fw-bold">🏠 KontrakanFinder</a>

            <div class="d-flex gap-3">
                <a href="/" class="text-dark">Dashboard</a>
                <a href="{{ route('login') }}" class="text-dark">Login</a>
            </div>
        </div>
    </nav>


<div class="homepage">

    <section class="hero">
        <div class="hero-box">

            <div class="hero-illustration">

                <div class="card-left">
                    <div class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#f1c40f" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M7 21v-2a4 4 0 0 1 3-3.87"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <div class="bar"></div>
                    </div>
                    <div class="lines"></div>
                </div>

                <div class="card-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" stroke="#f1c40f" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 2s8 7.58 8 12a8 8 0 0 1-16 0c0-4.42 8-12 8-12z"/>
                    </svg>
                    <div class="bar"></div>
                    <div class="bar small"></div>
                </div>

                <div class="center-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="white" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"/>
                        <path d="M17 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M7 21v-2a4 4 0 0 1 3-3.87"/>
                    </svg>
                </div>

                <div class="phone">
                    <div class="phone-inner">
                        <div class="phone-screen">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white">
                                <circle cx="11" cy="11" r="8"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="white" stroke-width="2"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            <h1 class="hero-title">
                TEMUKAN TEMAN<br>
                KONTRAKAN IDEAL<br>
                DENGAN MUDAH
            </h1>

            <p class="hero-desc">
                Kontrakanfinder adalah platform untuk mencari teman kontrakan yang sesuai.
                Hemat biaya, berbagi pengalaman, dan temukan teman kontrakan yang cocok untuk Anda!
            </p>

            <a href="{{ route('dashboard') }}" class="btn-start">
                Getting Start →
            </a>
        </div>
    </section>

</div>

@endsection