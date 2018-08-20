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
                            <h4 class="card-title mb-0">Data Barang</h4>
                            <span class="text-xs">Semua barang yang tersimpan</span>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-alternative">
                                <input type="text" id="filter-search" class="form-control form-control-alternative" placeholder="Cari disini...">
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
                            <a href="http://localhost/barang/barang/registrasi" class="btn btn-link btn-tambah-barang rounded-circle btn-icon-only" data-toggle="tooltip" data-placement="bottom" title="" style="padding-top: 1px" data-original-title="Tambah data barang">
                                <i class="fas fa-plus"></i>
                            </a>
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
                        <div class="col">
                            <div class="form-group">
                                <label class="text-xs font-weight-bold">Cari berdasarkan</label>
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <select class="form-control form-control-alternative" id="filter-search_by">
                                        <option value="nama">Nama</option>
                                        <option value="satuan">Satuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="text-xs font-weight-bold" for="filter-kategori">Kategori</label>
                                <select id="filter-kategori" class="form-control form-control-alternative">
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
                            <div class="form-group">
                                <label class="font-weight-bold text-xs">Dijual/Tidak</label>
                                <select class="form-control form-control-alternative" id="filter-status">
                                    <option value="---">---</option>
                                    <option value="dijual">Dijual</option>
                                    <option value="tidak dijual">Tidak dijual</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-full-width table-responsive">
                    <div class="progress" id="progress-load">
                        <div class="progress-bar-animated progress-bar-striped progress-bar bg-danger" style="width: 0%"></div>
                    </div>
                    <table class="table align-items-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Stok</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th class="text-right">Harga Jual</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="load-barang">

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <nav>
                        <ul class="pagination justify-content-end mb-0 load-barang-pagination">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-tambah_barang">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-primary">
            <div class="modal-header">
                <h4 class="modal-title text-white">Tambah barang</h4>
                <button class="close" data-dismiss='modal' type="button"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="col-sm-8">
                        <form id="form-tambah_barang" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="text-white form-control-label" for="tambah_barang-nama">Nama barang</label>
                                        <input type="text" id="tambah_barang-nama" name="barang_nama" class="form-control form-control-alternative" placeholder="Makaroni 100gr/Permen jumbo...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label class="text-white form-control-label" for="tambah_barang-kategori_id">Kategori</label>
                                        <select id="tambah_barang-kategori_id" name="barang_kategori_id" class="form-control form-control-alternative load-kategori-select">
                                        </select>
                                        <span class="form-text text-white text-xs">Klik kategori barang, atau <a href="#" data-toggle='modal' data-target='#modal-kategori' class="tambah-kategori text-white"><u>Tambahkan Kategori</u>.</a></span>

                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label class="text-white form-control-label" for="tambah_barang-status">Status</label>
                                        <select class="form-control form-control-alternative" id="tambah_barang-status" name="barang_status">
                                            <option value="dijual">Dijual</option>
                                            <option value="tidak dijual">Tidak dijual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label class="text-white form-control-label" for="tambah_barang-satuan">Satuan</label>
                                        <input type="text" id="tambah_barang-satuan" name="barang_satuan" class="form-control form-control-alternative" placeholder="pcs/dus/pack...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="text-white form-control-label" for="tambah_barang-harga">Harga</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div> 
                                            <input type="number" step="1" id="tambah_barang-harga" name="barang_harga" class="form-control" placeholder="5000/10000...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="text-white form-control-label" for="tambah_barang-foto">Gambar/Foto</label>
                                        <input type="file" id="tambah_barang-foto" class="form-control form-control-alternative element-gambar" name="barang_foto">
                                    </div>
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
                    <div class="col-sm-4">
                        <div class="thumbnail" style="border: 0">
                            <img class="gambar-fill img-thumbnail" src="<?=site_url('assets/custom/images/img_unavailable.png')?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit_barang">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-success">
            <div class="modal-header">
                <h4 class="text-white modal-title">Edit barang</h4>
                <button class="close" data-dismiss='modal' type="button"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="col-sm-8">
                        <form id="form-edit_barang" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="edit_barang-nama">Nama barang</label>
                                        <input type="hidden" id="edit_barang-id" name="id">
                                        <input type="text" id="edit_barang-nama" name="barang_nama" class="form-control form-control-alternative" placeholder="Makaroni 100gr/Permen jumbo...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label class="text-white form-control-label" for="edit_barang-kategori_id">Kategori</label>
                                        <select id="edit_barang-kategori_id" name="barang_kategori_id" class="form-control load-kategori-select form-control-alternative">
                                        </select>
                                        <span class="text-xs form-text text-white">Klik kategori barang, atau <a href="#" data-toggle='modal' data-target='#modal-kategori' class="tambah-kategori"><u>Tambahkan Kategori.</u></a></span>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="edit_barang-status" class="form-control-label text-white">Status</label>
                                        <select class="form-control form-control-alternative" id="edit_barang-status" name="barang_status">
                                            <option value="dijual">Dijual</option>
                                            <option value="tidak dijual">Tidak dijual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="edit_barang-satuan" class="form-control-label text-white">Satuan</label>
                                        <input type="text" id="edit_barang-satuan" name="barang_satuan" class="form-control form-control-alternative" placeholder="pcs/dus/pack...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="edit_barang-harga" class="form-control-label text-white">Harga</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input type="number" step="1" id="edit_barang-harga" name="barang_harga" class="form-control-alternative form-control" placeholder="5000/10000...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="edit_barang-foto" class="form-control-label text-white">Gambar/Foto</label>
                                        <input type="file" id="edit_barang-foto" class="form-control form-control-alternative element-gambar-b" name="barang_foto">
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
                        <div class="thumbnail" style="border: 0">
                            <img class="img-thumbnail gambar_b-fill edit_barang-fill-foto" src="<?=site_url('assets/custom/images/img_unavailable.png')?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-kategori">
    <div class="modal-dialog modal-lg" style="top: 50px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kategori</h4>
                <button class="close" data-dismiss='modal' type="button"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <form id="form-tambah_kategori">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group mb-1">
                                        <label for="tambah_kategori-nama" class="form-control-label">Nama Kategori</label>
                                        <input type="text" id="tambah_kategori-nama" class="form-control" placeholder="Nama Kategori">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="submit" value="Submit" class="btn btn-primary btn-block">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="load-kategori">
                            </tbody>
                        </table>
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
// ** Function + Global Variable    : Data Barang
// -------------------------------------------------------
var barang = {
    ajax_link: "<?=site_url('data/list_barang/list-1')?>",
    ajax_pagination: "<?=site_url('data/list_barang/pagination')?>",
    default_js: "<?=site_url('assets/custom/js/default.js')?>",
    params: {
        limit: 100,
        page: 1,
        search_by: 'nama'
    }
}
function refreshBarang() {
    $("#progress-load .progress-bar").animate({"width" : "90%"}, 0);
    $.ajax({
        url: barang.ajax_link,
        type: 'GET',
        dataType: 'html',
        data: barang.params,
    })
    .done(function(data) {
        $(".load-barang").html(data);
        $.getScript(barang.default_js);
        $.ajax({
            url: barang.ajax_pagination,
            type: 'GET',
            dataType: 'html',
            data: barang.params,
        })
        .done(function(data) {
            $(".load-barang-pagination").html(data);
            $("#progress-load .progress-bar").animate({"width" : "100%"}, 100, '', function() {
                setTimeout(function() {
                    $("#progress-load .progress-bar").hide('fast');
                }, 400)
            });
            eventAfterBarang();
        });
    });
}
refreshBarang();


