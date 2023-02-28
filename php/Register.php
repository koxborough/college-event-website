<?php
$inData = getRequestInfo();
$conn = new mysqli("localhost", "root", "", "college-event-website");

$name = $inData["name"];
$university = $inData["university"];
$username = $inData["username"];
$password = $inData["password"];

if ($conn->connect_error) 
{
    returnWithError( $conn->connect_error );
} 
else
{
    $test = $conn->prepare("SELECT COUNT(*) AS alreadyExists FROM Users WHERE username=?");
    $test->bind_param("s", $username);
    $test->execute();

    $result = $test->get_result();
    $row = $result->fetch_assoc();

    if ($row["alreadyExists"])
    {
        returnWithError("Error: User Already Exists");
    }
    else
    {
        $stmt = $conn->prepare("INSERT INTO Users (name, university, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $university, $username, $password);
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
    $retValue = '{"registered":""}';
    sendResultInfoAsJson($retValue);
}
?>