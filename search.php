<html>
    <body>
        <?php
            require 'globalClasses.php';
            $dba = new databaseAcessor();
            $wordToSearchFor = $_GET["searchBox"];
            $result = $dba->searchForName($wordToSearchFor);
            if(count($result) > 0)
            {
                echo "<form  name='selectPerson' action='signUpPerson.php' method='POST' enctype='application/x-www-form-urlencoded'>";
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