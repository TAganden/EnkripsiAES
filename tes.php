<form action="tes.php" method="post">
	<input type="text" name="nilai">
	<input type="text" name="nilai2">
	<input type="submit" name="submit" value="Proses">
</form>
<?php 


function cekJumlahBit($nilai) {
	$n = 4 - strlen($nilai);

	for($i = 0 ; $i < $n ; $i++) {
		$nilai = "0" . $nilai;
	}

	return $nilai;
}

if(isset($_POST["submit"])) {
	$nilai = $_POST["nilai"];
	$nilai2 = $_POST["nilai2"];

	$left = decbin(hexdec($nilai[0]));

	$right = decbin(hexdec($nilai[1]));


	echo cekJumlahBit($left) . "||" . cekJumlahBit($right);

	

/*	// Ini untuk kali 2
	$nilai = $_POST["nilai"];
	$nilai .= "0";
	
	echo $nilai."<br />";

	$pembanding = "100011011";

	$hasil = "";
	if($nilai[0] == 1) {
		for($i = 0 ; $i < strlen($nilai) ; $i++) {
			if($nilai[$i] == $pembanding[$i]) {
				$val = "0";
			} else {
				$val = "1";
			}
			$hasil = $hasil . $val;
		}
	} else {
		$hasil = substr($nilai, 1);
	}*/

	//Untuk Kali 3

	/*$nilai = $nilai_dup = $_POST["nilai"];
	$nilai .= "0";
	$hasil = substr($nilai, 0, 1);

	$pembanding = "100011011";

	for($i = 0 ; $i < strlen($nilai_dup) ; $i++) {
		if($nilai[$i + 1] == $nilai_dup[$i]) {
			$val = "0";
		} else {
			$val = "1";
		}

		$hasil .= $val;
	}

	$nilai = $hasil;

	echo $nilai."<br />";
	$hasil = "";

	if($nilai[0] == 1) {
		for($i = 0 ; $i < strlen($nilai) ; $i++) {
			if($nilai[$i] == $pembanding[$i]) {
				$val = "0";
			} else {
				$val = "1";
			}
			$hasil = $hasil . $val;
		}
	}
	
	echo $hasil."<br />";
	
	$hasil = substr($hasil, 1);

	echo $hasil;*/
}
?>