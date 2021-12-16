<?php 

require_once('connection.php');
if (function_exists($_GET['function'])) {
    $_GET['function']();
}

// Fungsi untuk get seluruh user
function get_user()
{
    global $conn;
    $query = mysqli_query($conn, "SELECT * FROM user");
    $result = array();
    while ($row = mysqli_fetch_array($query)) {
        array_push($result, array(
            'id_user' => $row['id_user'],
            'username' => $row['username'],
            'password' => $row['password'],
            'email' => $row['email'],
            'nama' => $row['nama'],
            'role' => $row['role']
        ));
    }
    $response = array(
        'status' => 1,
        'message' => 'Success',
        'data' => $result
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Fungsi untuk insert user
function insert_user()
{
    global $conn;
    $check = array(
        'id_user' => '',
        'username' => '',
        'password' => '',
        'email' => '',
        'nama' => '',
        'role' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    $id_user = $_POST["id_user"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $nama = $_POST["nama"];
    $role = $_POST["role"];
    if($check_match == count($check)){
        $result = mysqli_query($conn, "INSERT INTO user SET
        id_user = '$id_user',
        username = '$username',
        password = '$password',
        email = '$email',
        nama = '$nama',
        role = '$role'");
        if($result) {
            $response = array(
                'status' => 1,
                'message' =>'Insert user success!'
            );
        }
        else {
            $response = array(
                'status' => 0,
                'message' =>'Insert user fail!'
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
function update_user() 
{
    global $conn;
    if (!empty($_POST["id_user"])) {
        $check = array(
            'id_user' => '',
            'username' => '',
            'password' => '',
            'email' => '',
            'nama' => '',
            'role' => ''
        );
        $check_match = count(array_intersect_key($_POST, $check));
        $id_user = $_POST["id_user"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $nama = $_POST["nama"];
        $role = $_POST["role"];
        if($check_match == count($check)) {
            $result = mysqli_query($conn, "UPDATE user SET 
            username = '$username',
            password = '$password',
            email = '$email',
            nama = '$nama',
            role = '$role',
            WHERE id_user = '$id_user'");
            if($result) {
                $response=array(
                    'status' => 1,
                    'message' =>'Update user success!'
                );
            }
            else {
                $response=array(
                    'status' => 0,
                    'message' =>'Update user fail!'
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

// Fungsi untuk delete user
function delete_user() 
{
    global $conn;
    if (!empty($_POST['id_user'])) {
        $id_user = $_POST['id_user'];
        $queryDelete = "DELETE FROM user WHERE id_user=" . $id_user;
        mysqli_query($conn, $queryDelete);
        if (mysqli_affected_rows($conn) > 0) {
            $response = array(
                'status' => 1,
                'message' => 'Delete user success!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Delete user fail!'
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


function login_user(){
    global $conn;
    if ($_POST) {
        // $username = mysqli_real_escape_string($conn,$_POST["username"]);
        // $password = mysqli_real_escape_string($conn,$_POST["password"]);
        $username = $_POST["username"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM user WHERE username = '$username' and password = '$password'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);
        $result = array();
        if ($count > 0) {
            while ($row = $query->fetch_assoc()) {
                array_push($result, array(
                    'id_user' => $row['id_user'],
                    'username' => $row['username'],
                    'password' => $row['password'],
                    'email' => $row['email'],
                    'nama' => $row['nama'],
                    'role' => $row['role']
                ));
            };
        }
        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Login berhasil',
                'data' => $result
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Username atau password Anda salah!'
            );
        }
    } else {
        $response = array(
            'status' => -1,
            'message' => 'Silakan input username dan password Anda!'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

 ?>
 