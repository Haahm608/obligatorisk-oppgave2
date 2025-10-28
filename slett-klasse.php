<?php
/* slett-klasse.php */

// Kobling til USN-database
$host = "b-studentsql-1.usn.no";
$username = "haahm5273";
$password = "eef1haahm5273"; // passordet ditt
$database = "haahm5273";

// Forsøk tilkobling
$db = mysqli_connect($host, $username, $password, $database);
if (!$db) {
    die("<p style='color:red;'>Feil ved tilkobling til databasen: " . mysqli_connect_error() . "</p>");
}
mysqli_set_charset($db, "utf8mb4");
?>

<!DOCTYPE html>
<html lang="no">
<head>
<meta charset="UTF-8">
<title>Slett klasse</title>
<script>
function bekreft() {
    return confirm("Er du sikker på at du vil slette denne klassen?");
}
</script>
</head>
<body>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettklasseSkjema" name="slettklasseSkjema" onsubmit="return bekreft();">
    Klasse:
    <select name="klassekode" id="klassekode" required>
        <option value="">Velg klasse</option>
        <?php
        // Hent alle klasser fra databasen
        $sql = "SELECT klassekode, klassenavn FROM klasse ORDER BY klassekode";
        $res = mysqli_query($db, $sql);
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $kode = htmlspecialchars($row['klassekode']);
                $navn = htmlspecialchars($row['klassenavn']);
                echo "<option value='$kode'>$kode - $navn</option>";
            }
            mysqli_free_result($res);
        } else {
            echo "<option value=''>Feil ved henting av klasser</option>";
        }
        ?>
    </select>
    <br><br>
    <input type="submit" value="Slett klasse" name="slettklasseKnapp" id="slettklasseKnapp" />
</form>

<hr>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["slettklasseKnapp"])) {

    // Hent valgt klassekode
    $klassekode = strtoupper(trim($_POST["klassekode"] ?? ''));

    if ($klassekode === '') {
        echo "<p style='color:red;'>Du må velge en klasse.</p>";
    } else {
        // Sjekk om klassen har registrerte studenter
        $sqlSjekk = "SELECT COUNT(*) AS antall FROM student WHERE klassekode = ?";
        $stmt = mysqli_prepare($db, $sqlSjekk);
        mysqli_stmt_bind_param($stmt, "s", $klassekode);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $antall);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($antall > 0) {
            echo "<p style='color:red;'>❌ Kan ikke slette klasse <b>$klassekode</b> fordi den har $antall registrerte studenter.</p>";
        } else {
            // Slett klassen
            $sqlSlett = "DELETE FROM klasse WHERE klassekode = ?";
            $stmt2 = mysqli_prepare($db, $sqlSlett);
            mysqli_stmt_bind_param($stmt2, "s", $klassekode);
            if (mysqli_stmt_execute($stmt2)) {
                if (mysqli_stmt_affected_rows($stmt2) > 0) {
                    echo "<p style='color:green;'>✅ Klassen <b>$klassekode</b> er nå slettet.</p>";
                } else {
                    echo "<p style='color:orange;'>Ingen rad ble slettet (klassen finnes kanskje ikke).</p>";
                }
            } else {
                echo "<p style='color:red;'>Feil ved sletting: " . mysqli_error($db) . "</p>";
            }
            mysqli_stmt_close($stmt2);
        }
    }
}
mysqli_close($db);
?>

</body>
</html>



