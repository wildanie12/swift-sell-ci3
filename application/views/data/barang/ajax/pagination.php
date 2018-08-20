<li class="page-item <?=(($page <= 1) ? 'disabled' : '')?>">
	<button type="button" class="page-link page-control-back"><i class="fas fa-angle-left"></i></a>
</li>
<?php 
	// Menetapkan nilai lompatan pada setiap posisi
	// Lompatan ini menjadi jumlah tombol page pada inner display
	$step = 15;

	// Menetapkan lebar pada outer display dari posisi page sekarang
	$width_outer_display = 6;

	

	// Mencari jumlah total posisi outer page
	$total_position = floor($total_page / $step);
	$last_position_modulus = $total_page % $step;
	if ($last_position_modulus > 0) {
		$total_position++;
	}

	// Mencari posisi sekarang (berdasarkan page saat ini)
	// * Penambahan angka 1 disebabkan oleh awalan tombol page 1
	$position = floor($page / $step) + 1;


	// Mencari titik awal perulangan untuk outer display
	// * left_offset_position adalah lebar outer display kekiri 
	// * dari posisi page sekarang, karena kita ingin 
	// * posisi page ditengah maka lebar kita bagi 2
	$left_offset_position = floor($width_outer_display / 2);
	if ($position > $left_offset_position) {

		// * Jika posisi sekarang cukup jauh dengan tepi paling kiri (nomor 1) dan cukup untuk lebar offset kekiri, maka outer display dimulai dari posisi - offset
		$start_position = $position - $left_offset_position;
		$start_outer_display = (($start_position - 1) * $step) + 1;

		// * lebar yang sudah ditentukan, dikurangi offset kekiri 
		// * yang baru saja digunakan, sehingga menjadi sisa lebar 
		// * untuk digunakan kekanan nanti
		$width_outer_display = $width_outer_display - $left_offset_position;
	}
	else {

		// * Jika posisi sekarang mepet dengan tepi paling kiri (nomor 1)
		// * maka tidak ada pilihan lain selain outer display dimulai dari 1, 
		$start_position = 1;
		$start_outer_display = 1;

		// * lebar yang sudah ditentukan dikurangi offset kekiri
		// * yang baru saja digunakan, sehingga menjadi sisa 
		// * lebar untuk digunakan kekanan nanti
		// * Penentuan offset ke kiri menggunakan posisi page sekarang dikurangi 1
		$width_outer_display = $width_outer_display - ($position - 1);
	}

	// Mencari titik akhir perulangan untuk outer layer
	// * Pencarian dilakukan dengan cara mengecek, apakah
	// * lebar dari page sekarang ke tepi kanan akhir cukup atau
	// * tidak, dengan cara (offset kekanan > sisa lebar display)
	// * ket: offset kekanan = total posisi - posisi sekarang
	if (($total_position - $position) > $width_outer_display) {
		$end_position = $position + $width_outer_display;
		$end_outer_display = (($end_position - 1) * $step) + 1; 
		$width_outer_display = 0;
	}
	else {
		$end_position = $total_position;
		$end_outer_display = (($end_position - 1) * $step) + 1;
		$width_outer_display = $width_outer_display - ($total_position - $position);
	}


	$first_outer_display = 1;
	$last_outer_display = (($total_position - 1) * $step) + 1;

	for ($outer_display = $start_outer_display; $outer_display < ($end_outer_display + 1); $outer_display+=$step) :

		$recent_outer_display = $outer_display;
		$next_outer_display = $outer_display + $step;
		if ($recent_outer_display >= $last_outer_display) {
			$next_outer_display = $recent_outer_display + $last_position_modulus;
		}
		if ($page >= $recent_outer_display && $page < $next_outer_display) :
			for ($inner_display = $recent_outer_display; $inner_display < $next_outer_display; $inner_display++) :
				if ($inner_display == $page) :
					$active = 'active';
				else :
					$active = '';
				endif;
?>
<li class="page-item <?=$active?>">
	<button type="button" data-page='<?=$inner_display?>' class="page-link page-control"><strong><?=$inner_display?></strong></button>
</li>
<?php 
			endfor;
		else :
?>
<li class="page-item">
	<button type="button" data-page='<?=$outer_display?>' class="page-link page-control"><?=$outer_display?></button>
</li>
<?php 
		endif;
	endfor; 
?>
<li class="page-item <?=(($page >= $total_page) ? 'disabled' : '')?>">
	<button type="button" class="page-link page-control-next"><i class="fas fa-angle-right"></i></a>
</li>
