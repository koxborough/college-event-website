<?php
$inData = getRequestInfo();
$conn = new mysqli("localhost", "root", "", "college-event-website");

$eventId = $inData["eventId"];

if ($conn->connect_error) 
{
    returnWithError("Error: Connection Error");
} 
else
{
    $strt = $conn->prepare("SELECT * FROM Events WHERE Events.eventId=?");
    $strt->bind_param("i", $eventId);
    $strt->execute();

    $strt_result = $strt->get_result();
    
    $searchResults = startEventData($strt_result->fetch_assoc());
    $searchCount = 0;

    $cmmt = $conn->prepare("SELECT U.name, C.text, C.rating, C.date, C.time FROM Comments C, Users U WHERE U.userId=C.userId AND C.eventId=?");
    $cmmt->bind_param("i", $eventId);
    $cmmt->execute();

    $cmmt_result = $cmmt->get_result();
    while($row = $cmmt_result->fetch_assoc())
    {
        if( $searchCount > 0 )
        {
            $searchResults .= ",";
        }
        $searchCount++;
        $searchResults .= '{"name":"'.$row["name"].'","text":"'.$row["text"].'","rating":'.$row["rating"].',"date":"'.$row["date"].'","time":"'.$row["time"].'"}';
    }
    $searchResults .= "]";

    $pub = $conn->prepare("SELECT COUNT(*) AS isPublic FROM PublicEvents WHERE PublicEvents.eventId=?");
    $pub->bind_param("i", $eventId);
    $pub->execute();
    
    $pub_result = $pub->get_result();
    $pub_row = $pub_result->fetch_assoc();
    if (!$pub_row["isPublic"])
    {
        $searchResults .= ",";
        $priv = $conn->prepare("SELECT COUNT(*) AS isPrivate FROM PrivateEvents WHERE PrivateEvents.eventId=?");
        $priv->bind_param("i", $eventId);
        $priv->execute();
        
        $priv_result = $priv->get_result();
        $priv_row = $priv_result->fetch_assoc();
        if ($priv_row["isPrivate"])
        {
            $more = $conn->prepare("SELECT U.name, U.description FROM Universities U, PrivateEvents E WHERE E.eventId=? AND E.universityId=U.universityId");
            $more->bind_param("i", $eventId);
            $more->execute();

            $more_result = $more->get_result();
            $more_row = $more_result->fetch_assoc();
            $searchResults .= '"univName":"'.$more_row["name"].'", "univDescription":"'.$more_row["description"].'"';

            $more->close();
        }
        else
        {
            $more = $conn->prepare("SELECT RSO.name, RSO.description FROM RSOs RSO, RSOEvents RSOE WHERE RSOE.eventId=? AND RSOE.rsoId=RSO.rsoId");
            $more->bind_param("i", $eventId);
            $more->execute();

            $more_result = $more->get_result();
            $more_row = $more_result->fetch_assoc();
            $searchResults .= '"rsoName":"'.$more_row["name"].'", "rsoDescription":"'.$more_row["description"].'"';

            $more->close();
        }
        $priv->close();
    }
    $pub->close();

    $searchResults .= '}';
    sendResultInfoAsJson($searchResults);

    $cmmt->close();
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

function returnWithError($err)
{
    $retValue = '{"error":"' . $err . '"}';
    sendResultInfoAsJson($retValue);
}

function returnWithInfo($results)
{
    $retValue = '{"results":[' . $results . ']}';
    sendResultInfoAsJson($retValue);
}

function startEventData($row)
{
    return '{"eventId":'.$row["eventId"].',"title":"'.$row["title"].'","description":"'.$row["description"].'",'
        . '"date":"'.$row["date"].'","time":"'.$row["time"].'","category":"'.$row["category"].'","comments":[';
}
?>