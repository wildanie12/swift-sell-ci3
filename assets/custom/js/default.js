$(function () {
	$('[data-toggle="tooltip"]').tooltip({})
	$('[data-toggle="tooltip"]').click(function(event) {
		$('[data-toggle="tooltip"]').tooltip('hide');
	});
});


// -------------------------------------------------------------------------------------
// * Toggle sidebar
// -------------------------------------------------------------------------------------
function hide_sidebar() {
	windowWidth = $(window).width();
	if (windowWidth >= 768) {
		$(".navbar-vertical").animate({left: '-300px'}, 500, 'swing');
		$(".main-content").animate({marginLeft: '0px'}, 500, 'swing');
		$(".btn-sidebar-show").show('400');;
	}
}
function show_sidebar() {
	windowWidth = $(window).width();
	if (windowWidth >= 768) {
		$(".navbar-vertical").animate({left: '0px'}, 500, 'swing');
		$(".main-content").animate({marginLeft: '250px'}, 500, 'swing');
		$(".btn-sidebar-show").hide('400');;
	}
}
$(".btn-sidebar-hide").click(function(e) {
	e.preventDefault();
	hide_sidebar();
});
$(".btn-sidebar-show").click(function(e) {
	e.preventDefault();
	show_sidebar();
});


// -------------------------------------------------------------------------------------
// * Custom Trigger Kuesioner
// -------------------------------------------------------------------------------------
$(".custom-trigger").change(function(e) {
	value = $(this).val();
	trigger_value = $(this).data('custom-value');
	custom_ctx = $(this).data('custom-input');
	if (value == trigger_value) {
		$("#" + custom_ctx).show('400');
	}
	else {
		$("#" + custom_ctx).hide('400');
	}
});


// -------------------------------------------------------------------------------------
// * Dataset Form
// -------------------------------------------------------------------------------------
$(".dataset-form").submit(function(e) {
	e.preventDefault();

	datasetSelector = $(this).data('target');
	tableSelector = $(this).data('table');

	datasetCtx = $(datasetSelector);
	if (datasetCtx.val() == '') {
		dataset = [];
	}
	else {
		dataset = JSON.parse(datasetCtx.val());
	}
	dataset.push($(this).serializeArray());
	datasetCtx.val(JSON.stringify(dataset));
	$(this)[0].reset();

	refreshDataset(datasetSelector, tableSelector);		
});
$(".btn-submit-dataset").click(function(e) {
	e.preventDefault();

	datasetWrapperSelector = $(this).data('dataset-wrapper');
	datasetSelector = $(datasetWrapperSelector).data('target');
	tableSelector = $(datasetWrapperSelector).data('table');
	datasetCtx = $(datasetSelector);
	if (datasetCtx.val() == '') {
		dataset = [];
	}
	else {
		dataset = JSON.parse(datasetCtx.val());
	}
	console.log($(datasetWrapperSelector + " input[type='text']").serializeArray());
	dataset.push($(datasetWrapperSelector + " input[type='text']").serializeArray());
	datasetCtx.val(JSON.stringify(dataset));
	$(datasetWrapperSelector).find('input[type="text"]').val('');

	refreshDataset(datasetSelector, tableSelector);		
});
function refreshDataset(datasetSelector, tableSelector) {
	datasetCtx = $(datasetSelector);
	tableCtx = $(tableSelector);

	dataset = JSON.parse(datasetCtx.val());
	rowHtml = '';
	for (var baris = 0; baris < dataset.length; baris++) {
		rowHtml += '<tr>';
		for (var kolom = 0; kolom < dataset[baris].length; kolom++) {
			rowHtml += '<td>' + dataset[baris][kolom].value + '</td>';
		}
		rowHtml += '<td class="text-right"><button type="button" data-dataset="' + datasetSelector + '" data-table="' + tableSelector + '" class="btn btn-sm btn-secondary rounded-circle btn-icon-only btn-delete-dataset-item" data-id="' + baris + '"><i class="fas fa-times"></i></button></td>';
		rowHtml += '</tr>';
	}

	tableCtx.html(rowHtml);
	eventAfterRefreshDataset();
}
function eventAfterRefreshDataset() {
	$(".btn-delete-dataset-item").click(function(e) {
		datasetSelector = $(this).data('dataset');
		tableSelector = $(this).data('table');

		datasetCtx = $(datasetSelector);
		tableCtx = $(tableSelector);
		id = $(this).data('id');

		dataset = JSON.parse(datasetCtx.val());
		dataset.splice(id, 1);

		datasetCtx.val(JSON.stringify(dataset));
		refreshDataset(datasetSelector, tableSelector);
	});
};


// -------------------------------------------------------------------------------------
// * Trigger untuk pertanyaan turunan
// -------------------------------------------------------------------------------------
$(".trigger-turunan-input").change(function(e) {
	targetGrupElemen = $(this).data('target-turunan');
	if($(this).hasClass('trigger-turunan')) {
		$(".pertanyaan-turunan[data-grup-elemen='" +targetGrupElemen+ "']").show('400');
	}
	else {
		$(".pertanyaan-turunan[data-grup-elemen='" +targetGrupElemen+ "']").hide('400');
	}
});

// -------------------------------------------------------------------------------------
// disable mousewheel on a input number field when in focus
// (to prevent Cromium browsers change the value when scrolling)
// -------------------------------------------------------------------------------------
$('form').on('focus', 'input[type=number]', function (e) {
  $(this).on('mousewheel.disableScroll', function (e) {
    e.preventDefault();
  });
});
$('form').on('blur', 'input[type=number]', function (e) {
  $(this).off('mousewheel.disableScroll');
});


// -------------------------------------------------------------------------------------
// Modal collapse right
// -------------------------------------------------------------------------------------
function toggleModalCollapse(status) {
	if (status == 'show') {
		$(".modal-collapse #wrapper-utama").removeClass('col-sm-12');
		$(".modal-collapse #wrapper-utama").addClass('col-sm-6');
		$(".modal-collapse #wrapper-collapse").show('400');
		$(".modal-collapse .modal-dialog").animate({width: '90%', maxWidth: '1200px'}, 400, 'swing');
	}
	else {
		$(".modal-collapse #wrapper-collapse").hide('400');
		$(".modal-collapse #wrapper-utama").removeClass('col-sm-6');
		$(".modal-collapse #wrapper-utama").addClass('col-sm-12');
		$(".modal-collapse .modal-dialog").animate({width: '800px', maxWidth: '800px'}, 400, 'swing');
	}
}
