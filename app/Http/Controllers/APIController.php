<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\APIModel;

class APIController extends Controller
{
    protected $TitleId;
    protected $SecretKey;

    public function __construct() 
    {
        $this->TitleId = config('playfab.titleId');
        $this->SecretKey = config('playfab.secretKey');
    }

    function createCURL($endpoint, $header, $data) {
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

    function loginWithCustomID($komo_username) {
        $data = [
            "TitleId" => $this->TitleId,
            "CreateAccount" => false,
            "CustomId" => $komo_username,
        ];

        $result = $this->createCURL("Client/LoginWithCustomID", "", $data);

        return $result;
    }

    function registerPlayfabUser($komo_username) {
        $data = [
            "TitleId" => $this->TitleId,
            "CreateAccount" => true,
            "CustomId" => $komo_username,
        ];
        $result = $this->createCURL("Client/LoginWithCustomID", "", $data);
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
    //     $result = $this->createCURL("Client/GetAccountInfo", "X-Authorization: ".Session::get('SessionTicket'), $data);
    //     return view('dashboard')->with((array) $result);
    // }

    function changeDisplayName(Request $req) {
        try {
            $data = [
                "PlayFabId" => $req->playfab_id,
                "DisplayName" => $req->display_name,
            ];
            $result = $this->createCURL("Admin/UpdateUserTitleDisplayName", "X-SecretKey: ".$this->SecretKey, $data);
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
            $exec_display_name = $this->createCURL("Client/UpdateUserTitleDisplayName", "X-Authorization: ".$session_ticket, $data);
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
            $result = $this->createCURL("Admin/UpdateUserData", "X-SecretKey: ".$this->SecretKey, $data);
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
                    'status' => 'Username Taken',
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
                            'status' => 'Registration Success',
                        ];
                    } else {
                        $response = [
                            'status' => 'Registration Failed',
                        ];
                    }
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
            $result = $this->createCURL("Admin/GetUserAccountInfo", "X-SecretKey: ".$this->SecretKey, $data);
            echo json_encode($result);
            exit;
        } catch (Exception $e) {
            echo json_encode($e);
            exit;
        }
    }

    function addItemToInventory(Request $req) {
        try {
            $data = [
                "ItemIds" => array($req->item_id),
                "PlayFabId" => $req->playfab_id,
            ];
            $result = $this->createCURL("Server/GrantItemsToUser", "X-SecretKey: ".$this->SecretKey, $data);
            echo json_encode($result);
            exit;
        } catch (Exception $e) {
            echo json_encode($e);
            exit;
        }
    }

    function changeKOMOPassword(Request $req) {
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
        $result = $this->createCURL("Server/GetUserInventory", "X-SecretKey: ".$this->SecretKey, $data);
        echo json_encode($result);
    }

    function revokeInventory(Request $req) {
        try {
            $data = [
                'ItemInstanceId' => $req->item_instance_id,
                'PlayFabId' => $req->playfab_id,
            ];
            $result = $this->createCURL("Server/RevokeInventoryItem", "X-SecretKey: ".$this->SecretKey, $data);
            echo json_encode($result);
            exit;
        } catch (Exception $e) {
            echo json_encode($e);
            exit;
        }
    }

    function addGold(Request $req) {
        try {
            $data = [
                'Amount' => $req->amount,
                'PlayFabId' => $req->playfab_id,
                'VirtualCurrency' => 'GD',
            ];
            $result = $this->createCURL("Server/AddUserVirtualCurrency", "X-SecretKey: ".$this->SecretKey, $data);
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
            $result = $this->createCURL("Server/SubtractUserVirtualCurrency", "X-SecretKey: ".$this->SecretKey, $data);
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
        try {
            if (APIModel::addTransaction($req)) {
                $response = [
                    'status' => 'add transaction success',
                ];
            } else {
                $response = [
                    'status' => 'add transaction failed',
                ];
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

    function addToLeaderboard(Request $req) {
        $daily = "failed";
        $weekly = "failed";
        $monthly = "failed";
        $lifetime = "failed";
        $verify_api_key = APIModel::authorizeAPIKey($req->api_key);
        if ($verify_api_key) {
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
        } else {
            $status = ['status' => 'API Key Not Found'];
            echo json_encode($status);
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
}
