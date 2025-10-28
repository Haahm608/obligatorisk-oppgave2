<?php

/*

* Programmet lager et skjema for å kunne slette en student

* Programmet sletter den valgte studenten

*/

?>
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

    Student: <select name="brukernavn" id="brukernavn" required>
<option value="">Velg student</option>
<?php 

        include("dynamiske-funksjoner.php"); 

        listeboksStudent();  // Endret fra listeboksStudentnr() til listeboksStudent()

        ?>
</select> <br/>
<input type="submit" value="Slett student" name="slettStudentKnapp" id="slettStudentKnapp" />
</form>
 
<?php

if (isset($_POST["slettStudentKnapp"])) {

    $brukernavn = trim($_POST["brukernavn"]);

    if (!$brukernavn) {

        print("<p style='color:red'>Det er ikke valgt noen student.</p>");

    } else {

        include("db-tilkobling.php");

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
 