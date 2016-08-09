$('#follow-button').on('click', function() {
	$.ajax({
		method: 'POST',
		url: urlNotif,
		data: {tournamentId: tournamentId, _token: token}
	})
	.done(function(msg) {
		$('#modal-text').empty().append(msg['message']);
		
		if(msg['deleted']) {
			$('#follow-button').empty().append('<i class="glyphicon glyphicon-thumbs-up"></i> Follow');
			$('#modal-title-text').text('You have unfollowed a tournament!')
		}
		else {
			$('#follow-button').empty().append('<i class="glyphicon glyphicon-thumbs-down"></i> Unfollow');
			$('#modal-title-text').text('You have followed a tournament!')
		}

		$('#notif-modal').modal();
	});
});