function getEventPost()
{
    let data = {
        eventId: sessionStorage.getItem("eventId")
    };

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/GetEventPost.php", true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function () 
    {
        if (xhr.readyState === 4 && xhr.status === 200) 
        {
            
        }
    };
    xhr.send(JSON.stringify(data));
}