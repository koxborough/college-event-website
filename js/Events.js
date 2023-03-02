function getAllEvents()
{
    let user = JSON.parse(sessionStorage.getItem("user"));

    let data = {
        userId: user.userId
    };

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/GetAllEvents.php", true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function () 
    {
        if (xhr.readyState === 4 && xhr.status === 200) 
        {
            let response;
            try 
            {
                response = JSON.parse(xhr.responseText);
            }
            catch(e)
            {
                alert(xhr.responseText);
            }
            
            if ("error" in response)
            {
                let table = document.getElementById("table");
                table.innerHTML = "";
                let caption = table.createCaption();
                caption.innerHTML = response.error;
            }
            else
            {
                fillTable(response.results);
            }
        }
    };
    xhr.send(JSON.stringify(data));
}

function fillTable(eventList)
{
	let table = document.getElementById("table");

    let rowCount = table.rows.length;
    for (let i = rowCount - 1; i > 0; i--) 
    {
        table.deleteRow(i);
    }

	for (let event of eventList)
	{
		let numRows = table.rows.length;
		let row = table.insertRow(numRows);
		let cell1 = row.insertCell(0);
		let cell2 = row.insertCell(1);
		let cell3 = row.insertCell(2);
		let cell4 = row.insertCell(3);
        let cell5 = row.insertCell(4);
		cell1.innerHTML = event.title;
        cell2.innerHTML = event.date;
		cell3.innerHTML = event.category;
		cell4.innerHTML = event.type;
		cell5.innerHTML = `<button type="button" onclick="viewMore(${event.eventId})">View More</button>`;
	}
}

function viewMore(eventId)
{
    sessionStorage.setItem("eventId", eventId);
    window.location.href = "eventPost.html";
}