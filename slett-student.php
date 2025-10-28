<?php

/*

* Programmet lager et skjema for å kunne slette en student

* Programmet sletter den valgte studenten

*/

include("db-tilkobling.php");

?>
<!DOCTYPE html>
<html lang="no">
<head>
<meta charset="UTF-8">
<title>Slett student</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
 
<script>

function bekreft() {

    var brukernavn = document.getElementById("brukernavn").value;

    if (brukernavn == "") {

        alert("Velg en student å slette");

        return false;

    }

    return confirm("Er du sikker på at du vil slette denne studenten?");

}
</script>
 
<h3>Slett student</h3>
<form method="post" action="" id="slettStudentSkjema" name="slettStudentSkjema" onSubmit="return bekreft()">
<div class="form-group">
<label>Student:</label>
<select name="brukernavn" id="brukernavn" required>
<option value="">Velg student</option>
<?php

            // Bygg listeboksen direkte istedenfor å bruke dynamiske-funksjoner.php

            $sql = "SELECT * FROM student ORDER BY brukernavn";

            $resultat = mysqli_query($db, $sql);

            if ($resultat && mysqli_num_rows($resultat) > 0) {

                while ($rad = mysqli_fetch_array($resultat)) {

                    $brukernavn = $rad["brukernavn"];

                    $fornavn = $rad["fornavn"];

                    $etternavn = $rad["etternavn"];

                    echo "<option value='$brukernavn'>$brukernavn - $fornavn $etternavn</option>";

                }

            } else {

                echo "<option value=''>Ingen studenter registrert</option>";

            }

            ?>
</select>
</div>
<div class="button-group">
<input type="submit" value="Slett student" name="slettStudentKnapp" id="slettStudentKnapp" class="btn-danger">
</div>
</form>
 
<?php

if (isset($_POST["slettStudentKnapp"])) {

    $brukernavn = trim($_POST["brukernavn"]);
 
    if (!$brukernavn) {

        print("<p style='color:red'>Det er ikke valgt noen student.</p>");

    } else {

        // Først hent informasjon om studenten

        $sqlHentInfo = "SELECT * FROM student WHERE brukernavn='$brukernavn'";

        $resultat = mysqli_query($db, $sqlHentInfo);
 
        if (mysqli_num_rows($resultat) == 0) {

            print("<p style='color:red'>Studenten finnes ikke.</p>");

        } else {

            $rad = mysqli_fetch_array($resultat);

            $fornavn = $rad["fornavn"];

            $etternavn = $rad["etternavn"];
 
            // Slett studenten

            $sqlSetning = "DELETE FROM student WHERE brukernavn='$brukernavn'";

            if (mysqli_query($db, $sqlSetning)) {

                print("<p style='color:green'>

                        Studenten '$brukernavn - $fornavn $etternavn' er nå slettet!
</p>");

            } else {

                print("<p style='color:red'>

                        Feil ved sletting: " . mysqli_error($db) . "
</p>");

            }

        }

    }

}

?>
 
<p><a href="vis-alle-studenter.php">Vis alle studenter</a></p>
<p><a href="index.html">Tilbake til hovedmeny</a></p>
 
</body>
</html>
 