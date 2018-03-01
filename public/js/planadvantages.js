$(function() {
	
	//Create 
	$("#formCreateAdvantage").submit(function (ev) {
		ev.preventDefault();
		var url = $(this).attr('action');
		$.ajax({
	    	method: 'POST',
	        url: url,
	        	data: $('#formCreateAdvantage').serialize(),
	        	dataType: "json"
	    	})
	    	.done(function(data) {
	        	$.handleCreateSuccess(data, url);
	    	})
	    	.fail(function(data) {
	    		$.handleCreateFailure(data.responseJSON);	
	    	});
	});

	$.handleCreateSuccess = function(data, url) {
	    $.alert('success', 'Avantage de forfait créé !');
	    $('#description').val('');
	    $.clearErrors();

	    //Update table
	    if($('.advantage-row').length < 10) {

	    	var row = '<tr class="advantage-row">' +
		    	'<td>' + data.id          + '</td>' +
		      	'<td>' + data.description + '</td>' +
		      	'<td><form method="POST" action="' + url + '/' + data.id + '" accept-charset="UTF-8">' +
		        	'<input name="_method" value="DELETE" type="hidden"><input name="_token" value="' + data.token + '" type="hidden">'+
		          	'<a class="text-danger submitDeleteAdvantage point-cursor" value="Supprimer" type="submit"><i class="fa fa-trash"></i></a>' +
		        '</form></td></tr>';

			$(row).appendTo('#advantages-table');
	    }

    	return this;
	};

	$.handleCreateFailure = function(errors) {

		if(errors.errors != undefined && errors.errors.description != undefined) {
			//Validation error

			$.clearErrors();

			$('#descriptionGroup').addClass('has-error');

			$.each(errors.errors.description, function(index, value) {
				$('#descriptionGroup').append('<span class="help-block validation-error"><strong>' + value + '</strong></span>');
			});

		} else {
			//Server error
			$.alert('error', 'Une erreur est survenue.');
		}

    	return this;
	};

	$.clearErrors = function() {
		$('#descriptionGroup').removeClass('has-error');
		$('.validation-error').remove();
	}

});