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
        private $dbName = "Christmas";
        private $nameQueryString = "SELECT * FROM PersonOrdering p WHERE p.lastName LIKE ?";
        private $addFullPersonString = "INSERT INTO PersonOrdering (firstName, lastName, email, primaryPhoneId, primaryPhoneNum, secondaryPhoneId, secondaryPhoneNum, languageId) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        private $hostname;
        private $my_sql_connection;
        private $prepared_statement;
        
        public function __construct()
        {
            $this->hostname = gethostname();
        }
        
        private function makeStatementSelect($statement_string, $params)
        {
            $connecting_name = 'mysql:host='. $this->hostname . ';dbname=' . $this->dbName;
            
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
        
        private function makeStatementInsert($statement_string, $params)
        {
            $connecting_name = 'mysql:host='. $this->hostname . ';dbname=' . $this->dbName;
            
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
            
            $prepared_statement = $my_sql_connection->prepare($statement_string);
            
            $prepared_statement->execute($params);
            
            $result = $my_sql_connection->lastInsertId();
            
            return $result;
        }
        
        private function end_statement()
        {
            $this->my_sql_connection = null;
        }
        
        public function search_for_name($name_to_search_for)
        {
            $statement_string = $this->nameQueryString;
            $returner = $this->makeStatementSelect($statement_string, array($name_to_search_for));
            $this->end_statement();
            return $returner;
        } 
        
        public function addPerson($params)
        {
            $statementString = $this->addFullPersonString;
            $returner = $this->makeStatementInsert($this->addFullPersonString, $params);
            $this->end_Statement();
            return $returner;
            //$returner = $this->makeStatementSelect($statementString, $params);
        }
    }
?>