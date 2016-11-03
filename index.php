
<center>
<h1>Enkripsi AES</h1>
<form action="index.php" method="post">
<fieldset>
	<table>
		<tr>
			<td><label for="#nilai">Nilai : </label></td>
			<td><textarea name="nilai" id="nilai" cols="70" rows="6" required="required"></textarea></td>
		</tr>
		<tr>
			<td><label for="#kunci">Kunci : </label></td>
			<td><input type="text" name="key" required="required" maxlength="16"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="reset" value="#">&nbsp;
				<input type="submit" name="submit" value="                Proses                ">
			</td>
		</tr>
	</table>
</fieldset>
</form>
<?php

require_once "functions/fun.php";
require_once "functions/fun_kunci.php";
require_once "functions/fun_awal.php";

if(isset($_POST["submit"])) {
	$nilai = $_POST["nilai"];
	$key = $_POST["key"];

	// Misalnya Kunci
	$arr_kunci = array();
	$n = enkodeDec2Bin($key);
	$kunci = dapatKunci($n);
	$arr_kunci[] = $kunci;

	for($i = 0 ; $i < 9 ; $i++) {	
		$kunci = dapatKunci($kunci);
		$arr_kunci[] = $kunci;
	}
	// 

	// Proses
	$nilai = buat_karakter($nilai);
	

	for($i = 0 ; $i < count($nilai) ; $i++) {
		$n = $nilai[$i];
		// 1 - 9
		for($j = 0 ; $j < 9 ; $j++) {
			$hexa = enkodeDec2Bin($n);

			$hexa = subBytes($hexa);
			$hexa = shiftRows($hexa); 

			$hexa = MixColums($hexa);

			$hexa = addRoundKey($hexa,$arr_kunci[$j]);

			$n = getHasilEnkripsi($hexa);			
		}

		// 10 tanpa mixcolums
		$hexa = enkodeDec2Bin($n);

		$hexa = subBytes($hexa);
		$hexa = shiftRows($hexa); 

		$hexa = addRoundKey($hexa,$arr_kunci[9]);

		$n = getHasilEnkripsi($hexa);

		$arrHasil[] = $n;
	}

	// Menyimpan info dari enkripsi seperti hasil, pesan, kunci
	$info = "\n\n-----------------\nDari Pesan : \n" . $_POST["nilai"] ."\n";
	$info .= "\n-----------------\nDengan Key : \n" . $_POST["key"] ."\n";
	$fp = fopen('hasilenkripsi.txt','w') or die("Gagal");
	fwrite($fp, "----- Hasil Enkripsi -----\n\n" . implode($arrHasil) . $info);
	fclose($fp);

	?>

		<h2>
			Hasil Enkripsi :
		</h2>
		<p style="border : 2px solid silver ; padding : 20px ; width : 400px ; height : 200px ;"><?= implode($arrHasil) ?></p>

	<?php	
}
?>
</center>