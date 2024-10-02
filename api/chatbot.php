<?php
require '../config/db.php';
require 'AiResponse.php';  // Include the AI response logic

// Load the JSON responses file
$responses = json_decode(file_get_contents('../responses/responses.json'), true);

// Handle POST requests (user query submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userQuery = $_POST['query'];

    // Get AI response using the refactored function
    $aiResponse = getAiResponse($userQuery, $responses);

    // Save the query and the AI response in the database
    $stmt = $pdo->prepare("INSERT INTO queries (user_query, ai_response) VALUES (:user_query, :ai_response)");
    $stmt->execute([':user_query' => $userQuery, ':ai_response' => $aiResponse]);

    $queryId = $pdo->lastInsertId();

    $response = [
        'id' => $queryId,         // The newly inserted query ID
        'sentence' => $aiResponse // The AI response
    ];

    // Return the response as JSON
    echo json_encode($response);
}
