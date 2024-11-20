<?php

// Show all errors (for educational purposes)
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

// Constanten (connectie-instellingen databank)
define('DB_HOST', 'localhost:3306');
define('DB_USER', 'dylan');
define('DB_PASS', 'Yippie123!');
define('DB_NAME', 'contact');

date_default_timezone_set('Europe/Brussels');

// Verbinding maken met de databank
try {
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Verbindingsfout: ' . $e->getMessage();
    exit;
}

$name = isset($_POST['name']) ? (string)$_POST['name'] : '';
$email = isset($_POST['email']) ? (string)$_POST['email'] : '';
$message = isset($_POST['message']) ? (string)$_POST['message'] : '';
$msgName = '';
$msgEmail = '';
$msgMessage = '';

// form is sent: perform formchecking!
if (isset($_POST['btnSubmit'])) {

    $allOk = true;

    // name not empty
    if (trim($name) === '') {
        $msgName = 'Gelieve een naam in te voeren';
        $allOk = false;
    }

    if (trim($email) === '') {
        $msgEmail = 'Gelieve een email in te voeren';
        $allOk = false;
    }

    if (trim($message) === '') {
        $msgMessage = 'Gelieve een boodschap in te voeren';
        $allOk = false;
    }

    // end of form check. If $allOk still is true, then the form was sent in correctly
    if ($allOk) {
        // build & execute prepared statement
        $stmt = $db->prepare('INSERT INTO messages (sender, email, message, added_on) VALUES (?, ?, ?, ?)');
        $stmt->execute(array($name, $email, $message, (new DateTime())->format('Y-m-d H:i:s')));

        // the query succeeded, redirect to this very same page
        if ($db->lastInsertId() !== 0) {
            header('Location: formchecking_thanks.php?name=' . urlencode($name));
            exit();
        } // the query failed
        else {
            echo 'Databankfout.';
            exit;
        }

    }

}

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/@csstools/normalize.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <title>Contact</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="../"><img src="../images/logo.png" alt="Home"> / Dylan Baetens</a></li>
                <li><a href="../">Home</a></li>
                <li><a href="../projecten">Projecten</a></li>
                <li><a href="../overmij">Over mij</a></li>
                <li><a href="./">Contact</a></li>
            </ul>
        </nav>
    </header>
    <hr>
    <main>
        <form action="index.php" method="post">
            <h1>Contact</h1>
            <p class="message">Alle velden zijn verplicht, tenzij anders aangegeven.</p>

            <div>
                <label for="name">Jouw naam</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" class="input-text" />
            </div>

            <div>
                <label for="email">Jouw email</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" class="input-text" />
            </div>

            <div>
                <label for="message">Boodschap</label>
                <textarea name="message" id="message" rows="5" cols="40"><?php echo $message; ?></textarea>
            </div>

            <input type="submit" id="btnSubmit" name="btnSubmit" value="Verstuur" />
        </form>
    </main>
    <hr>
    <footer class="container">
        <p class="foot">&copy; 2024 Dylan Baetens - <a href="https://www.instagram.com/jack_edits_defuq">Instagram</a> -
            <a href="https://www.youtube.com/@HarJackore" class="links">Youtube</a>
        </p>
    </footer>
</body>
</html>