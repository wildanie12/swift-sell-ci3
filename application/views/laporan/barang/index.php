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
        <div class="col-sm">
            <div class="card border-0">
                <div class="card-header bg-secondary d-print-none">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Data Barang</h4>
                            <span class="text-xs">Gunakan filter dibawah untuk menyaring data laporan.</span>
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
                                <label class="text-xs font-weight-bold">Kategori</label>
                                <select class="form-control form-control-alternative" id="filter-kategori">
                                    <option value="---">---</option>
                                    <?php 
                                        foreach ($data_kategori as $kategori) {
                                    ?>
                                    <option value="<?=$kategori->id?>"><?=$kategori->nama?></option>
                                    <?php 
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-0">
                                <label class="text-xs font-weight-bold">Status</label>
                                <select class="form-control form-control-alternative" id="filter-status">
                                    <option value="---">---</option>
                                    <option value="dijual">Dijual</option>
                                    <option value="tidak dijual">Tidak Dijual</option>
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
        <h1 class="text-uppercase text-center mb-6">Laporan Rekap Data Barang</h1>
        <table class="load-laporan table table-md table-laporan"></table>
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
    ajax_link: '<?=site_url('laporan/list_barang/list-1')?>',
    default_js: '<?=site_url('assets/custom/js/default.js')?>',
    params: {
        limit: 0,
        page: 1,
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
$("#filter-page").on('input', function(e) {
    value = $(this).val();
    if (value >= 1) {
        laporan.params.page = value;
    }
    else {
        delete laporan.params.page;
    }
    refresh_laporan();
});
$("#filter-kategori").on('change', function(e) {
    value = $(this).val();
    if (value != '---') {
        laporan.params.kategori = value;
    }
    else {
        delete laporan.params.kategori;
    }
    refresh_laporan();
});
$("#filter-status").on('change', function(e) {
    value = $(this).val();
    if (value != '---') {
        laporan.params.status = value;
    }
    else {
        delete laporan.params.status;
    }
    refresh_laporan();
});
$("#filter-refresh").click(function(e) {
    refresh_laporan();
});
</script>
<?php $this->view('argon/footer')?>
