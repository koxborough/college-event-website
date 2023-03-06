<?php
$inData = getRequestInfo();
$conn = new mysqli("localhost", "root", "", "college-event-website");

$userId = $inData["userId"];
$title = $inData["title"];
$description = $inData["description"];
$date = $inData["date"];
$time = $inData["time"];
$category = $inData["category"];
$name = $inData["name"];
$address = $inData["address"];
$longitude = $inData["longitude"];
$latitude = $inData["latitude"];
$type = $inData["type"];
$specialId = $inData["specialId"];

if ($conn->connect_error) 
{
    returnWithError($conn->connect_error);
} 
else
{
    $stmt = $conn->prepare("INSERT INTO Location (name, address, longitude, latitude) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $name, $address, $longitude, $latitude);
    $stmt->execute();

    $last_input = $conn->prepare("SELECT MAX(locationId) AS id FROM Location");
    $last_input->execute();
    $result = $last_input->get_result();
    $row = $result->fetch_assoc();
    $locationId = $row["id"];

    $insert = $conn->prepare("INSERT INTO Events (title, description, date, time, category, locationId) VALUES (?, ?, ?, ?, ?, ?)");
    $insert->bind_param("sssssi", $title, $description, $date, $time, $category, $locationId);
    $insert->execute();
    
    $event = $conn->prepare("SELECT MAX(eventId) AS eventId FROM Events");
    $event->execute();
    $event_res = $event->get_result();
    $event_row = $event_res->fetch_assoc();
    $eventId = $event_row["eventId"];

    if ($type === "Public")
    {
        $final = $conn->prepare("INSERT INTO PublicEvents (eventId, createdById) VALUES (?, ?)");
        $final->bind_param("ii", $eventId, $userId);
        $final->execute();
        $final->close();
    }
    else if ($type === "Private")
    {
        $final = $conn->prepare("INSERT INTO PrivateEvents (eventId, universityId, createdById) VALUES (?, ?, ?)");
        $final->bind_param("iii", $eventId, $specialId, $userId);
        $final->execute();
        $final->close();
    }
    else
    {
        $final = $conn->prepare("INSERT INTO RSOEvents (eventId, rsoId, createdById) VALUES (?, ?, ?)");
        $final->bind_param("iii", $eventId, $specialId, $userId);
        $final->execute();
        $final->close();
    }

    $stmt->close();
    $last_input->close();
    $insert->close();
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

function returnWithError($error)
{
    $retValue = '{"error":"' . $error . '"}';
    sendResultInfoAsJson($retValue);
}

function returnWithoutError()
{
    $retValue = '{"success":""}';
    sendResultInfoAsJson($retValue);
}
?>