jQuery(document).ready(function($) {
	$('.img-wrapper').css('display', 'none');
	function readURL(input) {
	    if (input.files && input.files[0]){
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            $('.gambar-fill').attr('src', e.target.result);
				$('.img-wrapper').css('display', 'block');
	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$(".element-gambar").change(function(){
	    readURL(this);
	});

	$('.img-wrapper-b').css('display', 'none');
	function readURL_B(input) {
	    if (input.files && input.files[0]){
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            $('.gambar_b-fill').attr('src', e.target.result);
				$('.img-wrapper-B').css('display', 'block');
	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$(".element-gambar-b").change(function(){
	    readURL_B(this);
	});
});