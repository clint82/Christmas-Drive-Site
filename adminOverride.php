<html>
    <body>
        <?php
            $adminUsername = $_POST["userName"];
            $adminPassword = $_POST["password"];
            
            $dba = new databaseAcessor();
            $role = $dba->getUserRole($adminUsername, md5($adminPassword));
            
            $adminLoginValid = false;
            if(count(role) == 0)
            {
                echo "No one found with those credentials";
            }
            else
            {
                print_r($role);
                echo $role . "<br>";
                if($role == "ADMIN")
                {
                    echo "Is admin<br>";
                    
                    $adminLoginValid = true;
                }
            }
            
            if($adminLogin)
            {
                session_start();
                $attemptedOrderType = $_SESSION["attemptedOrderType"];
                $errorType = $_SESSION["errorType"];
                //echo $attemptedOrderType . "<br>";
                //echo $errorType . "<br>";
                
                if($attemptedOrderType == "food")
                {
                    if($errorType == "previouslyMadeClothingOrder")
                    {
                        echo "Adding a food order to this house with a pre-existing clothing order <br>";
                    }
                    else
                    {
                        echo "Changing the number of people in this food order<br>";
                        //need to add logic to not allow anything
                    }
                
                }
                else if($attemptedOrderType == "clothes")
                {
                    if($errorType == "previouslyMadeFoodOrder")
                    {
                        echo "Allowing for a food order after a clothing order has been made<br>";
                    }
                    else
                    {
                        echo "This should have been impossible to have been to<br>";
                    }
                }
                else
                {
                    echo "Nothing to do here";
                }
                
                //cleanup the session stuff and send the user out of here
                session_destroy(); 
            }
        ?>
    </body>
</html>