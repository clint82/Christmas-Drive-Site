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
        private $languageQueryString = "SELECT * FROM Language  ORDER BY languageName";
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
            
            if(empty($params))
            {
                $returnSucess = $preparedStatement->execute();
            }
            else
            {
                $returnSucess = $preparedStatement->execute($params);
            }
            
            if(!$returnSucess)
            {
                echo "<br>insert failed for ";
                print_r($params);
                print_r($mySqlConnection->errorInfo());
                echo "<br>";
            }
            
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
            
            if(empty($params))
            {
                $returnSucess = $preparedStatement->execute();
            }
            else
            {
                $returnSucess = $preparedStatement->execute($params);
            }
            
            if(!$returnSucess)
            {
                echo "<br>insert failed for ";
                print_r($params);
                print_r($mySqlConnection->errorInfo());
                echo "<br>";
            }
            
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
        
        public function addLanguage($language)
        {
            $returner = $this->makeStatementInsert($this->addLanguageString, array($language));
            $this->endStatement();
            return $returner;
        }
    }
?>