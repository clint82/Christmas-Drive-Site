<html>
    <body>
        <?php
        
            class PersonOrdering
            {
                public $id;
                public $firstName;
                public $lastName;
                public $email;
            }
        
            class database_acessor
            {
                private $username = "root";
                private $password = "password";
                private $db_name = "Christmas";
                private $name_search_string = "SELECT * FROM PersonOrdering p WHERE p.lastName LIKE ?";
                private $hostname;
                private $my_sql_connection;
                private $prepared_statement;
                
                public function __construct()
                {
                    $this->hostname = gethostname();
                }
                
                private function make_statement($statement_string, $params)
                {
                    $connecting_name = 'mysql:host='. $this->hostname . ';dbname=' . $this->db_name;
                    
                    try
                    {
                        $my_sql_connection = new PDO($connecting_name,$this->username,$this->password); 
                    }
                    catch(PDOException $e)
                    {
                        echo "failed ";
                        echo $e->getMessage();
                    }
                    
                    if($my_sql_connection->connect_error)
                    {
                        die('Could not connect: ' . $my_sql_connection->connect_error);
                    }
                    
                    $prepared_statement = $my_sql_connection->prepare($statement_string, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    
                    $prepared_statement->execute($params);
                    
                    $result = $prepared_statement->fetchAll(PDO::FETCH_CLASS, "PersonOrdering");
                    
                    return $result;
                }
                
                private function end_statement()
                {
                    $this->my_sql_connection = null;
                }
                
                public function search_for_name($name_to_search_for)
                {
                    $statement_string = $this->name_search_string;
                    $returner = $this->make_statement($statement_string, array($name_to_search_for));
                    $this->end_statement();
                    return $returner;
                } 
            }
            $dba = new database_acessor();
            print_r($_GET);
            print_r($_POST);
            $wordToSearchFor = $_GET["searchBox"];
            $result = $dba->search_for_name($wordToSearchFor);
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
                echo "no results found";
            }
        ?>
    </body>
</html>