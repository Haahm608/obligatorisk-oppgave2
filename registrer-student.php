include("db-tilkobling.php");
$resultat = mysqli_query($db, "SELECT * FROM klasse");
while ($rad = mysqli_fetch_assoc($resultat)) {
    echo "Klasse: " . $rad['klassekode'] . " - " . $rad['klassenavn'] . "<br>";
}
