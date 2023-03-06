<?php
$inData = getRequestInfo();
$conn = new mysqli("localhost", "root", "", "college-event-website");

if ($conn->connect_error) 
{
    returnWithError("Error: Connection Error");
} 
else
{
    $stmt = $conn->prepare("SELECT U.universityId, U.name FROM Universities U ORDER BY name");
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
        $searchResults .= '{"universityId":'.$row["universityId"].',"name":"'.$row["name"].'"}';
    }
    
    if( $searchCount == 0 )
    {
        returnWithError("There are no universities!");
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
    $retValue = '{"results":[' . $results . ']}';
    sendResultInfoAsJson($retValue);
}
?>