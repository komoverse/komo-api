<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Hello, world!</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>
  <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                
    <form action="{{ url('v1/match-history/add') }}" method="post">
        <h2>Input Match History</h2>
        API Key*
      <input type="text" name="api_key">
      <br>
      Match ID*
      <input type="text" name="match_id">
      <br>
      Playfab ID*
      <input type="text" name="playfab_id">
      <br>
      Display Name*
      <input type="text" name="display_name">
      <br>
      Placement*
      <input type="number" name="placement">
      <br>
      PLayer Level
      <input type="text" name="player_level">
      <br>
      lineup*
      <textarea name="lineup" id="" cols="30" rows="10">
{
    "3*eikthyr": 1,
    "3*sakura": 2,
    "2*rogue": 1,
    "1*rogue": 1,
    "1*kuli": 1
}
      </textarea>
      <br>
      Buff Item
      <textarea name="buff_items" id="" cols="30" rows="10">
{
    "lightning-gloves": 3,
    "wizard-stone": 2
}
      </textarea>
      <br>
      win
      <input type="number" name="win">
      <br>Lose
      <input type="number" name="lose">
      <br>
      Heroes kill
      <input type="number" name="heroes_kill">
      <br>Heroes death
      <input type="number" name="heroes_death">
      <br>
      Damage given
      <input type="number" name="damage_given">
      <br>Damage taken
      <input type="number" name="damage_taken">
      <br>
      Duration
      <input type="time" step="1" name="duration">
      <input type="submit">
  </form>
            </div>
            <div class="col-lg-8">
<h2>Get Match History List</h2>
playfab id
<input type="text" name="mh_playfab_id">
<button id="btn-history">Get</button>
<table id="table-player" class="table table-light table-sm table-striped">
    <thead>
        <tr>
            <td>Match ID</td>
            <td>#Rank</td>
            <td>Line Up</td>
            <td>Buff Items</td>
            <td>W-L</td>
            <td>K-D</td>
            <td>Damage Given / Taken</td>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<br>
<hr>
<br>
<h2>Get Match Detail</h2>
match id
<input type="text" name="mh_match_id">
<button id="btn-detail">Get</button>
<table id="table-match-detail" class="table table-light table-sm table-striped">
    <thead>
        <tr>
            <td>#Rank</td>
            <td>PLayer</td>
            <td>Line Up</td>
            <td>Buff Items</td>
            <td>W-L</td>
            <td>K-D</td>
            <td>Damage Given / Taken</td>
        </tr>
    </thead>
    <tbody></tbody>
</table>
            </div>
        </div>
    </div>
<script>
    
      $("#btn-history").on('click', function(){
        var playfab_id = $("input[name=mh_playfab_id]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/match-history/list',
          type: 'POST',
          dataType: 'json',
          data: {
            playfab_id: playfab_id,
          },
        })
        .always(function(result) {
          console.log(result);
          $("#table-player tbody").html("");
          $.each(result, function(index, val) {
               $("#table-player tbody").append('<tr>' +
                '<td>'+val.match_id+'</td>' +
                '<td>'+val.placement+'</td>' +
                '<td>'+val.lineup+'</td>' +
                '<td>'+val.buff_items+'</td>'+
                '<td>'+val.win+'-'+val.lose+'</td>' +
                '<td>'+val.heroes_kill+'-'+val.heroes_death+'</td>' +
                '<td>'+val.damage_given+' / '+val.damage_taken+'</td>' +
                '</tr>');
          });
        });
        
      });
      $("#btn-detail").on('click', function(){
        var match_id = $("input[name=mh_match_id]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/match-history/detail',
          type: 'POST',
          dataType: 'json',
          data: {
            match_id: match_id,
          },
        })
        .always(function(result) {
          console.log(result);
          $("#table-match-detail tbody").html("");
          $.each(result, function(index, val) {
               $("#table-match-detail tbody").append('<tr>' +
                '<td>'+val.placement+'</td>' +
                '<td>'+val.display_name+'</td>' +
                '<td>'+val.lineup+'</td>' +
                '<td>'+val.buff_items+'</td>'+
                '<td>'+val.win+'-'+val.lose+'</td>' +
                '<td>'+val.heroes_kill+'-'+val.heroes_death+'</td>' +
                '<td>'+val.damage_given+' / '+val.damage_taken+'</td>' +
                '</tr>');
          });
        });
        
      });
</script>
  </body>
  </html>