function pressEnter(textboxes, button)
{
    for (textbox of textboxes)
    {
        document.getElementById(textbox).addEventListener("keypress", function(events)
        {
            if (events.key === "Enter")
            {
                events.preventDefault();
                document.getElementById(button).click();
            }
        });
    }
}

function errorMessage(error)
{
    let line = document.getElementById(sessionStorage.getItem("lineId"));
    line.style.color = "red";
    line.innerHTML = error;
}

function userRegistered()
{
    if (sessionStorage.getItem("userRegistered") !== null)
    {
        let line = document.getElementById("loginResult");
        line.style.color = "green";
        line.innerHTML = "User Successfully Registered!";
    }
}

function prettyDate(date)
{
    return `${date.substring(5, 7)}/${date.substring(8)}/${date.substring(0, 4)}`;
}

function capitalize(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function targetedCapitalize(string)
{
    return (string.substring(0, 4) === "univ") ? `University ${string.substring(4)}` : `RSO ${string.substring(3)}`;
}