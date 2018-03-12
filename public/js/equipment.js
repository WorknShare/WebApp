$(function() {
	
	$("#formChangeAffect").submit(function (ev) {
		ev.preventDefault();
		var url = $(this).attr('action');
		$.ajax({
			method: 'POST',
			url: url,
				data: $('#formChangeAffect').serialize(),
				dataType: "json"
			})
			.done(function(data) {
				$.alert('success', 'Affectation modifiée.');
			})
			.fail(function(data) {
				$.alert('error', 'Erreur lors du changement d\'affectation');
			});
	});

	$('select').on('change', function() {
	 	$('#formChangeAffect').submit();
	});

})