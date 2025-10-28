<?php

include("db-tilkobling.php"); // kobler til databasen
 
if (isset($_POST["registrerKlasseKnapp"])) {

    $klassekode  = trim($_POST["klassekode"]);

    $klassenavn  = trim($_POST["klassenavn"]);

    $studiumkode = trim($_POST["studiumkode"]);
 
    // Sjekk at alle felt er fylt ut

    if (!$klassekode || !$klassenavn || !$studiumkode) {

        print("<p style='color:red'>Alle felt må fylles ut.</p>");

    } 

    // Sjekk at klassekode ikke overskrider 10 tegn

    else if (strlen($klassekode) > 10) {

        print("<p style='color:red'>Klassekode kan maks være 10 tegn.</p>");

    } 

    else {

        // Sjekk om klassen finnes fra før

        $sqlSjekk = "SELECT * FROM klasse WHERE klassekode = '$klassekode'";

        $resultat = mysqli_query($db, $sqlSjekk);
 
        if (mysqli_num_rows($resultat) > 0) {

            print("<p style='color:orange'>Klassen finnes allerede.</p>");

        } else {

            // Legg til ny klasse

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
</head>
<body>
 
<h3>Registrer ny klasse</h3>
<form method="post" action="">

    Klassekode: <input type="text" name="klassekode" maxlength="10" required><br><br>

    Klassenavn: <input type="text" name="klassenavn" required><br><br>

    Studiumkode: <input type="text" name="studiumkode" required><br><br>
<input type="submit" name="registrerKlasseKnapp" value="Registrer klasse">
<input type="reset" value="Nullstill">
</form>
 
<p><a href="vis-alle-klasser.php">Vis alle klasser</a></p>
 
</body>
</html>

 