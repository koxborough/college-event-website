function doRegister()
{
    let name = document.getElementById("regName").value;
    let university = document.getElementById("regUniv").value;
    let username = document.getElementById("regUsername").value;
    let password = document.getElementById("regPassword").value;

    if (name.length === 0)
    {
        errorMessage("Error: Name is blank");
        return;
    }
    else if (university.length === 0)
    {
        errorMessage("Error: University is blank");
        return;
    }
    else if (username.length === 0)
    {
        errorMessage("Error: Username is blank");
        return;
    }
    else if (password.length === 0)
    {
        errorMessage("Error: Password is blank");
        return;
    }

    let data = {
        name: name,
        university: university,
        username: username,
        password: password
    };

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/Register.php", true);
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
                window.location.href = "index.html";
            }
        }
    };
    xhr.send(JSON.stringify(data));
}

function errorMessage(error)
{
    let loginResult = document.getElementById("regResult");
    loginResult.style.color = "red";
    loginResult.innerHTML = error;
}