<?php
    class PersonOrdering
    {
        public $id;
        public $firstName;
        public $lastName;
        public $email;
    }

    class databaseAcessor
    {
        private $username = "root";
        private $password = "password";
        private $dbName = "Christmas";
        private $nameQueryString = "SELECT * FROM PersonOrdering p WHERE p.lastName LIKE ?";
        private $addFullPersonString = "INSERT INTO PersonOrdering (firstName, lastName, email, primaryPhoneId, primaryPhoneNum, secondaryPhoneId, secondaryPhoneNum, languageId) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        private $hostname;
        private $mySqlConnection;
        private $preparedStatement;
        
        public function __construct()
        {
            $this->hostname = gethostname();
        }
        
        private function makeStatementSelect($statementString, $params)
        {
            $connectingName = 'mysql:host='. $this->hostname . ';dbname=' . $this->dbName;
            
            try
            {
                $mySqlConnection = new PDO($connectingName,$this->username,$this->password); 
            }
            catch(PDOException $e)
            {
                echo "failed ";
                echo $e->getMessage();
            }
            
            if($mySqlConnection->connect_error)
            {
                die('Could not connect: ' . $mySqlConnection->connect_error);
            }
            
            $preparedStatement = $mySqlConnection->prepare($statementString, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            
            $preparedStatement->execute($params);
            
            $result = $preparedStatement->fetchAll(PDO::FETCH_CLASS, "PersonOrdering");
            
            return $result;
        }
        
        private function makeStatementInsert($statementString, $params)
        {
            $connectingName = 'mysql:host='. $this->hostname . ';dbname=' . $this->dbName;
            
            try
            {
                $mySqlConnection = new PDO($connectingName,$this->username,$this->password); 
            }
            catch(PDOException $e)
            {
                echo "failed ";
                echo $e->getMessage();
            }
            
            if($mySqlConnection->connect_error)
            {
                die('Could not connect: ' . $mySqlConnection->connect_error);
            }
            
            $preparedStatement = $mySqlConnection->prepare($statementString);
            
            $preparedStatement->execute($params);
            
            $result = $mySqlConnection->lastInsertId();
            
            return $result;
        }
        
        private function endStatement()
        {
            $this->mySqlConnection = null;
        }
        
        public function searchForName($nameToSearchFor)
        {
            $statementString = $this->nameQueryString;
            $returner = $this->makeStatementSelect($statementString, array($nameToSearchFor));
            $this->endStatement();
            return $returner;
        } 
        
        public function addPerson($params)
        {
            $statementString = $this->addFullPersonString;
            $returner = $this->makeStatementInsert($this->addFullPersonString, $params);
            $this->endStatement();
            return $returner;
            //$returner = $this->makeStatementSelect($statementString, $params);
        }
    }
?>