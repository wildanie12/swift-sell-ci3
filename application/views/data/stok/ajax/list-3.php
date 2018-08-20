<?php 
	$no = $offset;
	foreach ($data as $stok) {
		$no++;
		$barang = $this->BarangModel->single($stok->barang_id, 'OBJECT');
?>
<tr>
	<td><?=$no?></td>
	<td><?=$barang->nama?></td>
	<td><?=$barang->satuan?></td>
	<td>Rp. <?=number_format($barang->harga, 0, '', '.')?>,-</td>
	<td><strong><?=$stok->barcode?></strong></td>
	<td><?=$stok->stok_awal?></td>
	<td><?=($stok->stok_awal - $stok->stok)?></td>
	<td><?=$stok->stok?></td>
</tr>
<?php 	
	} 
	if ($no <= 0) {
?>
<tr>
	<td colspan="7" class="text-center">
		<span style="font-style: italic; color: darkgrey">Tidak ada data</span>
	</td>
</tr>
<?php
	}
?>