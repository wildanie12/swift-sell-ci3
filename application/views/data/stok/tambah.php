<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<div class="header bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-data.jpg')?>') 0 -150px/100% no-repeat !important; -webkit-filter: brightness(111%) contrast(80%); filter: brightness(111%) contrast(80%);">
   <div class="container-fluid">
      <div class="header-body">
      </div>
   </div>
</div>
<div class="row d-print-block d-none">
    <div class="col-sm-12">
        <h4 class="text-center">Daftar Barcode <?=$barang->nama?></h4>
        <div class="barcodes visible-print text-center"></div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row d-print-none">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Tambah Stok</h4>
                </div>
                <div class="card-body bg-secondary">
                    <form id="form-tambah_stok" action="<?=site_url('data/stok/tambah/submit?barang=' .$barang->id)?>" method="post">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Barang</label>
                                            <input type="text" name="barang_nama" class="form-control form-control-alternative" placeholder="Nama Barang" value="<?=$barang->nama?>" readonly="readonly">
                                            <input type="hidden" name="barang_id" value="<?=$barang->id?>">
                                            <input type="hidden" name="redirect" value="<?=$redirect?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Satuan</label>
                                            <input type="text" name="barang_satuan" class="form-control form-control-alternative" value="<?=$barang->satuan?>" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Harga</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp. </span>
                                                </div>
                                                <input type="number" name="barang_harga" class="form-control form-control-alternative" value="<?=$barang->harga?>" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Gambar</label>
                                            <img class="img-thumbnail" src="<?=site_url($barang->foto)?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Kode / Barcode</label>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <textarea name="barcode" readonly="readonly" rows="4" class="form-control form-control-alternative"></textarea>
                                                </div> 
                                            </div>
                                            <div class="row">
                                                <div class="col-sm pr-0">
                                                    <input type="text" name="kode" id="kode" class="form-control form-control-alternative" placeholder="Masukkan kode kemudian tekan enter...">
                                                </div>
                                                <div class="col-sm pr-0">
                                                    <input type="number" name="stok" id="stok" class="form-control form-control-alternative" placeholder="Masukkan Jumlah Stok kemudian tekan enter...">
                                                </div>
                                                <div class="col-auto">
                                                    <button type="button" class="btn btn-danger delete-code">Hapus Semua</button>
                                                </div>
                                            </div>
                                            <span class="help-block">Masukkan kode barcode, atau <a href="#" data-toggle='modal' data-target='#modal-buat_barcode'>Buat Barcode.!</a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Tanggal Kadaluarsa</label>
                                            <input type="date" name="tgl_kadaluarsa" class="form-control form-control-alternative">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Ingatkan kadaluarsa sebelum</label>
                                            <div class="input-group input-group-alternative">
                                                <input type="number" name="ingat_kadaluarsa" class="form-control form-control-alternative" value="<?=$default_kadaluarsa?>">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Hari</span>
                                                </div>
                                            </div>
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
</div>

<div class="modal fade d-print-none" id="modal-buat_barcode">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cetak Barcode</h4>
                <button class="close" type="button" data-dismiss='modal'>&times;</button>
            </div>
            <div class="modal-body bg-secondary">
                <div class="row d-print-none">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6 d-print-none">
                                <form class="form-horizontal" id="barcode-form">
                                    <div class="form-group mb-0">
                                        <label class="form-control-label col-xs-4">Nama Barang</label>
                                        <div class="col-xs-8">
                                            <input type="text" name="nama" class="form-control form-control-alternative" placeholder="Nama" readonly="true" value="<?=$barang->nama?>">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label col-xs-4">Jumlah Pack</label>
                                        <div class="col-xs-8">
                                            <input type="number" name="jumlah" class="form-control form-control-alternative" placeholder="Jumlah" value="1">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label col-xs-4">Duplikat / Isi Pack</label>
                                        <div class="col-xs-8">
                                            <input type="number" min="0" value="1" id="duplikat" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label col-xs-4">Harga Jual</label>
                                        <div class="col-xs-8">
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp. </span>
                                                </div>
                                                <input type="number" name="harga" class="form-control" value="<?=$barang->harga?>" readonly='readonly'>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-control-label col-xs-4">Satuan</label>
                                        <div class="col-xs-8">
                                            <input type="text" name="satuan" class="form-control" value="<?=$barang->satuan?>" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <div class="col-xs-12">
                                            <input type="submit" name="submit" value="Buat Kode.!" class="btn btn-primary btn-block">
                                        </div>
                                    </div>
                                    <div class="form-group mb-2" style="display: none" id="print-button-wrapper">
                                        <div class="col-xs-12">
                                            <button onclick="window.print()" type="button" id="print-button" class="btn btn-block btn-info">
                                                <span class="glyphicon glyphicon-print"></span> Cetak
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <form class="form-horizontal" id="layouting-form">
                                    <div class="form-group mb-0">
                                        <label class="form-control-label col-xs-5">Margin x (Each)</label>
                                        <div class="col-xs-7">
                                            <input type="range" min="0" max="100" value="11" id="margin-horizontal" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label col-xs-5">Margin y (Each)</label>
                                        <div class="col-xs-7">
                                            <input type="range" min="0" max="100" value="5" id="margin-vertical" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label col-xs-5">Padding (Each)</label>
                                        <div class="col-xs-7">
                                            <input type="range" min="0" max="100" value="0" id="padding" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-control-label col-xs-5">Size (Each)</label>
                                        <div class="col-xs-7">
                                            <input type="range" min="1" max="2" step="0.05" value="1.2" id="size" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-control-label col-xs-5">Border / Outline</label>
                                        <div class="col-xs-7">
                                            <div class="input-group input-group-alternative">
                                                <select id="border" class="form-control">
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
                                    <div class="form-group mb-0">
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

