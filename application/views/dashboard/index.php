<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<div class="header bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-dashboard.png')?>') 0 -150px/100% no-repeat !important;">
	<div class="container-fluid">
		<div class="header-body">
		</div>
	</div>
</div>
<div class="content">
	<div class="container-fluid mt--8">
		<div class="row mb-3">
			<div class="col-sm-8">
				<div class="card shadow">
					<div class="card-header">
						<h6 class="text-muted text-uppercase mb-0">Data Transaksi Penjualan</h6>
						<h3 class="card-title mb-0">Statistik Singkat</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col">
								<canvas id="statistik-penjualan" height="320" class="col-xs-12"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card shadow">
					<div class="card-header">
						<h6 class="text-muted text-uppercase mb-0">Capaian Data pada tanggal <?=date('d M Y')?></h6>
						<h3 class="card-title mb-0">Capaian Hari ini</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-6 text-center">
								<span class="fas fa-arrow-alt-circle-up text-success" style="font-size: 50pt"></span>
								<h2 style="margin-top: 5px; margin-bottom: 0px" class="font-ubuntu fill-num_transaksi">XX</h2>
								<span class="text-muted text-xs text-uppercase">Transaksi / Struk</span>
							</div>
							<div class="col-6 text-center">
								<span class="fas fa-cubes text-primary" style="font-size: 50pt"></span>
								<h2 style="margin-top: 5px; margin-bottom: 0px" class="font-ubuntu fill-num_stok_terjual">XX</h2>
								<span class="text-muted text-xs text-uppercase">Item Stok Terjual</span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-6 text-center">
								<span class="fas fa-clipboard-list text-primary" style="font-size: 50pt"></span>
								<h2 style="margin-top: 5px; margin-bottom: 0px" class="font-ubuntu fill-num_barang">XX</h2>
								<span class="text-muted text-xs text-uppercase">Jenis Barang Tersimpan</span>
							</div>
							<div class="col-6 text-center">
								<span class="fas fa-cubes text-success" style="font-size: 50pt"></span>
								<h2 style="margin-top: 5px; margin-bottom: 0px" class="font-ubuntu fill-num_stok">XX</h2>
								<span class="text-muted text-xs text-uppercase">Item Barang Tersimpan</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-12">
				<div class="card shadow">
					<div class="card-header bg-default">
						<h6 class="text-white text-muted text-uppercase mb-0">Data Barang yang akan kadaluarsa</h6>
						<h3 class="text-white card-title mb-0">Peringatan Kadaluarsa</h6>
					</div>
					<div class="table-responsive">
						<table class="table table-dark table-hover align-items-center">
							<tr class="thead-dark">
								<th>No</th>
								<th>Kode / Barcode</th>
								<th>Barang</th>
								<th>Satuan</th>
								<th>Harga</th>
								<th>Tanggal Kadaluarsa</th>
								<th>Interval Warning</th>
							</tr>
							<?php 
								$no = 0;
								foreach ($data_stok as $stok_kadaluarsa) {
									$tanggal_kadaluarsa = new DateTime($stok_kadaluarsa->tgl_kadaluarsa);
									if ($stok_kadaluarsa->tgl_kadaluarsa != '0000-00-00') {
										$interval = $waktu_sekarang->diff($tanggal_kadaluarsa)->d + 1;
										if ($interval <= $stok_kadaluarsa->ingat_kadaluarsa) {
											$no++;
											$barang = $this->BarangModel->single($stok_kadaluarsa->barang_id, 'OBJECT');
							?>
							<tr>
								<td><?=$no?></td>
								<td><strong><?=$stok_kadaluarsa->barcode?></strong></td>
								<td><?=$barang->nama?></td>
								<td><?=$barang->satuan?></td>
								<td>Rp. <?=number_format($barang->harga)?>,-</td>
								<td><?=date('d M Y', strtotime($stok_kadaluarsa->tgl_kadaluarsa))?> <br><strong>(<?=$interval?> Hari Lagi)</strong></td>
								<td><?=$stok_kadaluarsa->ingat_kadaluarsa?> Sebelum hari H</td>
							</tr>
							<?php
										}
									}
								}
								if ($no == 0) {
							?>
							<tr>
								<td colspan="7" class="text-center">
									<i>Tidak ada data</i>
								</td>
							</tr>
							<?php
								}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-12">
				<div class="card shadow">
					<div class="card-header bg-danger">
						<h6 class="text-white text-muted text-uppercase mb-0">Faktur Pembelian yang bersifat kredit dan berstatus belum lunas.</h6>
						<h3 class="text-white card-title mb-0">Data Pembelian Kredit</h3>
					</div>
					<div class="content table-responsive table-full-width">
						<table class="table table-hover">
							<tr class="text-white" style="background: #ff8fa5 !important">
								<th>No</th>
								<th>No Faktur</th>
								<th>Supplier</th>
								<th>Total Harga Beli</th>
								<th>Jatuh Tempo</th>
								<th>Tanggal Faktur</th>
								<th></th>
							</tr>
							<?php 
								$no = 0;
								foreach ($data_tr_beli_kredit as $tr) {
									if ($tr->kredit_selesai != 1) {
										$supplier_count = $this->SupplierModel->single($tr->supplier_id, 'COUNT');
										if ($supplier_count > 0) {
											$supplier = $this->SupplierModel->single($tr->supplier_id, 'OBJECT');
										}
										$no++;
							?>
							<tr>
								<td><?=$no?></td>
								<td><?=$tr->no_faktur?></td>
								<td><?=(($supplier_count > 0)?$supplier->nama: '<i>Tidak ada data Supplier</i>')?></td>
								<td>Rp. <?=number_format($tr->harga_beli, 0, '', '.')?>,-</td>
								<td><?=date('d-m-Y', strtotime($tr->jatuh_tempo))?></td>
								<td><?=date('d-m-Y', strtotime($tr->tanggal_faktur))?></td>
								<td>
									<a href="<?=site_url('laporan/pembelian?transaksi_id=' . $tr->id)?>" class="btn btn-secondary btn-icon-only rounded-circle">
										<i class="fas fa-eye"></i> 
									</a>
								</td>
							</tr>
							<?php
									}
								}
								if ($no == 0) {
							?>
							<tr>
								<td colspan="7" class="text-center">
									<i>Tidak ada data</i>
								</td>
							</tr>
							<?php
								}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="card shadow">
					<div class="card-header bg-warning">
						<h6 class="text-white text-muted text-uppercase mb-0">Faktur Pembelian yang bersifat konsinyasi / titip jual.</h6>
						<h3 class="text-white card-title mb-0">Data Pembelian Konsinyasi</h3>
					</div>
					<div class="table-responsive">
						<table class="table table-hover">
							<tr class="text-white" style="background: #ff9077">
								<th>No</th>
								<th>No Faktur</th>
								<th>Supplier</th>
								<th>Tanggal Faktur</th>
								<th></th>
							</tr>
							<?php 
								$no = 0;
								foreach ($data_tr_beli_konsinyasi as $tr) {
									if ($tr->kredit_selesai != 1) {
										$supplier_count = $this->SupplierModel->single($tr->supplier_id, 'COUNT');
										if ($supplier_count > 0) {
											$supplier = $this->SupplierModel->single($tr->supplier_id, 'OBJECT');
										}
										$no++;
							?>
							<tr>
								<td><?=$no?></td>
								<td><?=$tr->no_faktur?></td>
								<td><?=(($supplier_count > 0)?$supplier->nama: '<i>Tidak ada data Supplier</i>')?></td>
								<td><?=date('d-m-Y', strtotime($tr->tanggal_faktur))?></td>
								<td>
									<a href="<?=site_url('laporan/pembelian?transaksi_id=' . $tr->id)?>" class="btn btn-secondary btn-icon-only rounded-circle">
										<i class="fas fa-eye"></i> 
									</a>
								</td>
							</tr>
							<?php
									}
								}
								if ($no == 0) {
							?>
							<tr>
								<td colspan="5" class="text-center">
									<i>Tidak ada data</i>
								</td>
							</tr>
							<?php
								}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<div class="modal fade" id="modal-rincian_transaksi_kredit">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss='modal'>
					<i class="fas fa-times"></i>
				</button>
				<h4 class="modal-title">Rincian Transaksi Pembelian</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Barang</th>
									<th>Satuan</th>
									<th>Barcode / Kode</th>
									<th>Qty / Jumlah</th>
								</tr>
							</thead>
							<tbody class="load-rincian_transaksi_kredit"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-rincian_transaksi_konsinyasi">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss='modal'>
					<i class="fas fa-times"></i>
				</button>
				<h4 class="modal-title">Rincian Transaksi Pembelian</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Barang</th>
									<th>Satuan</th>
									<th>Harga</th>
									<th>Barcode / Kode</th>
									<th>Qty / Jumlah</th>
									<th>Stok Terjual</th>
									<th>Stok Tersisa</th>
								</tr>
							</thead>
							<tbody class="load-rincian_transaksi_konsinyasi"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->view('argon/js_script')?>