// -------------------------------------------------------
// ** function       : Events yang ada di tabel barang
// -------------------------------------------------------
function eventAfterBarang() {

    $(".page-control").click(function(e) {
        page = $(this).data('page');
        barang.params.page = page;
        refreshBarang();
    });

    $(".page-control-back").click(function(e) {
        if (barang.params.page > 1) {
            barang.params.page--;
            refreshBarang();
        }
    });
    $(".page-control-next").click(function(e) {
        barang.params.page++;
        refreshBarang();
    });

    // -------------------------------------------------------
    // ** Event        : Memnuculkan Form Edit Kategori 
    // -------------------------------------------------------
    $(".content-edit-barang").click(function(e) {
        e.preventDefault();
        id = $(this).data('id');
        $.ajax({
            url: '<?=site_url('data/read_barang')?>',
            type: 'GET',
            dataType: 'json',
            data: {id: id},
        })
        .done(function(data) {
            $("#edit_barang-id").val(data.id);
            $("#edit_barang-nama").val(data.nama);
            $("#edit_barang-status").val(data.status);
            $("#edit_barang-harga").val(data.harga);
            $("#edit_barang-kategori_id").val(data.kategori_id);
            $("#edit_barang-satuan").val(data.satuan);
            $(".edit_barang-fill-foto").attr('src', data.foto_formatted);
            $("#modal-edit_barang").modal('show');
        });
    });

    $(".content-delete-barang").click(function(e) {
        e.preventDefault();
        if (confirm('Anda yakin.?')) {
            id = $(this).data('id');
            $.ajax({
                url: '<?=site_url('data/write_barang/delete')?>',
                type: 'POST',
                dataType: 'html',
                data: {id: id},
            })
            .always(function() {
                refreshBarang();
            });
        }
    });
}


// -------------------------------------------------------
// ** Event + Ajax   : Tambah Barang
// -------------------------------------------------------
var barang_insert = {
    ajax_link: '<?=site_url('data/write_barang/insert')?>'
}
$(".btn-tambah-barang").click(function(e) {
    $("#modal-tambah_barang").modal('show');
    e.preventDefault();
});
$("#modal-tambah_barang").on('shown.bs.modal', function(e) {
    $("#tambah_barang-nama").focus();
});
$("#form-tambah_barang").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: barang_insert.ajax_link,
        type: 'POST',
        dataType: 'html',
        data: new FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
    })
    .done(function(data) {
        refreshBarang();
        $("#modal-tambah_barang .gambar-fill").attr('src', '<?=site_url('assets/custom/images/img_unavailable.png')?>');
        $("#modal-tambah_barang").modal('hide');
        $("#form-tambah_barang")[0].reset();
    });
});




