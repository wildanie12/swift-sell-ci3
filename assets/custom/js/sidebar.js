jQuery(document).ready(function($) {

	let toggleNavbar = false;
	$(".navbar-toggle").click(function(e) {
		toggleNavbar = !toggleNavbar;
		if (toggleNavbar) {
			$('.slider').animate({top: '80%'}, 250, 'swing');
		}
		else {
			$('.slider').animate({top: '50px'}, 250, 'swing');
		}
	});
	
	var sidebar_state = false;
	var width = $(window).width();
	if (width < 751) {
		function sidebar_open() {
			$('.slider span').removeClass('glyphicon-triangle-right');
			$('.slider span').addClass('glyphicon-triangle-left');
			$('.sidebar').animate({marginLeft: '0%'}, 250, 'swing');
			$('.slider').animate({marginLeft: '50%'}, 250, 'swing');
		}
		function sidebar_close() {
			$('.slider span').removeClass('glyphicon-triangle-left');
			$('.slider span').addClass('glyphicon-triangle-right');
			$('.sidebar').animate({marginLeft: '-50%'}, 250, 'swing');
			$('.slider').animate({marginLeft: '0%'}, 250, 'swing');
		}
		sidebar_close();

		$('.slider').click(function(event) {
			sidebar_state = !sidebar_state;
			if (sidebar_state) {
				sidebar_open();
			}
			else {
				sidebar_close();
			}
			event.preventDefault();
		});
	}
	else {
		function sidebar_open() {
			$('.slider span').removeClass('glyphicon-triangle-right');
			$('.slider span').addClass('glyphicon-triangle-left');
			$('.sidebar').animate({marginLeft: '0%'}, 250, 'swing');
			$('.slider').animate({marginLeft: '16.66666667%'}, 250, 'swing');

			$('.area-content').removeClass('col-sm-12');
			$('.area-content').addClass('col-sm-10');
			$('.area-content').addClass('col-sm-offset-2');
			$('.navbar').removeClass('col-sm-12');
			$('.navbar').addClass('col-sm-10');
			$('.navbar').addClass('col-sm-offset-2');
		}
		function sidebar_close() {
			$('.slider span').removeClass('glyphicon-triangle-left');
			$('.slider span').addClass('glyphicon-triangle-right');
			$('.sidebar').animate({marginLeft: '-16.66666667%'}, 250, 'swing');
			$('.slider').animate({marginLeft: '0%'}, 250, 'swing');

			$('.area-content').removeClass('col-sm-10');
			$('.area-content').removeClass('col-sm-offset-2');
			$('.area-content').addClass('col-sm-12');
			$('.navbar').removeClass('col-sm-10');
			$('.navbar').removeClass('col-sm-offset-2');
			$('.navbar').addClass('col-sm-12');
		}
		sidebar_open();

		var sidebar_state = true;
		$('.slider').click(function(event) {
			sidebar_state = !sidebar_state;
			if (sidebar_state) {
				sidebar_open();
			}
			else {
				sidebar_close();
			}
			event.preventDefault();
		});
	}
});
