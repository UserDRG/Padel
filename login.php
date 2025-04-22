<?php
// Démarrer la session
session_start();

// Inclure la configuration de la base de données
require_once 'config.php';

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];
    
    // Préparer la requête SQL
    $sql = "SELECT id, name, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Vérifier le mot de passe
        if (password_verify($password, $user['password'])) {
            // Authentification réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            
            // Redirection vers la page d'accueil
            header("Location: index.html?login=success");
        } else {
            // Mot de passe incorrect
            header("Location: index.html?login=failed");
        }
    } else {
        // Email non trouvé
        header("Location: index.html?login=failed");
    }
    
    $stmt->close();
    $conn->close();
    exit();
}

// Si accès direct à cette page
header("Location: index.html");
?>
