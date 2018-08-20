<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<div class="header bg-gradient-danger d-print-none pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-transaksi.jpg')?>') 0 -150px/100% no-repeat !important; -webkit-filter: brightness(80%) contrast(140%); filter: brightness(80%) contrast(140%);">
    <div class="container-fluid">
        <div class="header-body">
        </div>
    </div>
</div>
<h4 class="fill-barcode-judul d-none d-print-block text-center"></h4>
<div class="barcodes align-items-center d-none d-print-block">
</div>
<div class="container-fluid mt--7 d-print-none">
	<div class="row data-pembelian">
		<div class="col-sm-12">
			<div class="card shadow bg-warning">
				<div class="card-header bg-transparent">
					<h4 class="card-title text-white mb-0">Data Pembelian</h4>
					<span class="text-xs text-white">Isi form transaksi (kotak kuning) ini terlebih dahulu</span>
				</div>
				<div class="card-body">
					<form id="form-pembelian">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label class="form-control-label text-white" for="pembelian-tanggal_faktur">Tanggal Faktur</label>
									<input type="date" name="pembelian-tanggal_faktur" id="pembelian-tanggal_faktur" class="form-control form-control-alternative" required="required">
								</div>	
							</div>
							<div class="col-sm-9">
								<div class="form-group">
									<label class="form-control-label text-white" for="pembelian-no_faktur">Nomor Faktur Pembelian</label>
									<input type="text" name="pembelian-no_faktur" id="pembelian-no_faktur" class="form-control form-control-alternative" placeholder="Masukkan Nomor Faktur Disini..." required="required">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-control-label text-white" for="pembelian-supplier">Supplier</label>
											<select id="pembelian-supplier" name="pembelian-supplier_id" class="form-control form-control-alternative"></select>
											<span class="help-block text-white">Pilih supplier atau <a href="#" class="text-white" data-toggle='modal' data-target='#modal-supplier'><u>Tambah Supplier</u>.</a></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-control-label text-white" for="pembelian-harga_beli">Harga Beli Total</label>
											<div class="input-group input-group-alternative">
												<div class="input-group-prepend">
													<span class="input-group-text">Rp. </span>
												</div>
												<input type="number" id="pembelian-harga_beli" name="pembelian-harga_beli" class="form-control form-control-alternative" placeholder="Harga Total Pembelian...">
											</div>
											<span class="help-block text-white">Isi terlebih dahulu sebelum mengentry stok dibawah</span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-control-label text-white" for="pembelian-jenis_pembayaran">Jenis Pembayaran</label>
											<select id="pembelian-jenis_pembayaran" name="pembelian-jenis_pembayaran" class="form-control form-control-alternative" required="required">
												<option value="kontan">Kontan</option>
												<option value="kredit">Kredit</option>
												<option value="konsinyasi">Konsinyasi</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row pembelian-jatuh_tempo-wrapper" style="display: none">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-control-label text-white" for="pembelian-jatuh_tempo">Jatuh Tempo</label>
											<input type="date" name="pembelian-jatuh_tempo" id="pembelian-jatuh_tempo" class="form-control form-control-alternative">
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 table-responsive">
								<table class="table table-light">
									<thead>
										<tr>
											<th>No</th>
											<th>Barang</th>
											<th>Pcs</th>
											<th>Barcode</th>
											<th>Qty</th>
										</tr>
									</thead>
									<tbody class="load-list_item"></tbody>
								</table>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col-sm-12">
			<div class="card shadow">
				<div class="card-header">
					<h4 class="card-title mb-0">Data stok barang</h4>
				</div>
				<div class="card-body bg-secondary">
					<form id="form-tambah_stok">
						<div class="row">
							<div class="col-sm-4">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="form-control-label" for="pembelian-barang_id">Barang</label>
											<select class="form-control form-control-alternative" id="stok-barang_id" name="stok-barang_id">
												<option value="---">---</option>
												<?php 
													foreach ($data_barang as $barang) {
												?>
												<option value="<?=$barang->id?>"><?=$barang->nama?> | <?=$barang->satuan?></option>
												<?php 
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Satuan</label>
											<input type="hidden" name="stok-transaksi_id" class="form-control form-control-alternative">
											<input type="text" id="stok-barang_satuan" name="stok-barang_satuan" class="form-control form-control-alternative" value="" readonly="readonly" placeholder="pcs/pack/dus">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Harga</label>
											<div class="input-group input-group-alternative">
												<div class="input-group-prepend">
													<span class="input-group-text">Rp. </span>
												</div>
												<input type="number" id="stok-barang_harga" name="stok-barang_harga" class="form-control form-control-alternative" value="" readonly="readonly" placeholder="Harga Jual Barang">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<img id="stok-barang_gambar" class="img-thumbnail" src="<?=site_url('assets/custom/images/img_unavailable.png')?>">
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-8">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label>Kode / Barcode</label>
											<div class="row">
												<div class="col-sm-12">
													<textarea name="stok-barcode" readonly="readonly" rows="4" class="form-control form-control-alternative"></textarea>
												</div> 
											</div>
											<div class="row">
												<div class="col-sm-6">
													<input type="text" name="kode" id="kode" class="form-control form-control-alternative" placeholder="Masukkan kode kemudian tekan enter...">
												</div>
												<div class="col-sm-6">
													<input type="number" name="stok" id="stok" class="form-control form-control-alternative" placeholder="Masukkan Jumlah Stok kemudian tekan enter...">
												</div>
											</div>
											<span class="help-block">Masukkan kode barcode, atau <a href="#" data-toggle='modal' data-target='#modal-buat_barcode'>Buat Barcode.!</a></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label>Tanggal Kadaluarsa</label>
											<input type="date" name="stok-tgl_kadaluarsa" class="form-control form-control-alternative">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label>Ingatkan kadaluarsa sebelum</label>
											<div class="input-group input-group-alternative">
												<input type="number" name="stok-ingat_kadaluarsa" class="form-control form-control-alternative" value="<?=$default_kadaluarsa?>">
												<div class="input-group-prepend">
													<span class="input-group-text">Hari</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm">
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
<div class="modal fade" id="modal-supplier">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title mb-0">Data Supplier</h4>
				<button class="close" data-dismiss='modal' type="button">
					<i class="fa fa-times"></i>
				</button>
			</div>
			<div class="modal-body bg-secondary">
				<div class="row">
					<div class="col-sm-6 table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
									<th>Alamat</th>
									<th></th>
								</tr>
							</thead>
							<tbody class="load-supplier">
							</tbody>
						</table>
					</div>
					<div class="col-sm-6">
						<form id="form-tambah_supplier">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="form-control-label" for="tambah_supplier-nama">Nama</label>
										<input type="text" name="supplier_nama" id="tambah_supplier-nama" class="form-control form-control-alternative" placeholder="Nama Supplier...">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="form-control-label" for="tambah_supplier-alamat">Alamat</label>
										<textarea id="tambah_supplier-alamat" name="supplier_alamat" rows="3" class="form-control form-control-alternative"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<input type="submit" name="submit" value="submit" class="btn btn-primary btn-block">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<div class="modal fade d-print-none" id="modal-buat_barcode">
	<div class="modal-dialog modal-xl">
		<div class="modal-content bg-secondary">
			<div class="modal-header">
				<h4 class="modal-title mb-0">Cetak Barcode</h4>
				<button class="close" type="button" data-dismiss='modal'>&times;</button>
			</div>
			<div class="modal-body pt-0">
				<div class="row d-print-none">
					<div class="col-sm-6 d-print-none">
						<form class="form-horizontal" id="barcode-form">
							<div class="form-group mb-0">
								<label class="form-control-label col-xs-4">Nama Barang</label>
								<div class="col-xs-8">
									<input type="text" name="nama" class="form-control form-control-alternative" placeholder="Nama" readonly="true" value="Nama Barang">
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
									<input type="number" min="0" value="1" id="duplikat" class="form-control form-control-alternative">
								</div>
							</div>
							<div class="form-group mb-0">
								<label class="form-control-label col-xs-4">Harga Jual</label>
								<div class="col-xs-8">
									<div class="input-group input-group-alternative">
										<div class="input-group-prepend">
											<span class="input-group-text">Rp. </span>
										</div>
										<input type="number" name="harga" class="form-control form-control-alternative" readonly='readonly'>
									</div>
								</div>
							</div>
							<div class="form-group mb-2">
								<label class="form-control-label col-xs-4">Satuan</label>
								<div class="col-xs-8">
									<input type="text" name="satuan" class="form-control form-control-alternative" value="" readonly="readonly">
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
									<input type="range" min="0" max="100" value="11" id="margin-horizontal" class="form-control form-control-alternative">
								</div>
							</div>
							<div class="form-group mb-0">
								<label class="form-control-label col-xs-5">Margin y (Each)</label>
								<div class="col-xs-7">
									<input type="range" min="0" max="100" value="5" id="margin-vertical" class="form-control form-control-alternative">
								</div>
							</div>
							<div class="form-group mb-0">
								<label class="form-control-label col-xs-5">Padding (Each)</label>
								<div class="col-xs-7">
									<input type="range" min="0" max="100" value="0" id="padding" class="form-control form-control-alternative">
								</div>
							</div>
							<div class="form-group mb-0">
								<label class="form-control-label col-xs-5">Size (Each)</label>
								<div class="col-xs-7">
									<input type="range" min="1" max="2" step="0.05" value="1.2" id="size" class="form-control form-control-alternative">
								</div>
							</div>
							<div class="form-group mb-2">
								<label class="form-control-label col-xs-5">Border / Outline</label>
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
										<span class="input-group-text">px</span>
									</div>
								</div>
							</div>
							<div class="form-group mb-2">
								<button class="btn btn-danger btn-block" data-dismiss='modal'>
									<i class="fa fa-times"></i> 
									Close
								</button>
							</div>
						</form>
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
	$("#form-pembelian :input:not(input[name='pembelian-no_faktur'])").prop('disabled', true);
	$("#form-tambah_stok :input:not(input[name='pembelian-no_faktur'])").prop('disabled', true);
	// ---------------------------------------------
	// ** Data Transaksi
	// ---------------------------------------------
	var transaksi =  {
		id: -1,
		faktur: -1,
		mode: '',
		single: {
			ajax_link: '<?=site_url('transaksi/read_transaksi_beli')?>'
		},
		insert: {
			ajax_link: '<?=site_url('transaksi/write_transaksi_beli/insert')?>'
		},
		list_item: {
			ajax_link: '<?=site_url('data/list_stok/list-2')?>',
			default_js: '<?=site_url('assets/custom/js/default.js')?>'
		}
	}
	function refresh_item_transaksi() {
		$.ajax({
			url: transaksi.list_item.ajax_link,
			type: 'GET',
			dataType: 'html',
			data: {
				transaksi: transaksi.id,
				page: 1,
				limit: 999999
			},
		})
		.done(function(data) {
			$(".load-list_item").html(data);
			$.getScript(transaksi.list_item.default_js);
			item_transaksi_events();
		});
		
	}
	function item_transaksi_events() {
		$(".content-delete-stok").click(function(e) {
			id = $(this).val();
			if (confirm('Anda yakin.?')) {
				$.ajax({
					url: '<?=site_url('data/write_stok/delete')?>',
					type: 'POST',
					dataType: 'html',
					data: {id: id},
				})
				.always(function() {
					refresh_item_transaksi();
				});
			}
			e.preventDefault();
		});
	}
	$("#pembelian-no_faktur").focus();
	$("#pembelian-no_faktur").change(function(e) {
		no_faktur = $(this).val();
		transaksi.faktur = no_faktur;
		$.ajax({
			url: transaksi.single.ajax_link,
			type: 'GET',
			dataType: 'json',
			data: {faktur: transaksi.faktur},
		})
		.done(function(data) {
			$("#form-pembelian :input:not(input[name='pembelian-no_faktur'])").prop('disabled', false);
			$("#form-tambah_stok :input:not(input[name='pembelian-no_faktur'])").prop('disabled', false);
			$("#pembelian-barang_id").focus();
			if (data.count > 0) {
				transaksi.id = data.data.id;
				refresh_item_transaksi();
				
				$("input[name='stok-transaksi_id']").val(data.data.id);
				$("#pembelian-tanggal_faktur").val(data.data.tanggal_faktur);
				$("#pembelian-supplier_id").val(data.data.supplier_id);
				$("#pembelian-harga_beli").val(data.data.harga_beli);
				$("#pembelian-jenis_pembayaran").val(data.data.jenis_pembayaran);
				if (data.data.jenis_pembayaran == 'kredit') {
					$(".pembelian-jatuh_tempo-wrapper").show('fast');
					$(".pembelian-jatuh_tempo-wrapper").val(data.data.jatuh_tempo);
				}
				else {
					$(".pembelian-jatuh_tempo-wrapper").hide('fast');
				}
			}
			else {
				transaksi.id = -1;
				$(".load-list_item").html("<tr><td colspan='4' class='text-center'><span style='font-style: italic; color: darkgrey'>Transaksi belum dibuat</span></td></tr>");
				$("#pembelian-tanggal_faktur").val("<?=date('Y-m-d')?>");
			}
		});
	});

	$("#pembelian-jenis_pembayaran").change(function(e) {
		value = $(this).val();
		if (value == 'kredit') {
			$(".pembelian-jatuh_tempo-wrapper").show('fast');
		}
		else {
			$(".pembelian-jatuh_tempo-wrapper").hide('fast');
		}
	});


	// ----------------------------------------------------
	// ** Event + Ajax Script  : 	Data Stok + Submit
	// ----------------------------------------------------
	$("#stok-barang_id").change(function(e) {
		id = $(this).val();
		if (id != '---') {
			$.ajax({
				url: '<?=site_url('data/read_barang')?>',
				type: 'GET',
				dataType: 'json',
				data: {id: id},
			})
			.done(function(data) {
				$("#stok-barang_gambar").attr('src', data.foto_formatted);
				$("#stok-barang_satuan").val(data.satuan);
				$("#stok-barang_harga").val(data.harga);
				$("#barcode-form input[name='nama']").val(data.nama);
				$("#barcode-form input[name='harga']").val(data.harga);
				$("#barcode-form input[name='satuan']").val(data.satuan);
			});
		}
	});
	$("#form-tambah_stok").submit(function(e) {
		e.preventDefault();
		if (transaksi.id == -1) {
			$.ajax({
				url: transaksi.insert.ajax_link,
				type: 'POST',
				dataType: 'json',
				data: new FormData($("#form-pembelian")[0]),
				processData:false,
				contentType:false,
				cache:false,
				async:false
			})
			.done(function(data) {
				transaksi.id = data.transaksi_id;
				$("input[name='stok-transaksi_id']").val(transaksi.id);
				$.ajax({
					url: '<?=site_url('data/write_stok/insert')?>',
					type: 'POST',
					dataType: 'html',
					data: new FormData($("#form-tambah_stok")[0]),
					processData:false,
					contentType:false,
					cache:false,
					async:false,
				})
				.always(function(data) {
					refresh_item_transaksi();
					$("html, body").animate({scrollTop: $(".data-pembelian").offset().top}, 250);
					$("#form-tambah_stok")[0].reset();
					$("textarea[name='stok-barcode']").html('');
					$(".barcodes").html('');
				});
			});
		}
		else {
			$.ajax({
				url: '<?=site_url('data/write_stok/insert')?>',
				type: 'POST',
				dataType: 'html',
				data: new FormData($("#form-tambah_stok")[0]),
				processData:false,
				contentType:false,
				cache:false,
				async:false,
			})
			.always(function() {
				refresh_item_transaksi();
				$("#form-tambah_stok")[0].reset();
				$("html, body").animate({scrollTop: $(".data-pembelian").offset().top}, 250);
				$("textarea[name='stok-barcode']").html('');
				$(".barcodes").html('');
			});
		}
		
	});



	// --------------------------------------------
	// ** Kode Generator
	// --------------------------------------------

	$("#kode").keypress(function(e) {
		key = e.which;
		if (key == 13) {
			e.preventDefault();
			value = $(this).val();
			if (value != '') {
				$(this).val('');
				$("textarea[name='stok-barcode']").append(value + ':');
				$("#stok").focus();
			}
			else {
				alert('Masukkan Kode terlebih dahulu');
			}
		}
	});
	$("#kode").change(function(e) {
		e.preventDefault();
		value = $(this).val();
		if (value != '') {
			$(this).val('');
			$("textarea[name='stok-barcode']").append(value + ':');
			$("#stok").focus();
		}
		else {
			alert('Masukkan Kode terlebih dahulu');
		}
	});
	$("#stok").keypress(function(e) {
		key = e.which;
		if (key == 13) {
			e.preventDefault();
			value = $(this).val();
			if (value != '') {
				$(this).val('');
				$("textarea[name='stok-barcode']").append(value + '|');
				$("#kode").focus();
			}
			else {
				alert('Masukkan jumlah terlebih dahulu');
			}
		}
	});
	$("#stok").change(function(e) {
		e.preventDefault();
		value = $(this).val();
		if (value != '') {
			$(this).val('');
			$("textarea[name='stok-barcode']").append(value + '|');
			$("#kode").focus();
		}
		else {
			alert('Masukkan jumlah terlebih dahulu');
		}
	});

	// ------------------------------------------
	// ** Barcode Generator
	// ------------------------------------------

	$("#modal-buat_barcode").on('shown.bs.modal', function(e) {
		$("#duplikat").focus();
		$("#duplikat").select();
	});
	function get_new_id() {
		kode = 0;
	}

	var list = [];
	$("#barcode-form").on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: '<?=site_url('data/getNewID')?>',
			type: 'GET',
			dataType: 'json',
		})
		.done(function(data) {
            $(".fill-barcode-judul").html("Barcode barang " + $("#barcode-form input[name='nama']").val());
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

			form_str = ''
			for (var i = 0; i < list.length; i++) {
				form_str = form_str + list[i] + ':' +duplikat+ '|';
			}

			list = [];
			$("textarea[name='stok-barcode']").html('');
			$("textarea[name='stok-barcode']").html(form_str);

			$("#print-button-wrapper").show();

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


	// ---------------------------------------------
	// ** Data Supplier
	// ---------------------------------------------
	var supplier = {
		default_js: '<?=site_url('assets/custom/js/default.js')?>',
		list: {
			select: {
				ajax_link: '<?=site_url('transaksi/list_supplier/select-1')?>',
				params: {
					limit: 0,
					page: 1
				}
			},
			table: {
				ajax_link: '<?=site_url('transaksi/list_supplier/list-1')?>',
				params: {
					limit: 0,
					page: 1
				}
			}
		},
		insert: {
			ajax_link: '<?=site_url('transaksi/write_supplier/insert')?>',
		},
		delete: {
			ajax_link: '<?=site_url('transaksi/write_supplier/delete')?>',
		}
	}
	function refresh_supplier() {
		$.ajax({
			url: supplier.list.select.ajax_link,
			type: 'GET',
			dataType: 'html',
			data: supplier.list.select.params,
		})
		.done(function(data) {
			$("#pembelian-supplier").html(data);
		});

		$.ajax({
			url: supplier.list.table.ajax_link,
			type: 'GET',
			dataType: 'html',
			data: supplier.list.table.params,
		})
		.done(function(data) {
			$(".load-supplier").html(data);
			$.getScript(supplier.default_js);
			supplier_events();
		});
	}
	refresh_supplier();

	function supplier_events() {
		$(".content-delete-supplier").click(function(e) {
			e.preventDefault();
			if (confirm('Anda Yakin.?')) {
				id = $(this).data('id');
				$.ajax({
					url: supplier.delete.ajax_link,
					type: 'POST',
					dataType: 'html',
					data: {id: id},
				})
				.always(function() {
					refresh_supplier();
				});
			}
		});
	}

	$("#form-tambah_supplier").submit(function(e) {
		e.preventDefault();
		$.ajax({
			url: supplier.insert.ajax_link,
			type: 'POST',
			dataType: 'html',
			data: new FormData(this),
			processData:false,
			contentType:false,
			cache:false,
			async:false,
		})
		.always(function() {
			refresh_supplier();
			$("#modal-supplier").modal('hide');
			$("#form-tambah_supplier")[0].reset();
		});
		
	});
</script>
<?php $this->view('argon/footer')?>
