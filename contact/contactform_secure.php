<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);


define('DB_HOST', 'localhost');
define('DB_USER', 'yutaka');
define('DB_PASS', 'Aza@ever7');
define('DB_NAME', 'labo05_db');

date_default_timezone_set('Europe/Brussels');


try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Verbindingsfout: ' . $e->getMessage();
    exit;
}

$name = isset($_POST['name']) ? (string) $_POST['name'] : '';
$email = isset($_POST['email']) ? (string) $_POST['email'] : '';
$message = isset($_POST['message']) ? (string) $_POST['message'] : '';
$msgName = '';
$msgEmail = '';
$msgMessage = '';


if (isset($_POST['btnSubmit'])) {

    $allOk = true;


    if (trim($name) === '') {
        $msgName = 'Gelieve een naam in te voeren';
        $allOk = false;
    }


    if (trim($email) === '') {
        $msgEmail = 'Gelieve een e-mailadres in te voeren';
        $allOk = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msgEmail = 'Gelieve een geldig e-mailadres in te voeren';
        $allOk = false;
    }


    if (trim($message) === '') {
        $msgMessage = 'Gelieve een boodschap in te voeren';
        $allOk = false;
    }


    if ($allOk) {

        $stmt = $pdo->prepare('INSERT INTO messages (sender, email, message, added_on) VALUES (?, ?, ?, ?)');
        $stmt->execute(array($name, $email, $message, (new DateTime())->format('Y-m-d H:i:s')));


        if ($pdo->lastInsertId() !== 0) {
            header('Location: formchecking_thanks.php?name=' . urlencode($name));
            exit();
        } else {
            echo 'Databankfout.';
            exit;
        }
    }
}

?><!DOCTYPE html>
<html lang="nl">

<head>
    <title>Testform</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="./styles.css" />
</head>

<body>
    <a href="javascript:history.back()" class="back-button">← Terug</a>

    <main class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <h1>Testform</h1>
            <p class="message">Alle velden zijn verplicht, tenzij anders aangegeven.</p>

            <div>
                <label for="name">Jouw naam</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"
                    class="input-text" required />
                <span class="message error"><?php echo $msgName; ?></span>
            </div>

            <div>
                <label for="email">Jouw e-mail</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"
                    class="input-text" required />
                <span class="message error"><?php echo $msgEmail; ?></span>
            </div>

            <div>
                <label for="message">Boodschap</label>
                <textarea name="message" id="message" rows="5" cols="40"
                    required><?php echo htmlspecialchars($message); ?></textarea>
                <span class="message error"><?php echo $msgMessage; ?></span>
            </div>

            <input type="submit" id="btnSubmit" name="btnSubmit" value="Verstuur" />
        </form>
    </main>
</body>

</html>