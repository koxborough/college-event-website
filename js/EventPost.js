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
            let response = JSON.parse(xhr.responseText);
            if ("error" in response)
            {
                document.getElementById("title").innerHTML = response.error;
            }
            else
            {
                headerInformation(response);
                appendComments(response.comments);
            }
        }
    };
    xhr.send(JSON.stringify(data));
}

function headerInformation(response)
{
    let basicInfo = ["title", "description", "date", "time", "category"];
    for (let id of basicInfo)
    {
        if (id === "date")
        {
            response[id] = prettyDate(String(response[id]));
        }
        document.getElementById(id).innerHTML = `<strong>${capitalize(id)}:</strong> ${response[id]}`;
    }

    let targetedInfo = ["univName", "univDescription", "rsoName", "rsoDescription"];
    for (let id of targetedInfo)
    {
        if (id in response)
        {
            let element = document.getElementById(id);
            element.hidden = false;
            element.innerHTML = `<strong>${targetedCapitalize(id)}:</strong> ${response[id]}`;
        }
    }
}

function appendComments(comments)
{
    for (let comment of comments)
    {
        let div = document.createElement("div");
        for (let id in comment)
        {
            if (id === "date")
            {
                comment[id] = prettyDate(comment[id]);
            }
            div.innerHTML += `<p><strong>${capitalize(id)}:</strong> ${comment[id]}</p>`;
        }
        div.innerHTML += '<div class="break"></div>';
        document.getElementById("comments").append(div);
    }
}

function addComment()
{
    let text = document.getElementById("text").value;
    let rating = document.getElementById("rating").value;

    if (text.length === 0)
    {
        errorMessage("Error: Text is blank");
        return;
    }
    else if (rating.length === 0)
    {
        errorMessage("Error: Rating is blank");
        return;
    }

    let data = {
        userId: JSON.parse(sessionStorage.getItem("user")).userId,
        eventId: parseInt(sessionStorage.getItem("eventId")),
        text: text,
        rating: parseInt(rating),
        date: new Date().toISOString().slice(0, 10),
        time: new Date().toISOString().slice(11, 16)
    };
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/AddComment.php", true);
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
                window.location.reload();
            }
        }
    };
    xhr.send(JSON.stringify(data));
}