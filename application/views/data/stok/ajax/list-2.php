<?php 
	$no = $offset;
	foreach ($data_filtered as $stok) {
		$no++;
		$barang = $this->BarangModel->single($stok->barang_id, 'OBJECT');
?>
<tr>
	<td><?=$no?></td>
	<td><?=$barang->nama?></td>
	<td><?=$barang->satuan?></td>
	<td><strong><?=$stok->barcode?></strong></td>
	<td><?=$stok->stok_awal?></td>
	<td><a href="#" class="btn btn-icon-only btn-danger rounded-circle content-delete-stok" data-id="<?=$stok->id?>"><i class="fas fa-times"></i></a></td>
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