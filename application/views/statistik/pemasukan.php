<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<div class="header d-print-none bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-card-statistik.png')?>') 0 -150px/100% no-repeat !important; -webkit-filter: brightness(151%) contrast(160%); filter: brightness(151%) contrast(160%);">
   <div class="container-fluid">
      <div class="header-body">
      </div>
   </div>
</div>
<div class="container-fluid mt--5">
    <div class="row">
        <div class="col">
            <div class="card border-0">
                <div class="card-header bg-secondary d-print-none">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Statistik pemasukan</h4>
                            <span class="text-xs">Gunakan filter disamping kanan untuk mengatur rentang tanggal statistik.</span>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group mb-0">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Dari</span>
                                    </div>
                                    <input type="date" id="filter-statistik-dari" class="form-control form-control-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ke</span>
                                    </div>
                                    <input type="date" id="filter-statistik-sampai" value="<?=date('Y-m-d')?>" class="form-control form-control-alternative">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-primary btn-refresh rounded-circle btn-icon-only" data-toggle="tooltip" data-placement="bottom" title="" style="padding-top: 1px" data-original-title="Refresh" onclick="refresh_statistik()">
                                <i class="fas fa-sync"></i>
                            </a>
                            <a href="#" class="btn btn-info rounded-circle btn-icon-only" data-toggle="tooltip" data-placement="bottom" title="Cetak laporan" onclick="window.print()">
                                <i class="fas fa-print"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="text-center">STATISTIK PEMASUKAN TRANSAKSI PENJUALAN</h2>
                    <div class="row">
                        <div class="col-sm-12" style="padding-bottom: 70px">
                            <canvas id="statistik" height="400" class="col-xs-12"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->view('argon/js_script')?>
<script type="text/javascript">
    var statistik_ctx = document.getElementById('statistik').getContext('2d');
    var statistik_data = {
        ajax_link: '<?=site_url('statistik/statistik_pemasukan')?>',
        tanggal_awal_time: new Date($("#filter-statistik-dari").val()),
        tanggal_akhir_time: new Date($("#filter-statistik-sampai").val()),
        params: {
            tanggal_akhir: $("#filter-statistik-sampai").val()
        }
    }
    var statistik = new Chart(statistik_ctx, {
        type: 'line',
        data: {
            labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
            datasets: [{
                label: "Pemasukan",
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
            }]
        },
        options: {
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
                    scaleLabel: {
                        display: true,
                        labelString: 'Pemasukan'
                    },
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
    function refresh_statistik() {
        $.ajax({
            url: '<?=site_url('statistik/statistik_pemasukan')?>',
            type: 'GET',
            dataType: 'json',
            data: statistik_data.params,
        })
        .done(function(data) {
            statistik.data.labels = data.label;
            statistik.data.datasets[0].data = data.pemasukan;
            statistik.update();
        });
    }
    refresh_statistik();

    $("#filter-statistik-dari").change(function(e) {
        value = $(this).val();
        if (value != '') {
            statistik_data.params.tanggal_awal = value;
        }
        else {
            delete statistik_data.params.tanggal_awal;
        }
        refresh_statistik();
    });
    $("#filter-statistik-sampai").change(function(e) {
        value = $(this).val();
        if (value != '') {
            statistik_data.params.tanggal_akhir = value;
        }
        else {
            delete statistik_data.params.tanggal_akhir;
        }
        refresh_statistik();
    });
</script>
<?php $this->view('argon/footer')?>
