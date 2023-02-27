<?php
$inData = getRequestInfo();
$conn = new mysqli("localhost", "root", "", "college-event-website");

if ($conn->connect_error)
{
    returnWithError("Error: Connection Error");
}
else
{
    $stmt = $conn->prepare("SELECT userId, name, university FROM Users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $inData["username"], $inData["password"]);
    $stmt->execute();

    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc())
    {
        returnWithInfo($row["userId"], $row["name"], $row["university"]);
    }
    else
    {
        returnWithError("Error: Username/Password Incorrect");
    }

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

function returnWithInfo($userId, $name, $university)
{
    $retValue = '{"userId":' . $userId . ',"name":"' . $name . '","university":"' . $university . '"}';
    sendResultInfoAsJson($retValue);
}
?>