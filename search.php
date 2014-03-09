<html>
    <head>
        <script src="myscript.js"></script>
    </head>
    <body>
        <?php
            require 'globalClasses.php';
            $dba = new databaseAcessor();
            $wordToSearchFor = $_GET["searchBox"];
            $result = $dba->searchForName($wordToSearchFor);
            if(count($result) > 0)
            {
                echo "<form  id='selectPerson' name='selectPerson' action='addToyOrClothingOrder.php' method='POST' enctype='application/x-www-form-urlencoded'>";
                echo "<select name='householdStatus'>";
                foreach($result as $person)
                {
                    echo "<option value=";
                    echo $person->id;
                    echo ">";
                    echo $person->firstName;
                    echo " ";
                    echo $person->lastName;
                    echo " email: ";
                    echo $person->email;
                    echo "</option>";
                }
                echo "</select><br>";
                $formInfo = 
                "<select id='selectNameAction' name='selectNameAction' onChange='chooseOption()'>
                  <option value='makeClothingOrToyOrder' selected='selected'>Make Clothing/Toy Order</option>
                  <option value='makeFoodOrder'>Make Food Order</option>
                  <option value='editInfo'>Edit Information</option>
                </select><br>";
                
                echo $formInfo;
                
                echo "<input type='submit'>";
                echo "</form>";
            }
            else
            {
                echo "no results found for " . $wordToSearchFor;
            }
            echo "<a href='search.html'>Go Back</a>";
        ?>
    </body>
</html>