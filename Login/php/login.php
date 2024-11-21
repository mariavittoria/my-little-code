<?php
    //credenziali accesso database
    $servername="localhost";    
    $username_db="root";
    $password_db="";
    $dbname="aula";

    //crea connessione al database
    $conn= new mysqli($servername, $username_db, $password_db, $dbname);
    //controllo connessione
    if ($conn->connect_error) {
        die("Connessione fallita" . $conn->connect_error);
    }
    //connessione aperta funzionante
    
    //prendo i parametri POST
    $username = $_POST['username']; 
    $password = $_POST['password'];


    //--> ATTENZIONE: La richiesta funziona solo se modifico la password nel DB a mano

    //preparare la query SQL
    $sql = $conn->prepare("SELECT * FROM `utenti` WHERE username = ? AND password = ?");
    $sql->bind_param("ss",$username, $password);
    //lancio della query
    $sql->execute();
    //ottenimento dei risultati
    $result=$sql->get_result();
    if ($result->num_rows >0) {
        //utente trovato
        header("Location: ../avvio.html");
    } else {
        //utente non trovato
        header("Location: ../errore.html");
        exit;
    }
    $sql->close();
    $conn->close();
?>

