<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<div class="header d-print-none bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-konfigurasi.png')?>') 0 -240px/100% no-repeat !important; -webkit-filter: brightness(151%) contrast(160%); filter: brightness(151%) contrast(160%);">
    <div class="container-fluid">
        <div class="header-body">
        </div>
    </div>
</div>
<div class="container-fluid mt--5">
    <div class="row">
        <div class="col">
            <div class="card border-0 mb-6">
                <div class="card-header">
                    <h4 class="title mb-0">Konfigurasi sistem</h4>
                </div>
                <div class="card-body bg-info">
                    <form id="form-konfigurasi" action="<?=site_url('konfigurasi/update')?>" method='post' enctype='multipart/form-data'>
                        <div class="row">
                            <div class="col-sm">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label text-white">Nama Toko</label>
                                            <input type="text" name="APP_NAMA_TOKO" class="form-control form-control-alternative shadow" value="<?=$app_nama_toko?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label text-white">Alamat Toko</label>
                                            <textarea class="form-control form-control-alternative shadow" rows="3" name="APP_ALAMAT"><?=$app_alamat?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label text-white">Logo</label>
                                            <input class="element-gambar form-control form-control-alternative shadow" type="file" name="APP_LOGO">
                                            <span class="help-block text-white">Biarkan kosong jika tidak ingin merubah logo.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label text-white">PPN</label>
                                            <div class="input-group input-group-alternative">
                                                <input type="number" name="DATA_PPN" class="form-control form-control-alternative shadow" value="<?=$data_ppn?>">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label text-white">Default Interval Warning Stok</label>
                                            <div class="input-group input-group-alternative">
                                                <input type="text" name="DATA_DEFAULT_MIN_STOK" class="form-control form-control-alternative shadow" value="<?=$data_default_min_stok?>">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Hari</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label text-white">Default Interval Warning Kadaluarsa</label>
                                            <div class="input-group input-group-alternative">
                                                <input type="text" name="DATA_DEFAULT_KADALUARSA" class="form-control form-control-alternative shadow" value="<?=$data_default_kadaluarsa?>">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Hari</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <img class="gambar-fill img-thumbnail" src="<?=site_url('assets/custom/images/konfigurasi/APP_LOGO/' .$app_logo)?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-secondary btn-block">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->view('argon/js_script')?>
<script type="text/javascript">
</script>
<?php $this->view('argon/footer')?>
