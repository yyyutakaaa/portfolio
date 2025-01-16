<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=labo05", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Verbinding succesvol!";
} catch (PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
}
?>