var tournamentsDeleted = [];

$('.delete-button').on('click', function() {
	$('#delete-tournaments').attr('class', 'btn btn-danger');
	if($(this).attr('data-delete') == '0') {
		$(this).attr('style', 'color:#FF3030');
		$(this).attr('data-delete', '1');
		tournamentsDeleted.push($(this).closest('.row').attr('data-tourn-id'));
		console.log(tournamentsDeleted);
	} else {
		$(this).attr('style', 'color:#6B6B6B');
		$(this).attr('data-delete', '0');
		var index = tournamentsDeleted.indexOf($(this).closest('.row').attr('data-tourn-id'));
		tournamentsDeleted.splice(index, 1);
		console.log(tournamentsDeleted);
		if(tournamentsDeleted.length == 0) {
			$('#delete-tournaments').addClass('hidden');
		}
	}
	// $(this).closest('.row').remove();
});

$('.delete-button').hover(
	function() {
		if($(this).attr('data-delete') == '0') {
			$(this).css("color","#6B6B6B");
		}
	}, function() {
		if($(this).attr('data-delete') == '0') {
			$(this).css("color","transparent");
		}
	}
);

$('#delete-tournaments').on('click', function() {
	$.ajax( {
	    method: 'POST',
	    url: urlDelete,
	    data: {name: name, tournamentsDeleted: tournamentsDeleted, _token:token}
	  })
	  .done( function(msg) {
	  	for (var i = 0; i < msg.length; i++) {
	  		$('#tournaments-deleted').append('<li><b>' + msg[i] + '</b> tournament</li>')
	  	}
	  	$('#delete-modal').modal();
	  	$('#delete-tournaments').hide();
	  });
});

$('#undo-button').on('click', function() {
	$.ajax( {
	    method: 'POST',
	    url: urlUndo,
	    data: {name: name, tournamentsDeleted: tournamentsDeleted, _token:token}
	  })
	  .done( function(msg) {
	  	location.reload();
	  });
});

$('#continue-button').on('click', function() {
	location.reload();
});