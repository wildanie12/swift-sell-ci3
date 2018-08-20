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
	<th>Nama Barang</th>
	<th>Stok Tersedia</th>
	<th>Satuan</th>
	<th>Harga Jual</th>
	<th>Kategori</th>
	<th>Status</th>
</tr>
<?php 
	$no = 0 + $offset;
	foreach ($data as $barang) {
		$kategori = $this->KategoriModel->single($barang->kategori_id, 'OBJECT');
		// Stok
		$this->db->where('barang_id', $barang->id);
		$stok_tersedia = 0;
		$data_stok = $this->StokModel->show(0, 0, 'OBJECT');
		foreach ($data_stok as $stok) {
			$stok_tersedia += $stok->stok;
		}

		$no++;
?>
<tr class="clickable-tr">
	<td><?=$no?></td>
	<td><?=$barang->nama?></td>
	<td><?=$stok_tersedia?></td>
	<td><?=$barang->satuan?></td>
	<td>Rp. <?=number_format($barang->harga, 0, '', '.')?>,-</td>
	<td><?=$kategori->nama?></td>
	<td><?=$barang->status?></td>
</tr>
<?php
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