// -------------------------------------------------------
// ** Event + Ajax   : Edit Barang
// -------------------------------------------------------
var barang_update = {
    ajax_link: '<?=site_url('data/write_barang/update')?>'
}
$("#form-edit_barang").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: barang_update.ajax_link,
        type: 'POST',
        dataType: 'html',
        data: new FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
    })
    .done(function(data) {
        refreshBarang();
        $("#modal-edit_barang").modal('hide');
    });
});

// -------------------------------------------------------
// ** Events       : Event-event filter
// -------------------------------------------------------
$("#filter-limit").on('input', function(e) {
    value = $(this).val();
    if (value >= 0) {
        barang.params.limit = value;
    }
    else {
        delete barang.params.limit;
    }
    refreshBarang();
});
$("#filter-search").on('input', function(e) {
    value = $(this).val();
    if (value != '') {
        barang.params.search = value;
    }
    else {
        delete barang.params.search;
    }
    refreshBarang();
});
$("#filter-search_by").on('input', function(e) {
    value = $(this).val();
    if (value != '') {
        barang.params.search_by = value;
    }
    else {
        delete barang.params.search;
    }
    refreshBarang();
});

$("input[name='filter-search_by']").change(function(e) {
    value = $(this).val();
    if (value != '') {
        barang.params.search_by = value;
    }
    else {
        delete barang.params.search_by;
    }
    refreshBarang();
});


$("#filter-kategori").change(function(e) {
    value = $(this).val();
    if (value != '---') {
        barang.params.kategori = value;
    }
    else {
        delete barang.params.kategori;
    }
    refreshBarang();
});
$("#filter-status").change(function(e) {
    value = $(this).val();
    if (value != '---') {
        barang.params.status = value;
    }
    else {
        delete barang.params.status;
    }
    refreshBarang();
});


// -------------------------------------------------------
// ** Function + Global Variable    : Tabel Kategori
// -------------------------------------------------------
var kategori = {
    ajax_link: '<?=site_url('data/list_kategori/list-1')?>',
    ajax_link_select: '<?=site_url('data/list_kategori/select-1')?>',
    default_js: '<?=site_url('assets/custom/js/default.js')?>',
    params: {
        limit: 0,
        page: 1
    }
}
function refresh_kategori_select() {
    $.ajax({
        url: kategori.ajax_link_select,
        type: 'GET',
        dataType: 'html',
        data: kategori.params,
    })
    .done(function(data) {
        $(".load-kategori-select").html(data);
    });
}
refresh_kategori_select();

function refresh_kategori() {
    $.ajax({
        url: kategori.ajax_link,
        type: 'GET',
        dataType: 'html',
        data: kategori.params,
    })
    .done(function(data) {
        $(".load-kategori").html(data);
        kategori_events();
    });
}
refresh_kategori();


// -------------------------------------------------------
// ** Event + Ajax    : Tambah Kategori 
// -------------------------------------------------------
var kategori_insert = {
    ajax_link: '<?=site_url('data/write_kategori/insert')?>',
    params: {
        foto: 'img_unavailable.png',
        keterangan: ''
    }
}
$("#modal-kategori").on('shown.bs.modal', function(e) {
    $("#tambah_kategori-nama").focus();
});
$("#form-tambah_kategori").submit(function(e) {
    e.preventDefault();
    kategori_insert.params.nama = $("#tambah_kategori-nama").val();
    $.ajax({
        url: kategori_insert.ajax_link,
        type: 'POST',
        dataType: 'html',
        data: kategori_insert.params,
    })
    .done(function(data) {
        $("#tambah_kategori-nama").val('');
        $("#modal-kategori").modal('hide');
        $("#tambah_barang-nama").focus();
        refresh_kategori();
        refresh_kategori_select();
    });
});



// -------------------------------------------------------
// ** Function    : Event yang ada di tabel kategori
// -------------------------------------------------------
function kategori_events() {

// -------------------------------------------------------
// ** Event + Ajax    : Hapus Kategori 
// -------------------------------------------------------
var kategori_delete = {
    ajax_link: '<?=site_url('data/write_kategori/delete')?>',
    params: {
    }
}
$(".content-delete-kategori").click(function(e) {
    if (confirm('Anda yakin.?')) {
        kategori_delete.params.id = $(this).data('id');
        $.ajax({
            url: kategori_delete.ajax_link,
            type: 'POST',
            dataType: 'html',
            data: kategori_delete.params,
        })
        .done(function(data) {
            refresh_kategori();
            refresh_kategori_select();
        });
    }
});

}
</script>
<?php $this->view('argon/footer')?>
