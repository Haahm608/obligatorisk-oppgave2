<?php
include("db-tilkobling.php"); // kobler til databasen

if (isset($_POST["registrerStudentKnapp"])) {
    $brukernavn = trim($_POST["brukernavn"]);
    $fornavn    = trim($_POST["fornavn"]);
    $etternavn  = trim($_POST["etternavn"]);
    $klassekode = trim($_POST["klassekode"]);

    // Validering basert på databasestrukturen
    if (strlen($brukernavn) > 7) {
        print("<p style='color:red'>Brukernavn kan være maks 7 tegn.</p>");
    } elseif (strlen($fornavn) > 50) {
        print("<p style='color:red'>Fornavn kan maks være 50 tegn.</p>");
    } elseif (strlen($etternavn) > 50) {
        print("<p style='color:red'>Etternavn kan maks være 50 tegn.</p>");
    } elseif (!$brukernavn || !$fornavn || !$etternavn || !$klassekode) {
        print("<p style='color:red'>Alle felt må fylles ut.</p>");
    } else {
        // Sjekk om studenten finnes fra før
        $sqlSjekk = "SELECT * FROM student WHERE brukernavn = ?";
        $stmt = mysqli_prepare($db, $sqlSjekk);
        mysqli_stmt_bind_param($stmt, "s", $brukernavn);
        mysqli_stmt_execute($stmt);
        $resultat = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultat) > 0) {
            print("<p style='color:orange'>Studenten finnes allerede.</p>");
        } else {
            // Legg til ny student
            $sqlSettInn = "INSERT INTO student (brukernavn, fornavn, etternavn, klassekode)
                           VALUES (?, ?, ?, ?)";
            $stmt2 = mysqli_prepare($db, $sqlSettInn);
            mysqli_stmt_bind_param($stmt2, "ssss", $brukernavn, $fornavn, $etternavn, $klassekode);
            if (mysqli_stmt_execute($stmt2)) {
                print("<p style='color:green'>
                        Studenten <b>$brukernavn – $fornavn $etternavn</b> ble registrert i klasse <b>$klassekode</b>!
                </p>");
            } else {
                print("<p style='color:red'>
                        Feil ved registrering: " . mysqli_error($db) . "
                </p>");
            }
            mysqli_stmt_close($stmt2);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
<meta charset="UTF-8">
<title>Registrer student</title>
</head>
<body>

<h3>Registrer student</h3>
<form method="post" action="">
    Brukernavn: <input type="text" name="brukernavn" maxlength="7" required><br><br>
    Fornavn: <input type="text" name="fornavn" maxlength="50" required><br><br>
    Etternavn: <input type="text" name="etternavn" maxlength="50" required><br><br>
    Klassekode:
    <select name="klassekode" required>
        <option value="">Velg klasse</option>
        <?php
        // Hent klassene fra databasen
        $sqlKlasse = "SELECT klassekode, klassenavn FROM klasse ORDER BY klassekode";
        $res = mysqli_query($db, $sqlKlasse);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($rad = mysqli_fetch_assoc($res)) {
                $kode = htmlspecialchars($rad['klassekode']);
                $navn = htmlspecialchars($rad['klassenavn']);
                echo "<option value='$kode'>$kode - $navn</option>";
            }
        } else {
            echo "<option value=''>Ingen klasser funnet</option>";
        }
        ?>
    </select><br><br>

    <input type="submit" name="registrerStudentKnapp" value="Registrer student">
    <input type="reset" value="Nullstill">
</form>

<p><a href="vis-alle-studenter.php">Vis alle studenter</a></p>

</body>
</html>