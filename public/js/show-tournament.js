var container = $('#editor');

function encodeRR(data) {
  console.log(data);
  var parsed = "";
  var j = 1;
  console.log(data.teams.length);
  for(i = 0; i < data.teams.length; i++) {
    parsed = parsed.concat(data.teams[i].id.toString());
    parsed = parsed.concat('^^');
    parsed = parsed.concat(data.teams[i].name);
    parsed = parsed.concat('^^');
  }
  parsed = parsed.concat('&&');
  console.log('Teams: ' + parsed);
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
  console.log('Matches: ' + parsed)
  return parsed;
}

function decodeRR() {
  var tournamentData = '{"teams": [';
  var split = data.split('&&');
  var teams = split[0].split('^^');
  var matches = split[1].split('^^');
  var item1 = {};
  var temp;

  console.log('Teams: ' + teams);
  console.log('Matches' + matches);

  for(i = 0; i < teams.length-1; i++) {
    item1 = '{';
    item1 = item1.concat('"id":' + teams[i] + ',');
    i++;
    item1 = item1.concat('"name":' + '"' + teams[i] + '"');
    item1 = item1.concat('}');
    tournamentData = tournamentData.concat(item1);

    if(i < teams.length-2)
      tournamentData = tournamentData.concat(',');
  }

  tournamentData = tournamentData.concat('],' + '"matches":[');
  for(i = 0; i < matches.length-1; i++) {
    item1 = '{';
    item1 = item1.concat('"a": {"team":' + (parseInt(matches[i])-1) + ',');
    i++;
    item1 = item1.concat('"score":' + matches[i]);
    item1 = item1.concat('},');
    i++;
    item1 = item1.concat('"b": {"team":' + (parseInt(matches[i])-1) + ',');
    i++;
    item1 = item1.concat('"score":' + matches[i]);
    item1 = item1.concat('},');
    i++;
    if(matches[i] == 'undefined')
      matches[i] = 'null';
    item1 = item1.concat('"round":' + matches[i] + '}');

    tournamentData = tournamentData.concat(item1);

    if(i < matches.length-2)
      tournamentData = tournamentData.concat(',');
  }
  tournamentData = tournamentData.concat(']}');
  return tournamentData;
}

function updateTournament() {
  $.ajax( {
    method: 'POST',
    url: urlEdit,
    data: {tournamentId: tournamentId, tournamentType: tournamentType, tourn_data: tournamentData, _token:token}
  })
  .done( function(msg) {
    location.reload();
  });
}

function saveFn(data, userData) {

  
  console.log('modified');
}

$(function() {
  $('#editor').hide();
  if(tournamentType == 'Round Robin') {
    tournamentData = decodeRR();
    console.log(tournamentData);
    tournamentData = JSON.parse(tournamentData);
    globalTournData = tournamentData;
    $('#editor').group({
      init: tournamentData,
      save: function(state) {
        tournamentData = state;
        console.log(state);
        $('#view').empty().group({
          init: state
        })
      }
    })
  } else {
    tournamentData = JSON.parse(data);
    $('#view').bracket({
      init: tournamentData });
    container.hide();
    container.bracket({
      init: tournamentData,
      save: saveFn})

  }
})

$('#edit-button').on('click', function() {
  $(this).addClass('hidden');
  $('#save-button').attr('class', 'btn btn-success');
  $('#done-button').hide();
  $('#view').hide();
  $('#editor').show();
  
})

$('#save-button').on('click', function() {
  if(tournamentType == 'Round Robin') {
    tournamentData = encodeRR(tournamentData);
  } else {
    if($('.doubleElimination').is(":visible")) {
      tournamentType = 'Single Elimination';
    } else if($('.singleElimination').is(":visible")) {
      tournamentType = 'Double Elimination';
    }
    tournamentData = container.bracket('data');
    tournamentData = JSON.stringify(tournamentData);
  } 
  updateTournament();
})

$('#done-button').on('click', function() {
  if(tournamentType == 'Round Robin') {

  } else {
    try {
      var winner = $('[class = "team win highlightWinner"] > .label')[0].innerHTML;
      $('#done-modal-title-text').html('Declaring tournament as done');
      $('#done-modal-text').html('Are you sure you want to finish this tournament with <b>'+winner+'</b> as the winner?<br>' +
                                'Once you declare a tournament as done, you can no longer edit this tournament.');
      $('#done-modal-yes').attr('class', 'btn btn-primary');
      $('#done-modal').modal();
    } catch (err) {
      console.log(err);
      $('#done-modal-title-text').html('You can\'t declare this tournament as done yet!');
      $('#done-modal-text').html('This tournament doesn\'t have a winner yet!');
      $('#done-modal').modal();
    }
  }
})

$('#done-modal-yes').on('click', function() {
  var winner = $('[class = "team win highlightWinner"] > .label')[0].innerHTML;
  $.ajax( {
    method: 'POST',
    url: urlWin,
    data: {tournament_id:tournamentId, winner:winner, _token:token}
  })
  .done( function(msg) {
    $('#done-button').hide();
    $('#edit-button').hide();
  });
})
