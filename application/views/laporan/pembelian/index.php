<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<div class="header d-print-none bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-laporan.jpg')?>') 0 -570px/100% no-repeat !important; -webkit-filter: brightness(80%) contrast(160%); filter: brightness(80%) contrast(160%);">
   <div class="container-fluid">
      <div class="header-body">
      </div>
   </div>
</div>
<div class="container-fluid mt--5 d-print-none">
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="card border-0">
                <div class="card-header bg-secondary d-print-none">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Data Faktur Pembelian</h4>
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
                                <label class="text-xs font-weight-bold" for="filter-supplier">Supplier</label>
                                <select id="filter-supplier" class="form-control form-control-alternative">
                                    <option value="---">---</option>
                                    <?php 
                                    foreach ($data_supplier as $supplier) {
                                        ?>
                                        <option value="<?=$supplier->id?>"><?=$supplier->nama?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-xs">Tanggal faktur</label>
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Dari</span>
                                    </div>
                                    <input type="date" id="filter-tanggal_faktur_dari" class="form-control form-control-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ke</span>
                                    </div>
                                    <input type="date" id="filter-tanggal_faktur_ke" class="form-control form-control-alternative">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-xs">Jenis pembayaran</label>
                                <select class="form-control form-control-alternative" id="filter-jenis_pembayaran">
                                    <option value="---">---</option>
                                    <option value="kontan">Kontan</option>
                                    <option value="kredit">Kredit</option>
                                    <option value="konsinyasi">Konsinyasi</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-0">
                                <label for="filter-username" class="font-weight-bold text-xs">Pengguna</label>
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
                    <div class="row justify-content-center">
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
<div class="row d-none d-print-block" id="print-pembelian">
    <div class="col">
        <h1 class="text-uppercase text-center mb-6">Laporan Data Faktur Pembelian</h1>
        <table class="load-laporan table table-lg table-laporan"></table>
    </div>
</div>

<div class="row d-none d-print-none" id="print-detail_pembelian">
    <div class="col">
        <h1 class="text-uppercase text-center mb-6">Laporan detail Faktur Pembelian</h1>
        <table class="load-laporan_detail table table-lg table-laporan"></table>
    </div>
</div>

<div class="modal fade d-print-none" id="modal-detail_transaksi">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0">Rincian faktur pembelian</h4>
                <button class="close" data-dismiss='modal'>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <table class="table load-detail-faktur">
                </table>
                <div class="row">
                    <div class="col-sm">
                        <button onclick="window.print()" class="btn btn-info btn-block">
                            <i class="fas fa-print"></i> 
                            Cetak
                        </button>
                    </div>
                    <div class="col-sm" id="btn-selesai" style="display: none;">
                        <button class="btn btn-primary btn-block" data-id='-1'>
                            <i class="fas fa-clipboard-check"></i> 
                            Selesai
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->view('argon/js_script')?>
<script type="text/javascript">
$(".trigger-filter").on('click', function(e) {
    target = $(this).data('target');
    $(target).toggle(400);
});

<?php 
    if ($this->input->get('transaksi_id') != '') {
?>
showDetailTransaksi(<?=$this->input->get('transaksi_id')?>);
<?php 
    }
?>

// --------------------------------
// ** Refresh Laporan
// --------------------------------
var laporan = {
    ajax_link: '<?=site_url('laporan/list_pembelian/list-1')?>',
    default_js: '<?=site_url('assets/custom/js/default.js')?>',
    params: {
        limit: 999999,
        page: 1,
        berdasarkan: 'no_faktur'
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
        laporan_events();
    });
}
refresh_laporan();

