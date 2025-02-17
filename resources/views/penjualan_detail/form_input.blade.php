<div class="col-md-7">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group row">
                        <label for="kode_member">Member</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="kode_member"
                                value="{{ $memberSelected->kode_member }}">
                            <span class="input-group-btn">
                                <button onclick="tampilMember()" class="btn btn-info btn-flat" type="button"><i
                                        class="fa fa-arrow-right"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <form class="form-produk">
                        @csrf
                        <div class="form-group row">
                            <label for="kode_produk">Kode Produk</label>
                            <div class="input-group">
                                <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                                <span class="input-group-btn">
                                    <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"><i
                                            class="fa fa-arrow-right"></i></button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="form-group row">
                        <label for="kode_diskon">Diskon</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="kode_diskon"
                                value="{{ $memberSelected->diskon }}">
                            <span class="input-group-btn">
                                <button onclick="tampilDiskon()" class="btn btn-info btn-flat" type="button"><i
                                        class="fa fa-arrow-right"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table table-stiped table-bordered table-penjualan">
                    <thead>
                        <th width="5%">No.</th>
                        <th width="10%">Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="8%">Jumlah</th>
                        <th width="8%">Diskon</th>
                        <th>Subtotal</th>
                        <th width="3%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
            <div class="row">
                <div class="tampil-bayar bg-primary text-white"></div>
            </div>
        </div>
    </div>
</div>
