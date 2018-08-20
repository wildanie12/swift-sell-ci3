<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<h4 class="fill-barcode-judul d-none d-print-block text-center"></h4>
<div class="barcodes align-items-center d-none d-print-block">
</div>
<div class="header bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-data.jpg')?>') 0 -150px/100% no-repeat !important; -webkit-filter: brightness(111%) contrast(80%); filter: brightness(111%) contrast(80%);">
   <div class="container-fluid">
      <div class="header-body">
      </div>
   </div>
</div>
<div class="container-fluid mt--7 d-print-none">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-secondary">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Data Barcode Barang (Stok)</h4>
                            <span class="text-xs">Alumni yang sudah mengisi kuesioner</span>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-alternative">
                                <input type="text" id="filter-search" class="form-control form-control-alternative" placeholder="Cari barcode disini...">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary rounded-circle btn-icon-only trigger-filter" data-target="#filter-stok" data-toggle="tooltip" data-placement="bottom" title="" style="padding-top: 1px" data-original-title="Buka filter">
                                <i
                                class="fas fa-filter"></i>
                            </button>
                            <a href="#" class="btn btn-link btn-tambah-stok rounded-circle btn-icon-only" data-toggle="tooltip" data-placement="bottom" title="" style="padding-top: 1px" data-original-title="Tambah data stok">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row filter mt-4 mt-sm-2" id="filter-stok">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-0">
                                        <label class="text-xs font-weight-bold">Item / halaman</label>
                                        <div class="input-group input-group-alternative">
                                            <input type="number" id="filter-limit" class="form-control form-control-alternative" value="100">
                                            <div class="input-group-prepend d-none d-sm-block">
                                                <span class="input-group-text">Baris</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="text-xs font-weight-bold" for="filter-barang">Barang</label>
                                        <select id="filter-barang" class="form-control form-control-alternative">
                                            <option value="---">---</option>
                                            <?php 
                                            foreach ($data_barang as $barang) {
                                                ?>
                                                <option value="<?=$barang->id?>"><?=$barang->nama?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="progress" id="progress-load">
                        <div class="progress-bar-animated progress-bar-striped progress-bar bg-danger" style="width: 0%"></div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barcode</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Stok Awal</th>
                                <th>Stok Tersisa</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Tanggal Entry</th>
                                <th class="text-right"></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="load-stok">
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <nav>
                        <ul class="pagination justify-content-end mb-0 load-stok-pagination">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-tambah_stok">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss='modal' type="button"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Pilih barang yang akan ditambah stok</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="list-group">
                            <?php 
                            foreach ($data_barang as $barang) {
                                ?>
                                <a href="<?=site_url('data/stok/tambah?barang='.$barang->id)?>" class="list-group-item">
                                    <div class="row justify-content-left align-items-center">
                                        <div class="col-auto">
                                            <img class="avatar" style="width: 60px; height: 60px" src="<?=site_url($barang->foto)?>">
                                        </div>
                                        <div class="col-auto" style="vertical-align: middle;">
                                            <h5 class="list-group-item-heading mb-0" style="font-size: 14pt; font-weight: bolder"><?=$barang->nama?></h5>
                                            <p class="list-group-item-text mb-0">
                                                <strong>Satuan : </strong> <?=$barang->satuan?>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit_stok">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data Stok</h4>
                <button class="close" type="button" data-dismiss='modal'>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <form id="form-edit_stok">
                    <div class="row">
                        <div class="col-sm d-flex align-items-center flex-column">
                            <img src="<?=site_url('assets/custom/images/img_unavailable.png')?>" class="fill-barang-foto img-thumbnail mb-2">
                            <table class="table table-hover">
                                <tr>
                                    <th>Nama barang</th>
                                    <td>: <span class="fill-barang-nama"></span></td>
                                </tr>
                                <tr>
                                    <th>Satuan</th>
                                    <td>: <span class="fill-barang-satuan"></span></td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td>: <span class="fill-barang-harga"></span></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>: <span class="fill-barang-status"></span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Barcode</label>
                                        <input type="hidden" name="id" class="form-control fill-id">
                                        <input type="text" name="stok-barcode" class="form-control form-control-alternative fill-barcode" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Stok</label>
                                        <input type="number" name="stok-stok" class="form-control form-control-alternative fill-stok">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Tanggal Kadaluarsa</label>
                                        <input type="date" name="stok-tgl_kadaluarsa" class="form-control form-control-alternative fill-tgl_kadaluarsa">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Ingat kadaluarsa</label>
                                        <input type="text" name="stok-ingat_kadaluarsa" class="form-control form-control-alternative fill-ingat_kadaluarsa">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="submit" name="submit" class="btn btn-primary btn-block" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade d-print-none" id="modal-buat_barcode">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cetak Barcode</h4>
                <button class="close" type="button" data-dismiss='modal'>&times;</button>
            </div>
            <div class="modal-body pt-0">
                <div class="row d-print-none">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm d-print-none">
                                <form class="form-horizontal" id="barcode-form">
                                    <div class="form-group mb-0">
                                        <label class="form-control-label">Nama Barang</label>
                                        <div class="col-xs-8">
                                            <input type="text" name="nama" class="form-control form-control-alternative" placeholder="Nama" readonly="true" value="<?=$barang->nama?>">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label">Jumlah Pack</label>
                                        <div class="col-xs-8">
                                            <input type="number" name="jumlah" class="form-control form-control-alternative" placeholder="Jumlah" value="1" readonly="true">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label">Duplikat / Isi Pack</label>
                                        <div class="col-xs-8">
                                            <input type="number" min="0" value="1" id="duplikat" class="form-control form-control-alternative" readonly="true">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label">Harga Jual</label>
                                        <div class="col-xs-8">
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp. </span>
                                                </div>
                                                <input type="number" name="harga" class="form-control form-control-alternative" value="<?=$barang->harga?>" readonly='readonly'>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-control-label">Satuan</label>
                                        <div class="col-xs-8">
                                            <input type="text" name="satuan" class="form-control form-control-alternative" value="<?=$barang->satuan?>" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0" id="print-button-wrapper">
                                        <div class="col-xs-12">
                                            <button onclick="window.print()" type="button" id="print-button" class="btn btn-block btn-info">
                                                <span class="glyphicon glyphicon-print"></span> Cetak
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm">
                                <form class="form-horizontal " id="layouting-form">
                                    <div class="form-group mb-0">
                                        <label class="form-control-label">Margin x (Each)</label>
                                        <div class="col-xs-7">
                                            <input type="range" min="0" max="100" value="0" id="margin-horizontal" class="form-control form-control-alternative">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label">Margin y (Each)</label>
                                        <div class="col-xs-7">
                                            <input type="range" min="0" max="100" value="0" id="margin-vertical" class="form-control form-control-alternative">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label">Padding (Each)</label>
                                        <div class="col-xs-7">
                                            <input type="range" min="0" max="100" value="0" id="padding" class="form-control form-control-alternative">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label">Size (Each)</label>
                                        <div class="col-xs-7">
                                            <input type="range" min="1" max="2" step="0.05" value="1" id="size" class="form-control form-control-alternative">
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-control-label">Border / Outline</label>
                                        <div class="col-xs-7">
                                            <div class="input-group input-group-alternative">
                                                <select id="border" class="form-control form-control-alternative">
                                                    <option value="0">0 - Tidak ada</option>
                                                    <option selected="true" value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                </select>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">px</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-danger btn-block" data-dismiss='modal'>
                                            <i class="fa fa-times"></i> 
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-sm-12 barcodes text-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->view('argon/js_script')?>
<script type="text/javascript">
// -------------------------------------------------------------------------------------
// * Filter Collapse (membuka elemen filter)
// -------------------------------------------------------------------------------------

$(".trigger-filter").on('click', function(e) {
    target = $(this).data('target');
    $(target).toggle(400);
});

// -------------------------------------------------------
// ** Function + Global Variable    : Data Stok
// -------------------------------------------------------
var stok = {
    ajax_link: "<?=site_url('data/list_stok/list-1')?>",
    ajax_pagination: "<?=site_url('data/list_stok/pagination')?>",
    default_js: "<?=site_url('assets/custom/js/default.js')?>",
    params: {
        limit: 100,
        page: 1,
        search_by: 'barcode'
    }
}
function refreshStok() {
    $("#progress-load .progress-bar").animate({"width" : "90%"}, 0);
    $.ajax({
        url: stok.ajax_link,
        type: 'GET',
        dataType: 'html',
        data: stok.params,
    })
    .done(function(data) {
        $(".load-stok").html(data);
        $.getScript(stok.default_js);
        $.ajax({
            url: stok.ajax_pagination,
            type: 'GET',
            dataType: 'html',
            data: stok.params,
        })
        .done(function(data) {
            $("#progress-load .progress-bar").animate({"width" : "100%"}, 100, '', function() {
                setTimeout(function() {
                    $("#progress-load .progress-bar").hide('fast');
                }, 400)
            });
            $(".load-stok-pagination").html(data);
            eventAfterStok();
        });
        
    });
}
refreshStok();


// -------------------------------------------------------
// ** function       : Events yang ada di tabel stok
// -------------------------------------------------------
function eventAfterStok() {
    $(".page-control").click(function(e) {
        page = $(this).data('page');
        stok.params.page = page;
        refreshStok();
    });

    $(".page-control-back").click(function(e) {
        if (stok.params.page > 1) {
            stok.params.page--;
            refreshStok();
        }
    });
    $(".page-control-next").click(function(e) {
        stok.params.page++;
        refreshStok();
    });
    // -------------------------------------------------------
    // ** event + ajax submit       : Delete Stok
    // -------------------------------------------------------
    $(".content-delete-stok").click(function(e) {
        if (confirm('Anda Yakin?')) {
            id = $(this).data('id');
            $.ajax({
                url: '<?=site_url('data/write_stok/delete')?>',
                type: 'POST',
                dataType: 'html',
                data: {id: id},
            })
            .always(function() {
                refreshStok();
            });
        }
        e.preventDefault();
    });

    $(".content-edit-stok").click(function(e) {
        id = $(this).data('id')
        $.ajax({
            url: '<?=site_url('data/read_stok')?>',
            type: 'GET',
            dataType: 'json',
            data: {id: id},
        })
        .done(function(data) {
            $(".fill-barang-nama").html(data.barang_nama);
            $(".fill-barang-harga").html(data.barang_harga);
            $(".fill-barang-status").html(data.barang_status);
            $(".fill-barang-satuan").html(data.barang_satuan);
            $(".fill-barang-foto").attr('src', data.barang_foto_formatted);
            $(".fill-id").val(data.id);
            $(".fill-stok").val(data.stok);
            $(".fill-barcode").val(data.barcode);
            $(".fill-tgl_kadaluarsa").val(data.tgl_kadaluarsa);
            $(".fill-ingat_kadaluarsa").val(data.ingat_kadaluarsa);
            $("#modal-edit_stok").modal('show');
        });
    });

    $(".content-cetak-stok").click(function(e) {
        e.preventDefault();
        id = $(this).data('id')
        $.ajax({
            url: '<?=site_url('data/read_stok')?>',
            type: 'GET',
            dataType: 'json',
            data: {id: id},
        })
        .done(function(data) {
            $(".fill-barcode-judul").html("Barcode barang " + data.barang_nama);
        });
        barcode = $(this).data('barcode');
        harga = $(this).data('harga');
        num = $(this).data('num');
        $("#duplikat").val(num);
        $("#modal-buat_barcode").modal('show');
        duplikat = num;
        i = 1;
        $(".barcodes").html('');
        string = barcode;
        d = 1;
        while (d <= duplikat) {
            $(".barcodes").append("<svg class='barcode b"+ d +"'></svg>");
            JsBarcode(".b"+ d, string, {
                fontSize: 9,
                height: 20,
                width: 1,
                text: string + ' Rp. '+harga+',-'
            });
            d++;
        }
        margin_x = $("#layouting-form #margin-horizontal").val();
        margin_y = $("#layouting-form #margin-vertical").val();
        padding = $("#layouting-form #padding").val();
        size = $("#layouting-form #size").val();
        border = $("#layouting-form #border").val();

        $('.barcode').css('-webkit-transform', 'scale('+size+','+size+')');
        $('.barcode').css('-moz-transform', 'scale('+size+','+size+')');
        $('.barcode').css('-o-transform', 'scale('+size+','+size+')');
        $('.barcode').css('-ms-transform', 'scale('+size+','+size+')');
        $('.barcode').css('transform', 'scale('+size+','+size+')');
        $('.barcode').css('margin-left', margin_x);
        $('.barcode').css('margin-right', margin_x);
        $('.barcode').css('margin-top', margin_y);
        $('.barcode').css('margin-bottom', margin_y);
        $('.barcode').css('padding', padding);
        $('.barcode').css('border', border + 'px solid black');
    });
}
$(".btn-tambah-stok").click(function(e) {
    e.preventDefault();
    $("#modal-tambah_stok").modal('show');
});

$("#layouting-form").submit(function(e) {
    $("#barcode-form").submit();
    e.preventDefault();
});
$("#layouting-form #margin-horizontal").on('input', function(e) {
    margin = $(this).val();
    $('.barcode').css('margin-left', margin);
    $('.barcode').css('margin-right', margin);
})

$("#layouting-form #margin-vertical").on('input', function(e) {
    margin = $(this).val();
    $('.barcode').css('margin-top', margin);
    $('.barcode').css('margin-bottom', margin);
})

$("#layouting-form #padding").on('input', function(e) {
    padding = $(this).val();
    $('.barcode').css('padding', padding);
})

$("#layouting-form #size").on('input', function(e) {
    size = $(this).val();
    $('.barcode').css('-webkit-transform', 'scale('+size+','+size+')');
    $('.barcode').css('-moz-transform', 'scale('+size+','+size+')');
    $('.barcode').css('-o-transform', 'scale('+size+','+size+')');
    $('.barcode').css('-ms-transform', 'scale('+size+','+size+')');
    $('.barcode').css('transform', 'scale('+size+','+size+')');
})

$("#layouting-form #border").change(function(e) {
    border = $(this).val();
    $('.barcode').css('border', border + 'px solid black');
})

$("#form-edit_stok").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: '<?=site_url('data/write_stok/update')?>',
        type: 'POST',
        dataType: 'html',
        data: new FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false
    })
    .always(function() {
        refreshStok();
        $("#modal-edit_stok").modal('hide');
    });
});


// -------------------------------------------------------
// ** Events       : Event-event filter
// -------------------------------------------------------
$("#filter-limit").on('input', function(e) {
    value = $(this).val();
    if (value >= 0) {
        stok.params.limit = value;
    }
    else {
        delete stok.params.limit;
    }
    refreshStok();
});
$("#filter-search").on('input', function(e) {
    value = $(this).val();
    if (value != '') {
        stok.params.search = value;
    }
    else {
        delete stok.params.search;
    }
    refreshStok();
});

$("#filter-barang").change(function(e) {
    value = $(this).val();
    if (value != '---') {
        stok.params.barang = value;
    }
    else {
        delete stok.params.barang;
    }
    refreshStok();
});
</script>
<?php $this->view('argon/footer')?>
