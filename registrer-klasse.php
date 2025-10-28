<?php
include("db-tilkobling.php");

if (isset($_POST["registrerKlasseKnapp"])) {
    $klassekode  = strtoupper(trim($_POST["klassekode"])); // store bokstaver
    $klassenavn  = trim($_POST["klassenavn"]);
    $studiumkode = trim($_POST["studiumkode"]);

    // Validering
    if (!$klassekode || !$klassenavn || !$studiumkode) {
        echo "<p style='color:red'>Alle felt må fylles ut.</p>";
    } elseif (strlen($klassekode) > 10) {
        echo "<p style='color:red'>Klassekode kan maks være 10 tegn.</p>";
    } else {
        // Sjekk om klassen finnes fra før
        $sqlSjekk = "SELECT * FROM klasse WHERE klassekode = ?";
        $stmt = mysqli_prepare($db, $sqlSjekk);
        mysqli_stmt_bind_param($stmt, "s", $klassekode);
        mysqli_stmt_execute($stmt);
        $resultat = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultat) > 0) {
            echo "<p style='color:orange'>Klassen finnes allerede.</p>";
        } else {
            // Sett inn ny klasse
            $sqlSettInn = "INSERT INTO klasse (klassekode, klassenavn, studiumkode) VALUES (?, ?, ?)";
            $stmt2 = mysqli_prepare($db, $sqlSettInn);
            mysqli_stmt_bind_param($stmt2, "sss", $klassekode, $klassenavn, $studiumkode);
            if (mysqli_stmt_execute($stmt2)) {
                echo "<p style='color:green'>Klassen '$klassekode – $klassenavn' ble registrert!</p>";
            } else {
                echo "<p style='color:red'>Feil ved registrering: " . mysqli_error($db) . "</p>";
            }
            mysqli_stmt_close($stmt2);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
<meta charset="UTF-8">
<title>Registrer klasse</title>
</head>
<body>
<h3>Registrer ny klasse</h3>
<form method="post" action="">
    Klassekode: <input type="text" name="klassekode" maxlength="10" required><br><br>
    Klassenavn: <input type="text" name="klassenavn" required><br><br>
    Studiumkode: <input type="text" name="studiumkode" maxlength="10" required><br><br>
    <input type="submit" name="registrerKlasseKnapp" value="Registrer klasse">
    <input type="reset" value="Nullstill">
</form>

<p><a href="vis-alle-klasser.php">Vis alle klasser</a></p>
</body>
</html>





 