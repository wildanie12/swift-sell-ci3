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
                            <h4 class="card-title mb-0">Data Harga</h4>
                            <span class="text-xs">Klasifikasi harga yang diterapkan pada data barang.</span>
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
                            <button type="button" class="btn btn-primary rounded-circle btn-icon-only trigger-filter" data-target="#filter-harga" data-toggle="tooltip" data-placement="bottom" title="" style="padding-top: 1px" data-original-title="Buka filter">
                                <i
                                 class="fas fa-filter"></i>
                            </button>
                            <a href="#" class="btn btn-link btn-tambah rounded-circle btn-icon-only" data-toggle="tooltip" data-placement="bottom" title="" style="padding-top: 1px" data-original-title="Tambah data harga">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row filter mt-4 mt-sm-2" id="filter-harga">
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
                                <label class="text-xs font-weight-bold" for="filter-kategori">Barang</label>
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
                <div class="table-full-width table-responsive">
                    <div class="progress" id="progress-load">
                        <div class="progress-bar-animated progress-bar-striped progress-bar bg-danger" style="width: 0%"></div>
                    </div>
                    <table class="table align-items-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Nama Harga</th>
                                <th>Range / Batas</th>
                                <th class="text-right">Harga Asli</th>
                                <th class="text-right">Tetapan Harga</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="load-harga">
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <nav>
                        <ul class="pagination justify-content-end mb-0 load-harga-pagination">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-tambah_harga">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-primary">
            <div class="modal-header">
                <h4 class="modal-title text-white">Tambah barang</h4>
                <button class="close" data-dismiss='modal' type="button"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="col-sm-8">
                        <form id="form-tambah_harga" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-control-label text-white">Barang</label>
                                        <select class="form-control form-control-alternative" name="barang_id">
                                            <option value="---">---</option>
                                            <?php 
                                                foreach ($data_barang as $barang) {
                                                    echo "<option value='" .$barang->id. "'>" .$barang->nama. "</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-control-label text-white">Nama harga</label>
                                        <input type="text" name="nama" class="form-control form-control-alternative" placeholder="Misal : Harga dus / grosir / pack / ..." required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-control-label text-white">Range / Batas</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">>=</span>
                                            </div>
                                            <input type="number" name="range1" class="form-control form-control-alternative" value="100" step="1" required="required">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-control-label text-white">Harga</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input type="number" name="harga" class="form-control form-control-alternative" step="1" min="0" required="required">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="submit" name="submit" class="btn btn-secondary btn-block" value="Tambah">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-4">
                        <img class="fill-barang-foto img-thumbnail" src="<?=site_url('assets/custom/images/img_unavailable.png')?>">
                        <table class="table mt-2 table-dark">
                            <tr>
                                <th>Nama barang</th>
                                <td>: <span class="fill-barang-nama"></span></td>
                            </tr>
                            <tr>
                                <th>Satuan</th>
                                <td>: <span class="fill-barang-satuan"></span></td>
                            </tr>
                            <tr>
                                <th>Harga utama</th>
                                <td>: <span class="fill-barang-harga"></span></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>: <span class="fill-barang-kategori"></span></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: <span class="fill-barang-status"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit_harga">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-success">
            <div class="modal-header">
                <h4 class="text-white modal-title">Edit barang</h4>
                <button class="close" data-dismiss='modal' type="button"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="col-sm-8">
                        <form id="form-edit_harga" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-control-label text-white">Barang ID</label>
                                        <input type="text" name="barang_id" class="form-control form-control-alternative" readonly="readonly">
                                        <input type="hidden" name="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-control-label text-white">Nama harga</label>
                                        <input type="text" name="nama" class="form-control form-control-alternative" placeholder="Misal : Harga dus / grosir / pack / ..." required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-control-label text-white">Range / Batas</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">>=</span>
                                            </div>
                                            <input type="number" name="range1" class="form-control form-control-alternative" value="100" step="1" required="required">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-control-label text-white">Harga</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input type="number" name="harga" class="form-control form-control-alternative" step="1" min="0" required="required">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="submit" name="submit" class="btn btn-secondary btn-block" value="Edit">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-4">
                        <img class="fill-barang-foto img-thumbnail" src="<?=site_url('assets/custom/images/img_unavailable.png')?>">
                        <table class="table mt-2 table-dark">
                            <tr>
                                <th>Nama barang</th>
                                <td>: <span class="fill-barang-nama"></span></td>
                            </tr>
                            <tr>
                                <th>Satuan</th>
                                <td>: <span class="fill-barang-satuan"></span></td>
                            </tr>
                            <tr>
                                <th>Harga utama</th>
                                <td>: <span class="fill-barang-harga"></span></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>: <span class="fill-barang-kategori"></span></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: <span class="fill-barang-status"></span></td>
                            </tr>
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
var harga = {
    ajax_link: "<?=site_url('data/list_harga/list-1')?>",
    ajax_pagination: "<?=site_url('data/list_harga/pagination')?>",
    default_js: "<?=site_url('assets/custom/js/default.js')?>",
    params: {
        limit: 100,
        page: 1,
        search_by: 'nama'
    }
}
function refreshHarga() {
    $("#progress-load .progress-bar").animate({"width" : "90%"}, 0);
    $.ajax({
        url: harga.ajax_link,
        type: 'GET',
        dataType: 'html',
        data: harga.params,
    })
    .done(function(data) {
        $(".load-harga").html(data);
        $.getScript(harga.default_js);
        $.ajax({
            url: harga.ajax_pagination,
            type: 'GET',
            dataType: 'html',
            data: harga.params,
        })
        .done(function(data) {
            $(".load-harga-pagination").html(data);
            $("#progress-load .progress-bar").animate({"width" : "100%"}, 100, '', function() {
                setTimeout(function() {
                    $("#progress-load .progress-bar").hide('fast');
                }, 400)
            });
            eventAfterharga();
        });
    });
}
refreshHarga();


// -------------------------------------------------------
// ** function       : Events yang ada di tabel harga
// -------------------------------------------------------
function eventAfterharga() {

    $(".page-control").click(function(e) {
        page = $(this).data('page');
        harga.params.page = page;
        refreshHarga();
    });

    $(".page-control-back").click(function(e) {
        if (harga.params.page > 1) {
            harga.params.page--;
            refreshHarga();
        }
    });
    $(".page-control-next").click(function(e) {
        harga.params.page++;
        refreshHarga();
    });

    // -------------------------------------------------------
    // ** Event        : Memnuculkan Form Edit Kategori 
    // -------------------------------------------------------
    $(".content-edit").click(function(e) {
        e.preventDefault();
        id = $(this).data('id');
        $.ajax({
            url: '<?=site_url('data/read_harga')?>',
            type: 'GET',
            dataType: 'json',
            data: {id: id},
        })
        .done(function(data) {
            $("#form-edit_harga [name='id']").val(data.id);
            $("#form-edit_harga [name='barang_id']").val(data.barang_id);
            $("#form-edit_harga [name='range1']").val(data.range1);
            $("#form-edit_harga [name='range2']").val(data.range2);
            $("#form-edit_harga [name='harga']").val(data.harga);
            $("#form-edit_harga [name='nama']").val(data.nama);

            $("#modal-edit_harga .fill-barang-foto").attr('src', data.barang_foto_formatted);
            $("#modal-edit_harga .fill-barang-nama").html(data.barang_nama);
            $("#modal-edit_harga .fill-barang-satuan").html(data.barang_satuan);
            $("#modal-edit_harga .fill-barang-status").html(data.barang_status);
            $("#modal-edit_harga .fill-barang-harga").html(data.barang_harga_formatted);
            $("#modal-edit_harga .fill-barang-kategori").html(data.barang_kategori_formatted);

            $("#modal-edit_harga").modal('show');
        });
    });

    $(".content-delete").click(function(e) {
        e.preventDefault();
        if (confirm('Anda yakin.?')) {
            id = $(this).data('id');
            $.ajax({
                url: '<?=site_url('data/write_harga/delete')?>',
                type: 'POST',
                dataType: 'html',
                data: {id: id},
            })
            .always(function() {
                refreshHarga();
            });
        }
    });
}


// -------------------------------------------------------
// ** Event + Ajax   : Tambah harga
// -------------------------------------------------------
var harga_insert = {
    ajax_link: '<?=site_url('data/write_harga/insert')?>',
    ajax_read_barang: '<?=site_url('data/read_barang')?>'
}
$(".btn-tambah").click(function(e) {
    $("#modal-tambah_harga").modal('show');
    e.preventDefault();
});
$("#form-tambah_harga [name='barang_id']").change(function(e) {
    var barangId = $(this).val();
    $.ajax({
        url: harga_insert.ajax_read_barang,
        type: 'GET',
        dataType: 'json',
        data: {id: barangId},
    })
    .done(function(data) {
        $("#modal-tambah_harga .fill-barang-foto").attr('src', data.foto_formatted);
        $("#modal-tambah_harga .fill-barang-nama").html(data.nama);
        $("#modal-tambah_harga .fill-barang-satuan").html(data.satuan);
        $("#modal-tambah_harga .fill-barang-status").html(data.status);
        $("#modal-tambah_harga .fill-barang-harga").html(data.harga_formatted);
        $("#modal-tambah_harga .fill-barang-kategori").html(data.kategori_formatted);
    });
});
$("#modal-tambah_harga").on('shown.bs.modal', function(e) {
    $("#form-tambah_harga [name='barang_id']").focus();
});
$("#form-tambah_harga").submit(function(e) {
    e.preventDefault();
    if ($("#form-tambah_harga [name='barang_id']").val() != '---') {
        $.ajax({
            url: harga_insert.ajax_link,
            type: 'POST',
            dataType: 'html',
            data: new FormData(this),
            processData:false,
            contentType:false,
            cache:false,
            async:false,
        })
        .done(function(data) {
            refreshHarga();
            $("#modal-tambah_harga").modal('hide');
            $("#form-tambah_harga")[0].reset();
            $("#modal-tambah_harga .fill-barang-foto").attr('src', '<?=site_url('assets/custom/images/img_unavailable.png')?>');
            $("#modal-tambah_harga .fill-barang-nama").html(' - ');
            $("#modal-tambah_harga .fill-barang-satuan").html(' - ');
            $("#modal-tambah_harga .fill-barang-status").html(' - ');
            $("#modal-tambah_harga .fill-barang-harga").html(' - ');
            $("#modal-tambah_harga .fill-barang-kategori").html(' - ');
        });
    }
    else {
        alert('Pilih barang terlebih dahulu');
    }
});




// -------------------------------------------------------
// ** Event + Ajax   : Edit harga
// -------------------------------------------------------
var harga_update = {
    ajax_link: '<?=site_url('data/write_harga/update')?>',
};
$("#form-edit_harga").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: harga_update.ajax_link,
        type: 'POST',
        dataType: 'html',
        data: new FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
    })
    .done(function(data) {
        refreshHarga();
        $("#modal-edit_harga").modal('hide');
    });
});

// -------------------------------------------------------
// ** Events       : Event-event filter
// -------------------------------------------------------
$("#filter-limit").on('input', function(e) {
    value = $(this).val();
    if (value >= 0) {
        harga.params.limit = value;
    }
    else {
        delete harga.params.limit;
    }
    refreshHarga();
});
$("#filter-search").on('input', function(e) {
    value = $(this).val();
    if (value != '') {
        harga.params.search = value;
    }
    else {
        delete harga.params.search;
    }
    refreshHarga();
});

$("#filter-barang").change(function(e) {
    value = $(this).val();
    if (value != '---') {
        harga.params.barang = value;
    }
    else {
        delete harga.params.barang;
    }
    refreshHarga();
});
</script>
<?php $this->view('argon/footer')?>
