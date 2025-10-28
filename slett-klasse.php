<?php
include("db-tilkobling.php");
?>

<!DOCTYPE html>
<html lang="no">
<head>
<meta charset="utf-8">
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
        // Fyll select med klasser fra DB (enkelt, trygg SELECT)
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
            echo "<option value=''>Feil ved henting</option>";
        }
        ?>
    </select>
    <br><br>
    <input type="submit" value="Slett klasse" name="slettklasseKnapp" id="slettklasseKnapp" />
</form>

<hr>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["slettklasseKnapp"])) {
    echo "<h4>POST-data mottatt:</h4><pre>" . print_r($_POST, true) . "</pre>";

    $klassekode = strtoupper(trim($_POST["klassekode"] ?? ''));

    if ($klassekode === '') {
        echo "<p style='color:red;'>Du må velge en klasse.</p>";
    } else {
        // Sjekk om det finnes studenter i klassen
        $sqlSjekk = "SELECT COUNT(*) as cnt FROM student WHERE klassekode = ?";
        $stmt = mysqli_prepare($db, $sqlSjekk);
        mysqli_stmt_bind_param($stmt, "s", $klassekode);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $cnt);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($cnt > 0) {
            echo "<p style='color:red;'>❌ Kan ikke slette klasse <b>$klassekode</b> fordi den har $cnt registrerte studenter.</p>";
            echo "<p>Hvis du ønsker å fjerne klassen inklusive studenter, se alternativer under.</p>";
            echo "<ul>
                    <li>Alternativ A: Fjern eller flytt studentene før sletting.</li>
                    <li>Alternativ B: Slett studentene automatisk (se SQL-kommando lenger ned).</li>
                  </ul>";
        } else {
            // Utfør sletting (prepared)
            $sqlSlett = "DELETE FROM klasse WHERE klassekode = ?";
            $stmt2 = mysqli_prepare($db, $sqlSlett);
            mysqli_stmt_bind_param($stmt2, "s", $klassekode);
            if (mysqli_stmt_execute($stmt2)) {
                if (mysqli_stmt_affected_rows($stmt2) > 0) {
                    echo "<p style='color:green;'>✅ Klassen <b>$klassekode</b> er nå slettet.</p>";
                } else {
                    echo "<p style='color:orange;'>Ingen rad ble slettet (finnes kanskje ikke).</p>";
                }
            } else {
                // Dersom MySQL blokkerer sletting pga FK, mysqli_error viser det
                echo "<p style='color:red;'>Feil ved sletting: " . mysqli_error($db) . "</p>";
            }
            mysqli_stmt_close($stmt2);
        }
    }
}
?>

</body>
</html>


