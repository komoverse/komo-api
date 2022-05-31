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
        <div class="col-12 col-lg-6 py-5 text-center">
          <img src="https://komoverse.io/assets/img/logo.webp" alt="">
          <div class="p-5 my-5 explore-nft ylbr text-left">
            <h2>STAGING SERVER REGISTRATION</h2>
            KOMO Username
            <input type="text" name="komo_username" class="form-control mb-2">
            Password
            <input type="password" name="password" class="form-control mb-2">
            Confirm Password
            <input type="password" name="confirm_password" class="form-control mb-2">
            Email
            <input type="email" name="email" class="form-control mb-2">
            Wallet
            <input type="text" name="wallet_pubkey" class="form-control mb-2">
            <button class="btn btn-lg btn-info mb-2" id="btn-submit">Submit</button>
            <span class="reg-status mb-5"></span>
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="p-5 my-5 explore-nft ylbr text-center">
            <h2>Registered Users</h2>
            <table class="table table-sm table-dark">
              <thead>
                <tr>
                  <th>KOMO Username</th>
                  <th>Game ID</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      function refreshPlayerList() {
        $('tbody').html("");

        $.ajax({
          url: '{{ url('/') }}/v1/player-list',
          type: 'GET',
          dataType: 'json',
        })
        .always(function(result) {
          console.log(result);
          $.each(result, function(index, value) {
            console.log(index + " -> " + value + "^");
            $('tbody').append('<tr><td>'+value.komo_username+'</td><td>'+ value.playfab_id + '</td></tr>');
          });
        });
      }
      $(document).ready(function() {
        refreshPlayerList();
      });
      $("#btn-submit").on('click', function(){
        var komo_username = $("input[name=komo_username]").val();
        var password = $("input[name=password]").val();
        var confirm_password = $("input[name=confirm_password]").val();
        var email = $("input[name=email]").val();
        var wallet_pubkey = $("input[name=wallet_pubkey]").val();

        if (password == confirm_password) {

          $.ajax({
            url: '{{ url('/') }}/v1/register',
            type: 'POST',
            dataType: 'json',
            data: {
              komo_username: komo_username,
              password: password,
              email: email,
              wallet_pubkey: wallet_pubkey,
            },
          })
          .always(function(result) {
            console.log(result);
            $('.reg-status').html('<div class="alert alert-primary" role="alert">'+result.status+'</div>');
            refreshPlayerList();
          });
        }
      });

    </script>
  </body>
</html>