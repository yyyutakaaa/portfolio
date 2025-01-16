<?php
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'gast';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bedankt!</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <main class="container">
        <h1>Bedankt!</h1>
        <p>Bedankt, <strong><?php echo $name; ?></strong>, voor je bericht! We nemen zo snel mogelijk contact met je op.</p>
        <a href="contactform_secure.php">Terug naar het formulier</a>
    </main>
</body>
</html>