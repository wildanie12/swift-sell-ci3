<?php 
	foreach ($data as $kategori) {
?>
<option value='<?=$kategori->id?>'><?=$kategori->nama?></option>
<?php
	}
?>