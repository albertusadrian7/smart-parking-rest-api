<?php 

require_once('connection.php');
if (function_exists($_GET['function'])) {
    $_GET['function']();
}

function user_found($id_user) 
{
    global $conn;
    $result = mysqli_query($conn, "SELECT id_user FROM user
        WHERE id_user = '$id_user'");
        
        if(mysqli_num_rows ($result) > 0) {
            return true;
        }
        else {
            return false;
        }
}

function card_found($card_uid) 
{
    global $conn;
    $result = mysqli_query($conn, "SELECT card_uid FROM kartu
        WHERE card_uid = '$card_uid'");
        
        if(mysqli_num_rows ($result) > 0) {
            return true;
        }
        else {
            return false;
        }
}

function user_has_card($card_uid, $id_user) 
{
    global $conn;
    $result = mysqli_query($conn, "SELECT card_uid FROM kartu
        WHERE card_uid = '$card_uid' OR id_user = '$id_user'");
        
        if(mysqli_num_rows ($result) > 0) {
            return true;
        }
        else {
            return false;
        }
}

// Fungsi untuk registrasi kartu pengunjung
function register_user_card()
{
    global $conn;
    $check = array(
        'card_uid' => '',
        'id_user' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    $card_uid = $_POST["card_uid"];
    $id_user = $_POST["id_user"];
    if($check_match == count($check)){
        if(user_found($id_user)) {
            if(!user_has_card($card_uid, $id_user)) {
                $result = mysqli_query($conn, "INSERT INTO kartu SET
                card_uid = '$card_uid',
                id_user = '$id_user',
                saldo = 0");
                if($result) {
                    $response = array(
                        'status' => 1,
                        'message' =>'Kartu berhasil didaftarkan!'
                    );
                }
                else {
                    $response = array(
                        'status' => 0,
                        'message' =>'Kartu gagal didaftarkan!'
                    );
                }
            } else {
                $response = array(
                'status' => 0,
                'message' =>'User sudah punya kartu!');
            }
        } else {
            $response = array(
            'status' => 0,
            'message' =>'User tidak ditemukan!');
        }
    } else {
        $response = array(
        'status' => 0,
        'message' =>'Wrong Parameter');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Fungsi untuk update user
function update_card() 
{
    global $conn;
    if (!empty($_POST["card_uid"])) {
        $check = array(
            'saldo' => ''
        );
        $check_match = count(array_intersect_key($_POST, $check));
        $saldo = $_POST["saldo"];
        $card_uid = $_POST["card_uid"];
        if($check_match == count($check)) {
            if(card_found($card_uid)) {
                $result = mysqli_query($conn, "UPDATE kartu SET 
                saldo = '$saldo'
                WHERE card_uid = '$card_uid'");
                if($result) {
                    $response=array(
                        'status' => 1,
                        'message' =>'Update kartu berhasil!'
                    );
                }
                else {
                    $response=array(
                        'status' => 0,
                        'message' =>'Update kartu gagal!'
                    );
                }
            } else {
                $response=array(
                    'status' => 0,
                    'message' =>'Kartu belum terdaftar!'
                );
            }
        } else {
            $response=array(
                'status' => 0,
                'message' =>'Wrong Parameter',
                'data'=> $id_user
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Please provide an id'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Get Kartu By ID User
function get_kartu_by_id(){
    global $conn;
    if ($_POST) {
        $id_user = $_POST["id_user"];
        $sql = "SELECT * FROM kartu WHERE id_user = '$id_user'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);
        $result = array();
        if ($count > 0) {
            while ($row = $query->fetch_assoc()) {
                array_push($result, array(
                    'id_user' => $row['id_user'],
                    'card_uid' => $row['card_uid'],
                    'saldo' => $row['saldo']
                ));
            };
        }
        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Success',
                'data' => $result
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'No data found'
            );
        }
    } else {
        $response = array(
            'status' => -1,
            'message' => 'Silakan input id user'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Get ID User By Card UID
function get_kartu_by_card_uid(){
    global $conn;
    if ($_POST) {
        $card_uid = $_POST["card_uid"];
        $sql = "SELECT * FROM kartu WHERE card_uid = '$card_uid'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);
        $result = array();
        if ($count > 0) {
            while ($row = $query->fetch_assoc()) {
                array_push($result, array(
                    'id_user' => $row['id_user'],
                    'saldo' => $row['saldo']
                ));
            };
        }
        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Success',
                'data' => $result
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'No data found'
            );
        }
    } else {
        $response = array(
            'status' => -1,
            'message' => 'Silakan input card uid'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

 ?>
