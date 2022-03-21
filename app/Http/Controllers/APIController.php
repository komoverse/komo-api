<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\APIModel;

class APIController extends Controller
{
    protected $TitleId = "D8BE8";
    protected $SecretKey = "BHQDNJQ376PXI6OO7PYS16QNJURJEWKTR1YN9H4Y9NDXSB8WQ7";

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
        try {
            $data = [
                "DisplayName" => $display_name,
            ];
            $result = $this->createCURL("Client/UpdateUserTitleDisplayName", "X-Authorization: ".$session_ticket, $data);
            if ($result) {
                $response = [
                    "status" => "Change Success",
                    "display_name" => $result->data->DisplayName,
                ];
            } else {
                $response = [
                    "status" => "Change Failed",
                ];
            }
            return true;
        } catch (Exception $e) {
            return false;
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
                    // Change PLayfab Display Name
                    try {
                        $this->setInitialDisplayName($session_ticket, $req->komo_username);
                    } catch (Exception $e) {
                        $this->setInitialDisplayName($session_ticket, $playfab_id);
                    }

                    // Save to KOMO Database
                    if (APIModel::registerKOMO($req, $playfab_id)) {
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
                    $playfab = $this->loginWithCustomID($req->komo_username);
                    if ($playfab) {
                        $response = [
                            'status' => 'Login Success',
                            'playfab_id' => $playfab->data->PlayFabId,
                            'session_ticket' => $playfab->data->SessionTicket,
                        ];
                    } else {
                        $response = [
                            'status' => 'Connection to Playfab Failed',
                        ];
                    }
                } else {
                    $response = [
                        'status' => 'Wrong KOMO Password',
                    ];
                }
            } else {
                $response = [
                    'status' => 'KOMO Username Not Found',
                ];
            }

            echo json_encode($response);
            exit;
            
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
            echo json_encode($result);
            exit;
        }
    }
}
