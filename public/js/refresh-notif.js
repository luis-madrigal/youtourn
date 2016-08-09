$(document).ready( function(){
	$.get(url, function(data, status){
        if(data['notifications'].length > 0) {
            for(i = 0; i < data['notifications'].length; i++) {
                var route = 'http://localhost:8000/tournament_page/'+data['notifications'][i].object_id;
                if(data['notifications'][i].type == 'Follow')
                    $('#notif-container').append("<li><a id = 'notif"+data['notifications'][i].id+"' href = '"+route+"'><i class='glyphicon glyphicon-thumbs-up'></i> " +data['notifications'][i].body+ "</li>")
                else if(data['notifications'][i].type == 'Edit')
                    $('#notif-container').append("<li><a id = 'notif"+data['notifications'][i].id+"' href = '"+route+"'><i class='glyphicon glyphicon-pencil'></i> " +data['notifications'][i].body+ "</li>")
                if(!data['notifications'][i].is_read) {
                    $('#notif'+data['notifications'][i].id).attr('style', 'background-color:#C4C4C4')
                }
            }
        } else {
            $('#notif-container').append("<li><a href = '#'>No notifications</a></li>")
        }
    });
});