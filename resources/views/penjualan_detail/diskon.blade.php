<div class="modal fade" id="modal-diskon" tabindex="-1" role="dialog" aria-labelledby="modal-diskon">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Diskon</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-diskon">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama Diskon</th>
                        <th>Diskon</th>
                        <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>
                        @foreach ($diskons as $key => $item)
                            <tr>
                                <td width="5%">{{ $key + 1 }}</td>
                                <td>{{ $item->nama_diskon }}</td>
                                <td>{{ $item->diskon }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs btn-flat"
                                        onclick="pilihDiskon('{{ $item->id_diskon }}', '{{ $item->kode_diskon }}', '{{ $item->diskon }}')">
                                        <i class="fa fa-check-circle"></i>
                                        Pilih
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
