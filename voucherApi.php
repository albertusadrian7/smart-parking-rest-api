<?php 

require_once('connection.php');
if (function_exists($_GET['function'])) {
    $_GET['function']();
}

function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Fungsi untuk buat voucher
function create_voucher()
{
    global $conn;
    $check = array(
        'id_voucher' => '',
        'id_user' => '',
        'nominal' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    $id_voucher = $_POST["id_voucher"];
    $id_user = $_POST["id_user"];
    $status = "menunggu pembayaran";
    $nominal = $_POST["nominal"];
    $kode_voucher = generateRandomString();
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

// Get Voucher By ID User
function get_voucher_by_id(){
    global $conn;
    if ($_POST) {
        $id_user = $_POST["id_user"];
        $sql = "SELECT * FROM voucher WHERE id_user = '$id_user'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);
        $result = array();
        if ($count > 0) {
            while ($row = $query->fetch_assoc()) {
                array_push($result, array(
                    'id_voucher' => $row['id_voucher'],
                    'id_user' => $row['id_user'],
                    'kode_voucher' => $row['kode_voucher'],
                    'status' => $row['status'],
                    'nominal' => $row['nominal']
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