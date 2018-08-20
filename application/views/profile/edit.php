<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<div class="header bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-data.jpg')?>') 0 -150px/100% no-repeat !important; -webkit-filter: brightness(111%) contrast(80%); filter: brightness(111%) contrast(80%);">
    <div class="container-fluid">
        <div class="header-body">
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Profil</h4>
                </div>
                <div class="card-body bg-info">
                    <div class="row">
                        <div class="col-sm-8">
                            <form action="<?=site_url('profile/update')?>" method='post'>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-white" for="tambah_user-nama_lengkap">Nama Lengkap</label>
                                            <input type="text" name="user-nama_lengkap" id="tambah_user-nama_lengkap" class="form-control form-control-alternative" placeholder="Nama.." value="<?=$user_active['userdata']->nama_lengkap?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-white" for="tambah_user-username">Username</label>
                                            <input type="text" name="user-username" id="tambah_user-username" class="form-control form-control-alternative" placeholder="Username.." value="<?=$user_active['userdata']->username?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-white" for="tambah_user-password">Password</label>
                                            <input type="password" name="user-password" id="tambah_user-password" class="form-control form-control-alternative" placeholder="Password...">
                                            <span class="help-block text-white">Biarkan kosong jika tidak ingin merubah password</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group" id="tambah_user-password_confirm-wrapper">
                                            <label class="font-weight-bold text-white" for="tambah_user-password_confirm">Konfirmasi Password</label>
                                            <input type="password" name="user-password_confirm" id="tambah_user-password_confirm" class="form-control form-control-alternative" placeholder="Konfirmasi Password...">
                                            <span class="help-block text-white" id="tambah_user-password_confirm-help" style="display: none">Konfirmasi password tidak cocok</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-white" for="tambah_user-avatar">Avatar</label>
                                            <input type="file" name="user-avatar" id="tambah_user-avatar" class="form-control form-control-alternative element-gambar">
                                            <span class="help-block text-white">Biarkan kosong jika tidak ingin merubah gambar.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-white" for="tambah_user-alamat">Alamat</label>
                                            <textarea name="user-alamat" id="tambah_user-alamat" class="form-control form-control-alternative" rows="3"><?=$user_active['userdata']->alamat?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-white" for="tambah_user-alamat_printer">Alamat Printer</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">smb://</span>
                                                </div>
                                                <input type="text" value="<?=$user_active['userdata']->alamat_printer?>" name="user-alamat_printer" id="tambah_user-alamat_printer" class="form-control form-control-alternative" placeholder="192.168.1....">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-white" for="tambah_user-nama_printer">Nama Printer</label>
                                            <input type="text" value="<?=$user_active['userdata']->nama_printer?>" name="user-nama_printer" id="tambah_user-nama_printer" class="form-control form-control-alternative" placeholder="Nama..">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-4">
                            <label class="font-weight-bold text-white">Pratinjau</label><br>
                            <img class="img-thumbnail" src="<?=site_url($user_active['userdata']->avatar)?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->view('argon/js_script')?>
<?php $this->view('argon/footer')?>
