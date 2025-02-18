@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Data Produk</h4>
            <div class="card-header-action">
                <button type="button" class="btn btn-primary" onclick="create()"><i class="fa fa-plus-circle"></i> Tambah
                    Data</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No.</th>
                            <th>Nama Barang</th>
                            <th>Kategori Barang</th>
                            <th>Sisa Stok</th>
                            <th>Satuan</th>
                            <th>HPP</th>
                            <th>Harga Jual 1</th>
                            <th>Harga Jual 2</th>
                            <th>Harga Jual 3</th>
                            <th width="12%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('produk.javascript')
