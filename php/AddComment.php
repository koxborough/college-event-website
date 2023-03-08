<?php
$inData = getRequestInfo();
$conn = new mysqli("localhost", "root", "", "college-event-website");

$userId = $inData["userId"];
$eventId = $inData["eventId"];
$text = $inData["text"];
$rating = $inData["rating"];
$date = $inData["date"];
$time = $inData["time"];

if ($conn->connect_error) 
{
    returnWithError( $conn->connect_error );
} 
else
{
    $stmt = $conn->prepare("INSERT INTO Comments (userId, eventId, text, rating, date, time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisdss", $userId, $eventId, $text, $rating, $date, $time);
    $stmt->execute();
    
    returnWithoutError();
    $stmt->close();
    $conn->close();
}

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
}

function sendResultInfoAsJson($obj)
{
    header('Content-type: application/json');
    echo $obj;
}

function returnWithError($error)
{
    $retValue = '{"error":"' . $error . '"}';
    sendResultInfoAsJson($retValue);
}

function returnWithoutError()
{
    $retValue = '{"added":""}';
    sendResultInfoAsJson($retValue);
}
?>