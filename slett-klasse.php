 <?php

/*

* Programmet lager et skjema for å kunne slette en klasse

* Programmet sletter den valgte klassen

*/
 
// Inkluder database-tilkobling og funksjoner FØRST

include("db-tilkobling.php");

include("dynamiske-funksjoner.php");

?>
<script>

function bekreft() {

    var klassekode = document.getElementById("klassekode").value;

    if (klassekode == "") {

        alert("Velg en klasse å slette");

        return false;

    }

    return confirm("Er du sikker på at du vil slette denne klassen? ALLE STUDENTER I DENNE KLASSEN VIL BLI SLETTET!");

}
</script>
 
<h3>Slett klasse</h3>
<form method="post" action="" id="slettklasseSkjema" name="slettklasseSkjema" onSubmit="return bekreft()">

    Klasse: 
<select name="klassekode" id="klassekode" required>
<option value="">Velg klasse</option>
<?php 

        // Bygg listeboksen direkte for å sikre at den fungerer

        $sql = "SELECT * FROM klasse ORDER BY klassekode";

        $resultat = mysqli_query($db, $sql);

        if ($resultat && mysqli_num_rows($resultat) > 0) {

            while ($rad = mysqli_fetch_array($resultat)) {

                $kode = $rad["klassekode"];

                $navn = $rad["klassenavn"];

                echo "<option value='$kode'>$kode - $navn</option>";

            }

        } else {

            echo "<option value=''>Ingen klasser funnet</option>";

        }

        ?>
</select> <br/>
<input type="submit" value="Slett klasse" name="slettklasseKnapp" id="slettklasseKnapp" />
</form>
 
<?php

if (isset($_POST["slettklasseKnapp"])) {

    $klassekode = trim($_POST["klassekode"]);

    if (!$klassekode) {

        print("<p style='color:red'>Det er ikke valgt noen klasse.</p>");

    } else {

        // Database-tilkobling er allerede inkludert øverst

        // Først sjekk om klassen finnes

        $sqlSjekk = "SELECT * FROM klasse WHERE klassekode='$klassekode'";

        $resultat = mysqli_query($db, $sqlSjekk);

        if (mysqli_num_rows($resultat) == 0) {

            print("<p style='color:red'>Klassen finnes ikke.</p>");

        } else {

            $rad = mysqli_fetch_array($resultat);

            $klassenavn = $rad["klassenavn"];

            // Slett først alle studentene i klassen

            $sqlSlettStudenter = "DELETE FROM student WHERE klassekode='$klassekode'";

            mysqli_query($db, $sqlSlettStudenter);

            // Slett deretter klassen

            $sqlSlettKlasse = "DELETE FROM klasse WHERE klassekode='$klassekode'";

            if (mysqli_query($db, $sqlSlettKlasse)) {

                print("<p style='color:green'>

                        Klassen '$klassekode - $klassenavn' er nå slettet!<br>

                        Alle studenter i denne klassen er også slettet.
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
 