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
	<th>Username</th>
	<th>Nama Lengkap</th>
	<th>Level</th>
	<th>Status Pemblokiran</th>
	<th>Alamat</th>
	<th>IP Printer</th>
</tr>
<?php 
	$no = 0 + $offset;
	foreach ($data as $user) {
		$no++;
?>
<tr>
	<td><?=$no?></td>
	<td><?=$user->username?></td>
	<td><?=$user->nama_lengkap?></td>
	<td><?=$user->level?></td>
	<td><?=(($user->blokir == 'Y')? 'Diblokir' : 'Tidak diblokir')?></td>
	<td><?=$user->alamat?></td>
	<td>smb://<?=$user->alamat_printer?>/<?=$user->nama_printer?></td>
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
