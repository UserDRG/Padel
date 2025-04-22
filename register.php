<?php
// Inclure la configuration de la base de données
require_once 'config.php';

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Déterminer s'il s'agit d'un client ou d'un administrateur
    if (isset($_POST['clientName'])) {
        // Enregistrement d'un client
        $name = $_POST['clientName'];
        $email = $_POST['clientEmail'];
        $phone = $_POST['clientPhone'];
        $password = password_hash($_POST['clientPassword'], PASSWORD_DEFAULT); // Hashage du mot de passe
        $user_type = 'client';
    } else if (isset($_POST['adminName'])) {
        // Enregistrement d'un administrateur
        $name = $_POST['adminName'];
        $email = $_POST['adminEmail'];
        $phone = $_POST['adminPhone'];
        $password = password_hash($_POST['adminPassword'], PASSWORD_DEFAULT); // Hashage du mot de passe
        $user_type = 'admin';
        $admin_code = $_POST['adminCode'];
        
        // Vérifier si le code d'entreprise est correct
        if ($admin_code != "VOTRE_CODE_SECRET") { // Remplacez par votre code secret
            header("Location: index.html?register=invalid_code");
            exit();
        }
    } else {
        // Formulaire invalide
        header("Location: index.html?register=invalid");
        exit();
    }
    
    // Vérifier si l'email existe déjà
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Email déjà utilisé
        header("Location: index.html?register=email_exists");
    } else {
        // Insérer le nouvel utilisateur
        $sql = "INSERT INTO users (name, email, phone, password, user_type) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $phone, $password, $user_type);
        
        if ($stmt->execute()) {
            // Enregistrement réussi
            header("Location: index.html?register=success");
        } else {
            // Erreur lors de l'enregistrement
            header("Location: index.html?register=error");
        }
    }
    
    $stmt->close();
    $conn->close();
    exit();
}

// Si accès direct à cette page
header("Location: index.html");
?>
