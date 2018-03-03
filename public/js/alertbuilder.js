$.alert = function(type, message) {

	var alert;

	switch(type) {
		case 'error':
			alert = '<div class="alert alert-danger alert-dismissible alert-nomargin"><i class="fa fa-exclamation-triangle"></i><b class="overflow-break-word">' + message + '</b></div>';
			break;
		case 'warning':
			alert = '<div class="alert alert-warning alert-dismissible alert-nomargin"><i class="fa fa-exclamation-circle"></i><b class="overflow-break-word">' + message + '</b></div>';
			break;
		case 'info':
			alert = '<div class="alert alert-info alert-dismissible alert-nomargin"><i class="fa fa-info-circle"></i><b class="overflow-break-word">' + message + '</b></div>';
			break;
		case 'success':
			alert = '<div class="alert alert-success alert-dismissible alert-nomargin"><i class="fa fa-check"></i><b class="overflow-break-word">' + message + '</b></div>';
			break;
	}

	var div = $(alert).prependTo('.content');
	div.css('opacity', 0).css('padding-top', 0).css('padding-bottom', 0).css('margin-bottom', 0)
	  .slideDown('slow')
	  .animate(
	    { opacity: 1, paddingTop: 15, paddingBottom: 15, marginBottom: 15 },
	    { queue: false, duration: 'slow' }
	   	);
	window.setTimeout(function() {
		div.animate({ height: 0, opacity: 0, paddingTop: 0, paddingBottom: 0, marginBottom: 0 }, 'slow', function(){ $(this).remove(); } );
	}, 5000);
	return this;
}