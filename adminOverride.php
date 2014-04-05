<html>
    <body>
        <?php
            $adminUsername = $_POST["userName"];
            $adminPassword = $_POST["password"];
            
            $dba = new databaseAcessor();
            $role = $dba->getUserRole($adminUsername, md5($adminPassword));
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
                }
            }
        ?>
    </body>
</html>