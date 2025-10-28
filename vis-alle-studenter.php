<?php

include("db-tilkobling.php");
 
$sqlSetning = "SELECT * FROM student ORDER BY brukernavn";

$sqlResultat = mysqli_query($db, $sqlSetning) or die ("Ikke mulig å hente data fra databasen");

$antallRader = mysqli_num_rows($sqlResultat);

?>
<!DOCTYPE html>
<html lang="no">
<head>
<meta charset="UTF-8">
<title>Vis alle studenter</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
 
<h3>Registrerte studenter</h3>
 
<?php

if ($antallRader == 0) {

    print("<p>Ingen studenter er registrert ennå.</p>");

} else {

    print("<table>");

    print("<tr><th>Brukernavn</th><th>Fornavn</th><th>Etternavn</th><th>Klassekode</th></tr>");

    for ($r = 1; $r <= $antallRader; $r++) {

        $rad = mysqli_fetch_array($sqlResultat);

        $brukernavn = $rad["brukernavn"];

        $fornavn = $rad["fornavn"];

        $etternavn = $rad["etternavn"];

        $klassekode = $rad["klassekode"];

        print("<tr><td>$brukernavn</td><td>$fornavn</td><td>$etternavn</td><td>$klassekode</td></tr>");

    }

    print("</table>");

}

?>
 
<p><a href="registrer-student.php">Registrer ny student</a></p>
<p><a href="index.html">Tilbake til hovedmeny</a></p>
 
</body>
</html>
 