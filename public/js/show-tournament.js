var container = $('#editor');

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
  return parsed;
}

function decodeRR() {
  var tournamentData = '{"teams": [';
  var split = data.split('&&');
  var teams = split[0].split('^^');
  var matches = split[1].split('^^');
  var item1 = {};
  var temp;

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
        console.log(tournamentData);
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
  $('#view').hide();
  $('#editor').show();
  
})

$('#save-button').on('click', function() {
  // $('#editor').hide();
  // $('#view').show();
  // $(this).addClass('hidden');
  // $('#edit-button').attr('class', 'btn btn-primary');
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

// $('#editor').group({
//   init: tournamentData,
//   save: function(state) {
//     // Reconstruct read-only version by initializing it with received state
//     $('#view').empty().group({
//       init: state
//     })
//   }
// })

// $('#edit-button').click(function() {
//   console.log(tournamentData);
//   $('#save-button').show();
//   $('#edit-button').hide();
//   $('#view').hide();
//   $('#editor').show();

// })

// $('#save-button').click(function() {
//   $('#edit-button').show();
//   $('#save-button').hide();
//   $('#editor').hide();
//   $('#view').show();
// })