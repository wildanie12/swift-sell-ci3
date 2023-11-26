<?php
	$transaksi = $this->TransaksiBeliModel->single_by('id', $transaksi_id, 'OBJECT');
	$supplier = $this->SupplierModel->single(((is_object($transaksi))? $transaksi->supplier_id: 'Referensi transaksi tidak ditemukan'), 'OBJECT');
?>
<tr style="border: 0">
	<th style="width: 250px" colspan="2">Tanggal laporan</th>
	<td colspan="1">: <?=$filter['Tanggal Laporan']?></td>
	<th style="width: 250px" colspan="2">Harga beli</th>
	<td colspan="2" class="text-md font-weight-bold">: Rp. <?=number_format($transaksi->harga_beli, 0, '', '.')?>,-</td>
</tr>
<tr style="border: 0">
	<th style="width: 250px" colspan="2">No Faktur</th>
	<td>: <?=((is_object($transaksi))? $transaksi->no_faktur : 'Referensi transaksi tidak ditemukan')?></td>
	<th style="width: 250px" colspan="2">Supplier</th>
	<td colspan="2">: <?=((is_object($transaksi))? ((is_object($supplier)) ? $supplier->nama : 'Referensi supplier tidak ditemukan') : 'Referensi transaksi tidak ditemukan')?></td>
</tr>
<tr style="border: 0">
	<th style="width: 250px" colspan="2">Tanggal Faktur</th>
	<td>: <?=((is_object($transaksi))? date('d-m-Y', strtotime($transaksi->tanggal_faktur)) : 'Referensi transaksi tidak ditemukan')?></td>
	<th style="width: 250px" colspan="2">Jenis <br/>pembayaran</th>
	<td colspan="2">: <?=((is_object($transaksi))? $transaksi->jenis_pembayaran : 'Referensi transaksi tidak ditemukan')?></td>
</tr>
<?php 
	if (is_object($transaksi)) {
		if ($transaksi->jenis_pembayaran == 'kredit') {
?>
<tr>
	<th style="width: 250px" colspan="2">Jatuh Tempo</th>
	<td>: <?=date('d-m-Y', strtotime($transaksi->jatuh_tempo))?></td>
	<th style="width: 250px" colspan="2">Status Kredit</th>
	<td>: <?=(($transaksi->kredit_selesai == 1) ? 'Lunas' : 'Belum lunas')?></td>
</tr>
<?php 
		}
		else if ($transaksi->jenis_pembayaran == 'konsinyasi') {
?>
<tr>
	<th style="width: 250px" colspan="2">Status konsinyasi</th>
	<td>: <?=(($transaksi->kredit_selesai == 1) ? 'Selesai' : 'Belum selesai')?></td>
</tr>
<?php
		}
	}
?>
<tr>
	<td colspan="10" style="height: 30px"></td>
</tr>
<tr>
	<th>No</th>
	<th>Barang</th>
	<th>Barcode</th>
	<th>Stok Awal</th>
	<th>Stok Tersisa</th>
	<th>Stok Terjual</th>
	<th>Tanggal Kadaluarsa</th>
	<th>Tanggal Masuk</th>
</tr>
<?php 
	$no = 0 + $offset;
	foreach ($data as $stok) {
		if ($stok->stok > 0) {
			$barang = $this->BarangModel->single($stok->barang_id, 'OBJECT');
			$no++;
?>
<tr>
	<td><?=$no?></td>
	<td><strong><?=$barang->nama?> (<?=$barang->satuan?>)</strong></td>
	<td><?=$stok->barcode?></td>
	<td><?=$stok->stok_awal?></td>
	<td><?=$stok->stok?></td>
	<td><?=$stok->stok_awal - $stok->stok?></td>
	<td><?=($stok->tgl_kadaluarsa != '0000-00-00')?date('d-m-Y', strtotime($stok->tgl_kadaluarsa)): '<i>Tidak ada</i>'?></td>
	<td><?=date('d F Y', strtotime($stok->tanggal_masuk))?></td>
</tr>
<?php
		}
	}
	if ($no <= 0) {
?>
<tr>
	<td colspan="8" class="text-center">
		<span style="font-style: italic; color: darkgrey">Tidak ada data</span>
	</td>
</tr>
<?php
	}
?>
