function getRSOs()
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/GetRSOs.php", true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function () 
    {
        if (xhr.readyState === 4 && xhr.status === 200) 
        {
            let response = JSON.parse(xhr.responseText);
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
    xhr.send();
}

function fillTable(rsoList)
{
    let table = document.getElementById("table");

	for (let rso of rsoList)
	{
		let numRows = table.rows.length;
		let row = table.insertRow(numRows);
		let cell1 = row.insertCell(0);
		let cell2 = row.insertCell(1);
		cell1.innerHTML = rso.name;
		cell2.innerHTML = `<button type="button" onclick="sendData(${rso.rsoId})">Create Event for RSO</button>`;
    }
}

function sendData(id)
{
    sessionStorage.setItem("specialId", id);
    sessionStorage.setItem("eventType", "RSO");
    window.location.href = "createEvent.html";
}