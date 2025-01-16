<?php

// Constanten (connectie-instellingen databank)
define('DB_HOST', 'localhost');
define('DB_USER', 'yutaka');
define('DB_PASS', 'Aza@ever7');
define('DB_NAME', 'labo05_db');

date_default_timezone_set('Europe/Brussels');

// Verbinding maken met de databank
try {
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Verbindingsfout: ' . $e->getMessage();
    exit;
}

// Opvragen van alle berichten uit de tabel messages
$stmt = $db->prepare('SELECT * FROM messages ORDER BY added_on DESC');
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?><!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn berichten</title>
    <link rel="stylesheet" type="text/css" href="./styles.css"> <!-- Zorg dat styles.css correct gekoppeld is -->
</head>
<body>
    <main class="container">
        <h1>Mijn Berichten</h1>
        <?php if (count($items) > 0) { ?>
            <ul>
                <?php foreach ($items as $item) { ?>
                    <li>
                        <strong><?php echo htmlspecialchars($item['sender'], ENT_QUOTES, 'UTF-8'); ?>:</strong>
                        <?php echo htmlspecialchars($item['message'], ENT_QUOTES, 'UTF-8'); ?>
                        <em>(<?php echo (new DateTime($item['added_on']))->format('d-m-Y H:i:s'); ?>)</em>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>Nog geen berichten ontvangen.</p>
        <?php } ?>
    </main>
</body>
</html>