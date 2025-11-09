<?php
/*
* Programmet viser et skjema for å slette en student
* og sletter valgt student fra databasen.
*/

include("db-tilkobling.php");
?>

<!DOCTYPE html>
<html lang="no">
<head>
<meta charset="UTF-8">
<title>Slett student</title>
<script>
function bekreft() {
    var brukernavn = document.getElementById("brukernavn").value;
    if (brukernavn === "") {
        alert("Velg en student å slette.");
        return false;
    }
    return confirm("Er du sikker på at du vil slette denne studenten?");
}
</script>
</head>
<body>

<h3>Slett student</h3>
<form method="post" action="" id="slettStudentSkjema" onsubmit="return bekreft();">
    Student:
    <select name="brukernavn" id="brukernavn" required>
        <option value="">Velg student</option>
        <?php
        // Hent alle studenter fra databasen
        $sql = "SELECT brukernavn, fornavn, etternavn FROM student ORDER BY brukernavn";
        $resultat = mysqli_query($db, $sql);
        if ($resultat && mysqli_num_rows($resultat) > 0) {
            while ($rad = mysqli_fetch_assoc($resultat)) {
                $brukernavn = htmlspecialchars($rad['brukernavn']);
                $navn = htmlspecialchars($rad['fornavn'] . " " . $rad['etternavn']);
                echo "<option value='$brukernavn'>$brukernavn – $navn</option>";
            }
        } else {
            echo "<option value=''>Ingen studenter registrert</option>";
        }
        ?>
    </select>
    <br><br>
    <input type="submit" value="Slett student" name="slettStudentKnapp" id="slettStudentKnapp">
</form>

<hr>

<?php
if (isset($_POST["slettStudentKnapp"])) {
    $brukernavn = trim($_POST["brukernavn"]);

    if ($brukernavn === "") {
        echo "<p style='color:red'>Du må velge en student.</p>";
    } else {
        // Finn informasjon om studenten
        $sqlHent = "SELECT fornavn, etternavn FROM student WHERE brukernavn = ?";
        $stmt = mysqli_prepare($db, $sqlHent);
        mysqli_stmt_bind_param($stmt, "s", $brukernavn);
        mysqli_stmt_execute($stmt);
        $resultat = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultat) === 0) {
            echo "<p style='color:red'>Studenten finnes ikke.</p>";
        } else {
            $rad = mysqli_fetch_assoc($resultat);
            $fornavn = $rad["fornavn"];
            $etternavn = $rad["etternavn"];

            // Slett studenten
            $sqlSlett = "DELETE FROM student WHERE brukernavn = ?";
            $stmtSlett = mysqli_prepare($db, $sqlSlett);
            mysqli_stmt_bind_param($stmtSlett, "s", $brukernavn);
            if (mysqli_stmt_execute($stmtSlett)) {
                echo "<p style='color:green'>
                        ✅ Studenten <b>$brukernavn – $fornavn $etternavn</b> er nå slettet.
                      </p>";
            } else {
                echo "<p style='color:red'>Feil ved sletting: " . mysqli_error($db) . "</p>";
            }
            mysqli_stmt_close($stmtSlett);
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($db);
?>

</body>
</html>