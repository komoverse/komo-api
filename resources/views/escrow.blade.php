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

    <input type="text" name="lb_api_key">
    <input type="text" value="Aviabee" name="komo_username">
    <input type="text" value="KomouQBYhxdtAjfPDVLRCfDZ4fsQcBNVEn9eKacj7Ed" name="escrow_wallet">
    <input type="text" value="6D7rpquubY2JYa181SfxAMdPML5fbx8ukbAXfq6nfVtx" name="nft_id">
    <input type="text" name="solana_tx_signature" value="4BpGFdY4yYo3c9jwNEeFK8ZXkR7tupjzeDoD687jmo5sUbF5vskW8Bzof29SmAdAiPv1EqCh76MByd2weKcQsSV6">
    <button class="btn btn-success" id="btn-insert">Insert Escrow</button>
    <button class="btn btn-danger" id="btn-delete">Delete Escrow</button>

    <button class="btn btn-info" id="btn-get">Get Escrow NFT</button>

    <br>
    <button class="btn btn-outline-danger" id="btn-sell">Sell NFT</button>
    <button class="btn btn-outline-warning" id="btn-unsell">UnSell NFT</button>

    <span class="showajax"></span>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>

      $("#btn-get").on('click', function(){
      var komo_username = $("input[name=komo_username]").val();
      var api_key = $("input[name=lb_api_key]").val();
      var nft_id = $("input[name=nft_id]").val();
      var escrow_wallet = $("input[name=escrow_wallet]").val();
      var solana_tx_signature = $("input[name=solana_tx_signature]").val();
        $.ajax({
          url: '{{ url('/') }}/v1/escrow-nft/get',
          type: 'POST',
          dataType: 'json',
          data: {
            komo_username: komo_username,
            api_key: api_key,
          },
        })
        .always(function(result) {
          console.log(result);
        });
      });

      $("#btn-insert").on('click', function(){
      var komo_username = $("input[name=komo_username]").val();
      var api_key = $("input[name=lb_api_key]").val();
      var nft_id = $("input[name=nft_id]").val();
      var escrow_wallet = $("input[name=escrow_wallet]").val();
      var solana_tx_signature = $("input[name=solana_tx_signature]").val();
        console.log(api_key);
        $.ajax({
          url: '{{ url('/') }}/v1/escrow-nft/insert',
          type: 'POST',
          dataType: 'json',
          data: {
            komo_username: komo_username,
            api_key: api_key,
            nft_id: nft_id,
            escrow_wallet: escrow_wallet,
            solana_tx_signature: solana_tx_signature,
          },
        })
        .always(function(result) {
          console.log(result);
        });
      });

      $("#btn-delete").on('click', function(){
      var komo_username = $("input[name=komo_username]").val();
      var api_key = $("input[name=lb_api_key]").val();
      var nft_id = $("input[name=nft_id]").val();
      var escrow_wallet = $("input[name=escrow_wallet]").val();
      var solana_tx_signature = $("input[name=solana_tx_signature]").val();
        console.log(api_key);
        $.ajax({
          url: '{{ url('/') }}/v1/escrow-nft/delete',
          type: 'POST',
          dataType: 'json',
          data: {
            komo_username: komo_username,
            api_key: api_key,
            nft_id: nft_id,
            escrow_wallet: escrow_wallet,
            solana_tx_signature: solana_tx_signature,
          },
        })
        .always(function(result) {
          console.log(result);
        });
      });

      $("#btn-sell").on('click', function(){
      var komo_username = $("input[name=komo_username]").val();
      var api_key = $("input[name=lb_api_key]").val();
      var nft_id = $("input[name=nft_id]").val();
      var escrow_wallet = $("input[name=escrow_wallet]").val();
      var solana_tx_signature = $("input[name=solana_tx_signature]").val();
        console.log(api_key);
        $.ajax({
          url: '{{ url('/') }}/v1/escrow-nft/sell',
          type: 'POST',
          dataType: 'json',
          data: {
            komo_username: komo_username,
            api_key: api_key,
            nft_id: nft_id,
            escrow_wallet: escrow_wallet,
            solana_tx_signature: solana_tx_signature,
          },
        })
        .always(function(result) {
          console.log(result);
        });
      });

      $("#btn-unsell").on('click', function(){
      var komo_username = $("input[name=komo_username]").val();
      var api_key = $("input[name=lb_api_key]").val();
      var nft_id = $("input[name=nft_id]").val();
      var escrow_wallet = $("input[name=escrow_wallet]").val();
      var solana_tx_signature = $("input[name=solana_tx_signature]").val();
        console.log(api_key);
        $.ajax({
          url: '{{ url('/') }}/v1/escrow-nft/unsell',
          type: 'POST',
          dataType: 'json',
          data: {
            komo_username: komo_username,
            api_key: api_key,
            nft_id: nft_id,
            escrow_wallet: escrow_wallet,
            solana_tx_signature: solana_tx_signature,
          },
        })
        .always(function(result) {
          console.log(result);
        });
      });


    </script>
  </body>
</html>