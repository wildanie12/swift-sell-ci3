<ul class="pagination pagination-sm">
	<?php
		if ($page == 1) {
			echo "<li class='disabled'><a>&laquo;</a></li>";
		}
		else {
			$page_nav = $page - 1;
			echo "<li><a href='javascript:' data-intent='pagination' data-page='".$page_nav."'>&laquo;</a></li>";
		}
		if ($total_page > 20) {
			$overload = TRUE;
		}
		for ($i=1; $i <= $total_page; $i++) {
			if ($page == $i) {
				$active = " class='active'";
			}
			else {
				$active = "";
			}
	?>
	<li <?=$active?>><a data-intent="pagination" href="javascript:" data-page="<?=$i?>"><?=$i?></a></li>
	<?php
		}
		if ($page >= $total_page) {
			echo "<li class='disabled'><a>&raquo;</a></li>";
		}
		else {
			$page_nav = $page + 1;
			echo "<li><a href='javascript:' data-intent='pagination' data-page='".$page_nav."'>&raquo;</a></li>";
		}
	?>
</ul>