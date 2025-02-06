x<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-lg-3 col-lg-offset-1 control-label">Nama Lengkap</label>
                        <div class="col-lg-6">
                            <input type="text" name="name" id="name" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gender" class="col-lg-3 col-lg-offset-1 control-label">Jenis Kelamin</label>
                        <div class="col-lg-6">
                            <input type="text" name="gender" id="gender" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="placebirth" class="col-lg-3 col-lg-offset-1 control-label">Tempat Lahir</label>
                        <div class="col-lg-6">
                            <input type="text" name="placebirth" id="placebirth" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="datebirth" class="col-lg-3 col-lg-offset-1 control-label">Tanggal Lahir</label>
                        <div class="col-lg-6">
                            <input type="date" name="datebirth" id="datebirth" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-lg-3 col-lg-offset-1 control-label">Alamat</label>
                        <div class="col-lg-6">
                            <input type="text" name="address" id="address" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-lg-3 col-lg-offset-1 control-label">Nomor Telepon</label>
                        <div class="col-lg-6">
                            <input type="text" name="phone" id="phone" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-lg-3 col-lg-offset-1 control-label">Email</label>
                        <div class="col-lg-6">
                            <input type="email" name="email" id="email" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-lg-3 control-label">Password</label>
                        <div class="col-lg-6">
                            <input type="password" name="password" id="password" class="form-control" required
                                minlength="12" oninput="validateForm(this)">
                            <span class="help-block" style="color: red;"></span>
                        </div>
                    </div>
                    <script>
                        function validateForm(input) {
                            var passwordInput = document.getElementById('password');
                            var password = passwordInput.value;

                            // Regex untuk memeriksa apakah password memenuhi persyaratan
                            var regex = /^(?=.[A-Z])(?=.[a-z])(?=.\d)(?=.[@$!%?&])[A-Za-z\d@$!%?&]{12,}$/;

                            var isValid = regex.test(password);

                            var errorMessage = '';
                            if (!isValid) {
                                errorMessage = 'Password minimal berisikan 12 karakter, 1 Kapital, Huruf kecil, Angka, Karakter khusus.';
                            }

                            // Menampilkan pesan kesalahan
                            var errorElement = passwordInput.parentElement.querySelector('.help-block');
                            errorElement.textContent = errorMessage;

                            // Menetapkan warna teks pada pesan kesalahan
                            errorElement.style.color = isValid ? '' : 'red';

                            // Menetapkan border pada input
                            passwordInput.style.border = isValid ? '' : '1px solid red';

                            // Mengembalikan false jika validasi gagal
                            return isValid;
                        }
                    </script>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-lg-3 col-lg-offset-1 control-label">Konfirmasi
                            Password</label>
                        <div class="col-lg-6">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required data-match="#password">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i>
                        Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i
                            class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
