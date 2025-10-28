<?php
// Henter alle klasser til dropdown
function listeboksKlassekode() {
    include("db-tilkobling.php");
    $sql = "SELECT * FROM klasse ORDER BY klassekode;";
    $resultat = mysqli_query($db, $sql) or die("Feil ved henting av klasser: " . mysqli_error($db));
    while ($rad = mysqli_fetch_assoc($resultat)) {
        $kode = htmlspecialchars($rad["klassekode"]);
        $navn = htmlspecialchars($rad["klassenavn"]);
        print("<option value='$kode'>$kode - $navn</option>");
    }
}

// Henter alle studenter til dropdown
function listeboksStudent() {
    include("db-tilkobling.php");
    $sql = "SELECT * FROM student ORDER BY brukernavn;";
    $resultat = mysqli_query($db, $sql) or die("Feil ved henting av studenter: " . mysqli_error($db));
    while ($rad = mysqli_fetch_assoc($resultat)) {
        $brukernavn = htmlspecialchars($rad["brukernavn"]);
        $fornavn    = htmlspecialchars($rad["fornavn"]);
        $etternavn  = htmlspecialchars($rad["etternavn"]);
        print("<option value='$brukernavn'>$brukernavn - $fornavn $etternavn</option>");
    }
}
?>
