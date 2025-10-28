<?php

include("db-tilkobling.php"); // kobler til databasen
 
if (isset($_POST["registrerKlasseKnapp"])) {

    $klassekode  = trim($_POST["klassekode"]);

    $klassenavn  = trim($_POST["klassenavn"]);

    $studiumkode = trim($_POST["studiumkode"]);
 
    if (!$klassekode || !$klassenavn || !$studiumkode) {

        print("<p style='color:red'>Alle felt må fylles ut.</p>");

    } else {

        // sjekk om klassen finnes fra før

        $sqlSjekk = "SELECT * FROM klasse WHERE klassekode = '$klassekode'";

        $resultat = mysqli_query($db, $sqlSjekk);
 
        if (mysqli_num_rows($resultat) > 0) {

            print("<p style='color:orange'>Klassen finnes allerede.</p>");

        } else {

            // legg til ny klasse

            $sqlSettInn = "INSERT INTO klasse (klassekode, klassenavn, studiumkode)

                           VALUES ('$klassekode', '$klassenavn', '$studiumkode')";

            if (mysqli_query($db, $sqlSettInn)) {

                print("<p style='color:green'>

                        Klassen '$klassekode – $klassenavn' ble registrert!
</p>");

            } else {

                print("<p style='color:red'>

                        Feil ved registrering: " . mysqli_error($db) . "
</p>");

            }

        }

    }

}

?>
 
<!DOCTYPE html>
<html lang="no">
<head>
<meta charset="UTF-8">
<title>Registrer klasse</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
 
<h3>Registrer ny klasse</h3>
<form method="post" action="">

    Klassekode: <input type="text" name="klassekode" maxlength="5" required><br>
<small>Må være nøyaktig 5 tegn</small><br><br>

    Klassenavn: <input type="text" name="klassenavn" maxlength="50" required><br><br>

    Studiumkode: <input type="text" name="studiumkode" maxlength="50" required><br><br>
<input type="submit" name="registrerKlasseKnapp" value="Registrer klasse">
<input type="reset" value="Nullstill">
</form>
 
<p><a href="vis-alle-klasser.php">Vis alle klasser</a></p>
<p><a href="index.html">Tilbake til hovedmeny</a></p>
 
</body>
</html>
 