<?php 

// Mencetak Hasil Enkripsi
function getHasilEnkripsi($hexa) {
	$hasil = "";
	for($i = 0 ; $i < 4 ; $i++) {
		for($j = 0 ; $j < 4 ; $j++) {
			$hasil .= chr(hexdec($hexa[$j][$i]));
		}
	}
	return $hasil;
}

// Add Round Key
function addRoundKey($hexa,$kunci) {
	$hasil = "";
	for($i = 0 ; $i < 4 ; $i++) {
		for($j = 0 ; $j < 4 ; $j++) {
			// echo $hexa[$j][$i] . " || " . $kunci[$j][$i]."<br />";
			$hb = HexToBin($hexa[$j][$i]);
			$kk = HexToBin($kunci[$j][$i]);

			// echo $hb . " || " . $kk."<br />";

			for($a = 0 ; $a < 8 ; $a++) {
				if($hb[$a] == $kk[$a]) {
					$hasil .= "0";
				} else {
					$hasil .= "1";
				}
			}

			// echo $hasil."<br />"; 
			$hasil = dechex(bindec($hasil));
			if($hasil == 1) {
				$hasil = "0" . $hasil;
			}
			// echo $hasil."<br />";

			$arr_hasil[$j][$i] = $hasil;

			// //print_r($arr_hasil);

			$hasil = "";
		}
	}

	//print_r($arr_hasil);
	return $arr_hasil;
}

function MixColums($hexa) {
	//
	// membuka file
	$fileku = file("setting.txt");

	// menaruh isi ke dalam array
	$fil = array();

	for($i = 17 ; $i < 21 ; $i++) {
		$fil[] = $fileku[$i];
	}

	// inisialisasi nilai
	$arrProses = array();
	$arrHasil = array();
	$st = 0;
	$pembanding = "100011011";

	// mengambil nilai yang ada dalam nilai cth : 
	// untuk yang pertama [2f<=ambil 4d 01 11 ; 2f<=ambil 4d 01 11 ; dst]
	for($i = 0 ; $i < 4 ; $i++) {
		for($j = 0 ; $j < 4 ; $j++) {
			$arrProses[$j] = $hexa[$j][$i];
		}

		// jumlah dari [02 03 01 01 ; 01 02 03 01 ; dst] = 4 buah	
		for($k = 0 ; $k < count($fil) ; $k++) {

			// mengambil nilai menjadi array
			$prs = explode(" ", $fil[$k]);

			// jumlah hasil pengambilan tadi (hal 36)
			for($m = 0 ; $m < count($arrProses) ; $m++) {

				$hasil = "";
				
				// mengubah hexa menjadi bin
				$has = HexToBin($arrProses[$m]);
				
				// jika dikalikan dengan 01
				if($prs[$m] == 1) {
					$simpan[] = $has;

				// jika dikalikan dengan 02
				} elseif($prs[$m] == 2) {
					$has .= "0";

					if($has[0] == 1) {

						for($b = 0 ; $b < strlen($has) ; $b++) {
							if($has[$b] == $pembanding[$b]) {
								$val = "0";
							} else {
								$val = "1";
							}
							$hasil = $hasil . $val;
							// echo $val;
						}
					} else {
						$hasil = $has;
					}

					$hasil = substr($hasil, 1);
					$simpan[] = $hasil;

				// jika dikalikan dengan 03
				} elseif($prs[$m] == 3) {
					
					$nilai_dup = $has;
					$has .= "0";
					$hasil = substr($has, 0, 1);

					for($b = 0 ; $b < strlen($nilai_dup) ; $b++) {
						if($has[$b + 1] == $nilai_dup[$b]) {
							$val = "0";
						} else {
							$val = "1";
						}

						$hasil .= $val;
					}

					$has = $hasil;
					$hasil = "";

					if($has[0] == 1) {
						for($b = 0 ; $b < strlen($has) ; $b++) {
							if($has[$b] == $pembanding[$b]) {
								$val = "0";
							} else {
								$val = "1";
							}
							$hasil = $hasil . $val;
						}
					} else {
						$hasil = $has;
					}

					$hasil = substr($hasil, 1);
					$simpan[] = $hasil;
				}
			}

			//dilakukan proses xor

			//satu-satu, dimulai dari yang pertama-kedua-ketiga-keempat

			//ambil yang pertama
			$proses = $simpan[0];

			//xor
			for($sim = 1 ; $sim < count($simpan) ; $sim++) {
				for($si = 0 ; $si < strlen($simpan[$sim]) ; $si++) {
					if($proses[$si] == $simpan[$sim][$si]) {
						$proses[$si] = "0";
					} else {
 						$proses[$si] = "1";
					}
					$si++;
				}
			}

			//ubah hasil ke dalam bentuk hexa
			$final = dechex(bindec($proses));

			//jika panjangnya cuma 1 maka tambah belakangnya 0
			if(strlen($final) == 1) {
				$final = $final . "0";
			}

			//memasukan nilai hasil xor ke dalam array
			$arrHasil[] = $final;
		}
	}
	
	// hasil dilakukan pembalikan
	// echo "<br />"; //print_r(pembalikNilai($arrHasil));
	// echo '<br />';
	return pembalikNilai($arrHasil);

	//
}

