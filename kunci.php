<form action="kunci.php" method="post">
	<input type="text" name="nilai">

	<input type="submit" name="submit" value="Proses">
</form>
<?php 
require_once "functions/fun.php";
require_once "functions/fun_kunci.php";

if(isset($_POST["submit"])) {
	$nilai = $_POST["nilai"];

	$panjang = strlen($nilai);
	if($panjang % 16 != 0) {
		for($i = 0 ; $i < 16 - ($panjang % 16) ; $i++) {
			$nilai .= " ";
		}
	}

	$panjang = strlen($nilai);
	echo $nilai . "<br />";

	$hasil = "";
	$arrHasil = array();

	echo $panjang."<br />";

	for($i = 0 ; $i < $panjang ; $i++) {
		
		$hasil .= $nilai[$i];

		if(strlen($hasil) == 16) {
			$arrHasil[] = $hasil;
			$hasil = "";
		}
	}
	print_r($arrHasil);
}