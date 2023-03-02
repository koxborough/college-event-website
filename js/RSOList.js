function getRSOList()
{
    let user = JSON.parse(sessionStorage.getItem("user"));

    let data = {
        userId: user.userId
    };

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/GetRSOList.php", true);
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
                fillTable(response.rsoList);
            }
        }
    };
    xhr.send(JSON.stringify(data));
}

function fillTable(rsoList)
{
    let table = document.getElementById("table");

    let rowCount = table.rows.length;
    for (let i = rowCount - 1; i > 0; i--) 
    {
        table.deleteRow(i);
    }

	for (let rso of rsoList)
	{
		let numRows = table.rows.length;
		let row = table.insertRow(numRows);
		let cell1 = row.insertCell(0);
		let cell2 = row.insertCell(1);
		cell1.innerHTML = rso.name;
        if (rso.joined)
        {
            cell2.innerHTML = `<button type="button" onclick="leaveRSO(${rso.rsoId})">Leave RSO</button>`;
        }
        else
        {
            cell2.innerHTML = `<button type="button" onclick="joinRSO(${rso.rsoId})">Join RSO</button>`;
        }
	}
}

function leaveRSO(rsoId)
{
    if (!confirm("Are you sure you would like to leave the RSO?"))
    {
        return;
    }

    let user = JSON.parse(sessionStorage.getItem("user"));

    let data = {
        userId: user.userId,
        rsoId: rsoId
    };

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/LeaveRSO.php", true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function () 
    {
        if (xhr.readyState === 4 && xhr.status === 200) 
        {
            let response = JSON.parse(xhr.responseText);
            if ("error" in response)
            {
                alert(response.error);
            }
            else
            {
                window.location.reload();
            }
        }
    };
    xhr.send(JSON.stringify(data));
}

function joinRSO(rsoId)
{
    let user = JSON.parse(sessionStorage.getItem("user"));

    let data = {
        userId: user.userId,
        rsoId: rsoId
    };

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/JoinRSO.php", true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function () 
    {
        if (xhr.readyState === 4 && xhr.status === 200) 
        {
            let response = JSON.parse(xhr.responseText);
            if ("error" in response)
            {
                alert(response.error);
            }
            else
            {
                window.location.reload();
            }
        }
    };
    xhr.send(JSON.stringify(data));
}