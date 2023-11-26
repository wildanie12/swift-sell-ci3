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
	<th class="text-center">TRID</th>
	<th>Kasir</th>
	<th>Waktu/Tanggal</th>
	<th class="text-right">Bayar</th>
	<th class="text-right">Kembali</th>
	<th class="text-right">PPN</th>
	<th class="text-right">Total belanja</th>
</tr>
<?php 
	$no = 0 + $offset;
	$total = 0;
	$total_w_ppn = 0;
	foreach ($data_filtered as $transaksi) {
		$no++;
		$total_w_ppn += $transaksi->total_ppn;

		$this->db->where('transaksi_id', $transaksi->id);
		$data_item = $this->ItemTransaksiModel->show(0, 0, 'OBJECT');
		$total += $transaksi->total;
?>
<tr class="clickable-tr">
	<td><?=$no?></td>
	<td class="text-center"><strong><?=$transaksi->id?></strong></td>
	<td><?=$transaksi->kasir?></td>
	<td><?=$transaksi->waktu?>, <?=date('d-m-Y', strtotime($transaksi->tanggal))?></td>
	<td class="text-right">Rp. <?=number_format($transaksi->bayar, 0, '', '.')?></td>
	<td class="text-right">Rp. <?=number_format($transaksi->kembali, 0, '', '.')?></td>
	<td class="text-right">Rp. <?=number_format($transaksi->ppn, 0, '', '.')?> (<?=$transaksi->persentase_ppn?>%)</td>
	<td class="text-right font-weight-bold">Rp. <?=number_format($transaksi->total_ppn, 0, '', '.')?></td>
</tr>
<?php
	}
	if ($no <= 0) {
?>
<tr>
	<td colspan="9" class="text-center">
		<span style="font-style: italic; color: darkgrey">Tidak ada data</span>
	</td>
</tr>
<?php
	}
	else {
?>
<tr>
	<td colspan="7" class="text-right"><strong>Total</strong></td>
	<td class="text-right font-weight-bold">: Rp. <?=number_format($total, 0, '', '.')?></td>
</tr>
<tr>
	<td colspan="7" class="text-right"><strong>Total + PPN</strong></td>
	<td class="text-right font-weight-bold">: Rp. <?=number_format($total_w_ppn, 0, '', '.')?></td>
</tr>
<?php
	}
?>
