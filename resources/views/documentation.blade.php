<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>KOMO API Documentation</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>
  <style>
      .endpoint {
        background: navy;
        color: white;
        font-weight: bold;
      }
      .endpoint td {
        font-size: 18px;
      }
      .request, .response {
        background: skyblue;
      }
      .table {
        outline-color: navy;
        outline-width: 2px;
        outline-style: solid;
      }
      a {
        font-weight: bold;
        color: navy;
        text-decoration: none;
      }
      img {
        max-width: 100%;
      }
    .api {
        position: absolute;
        top: 80px;
        left: 35px;
        color: white;
        font-weight: bold;
        text-shadow: 0 0 5px black;
        -webkit-text-stroke-width: 0.2px;
        -webkit-text-stroke-color: black;
      }
  </style>
  <body>

    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-12 col-lg-3 border-end min-vh-100 p-3">
                <img src="https://komoverse.io/assets/img/logo.webp" width="190px" alt="">
                <span class="api">API Documentation</span>
                <br>
                <b>Table of Contents</b><br>
                    <h3>Game Related</h3>
                    <b>Account Management</b>
                <ul>
                    <li><a href="#register">Register</a></li>
                    <li><a href="#login">Login</a></li>
                    <li><a href="#get-all-players">Get All Players</a></li>
                    <li><a href="#get-account-info">Get Account Info</a></li>
                    <li><a href="#change-password">Change Password</a></li>
                    <li><a href="#change-display-name">Change Display Name</a></li>
                </ul>
                <b>Inventory & Economics</b>
                <ul>
                    <li><a href="#add-item-to-inventory">Add Item to Inventory</a></li>
                    <li><a href="#get-inventory">Get Player Inventory</a></li>
                    <li><a href="#revoke-inventory">Revoke Inventory Item</a></li>
                    <li><a href="#add-gold">Add Gold</a></li>
                    <li><a href="#substract-shard">Substract Shard</a></li>
                </ul>
                <b>Leaderboard</b>
                <ul>
                    <li><a href="#add-leaderboard">Add Leaderboard Data</a></li>
                    <li><a href="#get-leaderboard">Get Leaderboard Data</a></li>
                </ul>
                <hr>    
                <h3>Marketplace Related</h3>
                <ul>
                    <li><a href="#add-transaction">Add Transaction</a></li>
                    <li><a href="#transaction-count">Get Transaction Count</a></li>
                </ul>
            </div>
            <div class="col-12 col-lg-9 p-3">
                <h2 id="register">Register</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/register') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. Username for KOMO Account.</td>
                    </tr>
                    <tr>
                        <td>password</td>
                        <td>String. Password for KOMO Account.</td>
                    </tr>
                    <tr>
                        <td>email</td>
                        <td>String. Email address.</td>
                    </tr>
                    <tr>
                        <td>wallet_pubkey</td>
                        <td>(Optional) String. Phantom wallet public key.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">status: Username Taken, Registration Success, Registration Failed</td>
                    </tr>
                </table>


                <h2 id="login">Login</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/login') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. Username for KOMO Account.</td>
                    </tr>
                    <tr>
                        <td>password</td>
                        <td>String. Password for KOMO Account.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            if login success: 
                            <br>Playfab LoginWithCustomId response
                            <br><br>if login failed: <br>
                            status: KOMO Username Not Found, Wrong KOMO Password, Connection to Playfab Failed
                        </td>
                    </tr>
                </table>


                <h2 id="get-all-players">Get All Players</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>GET</td>
                        <td>{{ url('v1/player-list') }}</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON list of all player from KOMO Database
                        </td>
                    </tr>
                </table>

                <h2 id="get-account-info">Get Account Info</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/get-account-info') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>playfab_id</td>
                        <td>String. Playfab ID.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Playfab Account Info
                        </td>
                    </tr>
                </table>

                <h2 id="change-password">Change Password</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/change-password') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr>
                        <td>old_password</td>
                        <td>String. Old password.</td>
                    </tr>
                    <tr>
                        <td>new_password</td>
                        <td>String. New password.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            status: New Password Set, Failed to set new password, Old password not match with database
                        </td>
                    </tr>
                </table>

                <h2 id="change-display-name">Change Display Name</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/change-display-name') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>playfab_id</td>
                        <td>String. Playfab ID.</td>
                    </tr>
                    <tr>
                        <td>display_name</td>
                        <td>String. New display name to use in the game.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            status: Change Success, Change Failed
                            <br>
                            display_name: New Display Name
                        </td>
                    </tr>
                </table>


                <h2 id="add-item-to-inventory">Add Item To Inventory</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/add-item-to-inventory') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>playfab_id</td>
                        <td>String. Playfab ID.</td>
                    </tr>
                    <tr>
                        <td>item_id</td>
                        <td>String. Item ID as in Playfab.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON playfab response
                        </td>
                    </tr>
                </table>
                <h2 id="get-inventory">Get Player Inventory</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/get-inventory') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>playfab_id</td>
                        <td>String. Playfab ID.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON playfab response
                        </td>
                    </tr>
                </table>
                <h2 id="revoke-inventory">Revoke Inventory</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/revoke-inventory') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>item_instance_id</td>
                        <td>String. Item Instance ID.</td>
                    </tr>
                    <tr>
                        <td>playfab_id</td>
                        <td>String. Playfab ID.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON playfab response
                        </td>
                    </tr>
                </table>
                <h2 id="add-gold">Add Gold</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/add-gold') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>amount</td>
                        <td>Integer. Amount of Gold to be Added.</td>
                    </tr>
                    <tr>
                        <td>playfab_id</td>
                        <td>String. Playfab ID.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON playfab response
                        </td>
                    </tr>
                </table>
                <h2 id="substract-shard">Substract Shard</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/substract-shard') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>amount</td>
                        <td>Integer. Amount of Shard to be Substrac.t</td>
                    </tr>
                    <tr>
                        <td>playfab_id</td>
                        <td>String. Playfab ID.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON playfab response
                        </td>
                    </tr>
                </table>
                <h2 id="add-leaderboard">Add Leaderboard Data</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/leaderboard/add') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>playfab_id</td>
                        <td>String. Playfab ID.</td>
                    </tr>
                    <tr>
                        <td>exp_change</td>
                        <td>Integer. Number of EXP changed (negative value accepted to reduce EXP).</td>
                    </tr>
                    <tr>
                        <td>placement</td>
                        <td>Integer. Placement rank after match. Only accept number <i style="color:red">1</i> to <i style="color:red">8</i></td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON status of each leaderboard table writing
                    </tr>
                </table>
                <h2 id="get-leaderboard">Get Leaderboard Data</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/leaderboard/get') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>type</td>
                        <td>String. <i style="color:red">daily</i>, <i style="color:red">weekly</i>, <i style="color:red">monthly</i>, <i style="color:red">lifetime</i></td>
                    </tr>
                    <tr>
                        <td>parameter</td>
                        <td>String. 
                            <br>For daily <i style="color:red">yyyy_mm_dd</i> <i>e.g. 2022-06-03</i> (date and month use leading zero)
                            <br>For weekly <i style="color:red">yyyy_ww</i> <i>e.g. 2022-22</i> (week of the year starting monday)
                            <br>For montly <i style="color:red">yyyy_mm</i> <i>e.g. 2022-06</i> (2 digit month use leading zero)
                            <br>For lifetime <i style="color:red">no parameter required</i></td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON leaderboard data
                            <br>Leaderboard test preview available <a href="{{ url('leaderboard') }}">{{ url('leaderboard') }}</a>
                        </td>
                    </tr>
                </table>
                <br><br>
                <hr>
                <br><br>
                <h2 id="add-transaction">Add Transaction</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/add-transaction') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>seller</td>
                        <td>String. Seller Wallet Public Key</td>
                    </tr>
                    <tr>
                        <td>buyer</td>
                        <td>String. Buyer Wallet Public Key</td>
                    </tr>
                    <tr>
                        <td>tx_id</td>
                        <td>String. Transaction ID</td>
                    </tr>
                    <tr>
                        <td>tx_type</td>
                        <td>String. Type of transaction ( <i style="color:red">nft</i> or <i style="color:red">items</i> )</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON status response
                        </td>
                    </tr>
                </table>
                <h2 id="transaction-count">Get Transaction Count</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>GET</td>
                        <td>
                            {{ url('v1/transaction/all') }}<br>
                            {{ url('v1/transaction/nft') }}<br>
                            {{ url('v1/transaction/items') }}
                        </td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Integer. Count of transaction history.
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div><!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>