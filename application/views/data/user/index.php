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
        <div class="col-sm">
            <div class="card">
                <div class="card-header bg-secondary">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Data User</h4>
                            <span class="text-xs">Akun yang dapat mengakses sistem</span>
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
                            <button type="button" class="btn btn-primary rounded-circle btn-icon-only trigger-filter" data-target="#filter" data-toggle="tooltip" data-placement="bottom" title="" style="padding-top: 1px" data-original-title="Buka filter">
                                <i
                                class="fas fa-filter"></i>
                            </button>
                            <a href="#" class="btn btn-link btn-tambah-user rounded-circle btn-icon-only" data-toggle="tooltip" data-placement="bottom" title="" style="padding-top: 1px" data-original-title="Tambah data stok">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row filter mt-4 mt-sm-2" id="filter">
                        <div class="col">
                            <div class="form-group mb-0">
                                <label class="text-xs font-weight-bold">Item / halaman</label>
                                <div class="input-group input-group-alternative">
                                    <input type="number" id="filter-limit" class="form-control form-contorl-alternative" value="100">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Item</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-0">
                                <label class="text-xs font-weight-bold">Cari berdasarkan</label>
                                <select class="form-control form-control-alternative" id="filter-search-by">
                                    <option value="nama_lengkap">Nama lengkap</option>
                                    <option value="username">Username</option>
                                    <option value="alamat">Alamat</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-0">
                                <label class="text-xs font-weight-bold">Level</label>
                                <select class="form-control form-control-alternative" id="filter-level">
                                    <option class="---">---</option>
                                    <option class="administrator">Administrator</option>
                                    <option class="kasir">Kasir</option>
                                    <option class="staf gudang">Staf gudang</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-0">
                                <label class="text-xs font-weight-bold">Blokir</label>
                                <select class="form-control form-control-alternative" id="filter-blokir">
                                    <option value="---">---</option>
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Level</th>
                                <th>Alamat</th>
                                <th>Nama Printer</th>
                                <th>Alamat Printer</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="load-user">
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <nav>
                        <ul class="pagination justify-content-end mb-0 load-user-pagination">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-tambah_user">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-warning text-white">
            <div class="modal-header">
                <h4 class="modal-title text-white">Tambah user</h4>
                <button class="close" data-dismiss='modal' type="button"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="col-sm-8">
                        <form id="form-tambah_user" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="tambah_user-nama_lengkap">Nama Lengkap</label>
                                        <input type="text" name="user-nama_lengkap" id="tambah_user-nama_lengkap" class="form-control form-control-alternative" placeholder="Nama..">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="tambah_user-username">Username</label>
                                        <input type="text" name="user-username" id="tambah_user-username" class="form-control form-control-alternative" placeholder="Username..">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="tambah_user-password">Password</label>
                                        <input type="password" name="user-password" id="tambah_user-password" class="form-control form-control-alternative" placeholder="Password...">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" id="tambah_user-password_confirm-wrapper">
                                        <label class="form-control-label text-white" for="tambah_user-password_confirm">Konfirmasi Password</label>
                                        <input type="password" name="user-password_confirm" id="tambah_user-password_confirm" class="form-control form-control-alternative" placeholder="Konfirmasi Password...">
                                        <span class="help-block" id="tambah_user-password_confirm-help" style="display: none">Konfirmasi password tidak cocok</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="tambah_user-level">Level</label>
                                        <select class="form-control form-control-alternative  " name="user-level" id="tambah_user-level">
                                            <option value="kasir">Kasir</option>
                                            <option value="staf gudang">Staf Gudang</option>
                                            <option value="administrator">Administrator</option>
                                        </select >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="tambah_user-avatar">Avatar</label>
                                        <input type="file" name="user-avatar" id="tambah_user-avatar" class="form-control element-gambar">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="tambah_user-alamat">Alamat</label>
                                        <textarea name="user-alamat" id="tambah_user-alamat" class="form-control form-control-alternative " rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="tambah_user-alamat_printer">Alamat Printer</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">smb://</span>
                                            </div>
                                            <input type="text" name="user-alamat_printer" id="tambah_user-alamat_printer" class="form-control form-control-alternative" placeholder="192.168.1....">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="tambah_user-nama_printer">Nama Printer</label>
                                        <input type="text" name="user-nama_printer" id="tambah_user-nama_printer" class="form-control form-control-alternative" placeholder="Nama..">
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
                        <img class="gambar-fill img-thumbnail" src="<?=site_url('assets/custom/images/img_unavailable.png')?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-edit_user">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title text-white">Edit user</h4>
                <button class="close" data-dismiss='modal' type="button"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="col-sm-8">
                        <form id="form-edit_user" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="edit_user-nama_lengkap">Nama Lengkap</label>
                                        <input type="text" name="user-nama_lengkap" id="edit_user-nama_lengkap" class="form-control form-control-alternative" placeholder="Nama..">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="edit_user-username">Username</label>
                                        <input type="text" name="user-username" id="edit_user-username" class="form-control form-control-alternative" placeholder="Username.." readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="edit_user-password">Password</label>
                                        <input type="password" name="user-password" id="edit_user-password" class="form-control form-control-alternative" placeholder="Password...">
                                        <span class="help-block text-white">Biarkan kosong jika tidak ingin merubah password</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" id="edit_user-password_confirm-wrapper">
                                        <label class="form-control-label text-white" for="edit_user-password_confirm">Konfirmasi Password</label>
                                        <input type="password" name="user-password_confirm" id="edit_user-password_confirm" class="form-control form-control-alternative" placeholder="Konfirmasi Password...">
                                        <span class="help-block" id="edit_user-password_confirm-help" style="display: none">Konfirmasi password tidak cocok</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="edit_user-level">Level</label>
                                        <select class="form-control form-control-alternative" name="user-level" id="edit_user-level">
                                            <option value="kasir">Kasir</option>
                                            <option value="staf gudang">Staf Gudang</option>
                                            <option value="administrator">Administrator</option>
                                        </select >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="edit_user-avatar">Avatar</label>
                                        <input type="file" name="user-avatar" id="edit_user-avatar" class="form-control element-gambar">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="edit_user-alamat">Alamat</label>
                                        <textarea name="user-alamat" class="form-control form-control-alternative" id="edit_user-alamat" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="edit_user-alamat_printer">Alamat Printer</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">smb://</span>
                                            </div>
                                            <input type="text" name="user-alamat_printer" id="edit_user-alamat_printer" class="form-control form-control-alternative" placeholder="192.168.1....">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label text-white" for="edit_user-nama_printer">Nama Printer</label>
                                        <input type="text" name="user-nama_printer" id="edit_user-nama_printer" class="form-control form-control-alternative" placeholder="Nama..">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-secondary btn-block">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-4">
                        <img class="gambar-fill img-thumbnail fill_edit_gambar" src="<?=site_url('assets/custom/images/img_unavailable.png')?>">
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
    // ** Function + Global Variable    : Data user
    // -------------------------------------------------------
    var user = {
        ajax_link: "<?=site_url('data/list_user/list-1')?>",
        ajax_pagination: "<?=site_url('data/list_user/pagination')?>",
        default_js: "<?=site_url('assets/custom/js/default.js')?>",
        params: {
            limit: 100,
            page: 1,
            search_by: 'nama_lengkap'
        }
    }
    function refreshUser() {
        $.ajax({
            url: user.ajax_link,
            type: 'GET',
            dataType: 'html',
            data: user.params,
        })
        .done(function(data) {
            $(".load-user").html(data);
            $.getScript(user.default_js);
            $.ajax({
                url: user.ajax_pagination,
                type: 'GET',
                dataType: 'html',
                data: user.params,
            })
            .done(function(data) {
                $(".load-user-pagination").html(data);
                eventAfterUser();
            })
        });
    }
    refreshUser();


    // -------------------------------------------------------
    // ** function       : Events yang ada di tabel user
    // -------------------------------------------------------
    function eventAfterUser() {
        $(".page-control").click(function(e) {
            page = $(this).data('page');
            user.params.page = page;
            refreshUser();
        });

        $(".page-control-back").click(function(e) {
            if (user.params.page > 1) {
                user.params.page--;
                refreshUser();
            }
        });
        $(".page-control-next").click(function(e) {
            user.params.page++;
            refreshUser();
        });
        // -------------------------------------------------------
        // ** Event        : Memnuculkan Form Edit Kategori 
        // -------------------------------------------------------
        $(".content-edit-user").click(function(e) {
            username = $(this).data('id');
            $.ajax({
                url: '<?=site_url('data/read_user')?>',
                type: 'GET',
                dataType: 'json',
                data: {username: username},
            })
            .done(function(data){
                $("#modal-edit_user").modal('show');
                $("#edit_user-nama_lengkap").val(data.nama_lengkap);
                $("#edit_user-username").val(data.username);
                $("#edit_user-level").val(data.level);
                $("#edit_user-alamat").val(data.alamat);
                $("#edit_user-nama_printer").val(data.nama_printer);
                $("#edit_user-alamat_printer").val(data.alamat_printer);
                $(".fill_edit_gambar").attr('src', data.avatar_formatted);
            });
        });

        $(".content-delete-user").click(function(e) {
            if (confirm('Anda yakin.?')) {
                username = $(this).data('id');
                $.ajax({
                    url: '<?=site_url('data/write_user/delete')?>',
                    type: 'POST',
                    dataType: 'html',
                    data: {username: username},
                })
                .always(function() {
                    refreshUser();
                });
            }
            e.preventDefault();
        });
    }

    // -------------------------------------------------------
    // ** Event + Ajax Script : Tambah user
    // -------------------------------------------------------
    $(".btn-tambah-user").click(function(e) {
        $("#modal-tambah_user").modal('show');
    });
    $("#modal-tambah_user").on('shown.bs.modal', function(e) {
        $("#tambah_user-nama_lengkap").focus();
    });
    $("#tambah_user-password_confirm").on('input', function(e) {
        value = $(this).val();
        password = $("#tambah_user-password").val();
        if (value != password) {
            $("#tambah_user-password_confirm-help").show();
            $("#tambah_user-password_confirm").removeClass('is-valid');
            $("#tambah_user-password_confirm").addClass('is-invalid');
        }
        else {
            $("#tambah_user-password_confirm-help").hide();
            $("#tambah_user-password_confirm").removeClass('is-invalid');
            $("#tambah_user-password_confirm").addClass('is-valid');
        }
    });
    $("#form-tambah_user").submit(function(e) {
        e.preventDefault();
        password = $("#tambah_user-password").val();
        password_confirm = $("#tambah_user-password_confirm").val();
        if (password == password_confirm) {
            $.ajax({
                url: '<?=site_url('data/write_user/insert')?>',
                type: 'POST',
                dataType: 'html',
                data: new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false,
            })
            .always(function() {
                $("#modal-tambah_user").modal('hide');
                $("#form-tambah_user")[0].reset();
                refreshUser();
            });
        }
        else {
            alert('Konfirmasi password tidak cocok');
        }
    });


    // -------------------------------------------------------
    // ** Event + Ajax Script : Edit user
    // -------------------------------------------------------
    $("#modal-edit_user").on('shown.bs.modal', function(e) {
        $("#edit_user-nama_lengkap").focus();
    });
    $("#edit_user-password_confirm").on('input', function(e) {
        value = $(this).val();
        password = $("#edit_user-password").val();
        if (value != password) {
            $("#edit_user-password_confirm-help").show();
            $("#edit_user-password_confirm-wrapper").removeClass('has-success');
            $("#edit_user-password_confirm-wrapper").addClass('has-error');
        }
        else {
            $("#edit_user-password_confirm-help").hide();
            $("#edit_user-password_confirm-wrapper").removeClass('has-error');
            $("#edit_user-password_confirm-wrapper").addClass('has-success');
        }
    });
    $("#form-edit_user").submit(function(e) {
        e.preventDefault();
        password = $("#edit_user-password").val();
        password_confirm = $("#edit_user-password_confirm").val();
        if (password == password_confirm) {
            $.ajax({
                url: '<?=site_url('data/write_user/update')?>',
                type: 'POST',
                dataType: 'html',
                data: new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false,
            })
            .always(function() {
                $("#modal-edit_user").modal('hide');
                refreshUser();
            });
        }
        else {
            alert('Konfirmasi password tidak cocok');
        }
    });


    // -------------------------------------------------------
    // ** Events       : Event-event filter
    // -------------------------------------------------------
    $("#filter-limit").on('input', function(e) {
        value = $(this).val();
        if (value >= 0) {
            user.params.limit = value;
        }
        else {
            delete user.params.limit;
        }
        refreshUser();
    });
    $("#filter-search").on('input', function(e) {
        value = $(this).val();
        if (value != '') {
            user.params.search = value;
        }
        else {
            delete user.params.search;
        }
        refreshUser();
    });

    $("#filter-blokir").on('input', function(e) {
        value = $(this).val();
        if (value != '') {
            user.params.blokir = value;
        }
        else {
            delete user.params.blokir;
        }
        refreshUser();
    });

    $("#filter-level").on('input', function(e) {
        value = $(this).val();
        if (value != '---') {
            user.params.level = value;
        }
        else {
            delete user.params.level;
        }
        refreshUser();
    });

    $("#filter-search-by").change(function(e) {
        value = $(this).val();
        if (value != '---') {
            user.params.search_by = value;
        }
        else {
            delete user.params.search_by;
        }
        refreshUser();
    });


</script>
<?php $this->view('argon/footer')?>
