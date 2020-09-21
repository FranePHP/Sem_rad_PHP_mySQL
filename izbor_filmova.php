<?php

$mysqli = new mysqli("localhost", "test", "", "test");
$result = $mysqli->query("SELECT * FROM zanr");

?>

<form method="POST">
Naslov: <input type="text" name="naslov" />
<br/>
Godina: <input type="text" name="godina" />
<br/>
Trajanje: <input type="text" name="trajanje" />
<br/>
Žanr: <select name="id_zanr">
	<?php
		foreach ($result as $key => $value) {
			echo "<option value='" . $value["id"] . "'>" . $value["naziv"] . "</option>";
		}
	?>
</select>
<br/>
Slika: <input type="text" name="slika" />
<br/>
<input type="submit" value="Submit" />
</form>

<table border="1">
<tr><th>Slika</th><th>Naslov</th><th>Godina</th><th>Trajanje</th><th>Akcija</th></tr>

<?php

if (!isset($_GET['filter'])) {
	$result = $mysqli->query("SELECT * FROM filmovi");
} else {
	$result = $mysqli->query("SELECT * FROM filmovi WHERE UPPER(naslov) LIKE '".$_GET['filter']."%'");
}

foreach ($result as $key => $value) {
	echo "<tr><td><img src='". $value["slika"] ."' /></td><td>". $value["naslov"] ."</td><td>". $value["godina"] ."</td><td>". $value["trajanje"] ."</td><td><a href='filmovi.php?obrisi=" . $value["id"] . "'>obriši</a></td></tr>";
}

if (isset($_POST["naslov"])) {
	$result = $mysqli->query("INSERT INTO filmovi (slika, naslov, godina, trajanje, id_zanr) VALUES (
		'". $_POST["slika"] ."',
		'". $_POST["naslov"] ."',
		'". $_POST["godina"] ."',
		'". $_POST["trajanje"]  ."',
		" . $_POST["id_zanr"] . "
	)");

	if ($result) {
	    header("Refresh: 0");
	} else {
	    echo "Greska: " . $mysqli->error;
	}
}

if (isset($_GET["obrisi"])) {
	$result = $mysqli->query("DELETE FROM filmovi WHERE id = " . $_GET["obrisi"]);
	if ($result) {
	    header("Refresh: 0; url=filmovi.php");
	} else {
	    echo "Greska: " . $mysqli->error;
	}
}

?>

</table>
<br/><br/>

Početno slovo:
<a href="?filter=">*</a>

<?php
	for ($a = 0; $a < 26; $a++) {
		echo '<a href="?filter=' . chr(65 + $a) . '">' . chr(65 + $a) . '</a> ';
	}
?>