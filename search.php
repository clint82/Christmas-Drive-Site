<html>
    <body>
        <?php
        
            $username = "root";
            $password = "password";
            echo gethostname();
            echo "<br>";
            $my_sql_connection = new mysqli(gethostname(),$username,$password, "Christmas"); 
            if($my_sql_connection->connect_error)
            {
                die('Could not connect: ' . $my_sql_connection->connect_error);
            }
            
            $prepared_statement = $my_sql_connection->prepare("SELECT p.firstName, p.lastName FROM PersonOrdering p WHERE p.lastName LIKE ?");
            $prepared_statement->bind_param("s", $search_last_name);
            $search_last_name = $_POST["searchBox"];
            $prepared_statement->execute();
            $prepared_statement->bind_result($first, $last);
            
            while($prepared_statement->fetch())
            {
                echo "<br>$first<br>$last";
            }
            
            echo "<br>end";
            mysql_close(my_sql_connection);
        ?>
    </body>
</html>