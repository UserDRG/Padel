<?php
// Inclure la configuration de la base de données
require_once 'config.php';

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $court = $_POST['courtSelect'];
    $date = $_POST['bookingDate'];
    $time = $_POST['bookingTime'];
    $duration = $_POST['bookingDuration'];
    
    // Vérifier si le créneau est déjà réservé
    $sql = "SELECT * FROM reservations WHERE court = ? AND date = ? AND time = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $court, $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Le créneau est déjà réservé
        header("Location: index.html?reservation=unavailable#terrains");
    } else {
        // Insérer la nouvelle réservation
        $sql = "INSERT INTO reservations (court, date, time, duration, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // Si l'utilisateur est connecté, utiliser son ID, sinon utiliser NULL
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
        
        $stmt->bind_param("sssii", $court, $date, $time, $duration, $user_id);
        
        if ($stmt->execute()) {
            // Réservation réussie
            header("Location: index.html?reservation=success#terrains");
        } else {
            // Erreur lors de la réservation
            header("Location: index.html?reservation=error#terrains");
        }
    }
    
    $stmt->close();
    $conn->close();
    exit();
}

// Afficher les créneaux disponibles (si accès direct à cette page)
header("Location: index.html#terrains");
?>
