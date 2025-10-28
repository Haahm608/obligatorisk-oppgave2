<?php

function listeboksKlassekode() {

    include("db-tilkobling.php");

    $sql = "SELECT * FROM klasse ORDER BY klassekode;";

    $resultat = mysqli_query($db,$sql) or die("Feil ved henting av klasser: " . mysqli_error($db));

    while ($rad = mysqli_fetch_array($resultat)) {

        $kode = $rad["klassekode"];

        $navn = $rad["klassenavn"];

        print("<option value='$kode'>$kode - $navn</option>");

    }

}

function listeboksStudent() {

    include("db-tilkobling.php");

    $sql = "SELECT * FROM student ORDER BY brukernavn;";

    $resultat = mysqli_query($db,$sql) or die("Feil ved henting av studenter: " . mysqli_error($db));

    while ($rad = mysqli_fetch_array($resultat)) {

        $brukernavn = $rad["brukernavn"];

        $fornavn    = $rad["fornavn"];

        $etternavn  = $rad["etternavn"];

        print("<option value='$brukernavn'>$brukernavn - $fornavn $etternavn</option>");

    }

}
 
// LEGG TIL DENNE NYE FUNKSJONEN:

function listeboksStudentnr() {

    include("db-tilkobling.php");

    $sql = "SELECT * FROM student ORDER BY brukernavn;";

    $resultat = mysqli_query($db,$sql) or die("Feil ved henting av studenter: " . mysqli_error($db));

    while ($rad = mysqli_fetch_array($resultat)) {

        $brukernavn = $rad["brukernavn"];

        $fornavn    = $rad["fornavn"];

        $etternavn  = $rad["etternavn"];

        print("<option value='$brukernavn'>$brukernavn - $fornavn $etternavn</option>");

    }

}

?>
 