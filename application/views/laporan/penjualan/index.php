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
            <div class="card border-0">
                <div class="card-header bg-secondary d-print-none">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Data Faktur Pembelian</h4>
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
                        <div class="col-4">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-xs">Tanggal</label>
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Dari</span>
                                    </div>
                                    <input type="date" id="filter-tanggal_dari" class="form-control form-control-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ke</span>
                                    </div>
                                    <input type="date" id="filter-tanggal_ke" class="form-control form-control-alternative">

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-0">
                                <label for="filter-username" class="font-weight-bold text-xs">Kasir</label>
                                <select class="form-control form-control-alternative" id="filter-username" name="filter-username">
                                    <option value="---">---</option>
                                    <?php 
                                    foreach ($data_user as $user) {
                                        echo "<option value='".$user->username."'>".$user->nama_lengkap."</option>";
                                    }
                                    ?>
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
                            <table class="load-laporan table table-sm">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row d-none d-print-block">
    <div class="col">
        <h1 class="text-uppercase text-center mb-6">Laporan Rekap Data Transaksi Penjualan</h1>
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
    ajax_link: '<?=site_url('laporan/list_penjualan/list-1')?>',
    default_js: '<?=site_url('assets/custom/js/default.js')?>',
    dari_tanggal_time: '',
    sampai_tanggal_time: new Date(),
    params: {
        limit: 0,
        page: 1,
        dari_tanggal: '',
        sampai_tanggal: '<?=date('Y-m-d')?>'
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
$("#filter-username").on('change', function(e) {
    value = $(this).val();
    if (value != '---') {
        laporan.params.username = value;
    }
    else {
        delete laporan.params.username;
    }
    refresh_laporan();
});

$("#filter-tanggal_dari").change(function(e) {
    value = $(this).val();
    if (value != '') {
        laporan.params.tanggal_dari = value;
    }
    else {
        delete laporan.params.tanggal_dari;
    }
    refresh_laporan();
});
$("#filter-tanggal_ke").change(function(e) {
    value = $(this).val();
    if (value != '') {
        laporan.params.tanggal_ke = value;
    }
    else {
        delete laporan.params.tanggal_ke;
    }
    refresh_laporan();
});

$("#filter-refresh").click(function(e) {
    refresh_laporan();
});
</script>
<?php $this->view('argon/footer')?>
