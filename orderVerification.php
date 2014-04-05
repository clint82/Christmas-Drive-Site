<html>
    <body>
        <?php
            require 'globalClasses.php';
            $attemptedOrderType = $_SESSION["attemptedOrderType"];
            $errorType = $_SESSION["errorType"];
            echo $attemptedOrderType . "<br>";
            echo $errorType . "<br>";
            $dba = new databaseAcessor();
            if($attemptedOrderType == "food")
            {
                if($errorType == "previouslyMadeClothingOrder")
                {
                    echo "There is a food order already made for the address given, would you like to allow for a clothing order as well?<br>";
                }
                else
                {
                    echo "You have already made a clothing order<br>";
                }
            
            }
            else
            {
                if($errorType == "previouslyMadeFoodOrder")
                {
                    echo "There is a food order already made for the address given, would you like to allow for a clothing order as well?<br>";
                }
                else
                {
                    echo "Soemone at this address already made a food order, would you like to increase the total number of people for it?<br>";
                }
            }
            
            $dba->getUserRole();
        ?>
        
      <form name="addressBar" action="adminOverride.php" method="POST">
         Administer username:<br>
            <input type="text" id="userName" name="userName"><br>
            
         Password:<br>
            <input type="text" id="password" name="password"><br>
             <input type="button" value="submit" onclick="this.parentNode.parentNode.submit();">
        </form>
        
        
    </body>
</html>