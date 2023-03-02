<?php
$inData = getRequestInfo();
$conn = new mysqli("localhost", "root", "", "college-event-website");

$userId = $inData["userId"];
$rsoId = $inData["rsoId"];

if ($conn->connect_error) 
{
    returnWithError("Error: Connection Error");
} 
else
{
    $stmt = $conn->prepare("INSERT INTO RSOMembers (userId, rsoId) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $rsoId);
    $stmt->execute();
    
    $stmt->close();
    $conn->close();
    returnWithoutError();
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

function returnWithError($err)
{
    $retValue = '{"error":"' . $err . '"}';
    sendResultInfoAsJson($retValue);
}

function returnWithoutError()
{
    $retValue = '{"joined":""}';
    sendResultInfoAsJson($retValue);
}
?>