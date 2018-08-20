<?php 
	foreach ($data as $supplier) {
?>
<option value="<?=$supplier->id?>"><?=$supplier->nama?></option>
<?php 
	}
?>