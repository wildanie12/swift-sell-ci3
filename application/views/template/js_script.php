<script src="<?=base_url()?>assets/custom/js/jquery.min.js"></script>
<script src="<?=base_url()?>assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/custom/js/default.js"></script>

<script src="<?=base_url()?>assets/light-bootstrap-dashboard/js/bootstrap-notify.js"></script>

<script src="<?=base_url()?>assets/light-bootstrap-dashboard/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<?php
		foreach ($ui_js as $js) {
	?>
	<script src="<?=base_url()?>assets/<?=$js?>"></script>
	<?php
		}
	?>
