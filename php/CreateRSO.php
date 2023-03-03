<?php
$inData = getRequestInfo();
$conn = new mysqli("localhost", "root", "", "college-event-website");

$userId = $inData["userId"];
$name = $inData["name"];
$description = $inData["description"];

if ($conn->connect_error) 
{
    returnWithError($conn->connect_error);
} 
else
{
    $test = $conn->prepare("SELECT COUNT(*) AS alreadyExists FROM RSOs WHERE name=?");
    $test->bind_param("s", $name);
    $test->execute();

    $result = $test->get_result();
    $row = $result->fetch_assoc();

    if ($row["alreadyExists"])
    {
        returnWithError("Error: RSO Already Exists");
    }
    else
    {
        $stmt = $conn->prepare("INSERT INTO RSOs (createdById, name, description) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $name, $description);
        $stmt->execute();
        $stmt->close();
        returnWithoutError();
    }
    $test->close();
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
    $retValue = '{"created":""}';
    sendResultInfoAsJson($retValue);
}
?>