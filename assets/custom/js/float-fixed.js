// Area Cart -------------------------------------------
var areaState = false;
function areaOpen() {
	$("#cart").animate({bottom: '0'}, 250, 'swing');
	areaState = true;
}
function areaClose() {
	$("#cart").animate({bottom: '-335px'}, 250, 'swing');
	areaState = false;
}

$("#cart .fixed-button").click(function(e) {
	areaState = !areaState;
	if (areaState) {
		areaOpen();
	}
	else {
		areaClose();
	}
});