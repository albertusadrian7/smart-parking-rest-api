<?php 
	define('HOST', 'localhost');
	define('USER', 'root');
	define('PASS', '');
	define('DB', 'smart_parking');

	$conn = mysqli_connect(HOST, USER, PASS, DB) or die('Koneksi tidak berhasil: ' . mysqli_connect_error());
 ?>