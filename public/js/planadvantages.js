$(function() {

	//Get an url parameter by its name
	$.urlParam = function(name) {
	    var results = new RegExp('[\?&]' + name + '=([^]*)').exec(window.location.href);
	    if (results==null){
	       return null;
	    } else {
	       return results[1] || 0;
	    }
	}

	var page = $.urlParam('page');
	page == null ? 1 : page;

	$.createAdvantageRow = function(id, description, url, token) {
 		var row = '<tr class="advantage-row">' +
	    	'<td>' + id + '</td>' +
	      	'<td class="break-word"><form class="form-edit-advantage" method="POST" action="' + url + '" accept-charset="UTF-8"><input name="_method" value="PUT" type="hidden"><input name="_token" value="' + token + '" type="hidden">' +
	      	'<span class="advantage-description">' + description + '</span></form></td>' +
	      	'<td><a class="text-primary editAdvantage point-cursor" value="Modifier"><i class="fa fa-pencil"></i></a></td>' +
	      	'<td><form method="POST" action="' + url + '" accept-charset="UTF-8">' +
	        	'<input name="_method" value="DELETE" type="hidden"><input name="_token" value="' + token + '" type="hidden">'+
	          	'<a class="text-danger submitDeleteAdvantage point-cursor" value="Supprimer" type="submit"><i class="fa fa-trash"></i></a>' +
	        '</form></td></tr>';

		$(row).appendTo('#advantages-table');
 	}

 	//----------------------------------------------------

	//Create 
	$("#formCreateAdvantage").submit(function (ev) {
		ev.preventDefault();
		var url = $(this).attr('action');
		$.ajax({
			method: 'POST',
			url: url,
				data: $('#formCreateAdvantage').serialize() + "&page=" + page,
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
	    	$.createAdvantageRow(data.id, data.description, url + '/'+ data.id, data.token);
			$('#no-advantage-row').addClass('hidden');
			$('#advantages-row').removeClass('hidden');
	    }

	    //Update pagination
		$('#pagination-container').empty().append(data.links);

    	return this;
	};

	$.handleCreateFailure = function(data) {

		if(data.errors != undefined && data.errors.description != undefined) {
			//Validation error

			$.clearErrors();

			$('#descriptionGroup').addClass('has-error');

			$.each(data.errors.description, function(index, value) {
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

	//----------------------------------------------------

	//Delete
 	$('body').on('click', '.submitDeleteAdvantage', function() {
 		if(confirm('Voulez-vous vraiment supprimer cet avantage ?')) {
 			var form = $(this).parent();
 			var url = form.attr('action');

 			if($(".advantage-row").length <= 1) { 				

 				if(page == 1) { //All have been deleted
 					$('#no-advantage-row').removeClass('hidden');
					$('#advantages-row').addClass('hidden');
 				} else {
 					var previousPage = page;
 					page--;
 					window.history.replaceState( null, null, location.href.replace("page="+previousPage, "page="+page) );
 				}
 			}

			$.ajax({
				method: 'POST',
				url: url,
					data: form.serialize() + "&page=" + page,
					dataType: "json"
				})
				.done(function(data) {
					$.handleDeleteSuccess(this, data);
				})
				.fail(function(data) {
					$.handleDeleteFailure();	
				});
		}
	});

	$.handleDeleteSuccess = function(srcElement, data) {
		$.alert('success', 'Avantage supprimé.');

		//Update table
		$(".advantage-row").remove();
		$.each(data.advantages, function(index, value) {
			$.createAdvantageRow(value.id_plan_advantage, value.description, data.url + '/' + value.id_plan_advantage, data.token);
		});

		//Update pagination
		$('#pagination-container').empty().append(data.links);

		return this;
	};

	$.handleDeleteFailure = function() {
		$.alert('error', 'Une erreur est survenue. Impossible de supprimer cet avantage.');
		return this;
	};

	//----------------------------------------------------

	var previousDescription;

	//Edit
	$('body').on('mousedown', '.editAdvantage', function(event) {
		if($(this).children('i').first().hasClass('fa-pencil')) { //Normal mode, switch to edit mode
			var description = $(this).parent().parent().find('.advantage-description');
			var input = $('<input type="text" name="description" class="solid-text-input" value="' + description.text() + '" maxlength="255">');
			description.replaceWith( input );

			$(this).children('i').first().removeClass('fa-pencil');
			$(this).children('i').first().addClass('fa-check');

			setTimeout(function() {
				previousDescription = description.text();
				input.focus();
			}, 100);
		} else { //Edit mode, send changes
			$(this).parent().parent().find('.form-edit-advantage').first().submit();
		}
	});

	$('body').on('submit', '.form-edit-advantage', function (ev) {
		ev.preventDefault();
		var form = $(this);
		var url = $(this).attr('action');
		$.ajax({
			method: 'POST',
			url: url,
				data: $('.form-edit-advantage').serialize(),
				dataType: "json"
			})
			.done(function(data) {
				$.handleEditSuccess(data, form);
			})
			.fail(function(data) {
				$.handleEditFailure(data.responseJSON, form);	
			});
		$(".solid-text-input").blur();
	});

	//Cancel on focus out
	$('body').on('focusout', '.solid-text-input', function(event) {
		var icon = $(this).parent().parent().parent().find('.editAdvantage').first().children('i').first();
		icon.toggleClass('fa-pencil');
		icon.toggleClass('fa-check');

		$(this).replaceWith('<span class="advantage-description">' + previousDescription + '</span>');
	});

	$.handleEditSuccess = function(data, srcElement) {
		$.alert('success', 'Avantage modifié.');
		var icon = srcElement.parent().parent().find('.editAdvantage').first().children('i').first();
		icon.addClass('fa-pencil');
		icon.removeClass('fa-check');

		var field = srcElement.find('.advantage-description').first();
		field.text(data.text);
	}

	$.handleEditFailure = function(data, srcElement) {
		if(data.errors != undefined && data.errors.description != undefined) {
			//Validation error
			$.each(data.errors.description, function(index, value) {
				$.alert('warning', value);
			});

		} else {
			//Server error
			$.alert('error', 'Une erreur est survenue.');
		}
	}
});