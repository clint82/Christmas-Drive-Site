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
        private $addLanguageString = "INSERT INTO Language (languageName) VALUES (?);";
        private $languageQueryString = "SELECT * FROM Language";
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
            
            $result = $preparedStatement->fetchAll(PDO::FETCH_CLASS);
            
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
            $returner = $this->makeStatementSelect($this->nameQueryString, array($nameToSearchFor));
            $this->endStatement();
            return $returner;
        } 
        
        public function addPerson($params)
        {
            $returner = $this->makeStatementInsert($this->addFullPersonString, $params);
            $this->endStatement();
            return $returner;
        }
        
        public function getLanguages()
        {
            $returner = $this->makeStatementSelect($this->languageQueryString, array());
            $this->endStatement();
            return $returner;
        }
        
        public function addLanguages($language)
        {
            $returner = $this->makeStatementInsert($this->addLanguageString, $language);
            $this->endStatement();
            return $returner;
        }
    }
?>