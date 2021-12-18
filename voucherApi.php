<?php 

require_once('connection.php');
if (function_exists($_GET['function'])) {
    $_GET['function']();
}

// Fungsi untuk buat voucher
function create_voucher()
{
    global $conn;
    $check = array(
        'id_voucher' => '',
        'id_user' => '',
        'nominal' => '',
        'status' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    $id_voucher = $_POST["id_voucher"];
    $id_user = $_POST["id_user"];
    $status = $_POST["status"];
    $nominal = $_POST["nominal"];
    $kode_voucher = "KODEVOUCHERNICH";
    if($check_match == count($check)){
        $result = mysqli_query($conn, "INSERT INTO voucher SET
        id_voucher = '$id_voucher',
        id_user = '$id_user',
        status = '$status',
        kode_voucher = '$kode_voucher',
        nominal = '$nominal'");
        if($result) {
            $response = array(
                'status' => 1,
                'message' =>'Create voucher success!'
            );
        }
        else {
            $response = array(
                'status' => 0,
                'message' =>'Create voucher fail!'
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

?>