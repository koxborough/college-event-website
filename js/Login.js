function doLogin()
{
    let username = document.getElementById("loginUsername").value;
    let password = document.getElementById("loginPassword").value;

    if (username.length === 0)
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
        username: username,
        password: password
    };

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/Login.php", true);
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
                sessionStorage.setItem("user", JSON.stringify(response));
                window.location.href = "events.html";
            }
        }
    };
    xhr.send(JSON.stringify(data));
}