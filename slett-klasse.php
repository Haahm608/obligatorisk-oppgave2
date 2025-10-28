<?php
/* slett-klasse.php */
?>

<script src="funksjoner.js"></script>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettklasseSkjema" name="slettklasseSkjema">
    Klasse:
    <select name="klassekode" id="klassekode">
        <option value="">Velg klasse</option>
        <?php
        include("dynamiske-funksjoner.php");
        listeboksklassekode();
        ?>
    </select>
    <br><br>
    <input type="submit" value="Slett klasse" name="slettklasseKnapp" id="slettklasseKnapp">
</form>

<hr>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Debug: vis mottatte data
    echo "<h4>POST-data mottatt:</h4>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Hent valgt klasse
    $klassekode = trim($_POST["klassekode"] ?? '');

    if ($klassekode == "") {
        echo "<p style='color:red;'>❌ Du må velge en klasse før du kan slette.</p>";
    } else {
        include("db-tilkobling.php");

        if (!$db) {
            die("<p style='color:red;'>Feil: ikke kontakt med database: " . mysqli_connect_error() . "</p>");
        }

        // Sjekk om klassen har studenter
        $sqlSjekk = "SELECT * FROM student WHERE klassekode = '$klassekode'";
        $resultat = mysqli_query($db, $sqlSjekk);

        if (!$resultat) {
            die("<p style='color:red;'>Feil i SQL (sjekk): " . mysqli_error($db) . "</p>");
        }

        $antall = mysqli_num_rows($resultat);

        if ($antall > 0) {
            echo "<p style='color:red;'>❌ Kan ikke slette klasse <b>$klassekode</b> fordi den har registrerte studenter.</p>";
        } else {
            // Prøv å slette
            $sqlSlett = "DELETE FROM klasse WHERE klassekode = '$klassekode'";
            $ok = mysqli_query($db, $sqlSlett);

            if ($ok) {
                echo "<p style='color:green;'>✅ Klassen <b>$klassekode</b> er nå slettet.</p>";
            } else {
                echo "<p style='color:red;'>Feil ved sletting: " . mysqli_error($db) . "</p>";
            }
        }

        mysqli_close($db);
    }
}
?>
