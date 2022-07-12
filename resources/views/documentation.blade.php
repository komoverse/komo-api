<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>KOMO API Documentation</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://kit.fontawesome.com/b71ce7388c.js" crossorigin="anonymous"></script>

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
      #btn-back-to-top {
            position: fixed;
            bottom: 20px;
            left: 20px;
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
                    {{-- <li><a href="#add-gold">Add Gold</a></li> --}}
                    {{-- <li><a href="#substract-shard">Substract Shard</a></li> --}}
                </ul>
                <b>Leaderboard</b>
                <ul>
                    <li><a href="#add-leaderboard">Add Leaderboard Data</a></li>
                    <li><a href="#get-leaderboard">Get Leaderboard Data</a></li>
                    <li><a href="#add-match-history">Submit Match History</a></li>
                    <li><a href="#get-match-detail-by-id">Get Match Detail By Match ID</a></li>
                    <li><a href="#list-player-match-history">Get List of Match History Per Player</a></li>
                </ul>
                <hr>    
                <h3>Marketplace Related</h3>
                <ul>
                    <li><a href="#get-account-from-username">Get Account Info From Username</a></li>
                    <li><a href="#get-account-from-wallet">Get Account Info From Wallet Pubkey</a></li>
                    <li><a href="#add-transaction">Add Transaction</a></li>
                    <li><a href="#get-transaction">Get Transaction (by Date)</a></li>
                    <li><a href="#get-tx-by-wallet">Get Transaction (by Wallet)</a></li>
                    <li><a href="#get-tx-by-id">Get Transaction ID Detail</a></li>
{{--                     <li><a href="#transaction-count">Get Transaction Count</a></li>
                    <li><a href="#all-total-sales">Get All Total Sales</a></li>
                    <li><a href="#total-sales">Get Total Sales By Currency</a></li> --}}
                </ul>
                <hr>
                <h3>SHARD Payment Gateway (Web2)</h3>
                <ul>
                    <li><a href="#topup-IDR-QRIS">Topup SHARD using IDR via QRIS</a></li>
                    <li><a href="#topup-IDR-VA">Topup SHARD using IDR via Virtual Account</a></li>
                    <li><a href="#topup-USD-paypal">Topup SHARD using USD via Paypal</a></li>
                    <li><a href="#pay-with-shard">Pay With SHARD</a></li>
                </ul>
                <h3>NFT Escrow (Web2)</h3>
                <ul>
                    <li><a href="#escrow-get">Get Escrow NFT for Web2 User</h2></a></li>
                    <li><a href="#escrow-insert">Insert Escrow NFT Data</h2></a></li>
                    <li><a href="#escrow-delete">Delete Escrow NFT Data</h2></a></li>
                    <li><a href="#escrow-sell">Set Escrow NFT to "On Sell"</h2></a></li>
                    <li><a href="#escrow-unsell">Set Escrow NFT to "Owned" / Cancel "On Sell" Status</h2></a></li>
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
                        <td>wallet_pubkey <i>(optional)</i></td>
                        <td>String. Phantom wallet public key.</td>
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
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
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
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
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
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
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
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
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
                {{-- <h2 id="save-shard-tx">Add SHARD Transaction</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/save-shard-tx') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr>
                        <td>description</td>
                        <td>String. Transaction description.</td>
                    </tr>
                    <tr>
                        <td>debit_credit</td>
                        <td>Enum. 
                            <br><i style="color: red">debit</i> to add SHARD
                            <br><i style="color: red">credit</i> to subtract SHARD
                        </td>
                    </tr>
                    <tr>
                        <td>amount_shard</td>
                        <td>Integer. Amount of SHARD to add / subtract.</td>
                    </tr>
                    <tr>
                        <td>tx_status</td>
                        <td>Enum. Transaction status <i style="color:red">success</i>, <i style="color:red">pending</i>, <i style="color:red">failed</i></td>
                    </tr>
                    <tr>
                        <td>custom_param</td>
                        <td>String. Custom Parameter.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON. status and transaction ID
                        </td>
                    </tr>
                </table> --}}
                {{-- <h2 id="update-shard-tx">Add SHARD Transaction</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/update-shard-tx') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr>
                        <td>description</td>
                        <td>String. Transaction description.</td>
                    </tr>
                    <tr>
                        <td>debit_credit</td>
                        <td>Enum. 
                            <br><i style="color: red">debit</i> to add SHARD
                            <br><i style="color: red">credit</i> to subtract SHARD
                        </td>
                    </tr>
                    <tr>
                        <td>amount_shard</td>
                        <td>Integer. Amount of SHARD to add / subtract.</td>
                    </tr>
                    <tr>
                        <td>tx_status</td>
                        <td>Enum. Transaction status <i style="color:red">success</i>, <i style="color:red">pending</i>, <i style="color:red">failed</i></td>
                    </tr>
                    <tr>
                        <td>custom_param</td>
                        <td>String. Custom Parameter.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON. status and transaction ID
                        </td>
                    </tr>
                </table> --}}
                <h2 id="get-shard-tx">Get SHARD Transaction By TX ID</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/get-shard-tx') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_tx_id</td>
                        <td>String. KOMO SHARD Transaction ID.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON Transaction Details
                        </td>
                    </tr>
                </table>
                <h2 id="get-shard-tx-by-username">Get SHARD Transaction By Username</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/sget-shard-tx-by-username') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON Transaction List
                        </td>
                    </tr>
                </table>


                {{-- <h2 id="add-gold">Add Gold</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/add-gold') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
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
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
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
                </table> --}}
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
                            <br>For daily <i style="color:red">yyyy-mm-dd</i> <i>e.g. 2022-06-03</i> (date and month use leading zero)
                            <br>For weekly <i style="color:red">yyyy-ww</i> <i>e.g. 2022-22</i> (week of the year starting monday)
                            <br>For montly <i style="color:red">yyyy-mm</i> <i>e.g. 2022-06</i> (2 digit month use leading zero)
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
                <h2 id="add-match-history">Submit Match History</h2>
                <i style="color:red">Note: This API require 8 submissions for each player or matchmaking server can submit with 8 player data at once.<br><br></i>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/match-history/add') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>match_id</td>
                        <td>String. Match ID. Each player must submit with same Match ID.</td>
                    </tr>
                    <tr>
                        <td>playfab_id</td>
                        <td>String. Playfab ID.</td>
                    </tr>
                    <tr>
                        <td>display_name</td>
                        <td>String. Playfab Display Name.</td>
                    </tr>
                    <tr>
                        <td>placement</td>
                        <td>Integer. Placement rank after match. Only accept number <i style="color:red">1</i> to <i style="color:red">8</i></td>
                    </tr>
                    <tr>
                        <td>player_level <i>(optional)</i></td>
                        <td>String. Player level during match (reserved for ranked matchmaking)</td>
                    </tr>
                    <tr>
                        <td>lineup</td>
                        <td>String. Lineup heroes and star on JSON with following format.
                            <pre>
{ 
    "star*heroes-id": qty, 
}
For Example
{
    "3*eikthyr": 1,
    "3*sakura": 2,
    "2*rogue": 1,
    "1*rogue": 1,
    "1*kuli": 1
}
                            </pre>
                        </td>
                    </tr>
                    <tr>
                        <td>buff_items <i>(optional)</i></td>
                        <td>String. Buff items used during match on JSON with following format.
                            <pre>
{
    "item-id": <i>qty</i>,
}
For Example
{
    "lightning-gloves": 3,
    "wizard-stone": 2
}
                            </pre>
                        </td>
                    </tr>
                    <tr>
                        <td>win <i>(optional)</i></td>
                        <td>Integer. Round win</td>
                    </tr>
                    <tr>
                        <td>lose <i>(optional)</i></td>
                        <td>Integer. Round lose</td>
                    </tr>
                    <tr>
                        <td>heroes_kill <i>(optional)</i></td>
                        <td>Integer. Enemy heroes kill count</td>
                    </tr>
                    <tr>
                        <td>heroes_death <i>(optional)</i></td>
                        <td>Integer. Allied heroes death count</td>
                    </tr>
                    <tr>
                        <td>damage_given <i>(optional)</i></td>
                        <td>Integer. Damage given to enemy heroes</td>
                    </tr>
                    <tr>
                        <td>damage_taken <i>(optional)</i></td>
                        <td>Integer. Damage taken from enemy heroes</td>
                    </tr>
                    <tr>
                        <td>duration <i>(optional)</i></td>
                        <td>String. Duration of survival in <i style="color:red">hh:mm:ss</i> format. e.g. 00:32:15 for 0 hours 32 minutes 15 seconds</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON status of each leaderboard table writing
                    </tr>
                </table>
                <h2 id="list-player-match-history">Get List of Match History Per Player</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/match-history/list') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>playfab_id</td>
                        <td>String. Playfab ID</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON Match History data
                            <br>Match history test preview available <a href="{{ url('match-history') }}">{{ url('match-history') }}</a>
                        </td>
                    </tr>
                </table>
                <h2 id="get-match-detail-by-id">Get Match Detail By Match ID</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/match-history/detail') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>match_id</td>
                        <td>String. Match ID</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON Match History data
                            <br>Match history test preview available <a href="{{ url('match-history') }}">{{ url('match-history') }}</a>
                        </td>
                    </tr>
                </table>
                <br><br>
                <hr>
                <br><br>

                <h2 id="get-account-from-username">Get Account Info From Username</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/account-info/username') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON response contains account info
                        </td>
                    </tr>
                </table>

                <h2 id="get-account-from-wallet">Get Account Info From Wallet Pubkey</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/account-info/wallet') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>wallet_pubkey</td>
                        <td>String. Wallet Public Key.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON response contains account info
                        </td>
                    </tr>
                </table>
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
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
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
                    <tr>
                        <td>amount</td>
                        <td>Float. Amount of transaction made</td>
                    </tr>
                    <tr>
                        <td>currency</td>
                        <td>String. Currency used for transaction (<i style="color:red">SOL</i>, <i style="color:red">KOMO</i>, <i style="color:red">SHARD</i>)</td>
                    </tr>
                    <tr>
                        <td>custom_param <i>(optional)</i></td>
                        <td>String. Custom parameter for any purpose</td>
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
                <h2 id="get-transaction">Get Transaction (by Date)</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/get-transaction') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>tx_type</td>
                        <td>String. Type of transaction ( <i style="color:red">all</i> or <i style="color:red">nft</i> or <i style="color:red">items</i> )</td>
                    </tr>
                    <tr>
                        <td>date_start (optional)</td>
                        <td>String. Starting date of which transaction to be retrieved <i style="color:red">yyyy-mm-dd</i></td>
                    </tr>
                    <tr>
                        <td>date_end (optional)</td>
                        <td>String. Ending date of which transaction to be retrieved <i style="color:red">yyyy-mm-dd</i></td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON response contains number of records, total sales per category, total amount per currency, and transaction details
                        </td>
                    </tr>
                </table>
                <h2 id="get-tx-by-wallet">Get Transaction (by Wallet)</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/get-tx-by-wallet') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>wallet_pubkey <i>(optional)</i></td>
                        <td>String. Phantom wallet public key.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON response contains number of records, position, total sales per category, total amount per currency, and transaction details
                        </td>
                    </tr>
                </table>
                <h2 id="get-tx-by-id">Get Transaction ID Detail</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/get-tx-by-id') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>tx_id</td>
                        <td>String. Transaction ID.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON response contains detail of transaction
                        </td>
                    </tr>
                </table>
                {{--
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
                <h2 id="all-total-sales">Get All Total Sales</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>GET</td>
                        <td>
                            {{ url('v1/total-sales') }}
                        </td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON total amount and currency
                        </td>
                    </tr>
                </table>
                <h2 id="total-sales">Get Total Sales By Currency</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>GET</td>
                        <td>
                            {{ url('v1/sales/SOL') }}<br>
                            {{ url('v1/sales/KOMO') }}<br>
                            {{ url('v1/sales/USD') }}<br>
                            {{ url('v1/sales/IDR') }}
                        </td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Float. Total Amount of Sales by the Currency
                        </td>
                    </tr>
                </table> --}}


                <br><br>
                <hr>
                <br><br>


                <h2 id="topup-IDR-QRIS">Topup SHARD using IDR via QRIS</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/topup-shard/idr/qris') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr>
                        <td>amount_shard</td>
                        <td>Integer. Amount of SHARD.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON response status and QRIS URL<br>
                            <code>{status: 'success', currency: 'IDR', price: 1000, via: 'QRIS', qris_url: 'https://pg_endpoint/accounts/6d7...a7/requests/58f...0521/qr'}</code>
                        </td>
                    </tr>
                </table>

                <h2 id="topup-IDR-VA">Topup SHARD using IDR via Virtual Account (VA)</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/topup-shard/idr/va') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr>
                        <td>amount_shard</td>
                        <td>Integer. Amount of SHARD.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON response status and bank VA details<br>
                            <code>{
    "status": "success",
    "currency": "IDR",
    "price": 1000,
    "via": "VA",
    "bank_id": "demo",
    "address_name": "KMDO Komodo Partners",
    "va_number": "900....70"
}</code>
                        </td>
                    </tr>
                </table>

                <h2 id="topup-USD-paypal">Topup SHARD using USD via Paypal</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/topup-shard/usd/paypal') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr>
                        <td>amount_shard</td>
                        <td>Integer. Amount of SHARD.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON response status and paypal checkout link<br>
                            <code>{
    "status": "success",
    "currency": "USD",
    "price": 0.1,
    "via": "Paypal",
    "payment_link": "https://www.paypal.com/checkoutnow?token=XXXXXXXXXXXXX"
}</code>
                        </td>
                    </tr>
                </table>

                <h2 id="pay-with-shard">Pay With SHARD</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/pay-with-shard') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr>
                        <td>amount_shard</td>
                        <td>Integer. Amount of SHARD.</td>
                    </tr>
                    <tr>
                        <td>custom_param <i>(optional)</i></td>
                        <td>String. Custom parameter for any purpose</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON response status
                        </td>
                    </tr>
                </table>

                <br><br>
                <hr>
                <br><br>


                <h2 id="escrow-get">Get Escrow NFT for Web2 User</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/escrow-nft/get') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON list of NFTs owned by given KOMO username
                        </td>
                    </tr>
                </table>

                <h2 id="escrow-insert">Insert Escrow NFT Data</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/escrow-nft/insert') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr>
                        <td>nft_id</td>
                        <td>String. NFT ID.</td>
                    </tr>
                    <tr>
                        <td>escrow_wallet</td>
                        <td>String. Company Solana Wallet Pubkey for Escrow.</td>
                    </tr>
                    <tr>
                        <td>solana_tx_signature</td>
                        <td>String. Transaction Signature Hash.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON status
                        </td>
                    </tr>
                </table>
                <h2 id="escrow-delete">Delete Escrow NFT Data</h2>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/escrow-nft/delete') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr>
                        <td>nft_id</td>
                        <td>String. NFT ID.</td>
                    </tr>
                    <tr>
                        <td>solana_tx_signature</td>
                        <td>String. Transaction Signature Hash.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON status
                        </td>
                    </tr>
                </table>
                
                <h2 id="escrow-sell">Set Escrow NFT to "On Sell"</h2>
                <i style="color:red">This only set escrow status to on sell. For adding into marketplace please refer to <a href="#add-transaction">Add Transaction</a></i>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/escrow-nft/sell') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr>
                        <td>nft_id</td>
                        <td>String. NFT ID.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON status and NFT ownership data
                        </td>
                    </tr>
                </table>
                
                <h2 id="escrow-unsell">Set Escrow NFT to "Owned" / Cancel "On Sell" Status</h2>
                <i style="color:red">This only set escrow status to on sell. For adding into marketplace please refer to <a href="#add-transaction">Add Transaction</a></i>
                <table class="table table-bordered table-sm">
                    <tr class="endpoint">
                        <td>POST</td>
                        <td>{{ url('v1/escrow-nft/unsell') }}</td>
                    </tr>
                    <tr class="request">
                        <td colspan="2">Request</td>
                    </tr>
                    <tr>
                        <td>api_key</td>
                        <td>String. API Key for authentication.</td>
                    </tr>
                    <tr>
                        <td>komo_username</td>
                        <td>String. KOMO Username.</td>
                    </tr>
                    <tr>
                        <td>nft_id</td>
                        <td>String. NFT ID.</td>
                    </tr>
                    <tr class="response">
                        <td colspan="2">Response</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            JSON status and NFT ownership data
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-danger btn-floating btn-lg" id="btn-back-to-top">
    <i class="fas fa-arrow-up"></i>
    </button>
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    $('#btn-back-to-top').on('click', function(){
       $("html, body").animate({ scrollTop: 0 }, "slow");
  return false;
    });
</script>
  </body>
</html>