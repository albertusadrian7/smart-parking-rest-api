<?php 

require_once('connection.php');
if (function_exists($_GET['function'])) {
    $_GET['function']();
}

// Fungsi untuk registrasi kartu pengunjung
function register_user_card()
{
    global $conn;
    $check = array(
        'card_uid' => '',
        'saldo' => '',
        'id_user' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    $saldo = $_POST["saldo"];
    $id_user = $_POST["id_user"];
    $card_uid = $_POST["card_uid"];
    if($check_match == count($check)){
        $result = mysqli_query($conn, "INSERT INTO kartu SET
        saldo = '$saldo',
        id_user = '$id_user',
        card_uid = '$card_uid'");
        if($result) {
            $response = array(
                'status' => 1,
                'message' =>'Register user card success!'
            );
        }
        else {
            $response = array(
                'status' => 0,
                'message' =>'Register user card fail!'
            );
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
function top_up() 
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
            $result = mysqli_query($conn, "UPDATE kartu SET 
            saldo = '$saldo'
            WHERE card_uid = '$card_uid'");
            if($result) {
                $response=array(
                    'status' => 1,
                    'message' =>'Top up saldo success!'
                );
            }
            else {
                $response=array(
                    'status' => 0,
                    'message' =>'Top up saldo fail!'
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

 ?>
