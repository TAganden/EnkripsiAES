<?php 

//menghasilkan Kunci
function dapatKunci($n) {
	$hasil = array();

	$arrKey = array();
	$arrKey[0] = array();
	$arrKey[1] = array();
	$arrKey[2] = array();
	$arrKey[3] = array();

	for($j = 0 ; $j < 4 ; $j++) {
		$terakhir[] = $n[3][$j];
	}

	// echo "<br />";
	// //print_r($terakhir);
	// echo "<br />";

	$s = $terakhir[0];
	// $ss = $terakhir[0][0];
	for($ss = 0 ; $ss < 4 ; $ss++) {
		@$terakhir[$ss] = $terakhir[$ss + 1];
	}

	$terakhir[3] = $s;

	// echo "<br />";
	// //print_r($terakhir);
	// echo "<br />";

	//membuka file setting.txt untuk proses seperti s-box
	$fileku = file("setting.txt");

	//mengambil s-box dari setting.txt (baris, kolom) agar proses manjadi lebih gampang (dimulai dari 0 - 16)

	for($f = 0 ; $f < 16 ; $f++) {
		$fil[] = $fileku[$f];
	}


	for($k = 0 ; $k < 4 ; $k++) {
		$kiri = hexdec($terakhir[$k][0]);
		$kanan = hexdec($terakhir[$k][1]);
		$fil_kiri = $fil[$kiri];
		$fil_kiri = explode(" ",$fil_kiri);

		$hasil[] = $fil_kiri[$kanan];
	}

	// echo "<br />";
	// //print_r($hasil);


	for($b = 0 ; $b < 4 ; $b++) {
		$arrKey[$b][0] = $hasil[$b];
	}

	// echo "<br />";
	// //print_r($arrKey);

	for($b = 0 ; $b < 3 ; $b++) {
		for($c = 0 ; $c < 4 ; $c++) {
			// echo '<br />';
			// echo $arrKey[$c][$b] . "||" .$n[$c][$b];
			// echo "<br />";

			$kiri_xor = HexToBin($arrKey[$c][$b]);
			$kanan_xor = HexToBin($n[$c][$b]);

			// echo $kiri_xor . "||" .$kanan_xor;


			$xor = "";
			for($d = 0 ; $d < 8 ; $d++) {
				if($kiri_xor[$d] == $kanan_xor[$d]) {
					$xor .= "0";
				} else {
					$xor .= "1";
				}
			}

			// echo "<br />$xor<br />";
			
			$dech[] = dechex(bindec($xor));
			// echo //print_r($dech) . "<br />";
			
		}

		for($e = 0 ; $e < 4 ; $e++) {
			if(strlen($dech[$e]) < 2) {
				$dech[$e] = "0" . $dech[$e];
			}
			$arrKey[$e][$b + 1] = $dech[$e];
		} 

		unset($dech);

		// echo "<br />";
		// //print_r($arrKey);
		// echo "<br />";
	}
	// echo "<br /><br />";
	//print_r($arrKey);
	// echo "<br />";

	return $arrKey;
}


?>