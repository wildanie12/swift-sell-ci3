<?php 
	$no = $offset;
	foreach ($data_filtered as $stok) {
		$no++;
		$barang = $this->BarangModel->single($stok->barang_id, 'OBJECT');
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
	<td>
		<div class="dropup">
			<a href="#" class="btn btn-action btn-icon-only dropdown-toggle rounded-circle" data-toggle='dropdown'>
				<span class="fas fa-ellipsis-v"></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-right">
				<li>
					<a href="#" class="dropdown-item content-delete-stok" data-id='<?=$stok->id?>'>
						<span class="fas fa-times"></span> 
						Hapus
					</a>
				</li>
				<li>
					<a href="#" class="dropdown-item content-edit-stok" data-id='<?=$stok->id?>'>
						<span class="fas fa-pencil-alt"></span> 
						Edit
					</a>
				</li>
				<li>
					<a href="#" class="dropdown-item content-cetak-stok" data-id='<?=$stok->id?>' data-barcode='<?=$stok->barcode?>' data-num='<?=$stok->stok?>' data-harga='Rp.<?=number_format($barang->harga, 0, '', '.')?>,-'>
						<span class="fas fa-print"></span> 
						Cetak Barcode
					</a>
				</li>
			</ul>
		</div>
	</td>
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