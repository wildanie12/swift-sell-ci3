<?php 
	$no = $offset;
	foreach ($data as $transaksi) {
		$user = $this->UserModel->single($transaksi->kasir, 'OBJECT');
		$no++;
?>
<tr>
	<td><?=$no?></td>
	<td><?=$transaksi->id?></td>
	<td><?=date('d-m-Y', strtotime($transaksi->tanggal))?></td>
	<td><?=$transaksi->waktu?></td>
	<td><?=$user->nama_lengkap?></td>
	<td class="text-right">Rp. <?=number_format($transaksi->total_ppn, 0, '', '.')?>,-</td>
	<td class="text-right">Rp. <?=number_format($transaksi->bayar, 0, '', '.')?>,-</td>
	<td class="text-right">Rp. <?=number_format($transaksi->kembali, 0, '', '.')?>,-</td>
	<td>
		<div class="dropup">
			<a href="#" class="btn btn-icon-only rounded-circle dropdown-toggle" data-toggle='dropdown'>
				<span class="fas fa-ellipsis-v"></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-right">
				<li>
					<a href="#" class="dropdown-item content-view-transaksi" data-id='<?=$transaksi->id?>'>
						<span class="fas fa-eye"></span> 
						Lihat
					</a>
				</li>
				<li>
					<a href="#" class="dropdown-item content-delete-transaksi" data-id='<?=$transaksi->id?>'>
						<span class="fas fa-times"></span> 
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