function getUniversities()
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/GetUniversities.php", true);
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

function fillTable(universityList)
{
    let table = document.getElementById("table");

	for (let university of universityList)
	{
		let numRows = table.rows.length;
		let row = table.insertRow(numRows);
		let cell1 = row.insertCell(0);
		let cell2 = row.insertCell(1);
		cell1.innerHTML = university.name;
		cell2.innerHTML = `<button type="button" onclick="sendData(${university.universityId})">Create Event for University</button>`;
    }
}

function sendData(id)
{
    sessionStorage.setItem("specialId", id);
    sessionStorage.setItem("eventType", "Private");
    window.location.href = "createEvent.html";
}