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
        color: lime;
        font-weight: bold;
        text-shadow: 0 0 5px black;
        -webkit-text-stroke-width: 0.2px;
        -webkit-text-stroke-color: black;
      }
  </style>
  <body>

    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-12 col-lg-2 border-end min-vh-100 p-3">
                <img src="https://komoverse.io/assets/img/logo.webp" alt="">
                <span class="api">API Documentation</span>
                <br>
                <b>Table of Contents</b>
                <ul>
                    <li><a href="#register">Register</a></li>
                    <li><a href="#login">Login</a></li>
                    <li><a href="#get-account-info">Get Account Info</a></li>
                    <li><a href="#change-password">Change Password</a></li>
                    <li><a href="#change-display-name">Change Display Name</a></li>
                    <li><a href="#add-item-to-inventory">Add Item to Inventory</a></li>
                    <li><a href="#get-inventory">Get Player Inventory</a></li>
                    <li></li>
                </ul>
            </div>
            <div class="col-12 col-lg-10 p-3">
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
            </div>
        </div>
    </div><!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>