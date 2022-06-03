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
<link rel="stylesheet" href="https://komoverse.io/assets/css/main.css">
<link rel="stylesheet" href="https://komoverse.io/assets/css/custom.css">
  </head>
  <body>
    <div class="bg-lines"></div>
    <div class="bg-breathing"></div>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <select name="type" id="">
            <option value="daily">Daily Leaderboard</option>
            <option value="weekly">Weekly Leaderboard</option>
            <option value="monthly">Monthly Leaderboard</option>
            <option value="lifetime">Lifetime Leaderboard</option>
          </select>
          <input type="text" name="parameter" placeholder="Parameter">
          <input type="submit" id="btn-submit">
          <br>For daily <i style="color:red">yyyy_mm_dd</i> <i>e.g. 2022-06-03</i> (date and month use leading zero)
          <br>For weekly <i style="color:red">yyyy_ww</i> <i>e.g. 2022-22</i> (week of the year starting monday)
          <br>For montly <i style="color:red">yyyy_mm</i> <i>e.g. 2022-06</i> (2 digit month use leading zero)
          <br>For lifetime <i style="color:red">no parameter required</i></td>
          <table class="table table-light table-sm table-striped">
            <thead>
              <tr>
                <td>Playfab ID</td>
                <td>In-Game Name</td>
                <td>EXP</td>
                <td>Total Match</td>
                <td>#1</td>
                <td>#2</td>
                <td>#3</td>
                <td>#4</td>
                <td>#5</td>
                <td>#6</td>
                <td>#7</td>
                <td>#8</td>
              </tr>
            </thead>
            <tbody></tbody>
          </table>          
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      $("#btn-submit").on('click', function(){
        var type = $("select[name=type] option:selected").val();
        var parameter = $("input[name=parameter]").val();
        $('tbody').html("");

        $.ajax({
          url: '{{ url('/') }}/v1/leaderboard/get',
          type: 'POST',
          dataType: 'json',
          data: {
            type: type,
            parameter: parameter,
          },
        })
        .always(function(result) {
          console.log(result);
          if (result.status != "No Leaderboard Data for This Period") {
            $.each(result, function(index, value) {
              console.log(index + " -> " + value + "^");
              $('tbody').append('<tr><td>'+value.playfab_id+'</td><td>'+ value.in_game_display_name + '</td><td>'+ value.exp + '</td><td>'+ value.total_match + '</td><td>'+ value.placement_1 + '</td><td>'+ value.placement_2 + '</td><td>'+ value.placement_3 + '</td><td>'+ value.placement_4 + '</td><td>'+ value.placement_5 + '</td><td>'+ value.placement_6 + '</td><td>'+ value.placement_7 + '</td><td>'+ value.placement_8 + '</td></tr>');
            });
          } else {
            alert(result.status)
          }
        });
      });

    </script>
  </body>
</html>