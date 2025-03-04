<div class="col-md-5">
    <div class="card">

        <div class="card-header d-flex justify-content-between pb-2">
            <h4 class="card-title">Ringkasan Belanja</h4>
        </div>
        <div class="card-body">
            <div class="card mb-3 shadow-sm" id="card-member">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1 fw-bold">Nama</p>
                            <p class="mb-0" id="nama"></p>
                        </div>
                        <div class="col-6">
                            <p class="mb-1 fw-bold">Poin Member</p>
                            <p class="mb-0" id="poin"></p>
                        </div>
                    </div>
                    <div class="mt-3 d-flex align-items-center">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="poin_check">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Pakai Poin Member</label>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                @csrf
                <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                <input type="hidden" name="total" id="total">
                <input type="hidden" name="total_item" id="total_item">
                <input type="hidden" name="bayar" id="bayar">
                <input type="hidden" name="diskonrp" id="diskonrp">
                <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- Poin Didapatkan = Total Akhir * 2/100 --}}
                            <label for="poin_didapat">Poin Didapatkan</label>
                            <input type="text" class="form-control" name="poin_didapat" id="poin_didapat" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="poin_digunakan">Poin Digunakan</label>
                            <input type="text" id="poin_digunakan" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalrp">Total Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="text" id="totalrp" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="diskon">Diskon</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="text" id="diskon" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ppn">PPN 12%</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="text" id="ppn" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{-- Total Akhir = Total Harga - Diskon + PPN(12/100 * Total Harga) --}}
                    <label for="bayarrp" class="fs-5">Total Akhir</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="text" id="bayarrp" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="diterima">Diterima</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="number" id="diterima" class="form-control" name="diterima"
                            value="{{ $penjualan->diterima ?? 0 }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="alert alert-light-primary kembali" style="margin-left: 11px; width: 486px;">
                        <h6 class="py-1" style="margin-bottom: -0px;">
                            Kembalian : Rp. <span id="kembalirp"></span></h6>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary btn-block btn-simpan"><i
                                class="fa fa-check"></i>
                            Simpan</button>
                    </div>
                    <div class="col-md-6">
                        <button type="reset" class="btn btn-secondary btn-block">
                            Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
