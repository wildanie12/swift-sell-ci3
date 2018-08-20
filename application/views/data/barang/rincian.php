<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<div class="header d-print-none bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-data.jpg')?>') 0 -150px/100% no-repeat !important; -webkit-filter: brightness(111%) contrast(80%); filter: brightness(111%) contrast(80%);">
   <div class="container-fluid">
      <div class="header-body">
      </div>
   </div>
</div>
<div class="container-fluid mt--5">
    <div class="row d-print-block mb-7 d-none"></div>
    <div class="row d-print-block d-none">
        <div class="col-sm-12">
            <h1 class="text-center">DATA RINCIAN BARANG</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header ">
                    <h4 class="card-title mb-0">Rincian data barang</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3 col-xs-5">
                            <img class="img-thumbnail" src="<?=site_url($barang->foto)?>">
                        </div>
                        <div class="col-sm-9 col-xs-7">
                            <table class="table">
                                <tr>
                                    <th>Nama</th>
                                    <td>: <?=$barang->nama?></td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>: <?=$kategori->nama?></td>
                                </tr>
                                <tr>
                                    <th>Satuan</th>
                                    <td>: <?=$barang->satuan?></td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td>: Rp. <?=number_format($barang->harga, 0, '', '.')?>,-</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Stok</th>
                                    <td>: <?=$stok_tersedia?> <?=$barang->satuan?> (<?=date('d F Y')?>)</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="card-title mb-0 text-white">Statistik Stok</h4>
                </div>
                <div class="card-body">
                    <div class="row hidden-print">
                        <div class="col-sm-12">
                            <form id="form-filter-statistik_stok">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="form-control-label" for="filter-statistik_stok-dari">Dari Tanggal</label>
                                        <input type="date" id="filter-statistik_stok-dari" class="form-control form-control-alternative" value="<?=$waktu_sekarang->modify('-6 day')->format('Y-m-d')?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-control-label" for="filter-statistik_stok-sampai">Sampai Tanggal</label>
                                        <input type="date" id="filter-statistik_stok-sampai" class="form-control form-control-alternative" value="<?=date('Y-m-d')?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <div class="chart">
                                <canvas id="statistik-stok" class="chart-canvas" height="320"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-success ">
                    <h4 class="card-title mb-0 text-white">Statistik Penjualan</h4>
                </div>
                <div class="card-body">
                    <div class="row hidden-print">
                        <div class="col-sm-12">
                            <form id="form-filter-statistik_penjualan">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="form-control-label" for="filter-statistik_penjualan-dari">Dari Tanggal</label>
                                        <input type="date" id="filter-statistik_penjualan-dari" class="form-control form-control-alternative"  value="<?=$waktu_sekarang->format('Y-m-d')?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-control-label" for="filter-statistik_penjualan-sampai">Sampai Tanggal</label>
                                        <input type="date" id="filter-statistik_penjualan-sampai" class="form-control form-control-alternative"  value="<?=date('Y-m-d')?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <canvas id="statistik-penjualan" class="col-xs-12" height="320"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->view('argon/js_script')?>
<script type="text/javascript">
    var statistik = {
        stok: {
            ajax_link: '<?=site_url('data/statistik_barang/' .$barang->id)?>',
            tanggal_awal_time: new Date($("#filter-statistik_stok-dari").val()),
            tanggal_akhir_time: new Date($("#filter-statistik_stok-sampai").val()),
            params: {
                tanggal_awal: $("#filter-statistik_stok-dari").val(), 
                tanggal_akhir: $("#filter-statistik_stok-sampai").val()
            }
        },
        penjualan: {
            ajax_link: '<?=site_url('data/statistik_penjualan/' .$barang->id)?>',
            tanggal_awal_time: new Date($("#filter-statistik_penjualan-dari").val()),
            tanggal_akhir_time: new Date($("#filter-statistik_penjualan-sampai").val()),
            params: {
                tanggal_awal: $("#filter-statistik_penjualan-dari").val(), 
                tanggal_akhir: $("#filter-statistik_penjualan-sampai").val(),
            }
        },
    };

