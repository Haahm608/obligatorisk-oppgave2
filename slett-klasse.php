<?php
/* slett-klasse */
?>
<script src="funksjoner.js"></script>
<h3>Slett klasse</h3>
<form method="post" action="" id="slettklasseSkjema" name="slettklasseSkjema" onSubmit="return bekreft()">
Klasse
<select name="klassekode" id="klassekode">
<?php
print("<option value=''>velg klasse </option>");
include("dynamiske-funksjoner.php");
listeboksklassekode();
?>
</select> <br/>
<input type="submit" value="Slett klasse" name="slettklasseKnapp" id="slettklasseKnapp" />
</form>
 
<?php
if (isset($_POST["slettklasseKnapp"])) {
    $klassekode = $_POST["klassekode"];
 
    if (!$klassekode) {
        print("Det er ikke valgt noen klasse");
    } else {
        include("db-tilkobling.php");
 
        // 🔹 Sjekk om klassen har registrerte studenter
        $sqlSjekk = "SELECT * FROM student WHERE klassekode='$klassekode';";
        $resultat = mysqli_query($db, $sqlSjekk);
        $antall = mysqli_num_rows($resultat);
 
        if ($antall > 0) {
            // Klassen har studenter — ikke slett
            print("Kan ikke slette klasse <b>$klassekode</b> fordi den har registrerte studenter.<br>");
        } else {
            // Klassen har ingen studenter — slett den
            $sqlSlett = "DELETE FROM klasse WHERE klassekode='$klassekode';";
            mysqli_query($db, $sqlSlett) or die("Ikke mulig å slette data i databasen.");
            print("Følgende klasse er nå slettet: <b>$klassekode</b><br>");
        }
    }
}
?>
 