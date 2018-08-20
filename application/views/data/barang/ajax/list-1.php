<?php 
	$no = $offset;
	foreach ($data_filtered as $barang) {
		$no++;
		$stok = $this->StokModel->get_stok($barang->id);
		$kategori = $this->KategoriModel->single($barang->kategori_id, 'OBJECT');
		$ingat_habis = $barang->ingat_habis;
		$class = '';
		if ($stok <= $ingat_habis) {
			$class = 'bg-danger text-white';
		}
?>
<tr>
	<td><?=$no?></td>
	<td>
		<div class="media align-items-center">
			<div class="avatar rounded-circle mr-3">
				<img src="<?=site_url($barang->foto)?>">
			</div>
			<div class="media-body">
				<h4 class="mb-0"><?=$barang->nama?></h4>
			</div>
		</div>	
	</td>
	<td class="<?=$class?>"><?=$stok?></td>
	<td><?=((is_object($kategori) ? $kategori->nama : ''))?></td>
	<td><?=$barang->satuan?></td>
	<td class="text-right">
		Rp. <?=number_format($barang->harga, 0, '', '.')?>,-<br/>
		<?php 
			$this->db->where('barang_id', $barang->id);
			$this->db->order_by('range1', 'asc');
			$data_harga = $this->HargaModel->show(0, 0, 'OBJECT');
			foreach ($data_harga as $harga) {
		?>
		<strong>(<?=$harga->nama?>) Jumlah >= <?=$harga->range1?> : Rp. <?=number_format($harga->harga, 0, '', '.')?>,-</strong><br/>
		<?php 
			}
		?>
	</td>
	<td>
		<div class="dropup">
			<a href="#" class="btn btn-action dropdown-toggle btn-icon-only rounded-circle" data-toggle='dropdown'>
				<span class="fas fa-ellipsis-v"></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-right">
				<li>
					<a class="dropdown-item" href="<?=site_url('data/barang/' .$barang->id)?>">
						<span class="mr-2 fas fa-eye"></span>
						Lihat Rincian
					</a>
				</li>
				<li>
					<a class="dropdown-item" href="<?=site_url('data/stok/tambah?barang=' .$barang->id. '&redirect=data/barang')?>">
						<span class="mr-2 fas fa-plus"></span>
						Tambah Stok
					</a>
				</li>
				<li>
					<a class="dropdown-item content-edit-barang" href="#" data-id='<?=$barang->id?>'>
						<span class="mr-2 fas fa-pencil-alt"></span>
						Edit
					</a>
				</li>
				<li>
					<a class="dropdown-item content-delete-barang" href="#" data-id='<?=$barang->id?>'>
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