// ---------------------------------------------------
// ** Statistik Stok
// ---------------------------------------------------
var statistik_stok_ctx = document.getElementById('statistik-stok').getContext('2d');
var statistik_stok = new Chart(statistik_stok_ctx, {
    type: 'line',
    data: {
        labels: ["Hari 1", "Hari 2", "Hari 3", "Hari 4", "Hari 5", "Hari 6", "Hari 7"],
        datasets: [{
            label: "Barang Masuk",
            data: [3, 2, 3, 2, 3, 2, 3],
            backgroundColor: [
            'rgba(35, 167, 230, 0.4)'
            ],
            borderColor: [
            '#23a7e6'
            ],
            pointHoverBackgroundColor: '#23a7e6',
            pointHoverBorderColor: '#23a7e6',
            borderWidth: 3
        },
        {
            label: "Barang Keluar",
            data: [2, 3, 2, 3, 2, 3, 2],
            backgroundColor: [
            'rgba(245, 82, 82, 0.2)'
            ],
            borderColor: [
            'rgb(245, 82, 82)'
            ],
            pointHoverBackgroundColor: 'rgb(245, 82, 82)',
            pointHoverBorderColor: 'rgb(245, 82, 82)',
            borderWidth: 3
        }]
    },
    options : {
        legend: {
            display: true
        }
    }
});
function refresh_statistik_stok() {
    $.ajax({
        url: statistik.stok.ajax_link,
        type: 'GET',
        dataType: 'json',
        data: statistik.stok.params,
    })
    .done(function(data) {
        statistik_stok.data.labels = data.label;
        statistik_stok.data.datasets[0].data = data.barang_masuk;
        statistik_stok.data.datasets[1].data = data.barang_keluar;
        statistik_stok.update();
    });
}
refresh_statistik_stok();
$("#filter-statistik_stok-dari").change(function(e) {
    statistik.stok.params.tanggal_awal = $(this).val();
    statistik.stok.tanggal_awal_time = new Date($(this).val());
    if (statistik.stok.tanggal_awal_time > statistik.stok.tanggal_akhir_time) {
        statistik.stok.params.tanggal_awal = statistik.stok.params.tanggal_akhir,
        statistik.stok.tanggal_awal_time = statistik.stok.tanggal_akhir_time;
        $(this).val(statistik.stok.params.tanggal_akhir);
    }
    refresh_statistik_stok();
});
$("#filter-statistik_stok-sampai").change(function(e) {
    statistik.stok.params.tanggal_akhir = $(this).val();
    statistik.stok.tanggal_akhir_time = new Date($(this).val());
    if (statistik.stok.tanggal_akhir_time < statistik.stok.tanggal_awal_time) {
        statistik.stok.params.tanggal_akhir = statistik.stok.params.tanggal_awal,
        statistik.stok.tanggal_akhir_time = statistik.stok.tanggal_awal_time;
        $(this).val(statistik.stok.params.tanggal_awal);
    }
    refresh_statistik_stok();
});
// ---------------------------------------------------
// ** Statistik Penjualan
// ---------------------------------------------------
var statistik_penjualan_ctx = document.getElementById('statistik-penjualan').getContext('2d');
var statistik_penjualan = new Chart(statistik_penjualan_ctx, {
    type: 'line',
    data: {
        labels: ["Hari 1", "Hari 2", "Hari 3", "Hari 4", "Hari 5", "Hari 6", "Hari 7"],
        datasets: [{
            label: 'Penjualan',
            data: [3, 2, 3, 2, 3, 2, 3],
            backgroundColor: [
            'rgba(35, 167, 230, 0.2)'
            ],
            borderColor: [
            '#23a7e6'
            ],
            pointHoverBackgroundColor: '#23a7e6',
            pointHoverBorderColor: '#23a7e6',
            borderWidth: 3,
        }]
    },
    options: {
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function(item, data) {
                    var data = data.datasets[0].data[item.index];
                    return 'Rp.' + parseFloat(data).toLocaleString('en') + ',-';
                }
            },
            displayColors: false
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function (label, index, labels) {
                        return 'Rp. ' + (label).toLocaleString('en') + ',-';
                    }
                }
            }]
        }
    }
});



function refresh_statistik_penjualan() {
    $.ajax({
        url: statistik.penjualan.ajax_link,
        type: 'GET',
        dataType: 'json',
        data: statistik.penjualan.params,
    })
    .done(function(data) {
        statistik_penjualan.data.labels = data.label;
        statistik_penjualan.data.datasets[0].data = data.penjualan;
        statistik_penjualan.update();
    });
}
refresh_statistik_penjualan();
$("#filter-statistik_penjualan-dari").change(function(e) {
    statistik.penjualan.params.tanggal_awal = $(this).val();
    statistik.penjualan.tanggal_awal_time = new Date($(this).val());
    if (statistik.penjualan.tanggal_awal_time > statistik.penjualan.tanggal_akhir_time) {
        statistik.penjualan.params.tanggal_awal = statistik.penjualan.params.tanggal_akhir,
        statistik.penjualan.tanggal_awal_time = statistik.penjualan.tanggal_akhir_time;
        $(this).val(statistik.penjualan.params.tanggal_akhir);
    }
    refresh_statistik_penjualan();
});
$("#filter-statistik_penjualan-sampai").change(function(e) {
    statistik.penjualan.params.tanggal_akhir = $(this).val();
    statistik.penjualan.tanggal_akhir_time = new Date($(this).val());
    if (statistik.penjualan.tanggal_akhir_time < statistik.penjualan.tanggal_awal_time) {
        statistik.penjualan.params.tanggal_akhir = statistik.penjualan.params.tanggal_awal,
        statistik.penjualan.tanggal_akhir_time = statistik.penjualan.tanggal_awal_time;
        $(this).val(statistik.penjualan.params.tanggal_awal);
    }
    refresh_statistik_stok();
});




</script>
<?php $this->view('argon/footer')?>
