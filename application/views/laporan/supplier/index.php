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
        <div class="col">
            <div class="card border-0">
                <div class="card-header bg-secondary d-print-none">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Data Supplier</h4>
                            <span class="text-xs">Gunakan filter dibawah untuk menyaring data laporan.</span>
                        </div>
                        <div class="col-auto">
                            <a href="javascript:void(0)" class="btn btn-primary btn-refresh rounded-circle btn-icon-only" data-toggle="tooltip" data-placement="bottom" title="" style="padding-top: 1px" data-original-title="Refresh" onclick="refresh_laporan()">
                                <i class="fas fa-sync"></i>
                            </a>
                            <a href="#" class="btn btn-info rounded-circle btn-icon-only" data-toggle="tooltip" data-placement="bottom" title="Cetak laporan" onclick="window.print()">
                                <i class="fas fa-print"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="progress" id="progress-load">
                    <div class="progress-bar-animated progress-bar-striped progress-bar bg-danger" style="width: 0%"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
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
        <h1 class="text-uppercase text-center mb-6">Laporan Data Faktur Pembelian</h1>
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
    ajax_link: '<?=site_url('laporan/list_supplier/list-1')?>',
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
$("#filter-alamat").on('input', function(e) {
    value = $(this).val();
    if (value != '') {
        laporan.params.cari = value;
    }
    else {
        delete laporan.params.cari;
    }
    refresh_laporan();
});
$("#filter-refresh").click(function(e) {
    refresh_laporan();
});
</script>
<?php $this->view('argon/footer')?>
