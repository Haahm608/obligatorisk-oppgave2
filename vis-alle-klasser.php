<?php
include("db-tilkobling.php");
 
$sql = "SELECT * FROM klasse ORDER BY klassekode";
$resultat = mysqli_query($db, $sql);
$antall = mysqli_num_rows($resultat);
?>
 
<!DOCTYPE html>
<html lang="no">
<head>
<meta charset="UTF-8">
<title>Vis alle klasser</title>
</head>
<body>
 
<h3>Registrerte klasser</h3>
 
<?php
if ($antall == 0) {
    print("<p>Ingen klasser er registrert ennå.</p>");
} else {
    print("<table border='1' cellpadding='5'>");
    print("<tr><th>Klassekode</th><th>Klassenavn</th><th>Studiumkode</th></tr>");
 
    while ($rad = mysqli_fetch_assoc($resultat)) {
        $klassekode  = htmlspecialchars($rad["klassekode"]);
        $klassenavn  = htmlspecialchars($rad["klassenavn"]);
        $studiumkode = htmlspecialchars($rad["studiumkode"]);
 
        print("<tr>
<td>$klassekode</td>
<td>$klassenavn</td>
<td>$studiumkode</td>
</tr>");
    }
    print("</table>");
}
?>
 
<p><a href="registrer-klasse.php">Registrer ny klasse</a></p>
 
</body>
</html>
 