<?php

include("db-tilkobling.php");
 
if (isset($_POST["registrerStudentKnapp"])) {

    $brukernavn = trim($_POST["brukernavn"]);

    $fornavn    = trim($_POST["fornavn"]);

    $etternavn  = trim($_POST["etternavn"]);

    $klassekode = trim($_POST["klassekode"]);
 
    // Validering basert på databasestrukturen

    if (strlen($brukernavn) != 7) {

        print("<p style='color:red'>Brukernavn må være nøyaktig 7 tegn!</p>");

    }

    elseif (strlen($fornavn) > 50) {

        print("<p style='color:red'>Fornavn kan maks være 50 tegn.</p>");

    }

    elseif (strlen($etternavn) > 50) {

        print("<p style='color:red'>Etternavn kan maks være 50 tegn.</p>");

    }

    elseif (!$brukernavn || !$fornavn || !$etternavn || !$klassekode) {

        print("<p style='color:red'>Alle felt må fylles ut.</p>");

    } else {

        // Sjekk om studenten finnes fra før

        $sqlSjekk = "SELECT * FROM student WHERE brukernavn = '$brukernavn'";

        $resultat = mysqli_query($db, $sqlSjekk);
 
        if (mysqli_num_rows($resultat) > 0) {

            print("<p style='color:orange'>Studenten finnes allerede.</p>");

        } else {

            // Legg til ny student

            $sqlSettInn = "INSERT INTO student (brukernavn, fornavn, etternavn, klassekode)

                           VALUES ('$brukernavn', '$fornavn', '$etternavn', '$klassekode')";

            if (mysqli_query($db, $sqlSettInn)) {

                print("<p style='color:green'>

                        🎉 Studenten '$brukernavn - $fornavn $etternavn' ble registrert!
</p>");

            } else {

                print("<p style='color:red'>

                        ❌ Feil ved registrering: " . mysqli_error($db) . "
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
<title>Registrer student</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
 
<h3>Registrer ny student</h3>
<form method="post" action="">
<div class="form-group">
<label>Brukernavn:</label>
<input type="text" name="brukernavn" maxlength="7" placeholder="f.eks. stud001" required>
<small>7 tegn - unikt identifikator</small>
</div>
 
    <div class="form-group">
<label>Fornavn:</label>
<input type="text" name="fornavn" maxlength="50" placeholder="Skriv fornavn her" required>
</div>
 
    <div class="form-group">
<label>Etternavn:</label>
<input type="text" name="etternavn" maxlength="50" placeholder="Skriv etternavn her" required>
</div>
 
    <div class="form-group">
<label>Klassekode:</label>
<select name="klassekode" required>
<option value="">Velg klasse</option>
<?php

            // Bygg listeboksen direkte istedenfor å bruke dynamiske-funksjoner.php

            $sql = "SELECT * FROM klasse ORDER BY klassekode";

            $resultat = mysqli_query($db, $sql);

            if ($resultat && mysqli_num_rows($resultat) > 0) {

                while ($rad = mysqli_fetch_array($resultat)) {

                    $kode = $rad["klassekode"];

                    $navn = $rad["klassenavn"];

                    echo "<option value='$kode'>$kode - $navn</option>";

                }

            } else {

                echo "<option value=''>Ingen klasser tilgjengelig</option>";

            }

            ?>
</select>
<small>Velg hvilken klasse studenten skal tilhøre</small>
</div>
 
    <div class="button-group">
<input type="submit" name="registrerStudentKnapp" value="🎓 Registrer student" class="btn-primary">
<input type="reset" value="🧹 Nullstill" class="btn-secondary">
</div>
</form>
 
<div class="navigation-links">
<p><a href="vis-alle-studenter.php">📋 Vis alle studenter</a></p>
<p><a href="index.html">🏠 Tilbake til hovedmeny</a></p>
</div>
 
</body>
</html>
 