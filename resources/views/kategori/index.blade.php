@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Data Kategori</h4>
            <div class="card-header-action">
                <button type="button" class="btn btn-primary" onclick="create()"><i class="fa fa-plus-circle"></i> Tambah
                    Data</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="5%">No.</th>
                        <th>Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th width="10%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@include('kategori.javascript')
