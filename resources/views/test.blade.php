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
    Change Password
    <input type="password" name="new_password">
    <button class="btn btn-success" id="btn-change-pass">Change Password</button>
    <br>
    <br>
    <p>Change Display Name</p>
    Entity Token
    <input type="text" name="entity_token">
    Session Ticket
    <input type="text" name="session_ticket">
    Playfab ID
    <input type="text" name="playfab_id" value="A95421A781CFEA86">
    Display Name
    <input type="text" name="display_name">
    <button class="btn btn-success" id="btn-change-name">Change Game Display Name</button>
    <br>
    <br>
    <p>Grant Items</p>
    Items
    <input type="text" name="item_id">
    <button class="btn btn-success" id="btn-grant-items">Grant Items</button>
    <button class="btn btn-info" id="btn-get-inventory">Get Inventory</button>
    <br>
    <span class="inventory-wrapper"></span>

    <br>
    <br>
    <br>
    Gold Amount : <span class="gold-amount">0</span> | Shard Amount : <span class="shard-amount">0</span>
    <input type="number" name="amount">
    <button class="btn btn-success" id="btn-add-gold">Add Gold</button>
    <button class="btn btn-success" id="btn-substract-shard">Substract Shard</button>


    <br>
    <br>
    <br>
    Add Transaction : 
    <input type="text" name="seller" value="BwkQW4MWv6iVpJt9vZXwWxD9gRbDyfxZQGTLTCnmprW7"> 
    <input type="text" name="buyer" value="Bez6azyFZ1hBYA8SiFpo9YfpMe2eU81NSwEPrQEGK5wZ"> 
    <input type="text" name="tx_id" value="4BpGFdY4yYo3c9jwNEeFK8ZXkR7tupjzeDoD687jmo5sUbF5vskW8Bzof29SmAdAiPv1EqCh76MByd2weKcQsSV6"> 
    <select name="tx_type">
      <option value="nft">NFT</option>
      <option value="items">Items</option>
    </select>
    <input type="number" name="tx_amount" value="10.5">
    <select name="currency">
      <option value="SOL">SOL</option>
      <option value="KOMO">KOMO</option>
      <option value="IDR">IDR</option>
      <option value="USD">USD</option>
    </select>
    <textarea name="custom_param" id="" cols="30" rows="10"></textarea>
    <button class="btn btn-success" id="btn-add-tx">Add Transaction</button>

    <br>
    <br>
    <br>
    Get Transaction 
    <select name="gtx_tx_type">
      <option value="all">All</option>
      <option value="nft">NFT</option>
      <option value="items">Items</option>
    </select>
    <input type="date" name="gtx_start"> 
    <input type="date" name="gtx_end"> 
    <button class="btn btn-success" id="btn-get-tx">Get TX</button>
    <br>
    <input type="text" name="gtx2_wallet_pubkey" value="BwkQW4MWv6iVpJt9vZXwWxD9gRbDyfxZQGTLTCnmprW7">
    <button class="btn btn-success" id="btn-get-tx2">Get TX By Wallet</button>
    <br>
    <input type="text" name="gtx3_tx_id" value="4BpGFdY4yYo3c9jwNEeFK8ZXkR7tupjzeDoD687jmo5sUbF5vskW8Bzof29SmAdAiPv1EqCh76MByd2weKcQsSV6">
    <button class="btn btn-success" id="btn-get-tx3">Get TX By ID</button>
    <br>
    <br>
    <br>
    Input leaderboard
    API Key: <input type="text" name="lb_api_key">
    Playfab ID: <input type="text" name="lb_playfab_id" value="A95421A781CFEA86">
    EXP Change: <input type="number" name="lb_exp_change" step="1" min="-50" max="50">
    Placement: <input type="number" name="lb_placement" step="1" min="1" max="8">
    <button class="btn btn-success" id="btn-add-leaderboard">Add Leaderboard</button>


    <a href="{{ url('match-history') }}">Input Match History</a>

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

      $("#btn-change-pass").on('click', function() {
        var komo_username = $("input[name=gkomo_username]").val();
        var password = $("input[name=gpassword]").val();
        var new_password = $("input[name=new_password]").val();
        console.log(komo_username+password+new_password);
        $.ajax({
          url: '{{ url('/') }}/v1/change-password',
          type: 'POST',
          dataType: 'json',
          data: {
            komo_username: komo_username,
            old_password: password,
            new_password: new_password,
          },
        })
        .always(function(result) {
          console.log(result);
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

      $("#btn-grant-items").on('click', function(){
        var playfab_id = $("input[name=playfab_id]").val();
        var item_id = $("input[name=item_id]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/add-item-to-inventory',
          type: 'POST',
          dataType: 'json',
          data: {
            playfab_id: playfab_id,
            item_id: item_id,
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

      $("#btn-get-inventory").on('click', function(){
        $('.inventory-wrapper').html("");
        var playfab_id = $("input[name=playfab_id]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/get-inventory',
          type: 'POST',
          dataType: 'json',
          data: {
            playfab_id: playfab_id,
          },
        })
        .always(function(result) {
          console.log(result);
          $.each(result.data.Inventory, function(index, val) {
             console.log(val);
             $('.inventory-wrapper').append(val.ItemId + " - " + val.DisplayName + " - " + val.ItemInstanceId + "      <i onclick=\"removeInvent('"+val.ItemInstanceId+"')\">Remove</i><br>");
          });
          $('.gold-amount').html(result.data.VirtualCurrency.GD);
          $('.shard-amount').html(result.data.VirtualCurrency.SH);
        });
      });

      function removeInvent(instance_id) {
        var playfab_id = $("input[name=playfab_id]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/revoke-inventory',
          type: 'POST',
          dataType: 'json',
          data: {
            playfab_id: playfab_id,
            item_instance_id: instance_id,
          },
        })
        .always(function(result) {
          console.log(result);
        });
      }

      $("#btn-add-gold").on('click', function(){
        var playfab_id = $("input[name=playfab_id]").val();
        var api_key = $("input[name=lb_api_key]").val();
        var amount = $("input[name=amount]").val();
        console.log('add gold '+amount);
        $.ajax({
          url: '{{ url('/') }}/v1/add-gold',
          type: 'POST',
          dataType: 'json',
          data: {
            playfab_id: playfab_id,
            api_key: api_key,
            amount: amount,
          },
        })
        .always(function(result) {
          console.log(result);
          $('#btn-get-inventory').trigger('click');
        });
        
      });


      $("#btn-substract-shard").on('click', function(){
        var playfab_id = $("input[name=playfab_id]").val();
        var amount = $("input[name=amount]").val();
        console.log('sub shard '+amount);
        $.ajax({
          url: '{{ url('/') }}/v1/substract-shard',
          type: 'POST',
          dataType: 'json',
          data: {
            playfab_id: playfab_id,
            amount: amount,
          },
        })
        .always(function(result) {
          console.log(result);
          $('#btn-get-inventory').trigger('click');
        });
        
      });

      $("#btn-add-tx").on('click', function(){
        var seller = $("input[name=seller]").val();
        var buyer = $("input[name=buyer]").val();
        var tx_id = $("input[name=tx_id]").val();
        var tx_type = $("select[name=tx_type] option:selected").val();
        var amount = $("input[name=tx_amount]").val();
        var currency = $("select[name=currency] option:selected").val();
        var api_key = $("input[name=lb_api_key]").val();
        var custom_param = $("textarea[name=custom_param]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/add-transaction',
          type: 'POST',
          dataType: 'text',
          data: {
            seller: seller,
            buyer: buyer,
            tx_id: tx_id,
            tx_type: tx_type,
            amount: amount,
            currency: currency,
            custom_param: custom_param,
            api_key: api_key,
          },
        })
        .always(function(result) {
          console.log(result);
        });
        
      });

      $("#btn-add-leaderboard").on('click', function(){
        var playfab_id = $("input[name=lb_playfab_id]").val();
        var api_key = $("input[name=lb_api_key]").val();
        var exp_change = $("input[name=lb_exp_change]").val();
        var placement = $("input[name=lb_placement]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/leaderboard/add',
          type: 'POST',
          dataType: 'json',
          data: {
            playfab_id: playfab_id,
            api_key: api_key,
            exp_change: exp_change,
            placement: placement,
          },
        })
        .always(function(result) {
          console.log(result);
        });
        
      });


      $("#btn-get-tx").on('click', function(){
        var tx_type = $("select[name=gtx_tx_type] option:selected").val();
        var start_date = $("input[name=gtx_start]").val();
        var end_date = $("input[name=gtx_end]").val();
        var api_key = $("input[name=lb_api_key]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/get-transaction',
          type: 'POST',
          dataType: 'json',
          data: {
            date_start: start_date,
            date_end: end_date,
            tx_type: tx_type,
            api_key: api_key,
          },
        })
        .always(function(result) {
          console.log(result);
        });
        
      });

      $("#btn-get-tx2").on('click', function(){
        var wallet_pubkey = $("input[name=gtx2_wallet_pubkey]").val();
        var api_key = $("input[name=lb_api_key]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/get-tx-by-wallet',
          type: 'POST',
          dataType: 'json',
          data: {
            wallet_pubkey: wallet_pubkey,
            api_key: api_key,
          },
        })
        .always(function(result) {
          console.log(result);
        });
      });

      $("#btn-get-tx3").on('click', function(){
        var tx_id = $("input[name=gtx3_tx_id]").val();
        var api_key = $("input[name=lb_api_key]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/get-tx-by-id',
          type: 'POST',
          dataType: 'json',
          data: {
            tx_id: tx_id,
            api_key: api_key,
          },
        })
        .always(function(result) {
          console.log(result);
        });
        
      });

    </script>
  </body>
</html>