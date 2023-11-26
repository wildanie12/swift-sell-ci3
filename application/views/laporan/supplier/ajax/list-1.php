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
	<th>Nama Supplier</th>
	<th>Alamat</th>
	<th>Jumlah Transaksi dilakukan</th>
</tr>
<?php 
	$no = 0 + $offset;
	foreach ($data as $supplier) {
		$no++;
		$this->db->where('supplier_id', $supplier->id);

		$tr_count = 0;
		$data_tr = $this->TransaksiBeliModel->show(0, 0, 'OBJECT');
		foreach ($data_tr as $tr) {
			$tr_count++;
		}
?>
<tr>
	<td><?=$no?></td>
	<td><?=$supplier->nama?></td>
	<td><?=$supplier->alamat?></td>
	<td><?=$tr_count?> Kali Transaksi</td>
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
