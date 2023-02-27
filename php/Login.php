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
    
    if (!($row = $result->fetch_assoc()))
    {
        returnWithError("Error: Username/Password Incorrect");
    }
    else
    {
        $supad = $conn->prepare("SELECT COUNT(*) AS isSuperAdmin FROM superadmins WHERE userId=?");
        $supad->bind_param("i", $row["userId"]);
        $supad->execute();

        $res_supad = $supad->get_result();
        $row_supad = $res_supad->fetch_assoc();
        if ($row_supad["isSuperAdmin"])
        {
            returnWithInfo($row["userId"], $row["name"], $row["university"], "SuperAdmin");
            $supad->close();
        }
        else
        {
            $ad = $conn->prepare("SELECT COUNT(*) AS isAdmin FROM admins WHERE userId=?");
            $ad->bind_param("i", $row["userId"]);
            $ad->execute();
    
            $res_ad = $ad->get_result();
            $row_ad = $res_ad->fetch_assoc();
            if ($row_ad["isAdmin"])
            {
                returnWithInfo($row["userId"], $row["name"], $row["university"], "Admin");
            }
            else
            {
                returnWithInfo($row["userId"], $row["name"], $row["university"], "Student");
            }
            $supad->close();
            $ad->close();
        }
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

function returnWithInfo($userId, $name, $university, $type)
{
    $retValue = '{"userId":' . $userId . ',"name":"' . $name . '","university":"' . $university . '","type":"' . $type . '"}';
    sendResultInfoAsJson($retValue);
}
?>