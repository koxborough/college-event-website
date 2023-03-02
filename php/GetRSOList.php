<?php
$inData = getRequestInfo();
$conn = new mysqli("localhost", "root", "", "college-event-website");

$userId = $inData["userId"];

if ($conn->connect_error) 
{
    returnWithError("Error: Connection Error");
} 
else
{
    $stmt = $conn->prepare("CALL GetRSOList(?)");
    $stmt->bind_param("i", $inData["userId"]);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    $searchCount = 0;
    $searchResults = "";
    while($row = $result->fetch_assoc())
    {
        if( $searchCount > 0 )
        {
            $searchResults .= ",";
        }
        $searchCount++;
        $searchResults .= '{"name":"'.$row["name"].'","rsoId":'.$row["rsoId"].',"joined":'.$row["joined"].'}';
    }
    
    if( $searchCount == 0 )
    {
        returnWithError("There are no RSOs!");
    }
    else
    {
        returnWithInfo($searchResults);
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

function returnWithError($err)
{
    $retValue = '{"error":"' . $err . '"}';
    sendResultInfoAsJson($retValue);
}

function returnWithInfo($results)
{
    $retValue = '{"rsoList":[' . $results . ']}';
    sendResultInfoAsJson($retValue);
}
?>