function pembalikNilai($arr_hex) {
	$hexa = array();
	$flag = 0;
	for($i = 0 ; $i < 4 ; $i++) {
		for($j = 0 ; $j < 4 ; $j++) {
			$hexa[$j][$i] = $arr_hex[$flag];
			$flag++;
		}
	}

	//baris jadi kolom, kolom jadi baris
	return $hexa;
}

function cekJumlahBit($nilai) {
	// jika bitnya kurang dari 4
	$n = 4 - strlen($nilai);

	for($i = 0 ; $i < $n ; $i++) {
		$nilai = "0" . $nilai;
	}

	return $nilai;
}


function HexToBin($nilai) {
	// mengubah hexa ke binner
	$left = decbin(hexdec($nilai[0]));
	$right = decbin(hexdec($nilai[1]));
	return cekJumlahBit($left).cekJumlahBit($right);
}


function shiftRows($hexa) {
	$nampung = "";
	$flag = 0;
	for($i = 0 ; $i < 4 ; $i++) {

		for($j = 0 ; $j < $flag ; $j++) {
			$nampung = $hexa[$i][0];
			$hexa[$i][0] = 0;
			for($l = 0 ; $l < 3 ; $l++) {
				$hexa[$i][$l] = $hexa[$i][$l + 1];
			}
			$hexa[$i][3] = $nampung;
		}

		$flag++;
	}
	// echo "<br />";
	//print_r($hexa);

	return $hexa;
}

function enkodeDec2Bin($nilai) {

	// menyipkan array 1 dimensi untuk penampungan sementara hasil dari mengubah dec ke bin
	$arr_hex = array();
	for($i = 0 ; $i < strlen($nilai) ; $i++) {

		$huruf = decbin(ord($nilai[$i]));
		$n = 8 - strlen($huruf);
		$biner = $huruf;

		// jika hasil perubahan tidak mencapai jumlah 8
		for($j = 0 ; $j < $n ; $j++) {
			$biner = "0" . $biner;
		}

		// memisahkan 8 menjadi 4 | 4 untuk diubah ke hexadecimal (4 masing2 tersebut)
		$bagian_kiri = $bagian_kanan = "";
		for($k = 0 ; $k < 4 ; $k++) {
			$bagian_kiri = $bagian_kiri . $biner[$k];
			$bagian_kanan = $bagian_kanan . $biner[$k + 4];
		}

		// menggabungkan 4 | 4 tadi menjadi satu
		$hex = dechex(bindec($bagian_kiri)) . dechex(bindec($bagian_kanan));

		// menyimpan ke array
		$arr_hex[] = $hex;
	}

	// menyimpan array $arr_hex ke dalam array lain dengan bentuk array 2 dimensi $hexa
	$hexa = array();

	$flag = 0;
	for($i = 0 ; $i < 4 ; $i++) {
		for($j = 0 ; $j < 4 ; $j++) {
			$hexa[$j][$i] = $arr_hex[$flag];
			$flag++;
		}
	}

	//print_r($hexa);
	return $hexa;
}

function subBytes($hexa) {
	//membuka file setting.txt untuk proses seperti s-box
	$fileku = file("setting.txt");

	//mengambil s-box dari setting.txt (baris, kolom) agar proses manjadi lebih gampang (dimulai dari 0 - 16)

	for($f = 0 ; $f < 16 ; $f++) {
		$fil[] = $fileku[$f];
	}

	//proses
	for($i = 0 ; $i < 4 ; $i++) {
		for($j = 0 ; $j < 4 ; $j++) {

			$kiri = hexdec($hexa[$j][$i][0]);
			$kanan = hexdec($hexa[$j][$i][1]);

			$fil_kiri = $fil[$kiri];
			$fil_kiri = explode(" ",$fil_kiri);

			$subbyte = $fil_kiri[$kanan];

			$hexa[$j][$i] = $subbyte;
		}
	}

	//print_r($hexa);

	return $hexa;
}
?>