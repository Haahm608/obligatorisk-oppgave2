<?php /* slett-klasse */
/*
/* Programmet lager et skjema for å kunne slette en klasse
/* Programmet sletter den valgte klassen
*/
?>
<script src="funksjoner.js"> </script>
<h3>Slett klasse</h3>
<form method="post" action="" id="slettklasseSkjema" name="slettklasseSkjema" onSubmit="return bekreft()">
Klasse
<select name="klassekode" id="klassekode">
<?php print("<option value=''>velg klasse </option>");
include("dynamiske-funksjoner.php"); listeboksKlassekode(); ?>
</select> <br/>
<input type="submit" value="Slett klasse" name="slettklasseKnapp" id="slettklasseKnapp" />
</form>
<?php
if (isset($_POST ["slettklasseKnapp"]))
{
$klassekode=$_POST ["klassekode"];
if (!$klassekode)
{
print ("Det er ikke valgt noe klasse");
}
else
{
include("db-tilkobling.php"); /* tilkobling til database-serveren utført og valg av database foretatt */
 
// Her begynner alternativ 1: slett studentene først
mysqli_query($db, "DELETE FROM student WHERE klassekode='$klassekode'")
    or die("Ikke mulig å slette studenter fra databasen.");
 
// Slett deretter klassen
$sqlSetning="DELETE FROM klasse WHERE klassekode='$klassekode';";
mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; slette data i databasen");
/* SQL-setning sendt til database-serveren */
print ("F&oslash;lgende klasse er n&aring; slettet: $klassekode <br />");
}
}
?>
 
 