<?php 

require_once('connection.php');
if (function_exists($_GET['function'])) {
    $_GET['function']();
}

// Fungsi untuk sesi parkir
function create_parking_session()
{
    global $conn;
    $check = array(
        'id_parkir' => '',
        'id_user' => '',
        'card_uid' => '',
        'waktu_masuk' => '',
        'waktu_keluar' => '',
        'total' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    $id_parkir = $_POST["id_parkir"];
    $id_user = $_POST["id_user"];
    $card_uid = $_POST["card_uid"];
    $waktu_masuk = $_POST["waktu_masuk"];
    $waktu_keluar = $_POST["waktu_keluar"];
    $total = $_POST["total"];
    if($check_match == count($check)){
        $result = mysqli_query($conn, "INSERT INTO parkir SET
        id_parkir = '$id_parkir',
        id_user = '$id_user',
        card_uid = '$card_uid',
        waktu_masuk = '$waktu_masuk',
        waktu_keluar = '$waktu_keluar',
        total = '$total'");
        if($result) {
            $response = array(
                'status' => 1,
                'message' =>'Create parking session success!'
            );
        }
        else {
            $response = array(
                'status' => 0,
                'message' =>'Create parking session fail!'
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

function get_parking_session_by_user_id(){
    global $conn;
    if ($_POST) {
        $id_user = $_POST["id_user"];
        $sql = "SELECT * FROM parkir WHERE id_user = '$id_user'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);
        $result = array();
        if ($count > 0) {
            while ($row = $query->fetch_assoc()) {
                array_push($result, array(
                    'id_user' => $row['id_user'],
                    'id_parkir' => $row['id_parkir'],
                    'card_uid' => $row['card_uid'],
                    'waktu_masuk' => $row['waktu_masuk'],
                    'waktu_keluar' => $row['waktu_keluar'],
                    'total' => $row['total']
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

/*
// Fungsi untuk sesi parkir
function get_parking_session_by_user_id()
{
    global $conn;
    $id_user =  $_GET['id_user'];
    $query = mysqli_query($conn, "SELECT * FROM parkir WHERE id_user=" . $id_user);
    $result = array();
    while ($row = $query->fetch_assoc()) {
        array_push($result, array(
            'id_user' => $row['id_user'],
            'id_parkir' => $row['id_parkir'],
            'card_uid' => $row['card_uid'],
            'waktu_masuk' => $row['waktu_masuk'],
            'waktu_keluar' => $row['waktu_keluar'],
            'total' => $row['total']
        ));
    };
    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'Success',
            'data' => $result
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'No Data Found',
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
*/

 ?>
