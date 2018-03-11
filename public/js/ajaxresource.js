//Get an url parameter by its name
$.urlParam = function(name) {
    var results = new RegExp('[\?&]' + name + '=([^]*)').exec(window.location.href);
    if (results==null){
       return null;
    } else {
       return results[1] || 0;
    }
}

var AjaxResourceManager = function(messageCreated, messageDeleted, messageModify, messageDeleteFailure, messageDeleteConfirm, fieldName, clickable) {

	this.page = $.urlParam('page');
	this.page = this.page == null ? 1 : this.page;

	this.messageCreated = messageCreated;
	this.messageModify = messageModify;
	this.messageDeleted = messageDeleted;
	this.messageDeleteFailure = messageDeleteFailure;
	this.messageDeleteConfirm = messageDeleteConfirm;
	this.fieldName = fieldName;
	this.clickable = clickable != undefined ? clickable : false;

}

AjaxResourceManager.prototype.createResourceRow = function(id, description, url, token) {
	var spanDescriptionContent = this.clickable ? '<b><a href="' + url + '">' + description + '</a></b>' : description;
	var row = '<tr class="resource-row">' +
	'<td>' + id + '</td>' +
  	'<td class="break-word"><form class="form-edit-resource" method="POST" action="' + url + '" accept-charset="UTF-8"><input name="_method" value="PUT" type="hidden"><input name="_token" value="' + token + '" type="hidden">' +
  	'<span class="resource-description">' + spanDescriptionContent + '</span></form></td>' +
  	'<td><a class="text-primary editResource point-cursor" value="Modifier"><i class="fa fa-pencil"></i></a></td>' +
  	'<td><form method="POST" action="' + url + '" accept-charset="UTF-8">' +
    	'<input name="_method" value="DELETE" type="hidden"><input name="_token" value="' + token + '" type="hidden">'+
      	'<a class="text-danger submitDeleteResource point-cursor" value="Supprimer" type="submit"><i class="fa fa-trash"></i></a>' +
    '</form></td></tr>';

	$(row).appendTo('#resources-table');
}

AjaxResourceManager.prototype.handleCreateSuccess = function(data, url) {
    $.alert('success', this.messageCreated);
    $('#description').val('');
    this.clearErrors();

    //Update table
    if($('.resource-row').length < 10) {
    	this.createResourceRow(data.id, data.description, url + '/'+ data.id, data.token);
		$('#no-resource-row').addClass('hidden');
		$('#resources-row').removeClass('hidden');
    }

    //Update pagination
	$('#pagination-container').empty().append(data.links);

}

AjaxResourceManager.prototype.handleCreateFailure = function(data) {

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

}

AjaxResourceManager.prototype.clearErrors = function() {
	$('#descriptionGroup').removeClass('has-error');
	$('.validation-error').remove();
}

AjaxResourceManager.prototype.handleDeleteSuccess = function(srcElement, data) {
	$.alert('success', this.messageDeleted);

	var localManager = this;

	//Update table
	$(".resource-row").remove();
	$.each(data.resources, function(index, value) {
		localManager.createResourceRow(value.id, value.description, data.url + '/' + value.id, data.token);
	});

	//Update pagination
	$('#pagination-container').empty().append(data.links);

}

AjaxResourceManager.prototype.handleDeleteFailure = function() {
	$.alert('error', this.messageDeleteFailure);
}

AjaxResourceManager.prototype.handleEditSuccess = function(data, srcElement) {
	$.alert('success', this.messageModify);
	var icon = srcElement.parent().parent().find('.editResource').first().children('i').first();
	icon.addClass('fa-pencil');
	icon.removeClass('fa-check');

	var field = srcElement.find('.resource-description').first();

	if(manager.clickable)
		field.find('a').text(data.text);
	else
		field.text(data.text);
}

AjaxResourceManager.prototype.handleEditFailure = function(data, srcElement) {
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

//----------------------------------------------------

	//Create 
	$("#formCreateResource").submit(function (ev) {
		ev.preventDefault();
		var url = $(this).attr('action');
		$.ajax({
			method: 'POST',
			url: url,
				data: $('#formCreateResource').serialize() + "&page=" + manager.page,
				dataType: "json"
			})
			.done(function(data) {
				manager.handleCreateSuccess(data, url);
			})
			.fail(function(data) {
				manager.handleCreateFailure(data.responseJSON);	
			});
	});

	//----------------------------------------------------

	//Delete
	$('body').on('click', '.submitDeleteResource', function() {
		if(confirm(manager.messageDeleteConfirm)) {
			var form = $(this).parent();
			var url = form.attr('action');

			if($(".resource-row").length <= 1) {

				if(manager.page == 1) { //All have been deleted
					$('#no-resource-row').removeClass('hidden');
					$('#resources-row').addClass('hidden');
				} else {
					var previousPage = manager.page;
					manager.page--;
					window.history.replaceState( null, null, location.href.replace("page="+previousPage, "page="+manager.page) );
				}
			}

		$.ajax({
			method: 'POST',
			url: url,
				data: form.serialize() + "&page=" + manager.page,
				dataType: "json"
			})
			.done(function(data) {
				manager.handleDeleteSuccess(this, data);
			})
			.fail(function(data) {
				manager.handleDeleteFailure();	
			});
		}
	});

	//----------------------------------------------------

	//Edit
	$('body').on('mousedown', '.editResource', function(event) {
		if($(this).children('i').first().hasClass('fa-pencil')) { //Normal mode, switch to edit mode
			var description = $(this).parent().parent().find('.resource-description');
			var input = $('<input type="text" name="' + manager.fieldName + '" class="solid-text-input" value="' + description.text() + '" maxlength="255">');
			description.parent().append( input );
			description.hide();

			$(this).children('i').first().removeClass('fa-pencil');
			$(this).children('i').first().addClass('fa-check');

			setTimeout(function() {
				manager.previousDescription = manager.clickable ? description.find('a').text() : description.text();
				input.focus();
			}, 100);
		} else { //Edit mode, send changes
			$(this).parent().parent().find('.form-edit-resource').first().submit();
		}
	});

	$('body').on('submit', '.form-edit-resource', function (ev) {
		ev.preventDefault();
		var form = $(this);
		var url = $(this).attr('action');
		$.ajax({
			method: 'POST',
			url: url,
				data: $('.form-edit-resource').serialize(),
				dataType: "json"
			})
			.done(function(data) {
				manager.handleEditSuccess(data, form);
			})
			.fail(function(data) {
				manager.handleEditFailure(data.responseJSON, form);	
			});
		$(".solid-text-input").blur();
	});

	//Cancel on focus out
	$('body').on('focusout', '.solid-text-input', function(event) {
		var icon = $(this).parent().parent().parent().find('.editResource').first().children('i').first();
		icon.toggleClass('fa-pencil');
		icon.toggleClass('fa-check');

		var description = $(this).parent().find('.resource-description');
		if(manager.clickable)
			description.find('a').text(manager.previousDescription);
		else
			description.text(manager.previousDescription);
		description.show();
		$(this).remove();
	});

//----------------------------------------------------

