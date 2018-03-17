$(function() {

  $('body').on('mousedown', '.editType', function(event) {
		if($(this).children('i').first().hasClass('fa-pencil')) { //Normal mode, switch to edit mode
			var type = $(this).parent().parent().find('.type-name');
			var input = $('<input type="text" name="name" class="solid-text-input" value="' + type.text() + '" maxlength="255">');
			type.replaceWith( input );

			$(this).children('i').first().removeClass('fa-pencil');
			$(this).children('i').first().addClass('fa-check');

			setTimeout(function() {
				previousType = type.text();
				input.focus();
			}, 100);
		} else { //Edit mode, send changes
			$(this).parent().parent().find('.form-edit-type').first().submit();
		}
	});

});
