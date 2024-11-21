<?php
$servername = "localhost";
$username_db = "root";
$password_db = ""; // Imposta la password del tuo database
$dbname = "aula"; // Usa il nome del tuo database

// Creare la connessione
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Controllare la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['indirizzo']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $indirizzo = $_POST['indirizzo'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash della password per la sicurezza

        // Preparare e bind
        $stmt = $conn->prepare("INSERT INTO utenti (nome, cognome, indirizzo, email, username, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nome, $cognome, $indirizzo, $email, $username, $password);

        // Eseguire la query
        if ($stmt->execute()) {
            echo "Registrazione completata con successo";
        } else {
            echo "Errore: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo 'Uno o più campi non sono stati inviati correttamente.';
    }
} else {
    echo 'Metodo di richiesta non valido.';
}

$conn->close();
?>