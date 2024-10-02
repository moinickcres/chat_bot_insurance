<?php
// AiResponse.php

function getAiResponse($userQuery, $responses) {
    $userQuery = strtolower($userQuery); // Convert the query to lowercase for case-insensitive matching

    // Simplified checks for insurance-related queries
    if (strpos($userQuery, 'life') !== false) {
        return $responses['insurance']['life'];
    } elseif (strpos($userQuery, 'car') !== false) {
        return $responses['insurance']['car'];
    } elseif (strpos($userQuery, 'home') !== false) {
        return $responses['insurance']['home'];
    } elseif (strpos($userQuery, 'health') !== false) {
        return $responses['insurance']['health'];
    } elseif (strpos($userQuery, 'travel') !== false) {
        return $responses['insurance']['travel'];
    } elseif (strpos($userQuery, 'pet') !== false) {
        return $responses['insurance']['pet'];
    } elseif (strpos($userQuery, 'business') !== false) {
        return $responses['insurance']['business'];
    } elseif (strpos($userQuery, 'insurance') !== false) {
        return $responses['insurance']['general']; // General insurance query
    } elseif (strpos($userQuery, 'hello') !== false || strpos($userQuery, 'hi') !== false) {
        return $responses['greetings']['hello']; // Respond to greetings
    } elseif (strpos($userQuery, 'bye') !== false || strpos($userQuery, 'thanks') !== false) {
        return $responses['farewell']['bye']; // Respond to farewells
    } elseif (strpos($userQuery, 'more info') !== false) {
        return $responses['more_info']['link']; // Provide link to external resource
    } else {
        return "Sorry, I couldn't find an answer to your query. Please contact support for further assistance.";
    }
}
