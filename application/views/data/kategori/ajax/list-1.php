<?php 
	$no = 0;
	foreach ($data as $kategori) {
		$no++;
?>
<tr>
	<td><?=$no?></td>
	<td><?=$kategori->nama?></td>
	<td>
		<a href="#" class="content-delete-kategori" data-id='<?=$kategori->id?>'>
			<i class="fa fa-times"></i>
		</a>
	</td>
</tr>
<?php
	}
?>