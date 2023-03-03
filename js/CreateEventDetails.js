function createEventDetails()
{
    let idList = ["title", "description", "date", "time", "category", "location", "address", "longitude", "latitude"];
    for (let id of idList)
    {
        let value = document.getElementById(id).value;
        if (value.length === 0)
        {
            errorMessage(`Error: ${capitalize(id)} is blank`);
            return;
        }
    }

    let data = {
        userId: JSON.parse(sessionStorage.getItem("user")).userId,
        title: document.getElementById("title").value,
        description: document.getElementById("description").value,
        date: document.getElementById("date").value,
        time: document.getElementById("time").value,
        category: document.getElementById("category").value,
        name: document.getElementById("location").value,
        address: document.getElementById("address").value,
        longitude: document.getElementById("longitude").value,
        latitude: document.getElementById("latitude").value,
        type: "Public"
    };

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/CreateEventDetails.php", true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function () 
    {
        if (xhr.readyState === 4 && xhr.status === 200) 
        {
            alert(xhr.responseText);
            let response = JSON.parse(xhr.responseText);
            if ("error" in response)
            {
                errorMessage(response.error);
            }
            else
            {
                window.location.href = "events.html";
            }
            
        }
    };
    xhr.send(JSON.stringify(data));
}