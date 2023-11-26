<?php 
	$no = $offset;
	foreach ($data_filtered as $user) {
		$no++;
?>
<tr>
	<td><?=$no?></td>
	<td><?=$user->nama_lengkap?></td>
	<td><?=$user->username?></td>
	<td><?=$user->level?></td>
	<td><?=$user->alamat?></td>
	<td><?=$user->nama_printer?></td>
	<td><?=$user->alamat_printer?></td>
	<td>
		<div class="dropup">
			<a href="#" class="btn btn-action btn-icon-only rounded-circle dropdown-toggle" data-toggle='dropdown'>
				<span class="fas fa-ellipsis-v"></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-right">
				<li>
					<a href="#" class="dropdown-item content-edit-user" data-id='<?=$user->username?>'>
						<span class="fa fa-pencil-alt"></span> 
						Edit
					</a>
				</li>
				<li>
					<a href="#" class="dropdown-item content-delete-user" data-id='<?=$user->username?>'>
						<span class="fa fa-times"></span> 
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