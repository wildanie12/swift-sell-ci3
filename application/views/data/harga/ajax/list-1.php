<?php 
	$no = $offset;
	foreach ($data_filtered as $harga) {
		$no++;
		$barang = $this->BarangModel->single($harga->barang_id, 'OBJECT');
?>
<tr>
	<td><?=$no?></td>
	<td><?=((is_object($barang))? $barang->nama : 'Relasi barang tidak ditemukan')?></td>
	<td><?=$harga->nama?></td>
	<td><?=$harga->range1?></td>
	<td class="text-right">Rp <?=((is_object($barang))? number_format($barang->harga, 0, '', '.') : 'Referensi barang tidak ditemukan')?></td>
	<td class="text-right font-weight-bold text-md">Rp <?=number_format($harga->harga, 0, '', '.')?></td>
	<td>
		<div class="dropup">
			<a href="#" class="btn btn-action dropdown-toggle btn-icon-only rounded-circle" data-toggle='dropdown'>
				<span class="fas fa-ellipsis-v"></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-right">
				<li>
					<a class="dropdown-item content-edit" href="#" data-id='<?=$harga->id?>'>
						<span class="mr-2 fas fa-pencil-alt"></span>
						Edit
					</a>
				</li>
				<li>
					<a class="dropdown-item content-delete" href="#" data-id='<?=$harga->id?>'>
						<span class="mr-2 fas fa-times"></span>
						Hapus
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