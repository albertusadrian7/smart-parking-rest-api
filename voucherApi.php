<?php 

require_once('connection.php');
if (function_exists($_GET['function'])) {
    $_GET['function']();
}

function generateRandomString($length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
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
    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d H:i:s');
    $id_user = $_POST["id_user"];
    $nominal = $_POST["nominal"];
    $kode_voucher = generateRandomString();
    if($check_match == count($check)){
        $result = mysqli_query($conn, "INSERT INTO voucher SET
        id_voucher = '$id_voucher',
        id_user = '$id_user',
        status = 'false',
        kode_voucher = '$kode_voucher',
        nominal = '$nominal',
        tanggal = '$tanggal'
        ");
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
                    'nominal' => $row['nominal'],
                    'tanggal' => $row['tanggal'],
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

// Get Data Voucher By Kode Voucher
function get_voucher(){
    global $conn;
    if ($_POST) {
        $kode_voucher = $_POST["kode_voucher"];
        $sql = "SELECT * FROM voucher WHERE kode_voucher = '$kode_voucher'";
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
                    'nominal' => $row['nominal'],
                    'tanggal' => $row['tanggal'],
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
            'message' => 'Silakan input kode voucher'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function cari_voucher($kode_voucher) 
{
    global $conn;
    $result = mysqli_query($conn, "SELECT kode_voucher FROM voucher
        WHERE kode_voucher = '$kode_voucher'");

        if(mysqli_num_rows ($result) > 0) {
            return true;
        }
        else {
            return false;
        }
}

function nominal_voucher($kode_voucher) 
{
    global $conn;
    $result = mysqli_query($conn, "SELECT nominal FROM voucher
        WHERE kode_voucher = '$kode_voucher'");
        $row = mysqli_fetch_array($result);

        if($result) {
            return $row["nominal"];
        }
        else {
            return false;
        }
}

function status_voucher($kode_voucher) 
{
    global $conn;
    $result = mysqli_query($conn, "SELECT status FROM voucher
        WHERE kode_voucher = '$kode_voucher'");
        $row = mysqli_fetch_array($result);

        if($result) {
            return $row["status"];
        }
        else {
            return false;
        }
}

function pemilik_voucher($kode_voucher) 
{
    global $conn;
    $result = mysqli_query($conn, "SELECT id_user FROM voucher
        WHERE kode_voucher = '$kode_voucher'");
        $row = mysqli_fetch_array($result);

        if($result) {
            return $row["id_user"];
        }
        else {
            return false;
        }
}

function pakai_voucher($kode_voucher) 
{
    global $conn;
    $result = mysqli_query($conn, "UPDATE voucher SET 
        status = 'true'
        WHERE kode_voucher = '$kode_voucher'");

        if($result) {
            return true;
        }
        else {
            return false;
        }
}

function card_uid($id_user) 
{
    global $conn;
    $result = mysqli_query($conn, "SELECT card_uid FROM kartu
        WHERE id_user = '$id_user'");
        $row = mysqli_fetch_array($result);

        if($result) {
            return $row["card_uid"];
        }
        else {
            return false;
        }
}

function top_up(){
    global $conn;
    if ($_POST) {
        $kode_voucher = $_POST["kode_voucher"];
        $card_uid = $_POST["card_uid"];
        if(cari_voucher($kode_voucher)) {
            if(status_voucher($kode_voucher) == "false") {
                $nominal = nominal_voucher($kode_voucher);
                $result = mysqli_query($conn, "UPDATE kartu SET 
                saldo = saldo+$nominal
                WHERE card_uid = '$card_uid'");
                if ($result) {
                    $response = array(
                        'status' => 1,
                        'message' => $nominal
                    );
                } else {
                    $response = array(
                        'status' => 0,
                        'message' => 'Top up saldo gagal!'
                    );
                }
                pakai_voucher($kode_voucher);
            } else {
                $response = array(
                    'status' => -1,
                    'message' => 'Voucher telah digunakan!'
                );
            }
        } else {
            $response = array(
                'status' => -1,
                'message' => 'Voucher tidak ditemukan!'
            );
        }
    } else {
        $response = array(
            'status' => -1,
            'message' => 'Silakan input kode voucher'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>