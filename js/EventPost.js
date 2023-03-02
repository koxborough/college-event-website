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
        document.getElementById(id).innerHTML = `<strong>${capitalize(id)}:</strong> ${response[id]}`;
    }

    let targetedInfo = ["univName", "univDescription", "rsoName", "rsoDescription"];
    for (let id of targetedInfo)
    {
        if (id in response)
        {
            document.getElementById(id).innerHTML = `<strong>${targetedCapitalize(id)}:</strong> ${response[id]}`;
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
            div.innerHTML += `<p><strong>${capitalize(id)}:</strong> ${comment[id]}</p>`;
        }
        div.innerHTML += "<hr />";
        document.getElementById("body").append(div);
    }
}