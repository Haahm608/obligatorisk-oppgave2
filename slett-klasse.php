<?php
/* slett-klasse.php */
?>
<script src="funksjoner.js"></script>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettklasseSkjema" name="slettklasseSkjema" onSubmit="return bekreft()">
    Klasse:
    <select name="klassekode" id="klassekode" required>
        <option value="">Velg klasse</option>
        <?php
        include("dynamiske-funksjoner.php");
        listeboksklassekode();
        ?>
    </select>
    <br><br>
    <input type="submit" value="Slett klasse" name="slettklasseKnapp" id="slettklasseKnapp" />
</form>

<?php
if (isset($_POST["slettklasseKnapp"])) {
    $klassekode = trim($_POST["klassekode"]);

    if (!$klassekode) {
        print("<p style='color:red'>Du må velge en klasse.</p>");
    } else {
        include("db-tilkobling.php");

        // Sjekk om klassen har studenter
        $sqlSjekk = "SELECT * FROM student WHERE klassekode = ?";
        $stmt = mysqli_prepare($db, $sqlSjekk);
        mysqli_stmt_bind_param($stmt, "s", $klassekode);
        mysqli_stmt_execute($stmt);
        $resultat = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultat) > 0) {
            print("<p style='color:orange'>Kan ikke slette klasse <b>$klassekode</b> fordi den har registrerte studenter.</p>");
        } else {
            $sqlSlett = "DELETE FROM klasse WHERE klassekode = ?";
            $stmt = mysqli_prepare($db, $sqlSlett);
            mysqli_stmt_bind_param($stmt, "s", $klassekode);
            if (mysqli_stmt_execute($stmt)) {
                print("<p style='color:green'>Følgende klasse er nå slettet: <b>$klassekode</b></p>");
            } else {
                print("<p style='color:red'>Feil ved sletting: " . mysqli_error($db) . "</p>");
            }
        }
    }
}
?>
