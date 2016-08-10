var saveData = {
      "teams": [
    ["Team 1", "Team 2"],
    ["Team 3", "Team 4"]
  ],
  "results": [            
    [0,0],[0,0]
  ]
}
var groupData =  {}
var container = $('div#tournament .elims')

function encodeRR(data) {
  var parsed = "";
  for(i = 0; i < data.teams.length; i++) {
    parsed = parsed.concat(data.teams[i].id.toString());
    parsed = parsed.concat('^^');
    parsed = parsed.concat(data.teams[i].name);
    parsed = parsed.concat('^^');
  }
  parsed = parsed.concat('&&');
  for(i = 0; i < data.matches.length; i++) {
    parsed = parsed.concat(data.matches[i].a.team.id);
    parsed = parsed.concat('^^');
    parsed = parsed.concat(data.matches[i].a.score);
    parsed = parsed.concat('^^');
    parsed = parsed.concat(data.matches[i].b.team.id);
    parsed = parsed.concat('^^');
    parsed = parsed.concat(data.matches[i].b.score);
    parsed = parsed.concat('^^');
    parsed = parsed.concat(data.matches[i].round);
    parsed = parsed.concat('^^');
  }
  parsed = parsed.concat('&&');
  console.log(parsed);
  return parsed;
}

function saveFn(data, userData) {
}

$(function() {
    $('#robin').hide();
    
    container.bracket({
      init: saveData,
      save: saveFn})

    
});


$('div#robin').group({ 
  init: groupData,
  save: function(state) {

    groupData = state;
    $('#view').empty().group({
      init: state
    })
  }
});

$('select#choose').click(function() {
  var type = $('#choose').find(":selected").text();
  if(type == "Elimination") {
    $('#tournament').show();
    $('#robin').hide();
  } else if(type == "Round Robin") {
    $('#robin').show();
    $('#tournament').hide();
  }
});

$('#save-button').on('click', function() {
  var name = $('#name').text();
  var description = $('#description').val();
  var type = $('#choose').find(":selected").text();
  var visibility = $('#privacy').val();
  var hidden = $('.singleElimination').is(':visible');
  var data = null;

  if(type == "Elimination") {
    if(hidden)
      type = "Double Elimination";
    else
      type = "Single Elimination";
    data = container.bracket('data');
    data = JSON.stringify(data);
  } else {
    data = encodeRR(groupData);
  }
  console.log(data);
  $.ajax( {
    method: 'POST',
    url: url,
    data: {name: name, description: description, type: type, visibility: visibility, tourn_data: data, _token:token}
  })
  .done( function(msg) {
    window.location.replace('/tournament_page/' + msg['message']);  
  });
});

$('#upload-button').on('click', function() {
  $.ajax({
    url:urlUpload + '?_token=' + token,
    data:new FormData($('#upload-form')[0]),
    type:'post',
    cache:false,
    processData: false,
    contentType: false,
  })
  .done( function(msg) {
    console.log(msg);
  });
});