// --------------------------------------------
// ** Kode Generator
// --------------------------------------------

$("#kode").focus();
$("#kode").keypress(function(e) {
    key = e.which;
    if (key == 13) {
        if ($(this).val() != '') {
            $("#stok").focus();
            $(this).val('');
        }
        e.preventDefault();
    }
});
$("#kode").change(function(e) {
    e.preventDefault();
    value = $(this).val();
    if (value != '') {
        $.ajax({
            url: '<?=site_url('data/cek_kode')?>',
            type: 'GET',
            dataType: 'json',
            data: {barcode: value},
        })
        .done(function(data) {
            if (data.stok_count <= 0) {
                $(this).val('');
                $("textarea[name='barcode']").append(value + ':');
                $("#stok").focus();
            }
            else {
                alert('Kode sudah ada. (pada barang: '  + data.barang.nama + ', stok: ' +data.stok.stok+ ')');
                $("#kode").val('');
                $("#kode").focus();
            }
        });
    }
    else {
        alert('Masukkan Kode terlebih dahulu');
    }
});
$("#stok").keypress(function(e) {
    key = e.which;
    if (key == 13) {
        if ($(this).val() != '') {
            $("#kode").focus();
            $(this).val('');
        }
        e.preventDefault();
    }
});
$("#stok").change(function(e) {
    e.preventDefault();
    value = $(this).val();
    if (value != '') {
        $(this).val('');
        $("textarea[name='barcode']").append(value + '|');
        $("#kode").focus();
    }
    else {
        alert('Masukkan jumlah terlebih dahulu');
    }
});
$(".delete-code").click(function(e) {
    if (confirm('Anda yakin?')) {
        $("textarea[name='barcode']").html("");
        $("#kode").focus();
    }
});


// ------------------------------------------
// ** Barcode Generator
// ------------------------------------------

$("#modal-buat_barcode").on('shown.bs.modal', function(e) {
    $("#duplikat").focus();
    $("#duplikat").select();
    e.preventDefault();
});
$("#barcode-form").on('submit', function(e) {
    e.preventDefault();
    var list = [];
    $.ajax({
        url: '<?=site_url('data/getNewID')?>',
        type: 'GET',
        dataType: 'json',
    })
    .done(function(data) {
        jumlah = $("#barcode-form input[name='jumlah']").val();
        duplikat = $("#duplikat").val();
        i = 1;
        $(".barcodes").html('');
        fetch = data.kode;
        while(i <= jumlah) {
            string = fetch;
            string = string + i + (Math.floor(Math.random() * 6) + 1);
            list.push(string);

            d = 1;
            while (d <= duplikat) {
                $(".barcodes").append("<svg class='barcode b"+ i +"'></svg>");
                JsBarcode(".b"+ i, string, {
                    fontSize: 9,
                    height: 20,
                    width: 1,
                    text: string + ' Rp. <?=number_format($barang->harga, 0, '', '.')?>,-'
                });
                d++;
            }
            i++;
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
        $("#print-button-wrapper").show();
        var collection = "";
        list.forEach(function(item, index) {
            collection += item + ":" + duplikat + '|';
        });
        $("textarea[name='barcode']").val(collection);
    });
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
</script>
<?php $this->view('argon/footer')?>
