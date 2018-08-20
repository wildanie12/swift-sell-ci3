<?php $this->view('argon/header')?>
<?php  $this->view('argon/navigation')?>
<div class="header bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-transaksi.jpg')?>') 0 -150px/100% no-repeat !important; -webkit-filter: brightness(80%) contrast(140%); filter: brightness(80%) contrast(140%);">
    <div class="container-fluid">
        <div class="header-body">
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm">
							<div class="row align-items-center">
								<div class="col-sm-auto no-padding-right no-padding-left" style="margin-left: 15px">
									<img src="<?=site_url('assets/custom/images/konfigurasi/APP_LOGO/' .$app_logo)?>" class="img-thumbnail" style="height: 120px">
								</div>
								<div class="col-sm">
									<h2 style="margin-bottom: 0"><?=$app_name?></h2>
									<p style="font-style: italic;"><?=$app_alamat?></p>
								</div>
								<div class="col-sm-auto">
									<div class="row">
										<div class="col-sm-2 col-sm-offset-10 no-padding-left">
											<a href="<?=base_url()?>" data-toggle='tooltip'>
												<i class="fa fa-home" style="font-size: 60pt"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-2 mb-8">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header bg-success">
					<h4 class="card-title mb-0 text-white">Data Penjualan</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-2">
							<div class="row">
								<div class="col-sm-12">
									<img class="barang-foto img-thumbnail" src="<?=site_url('assets/custom/images/img_unavailable.png')?>">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 pt-4">
									<label style="display: block" class="text-xs font-weight-bold">Nama Barang</label>
									<h4 class="barang-nama" style="margin-top:0; padding: 0">-</h4>

									<label style="display: block" class="text-xs font-weight-bold">Satuan</label>
									<h4 class="barang-satuan" style="margin-top:0; padding: 0">-</h4>

									<label style="display: block" class="text-xs font-weight-bold">Stok Tersisa</label>
									<h4 class="barang-stok" style="margin-top:0; padding: 0">-</h4>

									<label style="display: block" class="text-xs font-weight-bold">Harga</label>
									<h4 class="barang-harga" style="margin-top:0; padding: 0">Rp. -</h4>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<form id="form-pembelian">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label  for="barcode">Barcode / Kode Barang</label>
											<input type="text" name="barcode" id="barcode" class="form-control" placeholder="Masukkan kode barang disini..." tabindex="1">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label  for="qty">Jumlah Beli</label>
											<input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Masukkan jumlah.." tabindex="3">
											<span class="help-block"><strong>Tips:</strong> Gunakan tombol arah atas dan bawah pada keyboard.</span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label  for="bayar">Nominal Pembayaran</label>
											<input type="number" min="0" name="bayar" id="bayar" class="form-control" placeholder="Masukkan Uang Pembayaran..." tabindex="2">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm">
										<div class="form-group">
											<button type="button" class="btn btn-danger btn-block" id="hapus">
												<i class="fas fa-times"></i> 
												Hapus
											</button>
											<span class="help-block"><strong>Pintasan keyboard: </strong>DEL</span>
										</div>
									</div>
									<div class="col-sm">
										<div class="form-group">
											<button type="button" class="btn btn-primary btn-block" id="cetak">
												<i class="fas fa-print"></i> 
												Cetak
											</button>
											<span class="help-block"><strong>Pintasan keyboard: </strong>CTRL+P</span>
										</div>
									</div>
									<div class="col-sm">
										<div class="form-group">
											<button type="button" class="btn btn-info btn-block" id="reset">
												<i class="fas fa-undo"></i> 
												Reset
											</button>
											<span class="help-block"><strong>Pintasan keyboard: </strong>F1 / F5</span>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-8 align-items-center justify-content-end d-flex kasir-harga">
									<h1 class="fill-total">Rp. -</h4>
								</div>
								<div class="col-sm-4 text-center kasir-atribut d-flex flex-column">
									<h5 style="margin: 4px"><?=date('d M Y')?> <?=date('H:i:s')?></h5>
									<h5 class="fill-transaksi_id text-lg">ID</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 table-responsive table-full-width no-padding-right">
									<table class="table table-striped table-hover table-bordered">
										<thead>
											<tr>
												<th>Barang</th>
												<th>Qty</th>
												<th>Harga</th>
												<th>Subtotal</th>
												<th></th>
											</tr>
										</thead>
										<tbody class="keranjang-load justif">
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->view('argon/js_script')?>
<script type="text/javascript">
	hide_sidebar();

	transaksi = {
		id: -1,
		bayar: -1,
		kembali: -1,
		total: -1,
		default_js: '<?=site_url('assets/custom/js/default.js')?>',
		read_barang: {
			ajax_link: '<?=site_url('data/read_stok/barcode')?>',
			params: {}
		},
		item: {
			ajax_link_insert: '<?=site_url('transaksi/write_item_transaksi/insert')?>',
			params: {}
		}
	}

	function readBarang(barcode) {
		$.ajax({
			url: transaksi.read_barang.ajax_link,
			type: 'GET',
			dataType: 'json',
			data: {barcode: barcode},
		})
		.fail(() => {
			$(".barang-foto").attr('src', '<?=site_url('assets/custom/images/img_unavailable.png')?>');
			$(".barang-nama").html('Tidak ada barang / stok yang cocok.');
			$(".barang-satuan").html('-');
			$(".barang-harga").html('-');
			$(".barang-stok").html('-');
		})
		.done(function(data) {
			$(".barang-foto").attr('src', data.barang_foto_formatted);
			$(".barang-nama").html(data.barang_nama);
			$(".barang-satuan").html(data.barang_satuan);
			$(".barang-harga").html(data.barang_harga_formatted);
			if (data.stok > 0) {
				transaksi.item.params.stok_id = data.id;
				$(".barang-stok").html(data.stok);
				$("#qty").attr('max', data.stok);
				$("#qty").removeAttr('readonly');
				$("#qty").focus();
			}
			else {
				$(".barang-stok").html('Stok Habis');
				$("#barcode").val('')
				$("#qty").attr('readonly', 'readonly');
			}
		});
	}
	$("#barcode").focus();
	$("#barcode").change(function(e) {
		barcode = $(this).val();
		if (barcode != '') {
			readBarang(barcode);
		}
	}).keydown(function(e) {
		code = e.which;
		if (code == 13) {
			e.preventDefault();
			barcode = $(this).val();
			if (barcode != '') {
				readBarang(barcode);
			}
		}
	});


	function insert_keranjang() {
		if (transaksi.id == -1) {
			$.ajax({
				url: '<?=site_url('transaksi/write_transaksi_jual/insert')?>',
				type: 'POST',
				dataType: 'json',
			})
			.done(function(data) {
				transaksi.id = data.transaksi_id;
				$(".fill-transaksi_id").html('ID : ' + data.transaksi_id);
				transaksi.item.params.transaksi_id = data.transaksi_id;

				$.ajax({
					url: transaksi.item.ajax_link_insert,
					type: 'POST',
					dataType: 'html',
					data: transaksi.item.params,
				})
				.always(function() {
					refresh_keranjang();
					transaksi.item.params.stok_id = -1;
					transaksi.item.params.qty = -1;
					$("#barcode").focus();
					$("#barcode").val('');
					$("#qty").val('');
					$(".barang-foto").attr('src', '<?=site_url('assets/custom/images/img_unavailable.png')?>');
					$(".barang-nama").html('-');
					$(".barang-satuan").html('-');
					$(".barang-harga").html('-');
					$(".barang-stok").html('-');
				});
			});
		}
		else {
			$.ajax({
				url: transaksi.item.ajax_link_insert,
				type: 'POST',
				dataType: 'html',
				data: transaksi.item.params,
			})
			.always(function() {
				refresh_keranjang();
				transaksi.item.params.stok_id = -1;
				transaksi.item.params.qty = -1;
				$("#barcode").val('');
				$("#qty").val('');
				$("#barcode").focus();
				$(".barang-foto").attr('src', '<?=site_url('assets/custom/images/img_unavailable.png')?>');
				$(".barang-nama").html('-');
				$(".barang-satuan").html('-');
				$(".barang-harga").html('-');
				$(".barang-stok").html('-');
			});
		}
	}

	$("#qty").keypress(function(e) {
		code = e.which;
		if (code == 13) {
			qty = $(this).val();
			// Apakah qty tidak kosong?
			if (qty != '') {
				// Apakah qty bernilai?
				if (qty > 0) {
					max = $(this).attr('max');
					// Apakah qty tidak melebihi stok tersedia?
					if (qty <= parseInt(max)) {
						transaksi.item.params.qty = qty;
						insert_keranjang();
					}
					else {
						alert('Jumlah beli melebihi batas stok barang');
						$(this).val('');
					}
				}
			}
		}
	});


	function refresh_keranjang() {
		$.ajax({
			url: '<?=site_url('transaksi/keranjang')?>',
			type: 'GET',
			dataType: 'html',
			data: {transaksi_id: transaksi.id},
		})
		.done(function(data) {
			$(".keranjang-load").html(data);
			$.getScript(transaksi.default_js);
			get_total();
			keranjang_events();
		});
	}
	function get_total() {
		$.ajax({
			url: '<?=site_url('transaksi/get_total')?>',
			type: 'GET',
			dataType: 'json',
			data: {transaksi_id: transaksi.id},
		})
		.done(function(data) {
			$(".fill-total").html(data.total_string);
			transaksi.total = data.total_ppn;
		});
	}

	function keranjang_events() {
		$(".content-delete-keranjang").click(function(e) {
			e.preventDefault();
			if (confirm('Anda Yakin.?')) {
				id = $(this).data('id');
				$.ajax({
					url: '<?=site_url('transaksi/write_item_transaksi/delete')?>',
					type: 'POST',
					dataType: 'json',
					data: {id: id},
				})
				.always(function() {
					get_total();
					// update_bayar();
					refresh_keranjang();
				});
			}
		});
	}


	function update_bayar() {
		if (transaksi.id != -1) {
			transaksi.bayar = $("#bayar").val();
			transaksi.kembali = transaksi.bayar - transaksi.total;
			if (transaksi.kembali >= 0) {
				$.ajax({
					url: '<?=site_url('transaksi/update_bayar')?>',
					type: 'POST',
					dataType: 'json',
					data: {
						bayar: transaksi.bayar,
						kembali: transaksi.kembali,
						transaksi_id: transaksi.id
					},
				})
				.always(function() {
					refresh_keranjang();
					$("#cetak").focus();
				});
				return true;
			}
			else {
				alert('Uang pembayaran tidak cukup, (kurang: Rp. ' + transaksi.kembali + ')');
				$("#bayar").val('');
				$("#bayar").focus();
				return false;
			}
		}
		else {
			alert("Tidak ada transaksi, Silahkan tambah keranjang terlebih dahulu");
			return false;
		}
	}
	$("#bayar").keypress(function(e) {
		code = e.which;
		if (code == 13) {
			transaksi.bayar = $(this).val();
			update_bayar();
		}
	});


	function hapus_transaksi() {
		if (transaksi.id != -1) {
			if (confirm("Apakah anda yakin akan menghapus data transaksi yang sudah dilakukan?")) {
				$.ajax({
					url: '<?=site_url('transaksi/write_transaksi_jual/delete')?>',
					type: 'POST',
					dataType: 'json',
					data: {transaksi: transaksi.id},
				})
				.always(function() {
					location.reload();
				});
			}
		}
		else {
			alert('Transaksi masih kosong...')
		}
	}
	function reset_transaksi() {
		if (transaksi.id != -1) {
			if (update_bayar()) {
				if (confirm("Reset Transaksi..?")) {
					location.reload();
				}
			}
		}
		else {
			alert('Transaksi masih kosong...')
		}
	}
	function cetak_transaksi() {
		if (transaksi.id != -1) {
			$.ajax({
				url: '<?=site_url('transaksi/cetak_struk')?>',
				type: 'GET',
				dataType: 'html',
				data: {transaksi_id: transaksi.id},
			})
			.fail(function() {
				alert('Error: Tidak dapat terhubung dengan printer');
			});
		}
		else {
			alert('Transaksi masih kosong...')
		}
	}


	$("#hapus").click(function(e) {
		hapus_transaksi();
	});

	$("#reset").click(function(e) {
		reset_transaksi();
	});

	$("#cetak").click(function(e) {
		if(update_bayar()) {
			cetak_transaksi();
		}
	});

	// HotKey
	var isCtrl = false;
	$(document).keyup(function(e) {
		if(e.which == 17) {
			isCtrl = false;
		}
	});

	$(document).keydown(function(e) {
		if(e.which == 17) {
			isCtrl = true; 
		}

		// CTRL + P
		if(e.which == 80 && isCtrl) { 
			e.preventDefault();
			if(update_bayar()) {
				cetak_transaksi();
			}
		}
		// DEL
		if(e.which == 46) { 
			e.preventDefault();
			hapus_transaksi();
		}
		// F1
		if(e.which == 112) { 
			e.preventDefault();
			reset_transaksi();
		}
		// F5
		if(e.which == 116) { 
			e.preventDefault();
			reset_transaksi();
		}
	});

</script>
<?php $this->view('argon/footer')?>
