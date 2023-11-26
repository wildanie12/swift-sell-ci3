<?php 
	$no = 0;
	foreach ($data as $supplier) {
		$no++;
?>
<tr>
	<td><?=$no?></td>
	<td><?=$supplier->nama?></td>
	<td><?=$supplier->alamat?></td>
	<td>
		<a href="#" class="content-delete-supplier" data-id='<?=$supplier->id?>'>
			<i class="fa fa-times"></i>
		</a>
	</td>
</tr>
<?php
	}
	if ($no <= 0) {
?>
<tr>
	<td colspan="4" class="text-center">
		<span style="font-style: italic; color: darkgrey">Tidak ada data</span>
	</td>
</tr>
<?php
	}
?>