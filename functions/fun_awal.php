<?php 

//membuat karakter maksudnya membuat tiap 16 karakter ke satu nilai array
function buat_karakter($nilai) {
	$panjang = strlen($nilai);
	
	if($panjang % 16 != 0) {
		for($i = 0 ; $i < 16 - ($panjang % 16) ; $i++) {
			$nilai .= " ";
		}
	}

	$panjang = strlen($nilai);
	// echo $nilai . "<br />";

	$hasil = "";
	$arrHasil = array();

	// echo $panjang."<br />";

	for($i = 0 ; $i < $panjang ; $i++) {
		
		$hasil .= $nilai[$i];

		if(strlen($hasil) == 16) {
			$arrHasil[] = $hasil;
			$hasil = "";
		}
	}
	return $arrHasil;
}
?>