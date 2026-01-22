@extends('layouts.app')

@section('title','Admin Dashboard')

@push('css')
<style>
body { background:#FFFDE7; }
.admin-card{
    border-radius:18px;
    border:none;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
}
.btn-yellow{
    background:#FFD54F;
    border:none;
    font-weight:600;
    border-radius:12px;
}
</style>
@endpush

@section('content')
<div class="container py-4">

<h3 class="mb-4">🛡️ Admin Dashboard</h3>

<div class="row">
    <div class="col-md-4">
        <div class="card admin-card text-center p-4">
            <h5>🚨 Laporan Kontrakan</h5>
            <a href="{{ route('admin.laporan') }}" class="btn btn-yellow mt-3">
                Kelola Laporan
            </a>
        </div>
    </div>
</div>

</div>
@endsection
