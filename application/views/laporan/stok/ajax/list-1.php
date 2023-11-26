<?php 
	foreach ($filter as $item => $value) {
?>
<tr style="border: 0">
	<th style="width: 250px" colspan="3"><?=$item?></th>
	<td colspan="5">: <?=$value?></td>
</tr>
<?php
	}
?>
<tr>
	<th>No</th>
	<th>Barcode</th>
	<th>Nama Barang</th>
	<th>Satuan</th>
	<th>Stok Awal</th>
	<th>Stok Tersisa</th>
	<th>Tanggal Kadaluarsa</th>
	<th>Tanggal Entry</th>
</tr>
<?php 
	$no = 0 + $offset;
	foreach ($data as $stok) {
		$barang = $this->BarangModel->single($stok->barang_id, 'OBJECT');
		if ($barang->status == 'dijual') {
			
		$no++;
?>
<tr>
	<td><?=$no?></td>
	<td><strong><?=$stok->barcode?></strong></td>
	<td><?=$barang->nama?></td>
	<td><?=$barang->satuan?></td>
	<td><?=$stok->stok_awal?></td>
	<td><?=$stok->stok?></td>
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
