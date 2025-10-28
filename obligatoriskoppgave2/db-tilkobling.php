<?php

/* Kobling til USN-database */
 
// Bruk informasjonen fra phpMyAdmin

$host = "b-studentsql-1.usn.no";

$username = "haahm5273";

$password = "eef1haahm5273; // ← skriv inn passordet du bruker i phpMyAdmin

$database = "haahm5273";
 
// Forsøk tilkobling

$db = mysqli_connect($host, $username, $password, $database);
 
// Sjekk om det fungerer

if (!$db) {

    die("Feil ved tilkobling til databasen: " . mysqli_connect_error());

}
 
// Tilkoblingen fungerer

// echo "Tilkobling vellykket!";

?>
 