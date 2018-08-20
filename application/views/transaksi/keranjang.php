<table>
	
<?php 
	$total = 0;
	foreach ($data as $keranjang) {
		$stok = $this->StokModel->single($keranjang->stok_id, 'OBJECT');
		$barang = $this->BarangModel->single($stok->barang_id, 'OBJECT');
		$total += $keranjang->total;
?>
<tr>
	<td><?=$keranjang->barang?></td>
	<td><?=$keranjang->qty?></td>
	<td>Rp. <?=number_format($keranjang->harga, 0, '', '.')?>,-</td>
	<td class="text-right">Rp. <?=number_format($keranjang->total, 0, '', '.')?>,-</td>
	<td>
		<a href="#" class="content-delete-keranjang" data-id='<?=$keranjang->id?>'>
			<i class="fa fa-times"></i>
		</a>
	</td>
</tr>
<?php
	}
	$total_ppn = $total * $ppn / 100;
	$total_w_ppn = $total + $total_ppn;
?>
<!-- <tr>
	<td colspan="3" class="text-right">Total</td>
	<td class="text-right">Rp. <=//number_format($total, 0, '', '.')?>,-</td>
</tr> -->
<tr>
	<td colspan="3" class="text-right">PPN (<?=$ppn?>)</td>
	<td class="text-right">Rp. <?=number_format($total_ppn, 0, '', '.')?>,-</td>
</tr>
<tr>
	<td colspan="3" class="text-right">Total + PPN</td>
	<td class="text-right text-lg ">Rp. <?=number_format($total_w_ppn, 0, '', '.')?>,-</td>
</tr>
<tr>
	<td colspan="3" class="text-right">Bayar</td>
	<td class="text-right text-lg ">Rp. <?=number_format($transaksi->bayar, 0, '', '.')?>,-</td>
</tr>
<tr>
	<td colspan="3" class="text-right">Kembali</td>
	<td class="text-right text-lg ">Rp. <?=number_format($transaksi->kembali, 0, '', '.')?>,-</td>
</tr>
</table>