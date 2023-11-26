var bulan_arr = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
var hari_arr = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

setInterval(function() {
	now = new Date();
	date = zero_fix(now.getDate());
	month = zero_fix(now.getMonth());
	year = now.getFullYear();
	sec = zero_fix(now.getSeconds());
	min = zero_fix(now.getMinutes());
	hour = zero_fix(now.getHours());
	ampm = get_ampm(hour);
	string_time = hour + ':' + min + ':' + sec + ' ' + ampm;
	string_date = date + '-' + month + '-' + year;
	$(".time-load").html(string_time);
	$(".date-load").html(string_date);
}, 1000);
function zero_fix(num) {
	if (num < 10) {
		num = '0' + num;
	}
	return num;
}
function get_ampm(hour) {
	if (hour <= 12) {
		return 'AM';
	}
	else {
		return 'PM';
	}
}