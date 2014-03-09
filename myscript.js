//validates first and last name, can only have spaces, dashes, periods, and letters
function validateName(inputString)
{
    var regexUnwantedCharacters = /[^A-Za-z -.]+/i;
    var neededCharacters = /[A-Z|a-z]/i;
    
    if(!inputString || inputString.length < 1)
        return false;
        
    return !regexUnwantedCharacters.test(inputString) && neededCharacters.test(inputString);
}

//should make sure email address is in the correct format
function validateEmail(testEmailAddress)
{
    var regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/i;
    return regex.test(testEmailAddress);
}

function changeElementColor(element, color)
{
    element.style.backgroundColor = color;
}

//validates email text box, will reset color if blank (may change)
function highlightEmailBoxIfNotValidated(idString)
{
    var element = document.getElementById(idString);
    
    if(!validateEmail(element.value) && element.value.length > 0) changeElementColor(element, 'red');
    else changeElementColor(element, 'white');
}

//validates first and last name text box, will reset color if blank (may change)
function highlightNameBoxIfNotValidated(idString)
{
    var element = document.getElementById(idString);
    
    if(!validateName(element.value) && element.value.length > 0) changeElementColor(element, 'red');
    else changeElementColor(element, 'white');
}

function addTextBoxIfUnselected(item)
{
    if(item.value == "other")
    {
        document.getElementById("otherLanguageDiv").style.visibility ="visible";
    }
}

function setAction(element, action)
{
    element.action = action;
}

function chooseOption()
{
    var selection = document.getElementById("selectNameAction").value;
    var formElement = document.getElementById("selectPerson");
    if(selection == "makeClothingOrToyOrder")
    {
        setAction(formElement, "addToyOrClothingOrder.php");
    }
    if(selection == "makeFoodOrder")
    {
        setAction(formElement, "addFoodOrder.php");
    }
    else if(selection == "editInfo")
    {
        setAction(formElement, "editInfo.php");
    }
}
