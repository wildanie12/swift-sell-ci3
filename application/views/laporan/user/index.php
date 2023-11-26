<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<div class="header d-print-none bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-laporan.jpg')?>') 0 -570px/100% no-repeat !important; -webkit-filter: brightness(80%) contrast(160%); filter: brightness(80%) contrast(160%);">
   <div class="container-fluid">
      <div class="header-body">
      </div>
   </div>
</div>
<div class="container-fluid mt--5 d-print-none">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-secondary d-print-none">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Data User / Pengguna</h4>
                            <span class="text-xs">Gunakan filter dibawah untuk menyaring data laporan.</span>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-alternative">
                                <input type="text" id="filter-search" class="form-control form-control-alternative" placeholder="Cari no faktur disini...">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary rounded-circle btn-icon-only trigger-filter" data-target="#filter-barang" data-toggle="tooltip" data-placement="bottom" title="" style="padding-top: 1px" data-original-title="Buka filter">
                                <i
                                 class="fas fa-filter"></i>
                            </button>
                            <a href="javascript:void(0)" class="btn btn-primary btn-refresh rounded-circle btn-icon-only" data-toggle="tooltip" data-placement="bottom" title="" style="padding-top: 1px" data-original-title="Refresh" onclick="refresh_laporan()">
                                <i class="fas fa-sync"></i>
                            </a>
                            <a href="#" class="btn btn-info rounded-circle btn-icon-only" data-toggle="tooltip" data-placement="bottom" title="Cetak laporan" onclick="window.print()">
                                <i class="fas fa-print"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row filter mt-4 mt-sm-3" id="filter-barang">
                        <div class="col">
                            <div class="form-group mb-0">
                                <label class="text-xs font-weight-bold">Item / halaman</label>
                                <div class="input-group input-group-alternative">
                                    <input type="number" id="filter-limit" class="form-control form-control-alternative" value="999999">
                                    <div class="input-group-prepend d-none d-sm-block">
                                        <span class="input-group-text">Baris</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-xs">Level</label>
                                <select class="form-control form-control-alternative" id="filter-level">
                                    <option value="---">---</option>
                                    <option value="administrator">Administrator</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="staf gudang">Staf gudang</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-xs">Blokir</label>
                                <select class="form-control form-control-alternative" id="filter-blokir">
                                    <option value="---">---</option>
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress" id="progress-load">
                    <div class="progress-bar-animated progress-bar-striped progress-bar bg-danger" style="width: 0%"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="col-sm-12 load-laporan table table-sm"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row d-none d-print-block">
    <div class="col">
        <h1 class="text-uppercase text-center mb-6">Laporan Data User / Pengguna Sistem</h1>
        <table class="load-laporan table table-lg table-laporan"></table>
    </div>
</div>

<?php $this->view('argon/js_script')?>
<script type="text/javascript">
$(".trigger-filter").on('click', function(e) {
    target = $(this).data('target');
    $(target).toggle(400);
});
// --------------------------------
// ** Refresh Laporan
// --------------------------------
var laporan = {
    ajax_link: '<?=site_url('laporan/list_user/list-1')?>',
    default_js: '<?=site_url('assets/custom/js/default.js')?>',
    params: {
        limit: 0,
        page: 1,
        berdasarkan: 'alamat'
    }
}
function refresh_laporan() {
    $.ajax({
        url: laporan.ajax_link,
        type: 'GET',
        dataType: 'html',
        data: laporan.params,
    })
    .done(function(data) {
        $(".load-laporan").html(data);
        $.getScript(laporan.default_js);
    });
}
refresh_laporan();

$("#filter-limit").on('input', function(e) {
    value = $(this).val();
    if (value >= 0) {
        laporan.params.limit = value;
    }
    else {
        delete laporan.params.limit;
    }
    refresh_laporan();
});
$("#filter-level").on('change', function(e) {
    value = $(this).val();
    if (value != '---') {
        laporan.params.level = value;
    }
    else {
        delete laporan.params.level;
    }
    refresh_laporan();
});
$("#filter-blokir").on('change', function(e) {
    value = $(this).val();
    if (value != '---') {
        laporan.params.blokir = value;
    }
    else {
        delete laporan.params.blokir;
    }
    refresh_laporan();
});
</script>
<?php $this->view('argon/footer')?>
