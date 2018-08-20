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
                <div class="card-header bg-secondary">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Data Transaksi</h4>
                            <span class="text-xs">Semua transaksi tercatat</span>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-alternative">
                                <input type="text" id="filter-search" class="form-control form-control-alternative" placeholder="Cari ID transaksi disini...">
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
                        </div>
                    </div>
                    <div class="row filter mt-4 mt-sm-2" id="filter-barang">
                        <div class="col">
                            <div class="form-group">
                                <label class="text-xs font-weight-bold">Item / halaman</label>
                                <div class="input-group input-group-alternative">
                                    <input type="number" id="filter-limit" class="form-control form-control-alternative" value="100">
                                    <div class="input-group-prepend d-none d-sm-block">
                                        <span class="input-group-text">Baris</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="colsm-5">
                            <div class="form-group">
                                <label class="text-xs font-weight-bold">Tanggal</label>
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Dari</span>
                                    </div>
                                    <input type="date" id="filter-tanggal-dari" class="form-control form-control-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Sampai</span>
                                    </div>
                                    <input type="date" id="filter-tanggal-sampai" class="form-control form-control-alternative">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="font-weight-bold text-xs">Kasir</label>
                                <select class="form-control form-control-alternative" id="filter-username">
                                    <option value="---">---</option>
                                    <?php 
                                    foreach ($data_user as $user) {
                                        ?>
                                        <option value="<?=$user->username?>"><?=$user->nama_lengkap?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content table-full-width table-responsive">
                    <div class="progress" id="progress-load">
                        <div class="progress-bar-animated progress-bar-striped progress-bar bg-danger" style="width: 0%"></div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Transaksi</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Kasir</th>
                                <th>Total</th>
                                <th>Bayar</th>
                                <th>Kembali</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="load-transaksi">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-rincian_transaksi">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0">Rincian Transaksi</h4>
                <button class="close" data-dismiss='modal'>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody class="load-keranjang"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-cetak-struk" data-id='' type="button">
                    <i class="fas fa-print"></i> 
                    Cetak Struk
                </button>
            </div>
        </div>
    </div>
</div>

<?php $this->view('argon/js_script')?>
<script type="text/javascript">
// -------------------------------------------------------
// ** Function + Global Variable    : Data Transaksi
// -------------------------------------------------------
var transaksi = {
    ajax_link: "<?=site_url('data/list_transaksi/list-1')?>",
    default_js: "<?=site_url('assets/custom/js/default.js')?>",
    params: {
        limit: 100,
        page: 1,
        search_by: 'id'
    }
}
function refresh_transaksi() {
    $.ajax({
        url: transaksi.ajax_link,
        type: 'GET',
        dataType: 'html',
        data: transaksi.params,
    })
    .done(function(data) {
        $(".load-transaksi").html(data);
        $.getScript(transaksi.default_js);
        transaksi_events();
    });
}
refresh_transaksi();

$(".btn-cetak-struk").click(function(e) {
    if (confirm('Cetak Struk.?')) {
        id = $(this).data('id');
        $.ajax({
            url: '<?=site_url('transaksi/cetak_struk')?>',
            type: 'GET',
            dataType: 'html',
            data: {transaksi_id: id},
        })
        .done(function(data) {
        })
        .fail(function() {
            alert('Tidak dapat terhubung dengan printer');
        });
    }
});


// -------------------------------------------------------
// ** function       : Events yang ada di tabel transaksi
// -------------------------------------------------------
function transaksi_events() {

// -------------------------------------------------------
// ** event + ajax submit       : Delete transaksi
// -------------------------------------------------------
$(".content-delete-transaksi").click(function(e) {
    if (confirm('Anda Yakin?')) {
        id = $(this).data('id');
        $.ajax({
            url: '<?=site_url('data/write_transaksi/delete')?>',
            type: 'POST',
            dataType: 'html',
            data: {id: id},
        })
        .always(function() {
            refresh_transaksi();
        });
    }
    e.preventDefault();
});

$(".content-view-transaksi").click(function(e) {
    e.preventDefault();
    id = $(this).data('id');
    $(".btn-cetak-struk").attr('data-id', id);
    $.ajax({
        url: '<?=site_url('data/list_item_transaksi/list-1')?>',
        type: 'GET',
        dataType: 'html',
        data: {id: id},
    })
    .done(function(data) {
        $(".load-keranjang").html(data);
        $("#modal-rincian_transaksi").modal('show');
    });
});
}


// -------------------------------------------------------
// ** Events       : Event-event filter
// -------------------------------------------------------
$("#filter-limit").on('input', function(e) {
    value = $(this).val();
    if (value >= 0) {
        transaksi.params.limit = value;
    }
    else {
        delete transaksi.params.limit;
    }
    refresh_transaksi();
});
$("#filter-page").on('input', function(e) {
    value = $(this).val();
    if (value > 0) {
        transaksi.params.page = value;
    }
    else {
        delete transaksi.params.page;
    }
    refresh_transaksi();
});
$("#filter-search").on('input', function(e) {
    value = $(this).val();
    if (value != '') {
        transaksi.params.search = value;
    }
    else {
        delete transaksi.params.search;
    }
    refresh_transaksi();
});
$("#filter-tanggal-dari").on('change', function(e) {
    value = $(this).val();
    if (value != '') {
        transaksi.params.tanggal_dari = value;
    }
    else {
        delete transaksi.params.tanggal_dari;
    }
    refresh_transaksi();
});
$("#filter-tanggal-sampai").on('change', function(e) {
    value = $(this).val();
    if (value != '') {
        transaksi.params.tanggal_sampai = value;
    }
    else {
        delete transaksi.params.tanggal_sampai;
    }
    refresh_transaksi();
});
$("#filter-username"). change(function(e) {
    value = $(this).val();
    if (value != '---') {
        transaksi.params.username = value;
    }
    else {
        delete transaksi.params.username;
    }
    refresh_transaksi();
});
</script>
<?php $this->view('argon/footer')?>
