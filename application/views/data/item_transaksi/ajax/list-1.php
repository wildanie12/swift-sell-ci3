<?php 
	$total = 0;
	foreach ($data as $item) {
		$total += $item->total;
?>
<tr>
	<td><?=$item->barang?></td>
	<td><?=$item->qty?></td>
	<td><?=$item->harga?></td>
	<td class="text-right">Rp. <?=number_format($item->total, 0, '', '.')?>,-</td>
</tr>
<?php
	}
?>
<tr>
	<td colspan="3" class="text-right">Total</td>
	<td class="text-right"><strong>Rp. <?=number_format($total, 0, '', '.')?>,-</strong></td>
</tr>
<tr>
	<td colspan="3" class="text-right">PPN</td>
	<td class="text-right"><strong>Rp. <?=number_format($transaksi->ppn, 0, '', '.')?>,-</strong></td>
</tr>
<tr>
	<td colspan="3" class="text-right">Total + PPN</td>
	<td class="text-right"><strong>Rp. <?=number_format($transaksi->total_ppn, 0, '', '.')?>,-</strong></td>
</tr>
<tr>
	<td colspan="3" class="text-right">Bayar</td>
	<td class="text-right"><strong>Rp. <?=number_format($transaksi->bayar, 0, '', '.')?>,-</strong></td>
</tr>
<tr>
	<td colspan="3" class="text-right">Kembali</td>
	<td class="text-right"><strong>Rp. <?=number_format($transaksi->kembali, 0, '', '.')?>,-</strong></td>
</tr>