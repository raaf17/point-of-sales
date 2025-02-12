@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Dashboard</h4>
            <div class="card-header-action">
                <a href="{{ route('transaksi.baru') }}" class="btn btn-primary">Kasir</a>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <h4 class="alert-heading">Hello, {{ auth()->user()->name }}</h4>
                <p>Selamat datang di aplikasi <b>Kasirku</b></p>
            </div>
        </div>
    </div>
@endsection
