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