function laporan_events() {
    $(".content-view-transaksi").click(function(e) {
        e.preventDefault();
        id = $(this).data('id');
        selesai = $(this).data('selesai');
        $("#modal-detail_transaksi #btn-selesai button").attr('data-id', id);
        $.ajax({
            url: '<?=site_url('laporan/list_stok/list-2')?>',
            type: 'GET',
            dataType: 'html',
            data: {transaksi_id: id},
        })
        .done(function(data) {
            $(".load-detail-faktur").html(data);
            $(".load-laporan_detail").html(data);
            if (selesai == 'Ya') {
                $("#modal-detail_transaksi #btn-selesai").show('400');
            }
            else {
                $("#modal-detail_transaksi #btn-selesai").hide('400');
            }
            $("#modal-detail_transaksi").modal('show');
        });
    });

    $(".content-delete").click(function(e) {
        e.preventDefault();
        id = $(this).data('id');
        if (confirm('Anda yakin?, data tidak dapat dikembalikan')) {
            if (confirm('Stok barang didalamnya juga akan ikut terhapus, anda yakin?')) {
                $.ajax({
                    url: '<?=site_url('transaksi/write_transaksi_beli/delete')?>',
                    type: 'POST',
                    dataType: 'html',
                    data: {id: id},
                })
                .done(function(data) {
                    refresh_laporan();
                });
            }
        }
    });
}
$("#modal-detail_transaksi").on('shown.bs.modal', function(e) {
    $("#print-pembelian").removeClass('d-print-block');
    $("#print-pembelian").addClass('d-print-none');
    $("#print-detail_pembelian").removeClass('d-print-none');
    $("#print-detail_pembelian").addClass('d-print-block');
});
$("#modal-detail_transaksi").on('hide.bs.modal', function(e) {
    $("#print-detail_pembelian").removeClass('d-print-block');
    $("#print-detail_pembelian").addClass('d-print-none');
    $("#print-pembelian").removeClass('d-print-none');
    $("#print-pembelian").addClass('d-print-block');
});

function showDetailTransaksi(id) {
    $("#modal-detail_transaksi #btn-selesai button").attr('data-id', id);
    $.ajax({
        url: '<?=site_url('laporan/list_stok/list-2')?>',
        type: 'GET',
        dataType: 'html',
        data: {transaksi_id: id},
    })
    .done(function(data) {
        $.ajax({
            url: '<?=site_url('laporan/read_transaksi_beli')?>',
            type: 'GET',
            dataType: 'json',
            data: {id: id},
        })
        .done(function(data) {
            if (data.kredit_selesai == 0 && data.jenis_pembayaran != 'kontan') {
                $("#modal-detail_transaksi #btn-selesai").show('400');
            }
            else {
                $("#modal-detail_transaksi #btn-selesai").hide('400');
            }
        });
        
        $(".load-detail-faktur").html(data);
        $(".load-laporan_detail").html(data);
        $("#modal-detail_transaksi").modal('show');
    });
}


$("#modal-detail_transaksi #btn-selesai button").click(function(e) {
    if (confirm('Apakah anda yakin?')) {
        if (confirm('data yang telah dirubah tidak dapat dirubah kembali?')) {
            transaksi_id = $(this).data('id');
            $.ajax({
                url: '<?=site_url('transaksi/write_transaksi_beli/set_selesai')?>',
                type: 'POST',
                dataType: 'html',
                data: {
                    id: transaksi_id,
                    selesai: 1
                },
            })
            .done(function(data) {
                if (transaksi_id != -1) {
                    showDetailTransaksi(transaksi_id);
                }
                refresh_laporan();
            });
        }
    }
});

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
$("#filter-search").on('input', function(e) {
    value = $(this).val();
    if (value != '') {
        laporan.params.search = value;
    }
    else {
        delete laporan.params.search;
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
$("#filter-supplier").on('change', function(e) {
    value = $(this).val();
    if (value != '---') {
        laporan.params.supplier = value;
    }
    else {
        delete laporan.params.supplier;
    }
    refresh_laporan();
});
$("#filter-tanggal_faktur_dari").on('change', function(e) {
    value = $(this).val();
    if (value != '') {
        laporan.params.tanggal_faktur_dari = value;
    }
    else {
        delete laporan.params.tanggal_faktur_dari;
    }
    refresh_laporan();
});
$("#filter-tanggal_faktur_ke").on('change', function(e) {
    value = $(this).val();
    if (value != '') {
        laporan.params.tanggal_faktur_ke = value;
    }
    else {
        delete laporan.params.tanggal_faktur_ke;
    }
    refresh_laporan();
});
$("#filter-jenis_pembayaran").change(function(e) {
    value = $(this).val();
    if (value != '---') {
        laporan.params.jenis_pembayaran = value;
    }
    else {
        delete laporan.params.jenis_pembayaran;
    }
    refresh_laporan();
});
</script>
<?php $this->view('argon/footer')?>