<?php 
	$tanggal_akhir = new DateTime();
	$tanggal_awal = new DateTime();
	$tanggal_awal->modify('-1 Week');
?>
<script type="text/javascript">
	var statistik_penjualan_params = {
		tanggal_awal: '<?=$tanggal_awal->format('Y-m-d')?>',
		tanggal_akhir: '<?=$tanggal_akhir->format('Y-m-d')?>'
	}
	var statistik_penjualan_ctx = document.getElementById('statistik-penjualan').getContext('2d');
	var statistik_penjualan = new Chart(statistik_penjualan_ctx, {
		type: 'line',
		data: {
			labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
			datasets: [{
				label: "Pemasukan",
	            data: [3, 2, 3, 2, 3, 2, 3],
	            backgroundColor: [
	                'rgba(35, 167, 230, 0.2)'
	            ],
	            borderColor: [
	                '#23a7e6'
	            ],
	            pointHoverBackgroundColor: '#23a7e6',
	            pointHoverBorderColor: '#23a7e6',
	            borderWidth: 1
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
	function refresh_statistik_penjualan() {
		$.ajax({
			url: '<?=site_url('dashboard/statistik_pemasukan')?>',
			type: 'GET',
			dataType: 'json',
			data: statistik_penjualan_params
		})
		.done(function(data) {
			statistik_penjualan.data.labels = data.label;
			statistik_penjualan.data.datasets[0].data = data.pemasukan;
			statistik_penjualan.update();
		});
	}
	refresh_statistik_penjualan();

	$(".content-view-transaksi_kredit").click(function(e) {
		e.preventDefault();
		id = $(this).data('id');
		$.ajax({
			url: '<?=site_url('data/list_stok/list-2')?>',
			type: 'GET',
			dataType: 'html',
			data: {transaksi: id},
		})
		.done(function(data) {
			$(".load-rincian_transaksi_kredit").html(data);
			$("#modal-rincian_transaksi_kredit").modal('show');
		});
	});
	$(".content-edit-transaksi_kredit").click(function(e) {
		if (confirm('Anda yakin..?')) {
			if (confirm('Perubahan Status lunas menjadi permanen dan tidak dapat diubah..?')) {
			}
			else {
				e.preventDefault();
			}
		}
		else {
			e.preventDefault();
		}
	});
	$(".content-view-transaksi_konsinyasi").click(function(e) {
		e.preventDefault();
		id = $(this).data('id');
		$.ajax({
			url: '<?=site_url('data/list_stok/list-3')?>',
			type: 'GET',
			dataType: 'html',
			data: {transaksi: id},
		})
		.done(function(data) {
			$(".load-rincian_transaksi_konsinyasi").html(data);
			$("#modal-rincian_transaksi_konsinyasi").modal('show');
		});
	});
	$(".content-edit-transaksi_konsinyasi").click(function(e) {
		if (confirm('Anda yakin..?')) {
			if (confirm('Perubahan Status lunas menjadi permanen dan tidak dapat diubah..?')) {
			}
			else {
				e.preventDefault();
			}
		}
		else {
			e.preventDefault();
		}
	});

	function refresh_capaian() {
		$.ajax({
			url: '<?=site_url('data/capaian')?>',
			type: 'GET',
			dataType: 'json',
		})
		.done(function(data) {
			$(".fill-num_transaksi").html(data.transaksi.count);
			$(".fill-num_stok_terjual").html(data.item_transaksi.count);
			$(".fill-num_barang").html(data.barang.count);
			$(".fill-num_stok").html(data.stok.count);
		});
	}
	refresh_capaian();
	setInterval(function() {
		refresh_capaian();
		refresh_statistik_penjualan();
	}, 3000)
</script>
<?php $this->view('argon/footer')?>
