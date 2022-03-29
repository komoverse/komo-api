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
    <h1>Hello, world!</h1>
    <p>Register</p>
    Username
    <input type="text" name="komo_username">
    Password
    <input type="password" name="password">
    Email
    <input type="email" name="email">
    Wallet
    <input type="text" name="wallet_pubkey">
    <button class="btn btn-success" id="btn-submit">Submit</button>
    <span class="reg-status"></span>

    <br>
    <br>
    <p>Login</p>
    Username
    <input type="text" name="gkomo_username">
    Password
    <input type="password" name="gpassword">
    <button class="btn btn-success" id="btn-login">Game Login</button>
    <br>
    <br>
    <p>Change Display Name</p>
    Entity Token
    <input type="text" name="entity_token">
    Session Ticket
    <input type="text" name="session_ticket">
    Playfab ID
    <input type="text" name="playfab_id">
    Display Name
    <input type="text" name="display_name">
    <button class="btn btn-success" id="btn-change-name">Change Game Display Name</button>
    <br>
    <span class="showajax"></span>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      $("#btn-submit").on('click', function(){
        var komo_username = $("input[name=komo_username]").val();
        var password = $("input[name=password]").val();
        var email = $("input[name=email]").val();
        var wallet_pubkey = $("input[name=wallet_pubkey]").val();

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
          $('.reg-status').text(result.status);
        });
        
      });

      $("#btn-login").on('click', function(){
        var komo_username = $("input[name=gkomo_username]").val();
        var password = $("input[name=gpassword]").val();
        console.log(komo_username + " " + password);
        $.ajax({
          url: '{{ url('/') }}/v1/login',
          type: 'POST',
          dataType: 'json',
          data: {
            komo_username: komo_username,
            password: password,
          },
        })
        .always(function(result) {
          console.log(result);
          if (result.code == 200) {
            $('input[name=entity_token]').val(result.data.EntityToken.EntityToken);
            $('input[name=playfab_id]').val(result.data.PlayFabId);
            $('input[name=session_ticket]').val(result.data.SessionTicket);
            getDisplayName();
          }
        });
        
      });

      $("#btn-change-name").on('click', function(){
        var playfab_id = $("input[name=playfab_id]").val();
        var display_name = $("input[name=display_name]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/change-display-name',
          type: 'POST',
          dataType: 'json',
          data: {
            playfab_id: playfab_id,
            display_name: display_name,
          },
        })
        .always(function(result) {
          console.log(result);
          $('.showajax').html(result);
        });
        
      });

      function getDisplayName() {
        var playfab_id = $("input[name=playfab_id]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/account-info',
          type: 'POST',
          dataType: 'json',
          data: {
            playfab_id: playfab_id,
          },
        })
        .always(function(result) {
          console.log(result);
          $('input[name=display_name]').val(result.data.UserInfo.TitleInfo.DisplayName);
        });

      }
    </script>
  </body>
</html>