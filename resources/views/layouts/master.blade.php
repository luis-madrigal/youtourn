<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>@yield('title')</title>
       	<link rel = "stylesheet" href = "{{ URL::to('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/styles.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/drop-down-menu.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/jquery-ui.css') }}">
        <link rel="icon" href="{{ URL::to('images/ytsmalllogo.ico') }}">
        @yield('css_links')
    </head>
    <body>
    	
    	@yield('content')
    	

        <script type="text/javascript" src="{{ URL::to('js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::to('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript">
            var urlSearch = '{{ route("search.autocomplete") }}';
            var userNotifs = [];
            @if(Auth::check())
                $(document).ready( function(){
                    loadNotifs();
                });

                function loadNotifs() {
                    console.log('load notifs');
                    var url = "{{ route('get.notifs', ['user_id' => Auth::user()->id]) }}";
                    $.get(url, function(data, status){
                        $('#notif-container').empty();
                        var unreadCount = 0;
                        if(data['notifications'].length > 0) {
                            for(i = 0; i < data['notifications'].length; i++) {
                                var route = 'http://localhost:8000/tournament_page/'+data['notifications'][i].object_id;
                                if(data['notifications'][i].type == 'Follow')
                                    $('#notif-container').append("<li><a id = 'notif"+data['notifications'][i].id+"' href = '"+route+"'><i class='glyphicon glyphicon-thumbs-up'></i> " +data['notifications'][i].body+ "</li>")
                                else if(data['notifications'][i].type == 'Edit')
                                    $('#notif-container').append("<li><a id = 'notif"+data['notifications'][i].id+"' href = '"+route+"'><i class='glyphicon glyphicon-pencil'></i> " +data['notifications'][i].body+ "</li>")
                                else if(data['notifications'][i].type == 'Winner')
                                    $('#notif-container').append("<li><a id = 'notif"+data['notifications'][i].id+"' href = '"+route+"'><i class='glyphicon glyphicon-flash'></i> " +data['notifications'][i].body+ "</li>")
                                if(!data['notifications'][i].is_read) {
                                    $('#notif'+data['notifications'][i].id).attr('style', 'background-color:#C4C4C4');
                                    unreadCount++;
                                }
                            }
                            if(unreadCount != 0)
                                $('#notif-count').text(unreadCount);
                        } else {
                            $('#notif-container').append("<li><a href = '#'>No notifications</a></li>")
                        }
                    });
                    setTimeout(function(){ loadNotifs(); }, 3000);
                }

                function setUnreadNotifications() {
                    for (var i = 0; i < userNotifs.length; i++) {
                        $('#notif'+userNotifs[i].id).attr('style', 'background-color:white')  
                    }
                    userNotifs = [];
                    $('#notif-count').empty();
                }

                $('#notif-button').on('click', function() {
                    $(this).toggleClass('white');
                    setUnreadNotifications();
                    var url = "{{ route('set.notifs.read') }}"
                    var token = "{{ Session::token() }}"
                    $.ajax( {
                        method: 'POST',
                        url: url,
                        data: {_token:token}
                    })
                    .done( function(msg) {
                        userNotifs = msg;
                    });
                });

                $('#notif-button').focusout(function () {
                    $(this).removeClass('white');
                });
            @endif
        </script>
        <script src="{{ URL::to('js/jquery-ui.js') }}"></script>
        <script src="{{ URL::to('js/autocomplete.js') }}"></script>
        @yield('js_links')
    </body>
</html>
