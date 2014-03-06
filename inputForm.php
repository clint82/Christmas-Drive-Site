
<html>
    <body>
        <?php
        
            function validateName($string)
            {
                
            }
            
            function validateEmail($string)
            {
                
            }
            
            function validateAddress($string)
            {
                
            }
            $username = "root";
            $password = "password";
            $mysqlConnection = mysql_pconnect("hostname",$username,$password); 
            if(!mysqlConnection)
            {
                echo "Failed to connect";
                exit();
            }
            
            print_r($_POST);
        
        ?>
        
        Welcome 
        
    </body>
</html>