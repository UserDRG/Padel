<?php
// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    // Email de destination (votre email)
    $to = "popolo11828@gmail.com";
    
    // Construction de l'email
    $email_subject = "Nouveau message de contact: $subject";
    $email_body = "Vous avez reçu un nouveau message.\n\n".
                 "Nom: $name\n".
                 "Email: $email\n".
                 "Objet: $subject\n".
                 "Message:\n$message";
    $headers = "From: $email\r\nReply-To: $email";
    
    // Envoi de l'email
    if(mail($to, $email_subject, $email_body, $headers)) {
        // Redirection avec message de succès
        header("Location: index.html?message=success#contact");
    } else {
        // Redirection avec message d'erreur
        header("Location: index.html?message=error#contact");
    }
    exit();
}
?>
