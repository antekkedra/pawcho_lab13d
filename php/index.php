<?php
$user = trim(file_get_contents('/run/secrets/db_user'));
$pass = trim(file_get_contents('/run/secrets/db_password'));

try {
    new PDO("mysql:host=mysql;dbname=db", $user, $pass);
    echo "Połączenie z bazą danych OK";
} catch (PDOException $e) {
    echo "Błąd połączenia z DB";
}
