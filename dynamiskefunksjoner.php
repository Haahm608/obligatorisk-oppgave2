<?php
/* Kobling til USN-database */
 
// Bruk informasjonen fra phpMyAdmin
$host = "b-studentsql-1.usn.no";
$username = "ahabd4711";
$password = "212dahabd4711"; // ← skriv inn passordet du bruker i phpMyAdmin
$database = "ahabd4711";
 
// Forsøk tilkobling
$db = mysqli_connect($host, $username, $password, $database);
 
// Sjekk om det fungerer
if (!$db) {
    die("Feil ved tilkobling til databasen: " . mysqli_connect_error());
}
 
// Tilkoblingen fungerer
// echo "Tilkobling vellykket!";
?>
 