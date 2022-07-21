<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\APIModel;

class APIController extends Controller
{
    protected $TitleId;
    protected $SecretKey;
    protected $pg_api_key;
    protected $pg_account_id;
    protected $pg_endpoint;
    protected $pg_header;
    protected $pg_bank_id;

    public function __construct() 
    {
        $this->TitleId = config('playfab.titleId');
        $this->SecretKey = config('playfab.secretKey');
        $this->pg_api_key = config('payment_gateway.pg_api_key');
        $this->pg_account_id = config('payment_gateway.pg_account_id');
        $this->pg_endpoint = config('payment_gateway.pg_endpoint');
        $this->pg_bank_id = config('payment_gateway.pg_bank_id');
        $this->pg_header = 'Authorization: Bearer '.config('payment_gateway.pg_api_key');
    }

    function curlPlayfab($endpoint, $header, $data) {
        $url = "https://".$this->TitleId.".playfabapi.com/".$endpoint;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $send_header = array('Content-Type: application/json');
        if (isset($header)) {
            array_push($send_header, $header);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $send_header);

        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response);
        return $result;
    }

    function curlPOST($url, $header, $data) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $send_header = array('Content-Type: application/json');
        if (isset($header)) {
            array_push($send_header, $header);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $send_header);

        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response);
        return $result;
    }

    function curlGET($url, $header) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $send_header = array('Content-Type: application/json');
        if (isset($header)) {
            array_push($send_header, $header);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $send_header);

        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response);
        return $result;
    }

    function loginWithCustomID($komo_username) {
        $data = [
            "TitleId" => $this->TitleId,
            "CreateAccount" => false,
            "CustomId" => $komo_username,
        ];

        $result = $this->curlPlayfab("Client/LoginWithCustomID", "", $data);

        return $result;
    }

    function registerPlayfabUser($komo_username) {
        $data = [
            "TitleId" => $this->TitleId,
            "CreateAccount" => true,
            "CustomId" => $komo_username,
        ];
        $result = $this->curlPlayfab("Client/LoginWithCustomID", "", $data);
        return $result;
    }

    // function showClientPLayfabInfo() {
    //     $data = [
    //         "PlayFabId" => Session::get('PlayFabId'),
    //         "ProfileConstraints" => [
    //             "ShowAvatarUrl" => true,
    //             "ShowDisplayName" => true,
    //         ],
    //     ];
    //     $result = $this->curlPlayfab("Client/GetAccountInfo", "X-Authorization: ".Session::get('SessionTicket'), $data);
    //     return view('dashboard')->with((array) $result);
    // }

    function changeDisplayName(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            $data = [
                "PlayFabId" => $req->playfab_id,
                "DisplayName" => $req->display_name,
            ];
            $result = $this->curlPlayfab("Admin/UpdateUserTitleDisplayName", "X-SecretKey: ".$this->SecretKey, $data);
            if ($result) {
                $response = [
                    "status" => "Change Success",
                    "display_name" => $result->data->DisplayName,
                ];
                APIModel::changeDBDisplayName($req);
            } else {
                $response = [
                    "status" => "Change Failed",
                ];
            }
            echo json_encode($response);
            exit;
        } catch (Exception $e) {
            echo json_encode($e);
            exit;
        }
    }

    function setInitialDisplayName($session_ticket, $display_name) {
        $looper = true;
        $init_display_name = $display_name;
        $counter = 0;
        while ($looper == true) {
            if ($counter > 0) {
                $try_display_name = $init_display_name.$counter;
            } else {
                $try_display_name = $init_display_name;
            }
            $data = [
                "DisplayName" => $try_display_name,
            ];
            $exec_display_name = $this->curlPlayfab("Client/UpdateUserTitleDisplayName", "X-Authorization: ".$session_ticket, $data);
            if ($exec_display_name->code == 400) {
                $counter++;
            } else {
                $looper = false;
            }
        }
        return $try_display_name;
    }

    function setMapID($playfab_id, $map_id) {
         try {
            $data = [
                "PlayFabId" => $playfab_id,
                "Data" => [
                    "Map ID" => $map_id,
                ],
                "Permission" => "Public",
            ];
            $result = $this->curlPlayfab("Admin/UpdateUserData", "X-SecretKey: ".$this->SecretKey, $data);
            if ($result) {
                $response = [
                    "status" => "Change Success",
                    "map_id" => $map_id,
                ];
            } else {
                $response = [
                    "status" => "Change Failed",
                ];
            }
        } catch (Exception $e) {
            echo json_encode($e);
            exit;
        }
    }

    function register(Request $req) {
        try {
            // Check existing KOMO account
            if (APIModel::getUserFromUsername($req->komo_username)) {
                $response = [
                    'status' => 'error',
                    'message' => 'Username Taken',
                ];
            } else {
                // Register PLayfab
                if ($playfab = $this->registerPlayfabUser($req->komo_username)) {
                    $playfab_id = $playfab->data->PlayFabId;
                    $session_ticket = $playfab->data->SessionTicket;
                    // Set Initial Display Name and Map ID
                    $display_name = $this->setInitialDisplayName($session_ticket, $req->komo_username);
                    $map_id = $this->setMapID($playfab_id, "Paragon");

                    // Save to KOMO Database
                    if (APIModel::registerKOMO($req, $playfab_id, $display_name)) {
                        $response = [
                            'status' => 'success',
                            'message' => 'Registration Success',
                        ];
                    } else {
                        $response = [
                            'status' => 'error',
                            'message' => 'Registration Failed',
                        ];
                    }
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Error creating playfab account',
                    ];
                }
            }
            // Return registration result
            echo json_encode($response);
            exit;

        } catch (Exception $e) {
            echo json_encode($e);   
            exit;
        }
    }

    function login(Request $req) {
        try {
            $userdata = APIModel::getUserFromUsername($req->komo_username);
            if ($userdata) {
                if ($userdata->password == md5($req->password.$userdata->salt)) {
                    // Save login location
                    $ipgeo = file_get_contents("https://api.iplocation.net/?ip=".$req->ip());
                    if ($ipgeo) {
                        APIModel::saveLoginInfo($req, $ipgeo);
                    }

                    // Login to PlayFab
                    $playfab = $this->loginWithCustomID($req->komo_username);
                    if ($playfab) {
                        echo json_encode($playfab);
                    } else {
                        $response = [
                            'status' => 'Connection to Playfab Failed',
                        ];
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response = [
                        'status' => 'Wrong KOMO Password',
                    ];
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response = [
                    'status' => 'KOMO Username Not Found',
                ];
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            echo json_encode($e);
            exit;
        }
    }

    function getAccountInfo(Request $req) {
        try {
            $data = [
                "PlayFabId" => $req->playfab_id,
            ];
            $result = $this->curlPlayfab("Admin/GetUserAccountInfo", "X-SecretKey: ".$this->SecretKey, $data);
            echo json_encode($result);
            exit;
        } catch (Exception $e) {
            echo json_encode($e);
            exit;
        }
    }

    function addItemToInventory(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            $data = [
                "ItemIds" => array($req->item_id),
                "PlayFabId" => $req->playfab_id,
            ];
            $result = $this->curlPlayfab("Server/GrantItemsToUser", "X-SecretKey: ".$this->SecretKey, $data);
            echo json_encode($result);
            exit;
        } catch (Exception $e) {
            echo json_encode($e);
            exit;
        }
    }

    function changeKOMOPassword(Request $req) {
        $this->verifyAPIKey($req->api_key);
        $userdata = APIModel::getUserFromUsername($req->komo_username);
        if (md5($req->old_password.$userdata->salt) == $userdata->password) {
            if (APIModel::setNewPassword($req, $userdata->salt)) {
                $result = [
                    'status' => 'New Password Set',
                ];
                echo json_encode($result);
                exit;
            } else {
                $result = [
                    'status' => 'Failed to set new password',
                ];
                echo json_encode($result);
                exit;
            }
        } else {
            $result = [
                'status' => 'Old password not match with database',
            ];
            echo json_encode($result);
            exit;
        }
    }

    function getInventory(Request $req) {
        $data = [
            'PlayFabId' => $req->playfab_id,
        ];
        $result = $this->curlPlayfab("Server/GetUserInventory", "X-SecretKey: ".$this->SecretKey, $data);
        echo json_encode($result);
    }

    function revokeInventory(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            $data = [
                'ItemInstanceId' => $req->item_instance_id,
                'PlayFabId' => $req->playfab_id,
            ];
            $result = $this->curlPlayfab("Server/RevokeInventoryItem", "X-SecretKey: ".$this->SecretKey, $data);
            echo json_encode($result);
            exit;
        } catch (Exception $e) {
            echo json_encode($e);
            exit;
        }
    }

    function addGold(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            $data = [
                'Amount' => $req->amount,
                'PlayFabId' => $req->playfab_id,
                'VirtualCurrency' => 'GD',
            ];
            $result = $this->curlPlayfab("Server/AddUserVirtualCurrency", "X-SecretKey: ".$this->SecretKey, $data);
            echo json_encode($result);
            exit;
        } catch (Exception $e) {
            echo json_encode($e);
            exit;
        }
    }

    function substractShard(Request $req) {
        try {
            $data = [
                'Amount' => $req->amount,
                'PlayFabId' => $req->playfab_id,
                'VirtualCurrency' => 'SH',
            ];
            $result = $this->curlPlayfab("Server/SubtractUserVirtualCurrency", "X-SecretKey: ".$this->SecretKey, $data);
            echo json_encode($result);
            exit;
        } catch (Exception $e) {
            echo json_encode($e);
            exit;
        }
    }

    function getAllPlayer() {
        try {
            echo json_encode(APIModel::getAllPlayer());
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function addTransaction(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            $currencies = array("SOL", "KOMO", "USD", "IDR");
            if (!in_array(strtoupper($req->currency), $currencies)) {

                $response = [
                    'status' => 'unknown currency',
                ];
            } else {
                if (APIModel::addTransaction($req)) {
                    $response = [
                        'status' => 'add transaction success',
                    ];
                } else {
                    $response = [
                        'status' => 'add transaction failed',
                    ];
                }
            }
            echo json_encode($response);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getNFTTransactionCount() {
        echo APIModel::getNFTTransactionCount();
    }

    function getItemsTransactionCount() {
        echo APIModel::getItemsTransactionCount();
    }

    function getAllTransactionCount() {
        echo APIModel::getAllTransactionCount();
    }

    function getTotalSalesByCurrency(Request $req) {
        echo APIModel::getTotalSalesByCurrency($req->currency);
    }

    function getAllTotalSales() {
        echo json_encode(APIModel::getAllTotalSales());
    }

    function addToLeaderboard(Request $req) {
        $this->verifyAPIKey($req->api_key);
        $daily = "failed";
        $weekly = "failed";
        $monthly = "failed";
        $lifetime = "failed";
        $verify_api_key = APIModel::authorizeAPIKey($req->api_key);
        try {
            if (($req->placement < 1) || ($req->placement > 8)) {
                $response = [
                    'status' => 'Placement value is not valid. 1-8 only'
                ];
                echo json_encode($response);
                exit;
            }
            if (APIModel::saveDailyLeaderboard($req)) {
                $daily = "success";
            }
            if (APIModel::saveWeeklyLeaderboard($req)) {
                $weekly = "success";
            }
            if (APIModel::saveMonthlyLeaderboard($req)) {
                $monthly = "success";
            }
            if (APIModel::saveLifetimeLeaderboard($req)) {
                $lifetime = "success";
            }
            $response = [
                'write.daily' => $daily,
                'write.weekly' => $weekly,
                'write.monthly' => $monthly,
                'write.lifetime' => $lifetime,
            ];

            echo json_encode($response);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getLeaderboard(Request $req) {
        try {
            $response = APIModel::getLeaderboard($req);
            if ($response) {
                echo json_encode($response);
            } else {
                $status = [
                    'status' => 'No Leaderboard Data for This Period',
                ];
                echo json_encode($status);
            }
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function verifyAPIKey($api_key) {
        $verify_api_key = APIModel::authorizeAPIKey($api_key);
        if (!$verify_api_key) {
            $status = ['status' => 'API Key Not Found'];
            echo json_encode($status);
            exit;
        }
    }

    function addMatchHistory(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            if (APIModel::submitMatchHistory($req)) {
                $data = [
                    'status' => 'success'
                ];
                echo json_encode($data);
            } else {
                $data = [
                    'status' => 'failed'
                ];
                echo json_encode($data);
            }
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function listMatchHistory(Request $req) {
        try {
            echo json_encode(APIModel::getMatchListByPlayer($req->playfab_id));
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }
    
    function getMatchDetail(Request $req) {
        try {
            echo json_encode(APIModel::getMatchDetailByID($req->match_id));
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getTransactionByDate(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            $tx_data = APIModel::getTransactionByDate($req);
            $sum_data = APIModel::getTransactionSumByDate($req);
            $sum_data_array = [];                
            foreach ($sum_data as $row) {
                $sum_data_array[$row->currency] = $row->total_amount;                
            }
            $type_data = APIModel::getTransactionTypeByDate($req);
            $type_data_array = [];                
            foreach ($type_data as $row) {
                $type_data_array[$row->tx_type] = $row->total_type;                
            }
            $data = [
                'records' => count($tx_data),
                'sum_amount' => $sum_data_array,
                'types' => $type_data_array,
                'transactions' => $tx_data,
            ];
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getTransactionByTxID(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            echo json_encode(APIModel::getTransactionByTxID($req->tx_id));
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getTransactionByWallet(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            $tx_data = APIModel::getTransactionByWallet($req);
            $sum_data = APIModel::getTransactionSumByWallet($req);
            $sum_data_array = [];
            $as_buyer = 0; $as_seller = 0;
            foreach ($tx_data as $row) {
                if ($row->buyer == $req->wallet_pubkey) {
                    $as_buyer++;             
                } else {
                    $as_seller++;
                }
            }
            foreach ($sum_data as $row) {
                $sum_data_array[$row->currency] = $row->total_amount;
            }
            $type_data = APIModel::getTransactionTypeByWallet($req);
            $type_data_array = [];                
            foreach ($type_data as $row) {
                $type_data_array[$row->tx_type] = $row->total_type;                
            }
            $data = [
                'records' => count($tx_data),
                'sum_amount' => $sum_data_array,
                'types' => $type_data_array,
                'position' => [
                    'seller' => $as_seller,
                    'buyer' => $as_buyer,
                ],
                'transactions' => $tx_data,
            ];
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getKOMOAccountInfoByUsername(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            echo json_encode(APIModel::getKOMOAccountInfoByUsername($req->komo_username));
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getKOMOAccountInfoByWallet(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            echo json_encode(APIModel::getKOMOAccountInfoByWallet($req->wallet_pubkey));
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getKOMOAccountInfoByEmail(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            echo json_encode(APIModel::getKOMOAccountInfoByEmail($req->email));
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getKOMOAccountInfoByFind(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            echo json_encode(APIModel::getKOMOAccountInfoByFind($req->find_query));
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function addShardTransaction(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            $komo_tx_id = strtoupper(md5($req->username.uniqid()));
            if (APIModel::saveShardTransaction($req, $komo_tx_id)) {
                $status = [
                    'status' => 'success',
                    'komo_tx_id' => $komo_tx_id,
                ];
                echo json_encode($status);
            } else {
                $status = [
                    'status' => 'error',
                ];
                echo json_encode($status);
            }
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getShardTransaction(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            echo json_encode(APIModel::getShardTransaction($req->komo_tx_id));
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getShardTransactionByUsername(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            echo json_encode(APIModel::getShardTransactionByUsername($req->komo_username));
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function updateShardTX(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            if (APIModel::updateShardTX($req)) {
                $tx_data = APIModel::getShardTransaction($req->komo_tx_id);
                if ($tx_data->debit_credit == 'debit') {
                    if (APIModel::addAccountShard($tx_data->komo_username, $tx_data->amount_shard)) {
                    	$data = [
                        	'status' => 'Add SHARD Success',
                    	];
                    } else {
                        $data = [
                        	'status' => 'Add SHARD Failed',
                    	];
                    }
                } else {
                    if (APIModel::subtractAccountShard($tx_data->komo_username, $tx_data->amount_shard)) {
                        $data = [
                        	'status' => 'Subtract SHARD Success',
                    	];
                    } else {
                        $data = [
                        	'status' => 'Subtract SHARD Failed',
                    	];
                    }
                }
            } else {
                        $data = [
                        	'status' => 'Transaction Not Updated',
                    	];
            }
        	echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function submitCallback(Request $req) {
        try {
            if (APIModel::submitCallback($req)) {
                $data = [
                    'status' => 'success',
                ];
            } else {
                $data = [
                    'status' => 'failed',
                ];
            }
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function topupShardIDRQRIS(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            // Setup TX ID and exchange
            $komo_tx_id = strtoupper(md5($req->username.uniqid()));
            $price = (int) $req->amount_shard * 100;

            // Make QRIS Request
            $data = [
                'type' => 'qris',
                'amount' => $price,
            ];
            $url = $this->pg_endpoint.'/accounts/'.$this->pg_account_id.'/deposits/requests';
            $pg_data = $this->curlPOST($url, $this->pg_header, $data);

            // Get QRIS URL
            $qris_url = $this->pg_endpoint.'/accounts/'.$this->pg_account_id.'/deposits/requests/'.$pg_data->id.'/qr';

            // save to DB
            $txdata = [
                'komo_tx_id' => $komo_tx_id,
                'komo_username' => $req->komo_username,
                'description' => 'Topup '.$req->amount_shard.' SHARD via IDR (QRIS)',
                'debit_credit' => 'debit',
                'amount_shard' => $req->amount_shard,
                'tx_status' => 'pending',
                'custom_param' => json_encode($pg_data),
                'tx_source' => $req->api_key,
            ];
            if (APIModel::saveShardTransactionByAPI($txdata)) {
                $data = [
                    'status' => 'success',
                    'currency' => 'IDR',
                    'price' => $price,
                    'via' => 'QRIS',
                    'qris_url' => $qris_url,
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Save SHARD Transaction Failed',
                ];
            }

            echo json_encode($data);

        } catch (Exception $e) {
            echo $json_encode($e);
            
        }
    }

    function topupShardIDRVA(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            // Setup TX ID and exchange
            $komo_tx_id = strtoupper(md5($req->username.uniqid()));
            $price = (int) $req->amount_shard * 100;

            // Make VA Request
            $data = [
                'type' => 'va',
                'amount' => $price,
                'bankId' => $this->pg_bank_id,
            ];
            $url = $this->pg_endpoint.'/accounts/'.$this->pg_account_id.'/deposits/requests';
            $pg_data = $this->curlPOST($url, $this->pg_header, $data);

            // save to DB
            $txdata = [
                'komo_tx_id' => $komo_tx_id,
                'komo_username' => $req->komo_username,
                'description' => 'Topup '.$req->amount_shard.' SHARD via IDR (VA)',
                'debit_credit' => 'debit',
                'amount_shard' => $req->amount_shard,
                'tx_status' => 'pending',
                'custom_param' => json_encode($pg_data),
                'tx_source' => $req->api_key,
            ];
            if (APIModel::saveShardTransactionByAPI($txdata)) {
                $data = [
                    'status' => 'success',
                    'currency' => 'IDR',
                    'price' => $price,
                    'via' => 'VA',
                    'bank_id' => $pg_data->bankId,
                    'address_name' => $pg_data->addressName,
                    'va_number' => $pg_data->address,
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Save SHARD Transaction Failed',
                ];
            }

            echo json_encode($data);

        } catch (Exception $e) {
            echo $json_encode($e);
            
        }
    }
    function topupShardUSDPaypal(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            // Setup TX ID and exchange
            $komo_tx_id = strtoupper(md5($req->username.uniqid()));
            $price = (float) $req->amount_shard / 100;
            
            // Make paypal request
            $provider = \PayPal::setProvider();
            $provider->getAccessToken();
            $data = json_decode('{
                "intent": "CAPTURE",
                "purchase_units": [
                  {
                    "amount": {
                      "currency_code": "USD",
                      "value": "'.$price.'"
                    }
                  }
                ]
            }', true);
            $paypal = $provider->createOrder($data);

            // save to DB
            $txdata = [
                'komo_tx_id' => $komo_tx_id,
                'komo_username' => $req->komo_username,
                'description' => 'Topup '.$req->amount_shard.' SHARD via USD (Paypal)',
                'debit_credit' => 'debit',
                'amount_shard' => $req->amount_shard,
                'tx_status' => 'pending',
                'custom_param' => json_encode($paypal),
                'tx_source' => $req->api_key,
            ];
            if (APIModel::saveShardTransactionByAPI($txdata)) {
                $data = [
                    'status' => 'success',
                    'currency' => 'USD',
                    'price' => $price,
                    'via' => 'Paypal',
                    'payment_link' => $paypal['links'][1]['href'],
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Save SHARD Transaction Failed',
                ];
            }

            echo json_encode($data);

        } catch (Exception $e) {
            echo $json_encode($e);
        }
    }

    function payWithShard(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            // Get SHARD Amount
            $userdata = APIModel::getUserFromUsername($req->komo_username);
            if ($userdata) {
                if ($userdata->shard > $req->pay_amount) {
                    // deduct shard
                    if (APIModel::subtractAccountShard($req->komo_username, $req->amount_shard)) { 
                        $komo_tx_id = strtoupper(md5($req->username.uniqid()));
                        $txdata = [
                            'komo_tx_id' => $komo_tx_id,
                            'komo_username' => $req->komo_username,
                            'description' => 'Payment '.$req->amount_shard.' SHARD',
                            'debit_credit' => 'credit',
                            'amount_shard' => $req->amount_shard,
                            'tx_status' => 'success',
                            'custom_param' => json_encode($req->custom_param),
                            'tx_source' => $req->api_key,
                        ];
                        APIModel::saveShardTransactionByAPI($txdata);

                        $data = [
                            'status' => 'success',
                            'message' => 'Deducted '.$req->amount_shard.' SHARD from Account',
                        ];
                    } else {
                        $data = [
                            'status' => 'error',
                            'message' => 'Failed to Deduct SHARD',
                        ];
                    }
                } else {
                        $data = [
                            'status' => 'error',
                            'message' => 'Not Enough SHARD To Make This Transaction',
                        ];
                    }
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'KOMO Username Not Found',
                ];
            }
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function getOwnedNFTWeb2(Request $req) {
        echo json_encode(APIModel::getOwnedNFTWeb2($req->komo_username));
    }

    function sendFromUserToEscrow(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            if (APIModel::insertNFTEscrow($req)) {
                if (APIModel::saveEscrowIOTraffic($req, 'inbound')) {
                    $data = [
                        'status' => 'success',
                        'message' => 'Insert Escrow Database Success',
                    ];
                } else {
                    $data = [
                        'status' => 'warning',
                        'message' => 'Insert Escrow Database Success but TX History Failed',
                    ];
                }
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Failed to Insert Escrow Database',
                ];
            }
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function sendFromEscrowToUser(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            if (APIModel::saveEscrowIOTraffic($req, 'outbound')) {
                if (APIModel::removeEscrow($req)) {
                    $data = [
                        'status' => 'success',
                        'message' => 'Removal NFT Escrow Database Success',
                    ];
                } else {
                    $data = [
                        'status' => 'warning',
                        'message' => 'Removal NFT Escrow Database Success but TX History Failed',
                    ];
                }
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Failed to Insert Escrow Database',
                ];
            }
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function setEscrowNFTToSell(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            if (APIModel::setEscrowNFTToSell($req)) {
                $nftdata = APIModel::getWeb2NFTData($req);
                $data = [
                    'status' => 'success',
                    'message' => 'Success Set Escrow NFT to On Sell',
                    'nft_data' => $nftdata,
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Failed to Set Escrow NFT to Sell',
                ];
            }
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function setEscrowNFTToUnSell(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            if (APIModel::setEscrowNFTToUnSell($req)) {
                $nftdata = APIModel::getWeb2NFTData($req);
                $data = [
                    'status' => 'success',
                    'message' => 'Success Set Escrow NFT to Owned',
                    'nft_data' => $nftdata,
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Failed to Set Escrow NFT to Owned',
                ];
            }
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }

    function changeProfilePicture(Request $req) {
        $this->verifyAPIKey($req->api_key);
        try {
            if (APIModel::addPPToDatabase($req->komo_username, $req->profile_picture_url)) {

                $pfdata = [
                    "PlayFabId" => $req->playfab_id,
                    "ImageUrl" => $req->profile_picture_url,
                ];
                $result = $this->curlPlayfab("Server/UpdateAvatarUrl", "X-SecretKey: ".$this->SecretKey, $pfdata);

                $data = [
                    'status' => 'success',
                    'message' => 'Upload successful',
                    'pp_url' => $req->profile_picture_url,
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Failed to save database',
                ];
            }
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }
}