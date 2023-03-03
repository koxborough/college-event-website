function createUniv()
{
    let userId = JSON.parse(sessionStorage.getItem("user")).userId;
    let name = document.getElementById("name").value;
    let description = document.getElementById("description").value;

    if (name.length === 0)
    {
        errorMessage("Error: Name is blank");
        return;
    }
    else if (description.length === 0)
    {
        errorMessage("Error: Description is blank");
        return;
    }

    let data = {
        userId: userId,
        name: name,
        description: description
    };

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/CreateUniv.php", true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function () 
    {
        if (xhr.readyState === 4 && xhr.status === 200) 
        {
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