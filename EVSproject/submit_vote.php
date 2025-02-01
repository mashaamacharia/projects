<?php
session_start();
require 'connection.php';  // This file should contain your database connection logic

$user_id = $_SESSION['user_id'];
$user_faculty = $_SESSION['faculty'];
$error_message = "";

// Check if the user has already voted
$checkVoteQuery = $conn->prepare("SELECT COUNT(*) FROM votes WHERE user_id = ?");
$checkVoteQuery->bind_param("i", $user_id);
$checkVoteQuery->execute();
$checkVoteQuery->bind_result($voteCount);
$checkVoteQuery->fetch();
$checkVoteQuery->close();

if ($voteCount > 0) {
    $error_message = "You have already voted.";
    echo json_encode(['success' => false, 'message' => $error_message]);
    exit();
}

// Prepare an array to store vote insert queries
$voteInserts = [];

foreach ($_POST as $position => $candidate_id) {
    if (!empty($candidate_id)) {
        $voteInserts[] = "('$user_id', '$position', '$candidate_id')";
    }
}

if (count($voteInserts) > 0) {
    // Insert the votes
    $insertVotesQuery = "INSERT INTO votes (user_id, position, candidate_id) VALUES " . implode(", ", $voteInserts);
    if ($conn->query($insertVotesQuery) === TRUE) {
        echo json_encode(['success' => true, 'message' => "Vote submitted successfully."]);
    } else {
        echo json_encode(['success' => false, 'message' => "Error: " . $conn->error]);
    }
} else {
    $error_message = "No votes submitted.";
    echo json_encode(['success' => false, 'message' => $error_message]);
}

$conn->close();
