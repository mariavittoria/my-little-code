<?php
// Credenziali accesso database
$servername = "localhost";
$username_db = "root";
$password_db = ""; 
$dbname = "aula";

// Creare la connessione
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Controllare la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Prendere i parametri POST
$username = $_POST['username']; 
$password = $_POST['password'];

// Preparare la query SQL per ottenere la hash della password memorizzata
$sql = $conn->prepare("SELECT password FROM utenti WHERE username = ?");
$sql->bind_param("s", $username);
// Lanciare la query
$sql->execute();
// Ottenere i risultati
$result = $sql->get_result();

if ($result->num_rows > 0) {
    // Utente trovato
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    // Verificare la password inserita con la hash memorizzata
    if (password_verify($password, $hashed_password)) {
        // Password corretta
        header("Location: ../avvio.html");
    } else {
        // Password errata
        header("Location: ../errore.html");
        exit;
    }
} else {
    // Utente non trovato
    header("Location: ../errore.html");
    exit;
}

$sql->close();
$conn->close();
?>