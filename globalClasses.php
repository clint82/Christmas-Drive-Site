<?php

    class databaseAcessor
    {
        private $username = "root";
        private $password = "password";
        private $dbName = "Christmas";
        private $nameQueryString = "SELECT * FROM PersonOrdering p WHERE p.lastName LIKE ?";
        private $addFullPersonString = "INSERT INTO PersonOrdering (firstName, lastName, email, primaryPhoneId, primaryPhoneNum, secondaryPhoneId, secondaryPhoneNum, languageId) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        private $addLanguageString = "INSERT INTO Language (languageName) VALUES (?);";
        private $languageQueryString = "SELECT * FROM Language  ORDER BY languageName";
        private $addressAddingString = "INSERT IGNORE INTO Addresses (houseNumber, streetName, city, zipCode) VALUES (?, ?, ?, ?)";
        private $findAddedAddressString = "SELECT * FROM Addresses WHERE (houseNumber, streetName, city, zipCode) = (?, ?, ?, ?) LIMIT 1";
        private $getColumnMaxStringLength = "SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS WHERE (table_name, COLUMN_NAME) = (?, ?)";
        private $getAllTables = "SHOW TABLES FROM Christmas";
        private $hostname;
        private $mySqlConnection;
        private $preparedStatement;
        private $maxStringLengths;
        
        public function __construct()
        {
            $this->hostname = gethostname();
            $this->maxStringLengths = array();
            //should replace with something more automatic
            $this->addressLengths["houseNumber"] = 10;
            $this->addressLengths["streetName"] = 30;
            $this->addressLengths["city"] = 20;
            $this->addressLengths["zipCode"] = 12;
            
            //manually storing max string lengths (performance will be affected)
            $this->maxStringLengths = array();
            
            $this->maxStringLengths["Addresses"] = array();
            $this->maxStringLengths["Addresses"]["houseNumber"];
            $this->maxStringLengths["Addresses"]["streetName"];
            $this->maxStringLengths["Addresses"]["city"];
            $this->maxStringLengths["Addresses"]["zipCode"];
            
            $this->maxStringLengths["Childeren"] = array();
            $this->maxStringLengths["Childeren"]["firstName"] = 20;
            $this->maxStringLengths["Childeren"]["lastName"] = 20;
            
            $this->maxStringLengths["PersonOrdering"] = array();
            $this->maxStringLengths["PersonOrdering"]["lastName"] = 20;
            $this->maxStringLengths["PersonOrdering"]["firstName"] = 20;
            
            $this->maxStringLengths["Language"] = array();
            $this->maxStringLengths["Language"]["languageName"] = 20;
            
            $this->maxStringLengths["PhoneType"] = array();
            $this->maxStringLengths["PhoneType"]["description"] = 20;
            
            
            //performance issues with so many queries at construction
           /* $queryTablesResult = $this->makeStatementSelect($this->getAllTables);
            $tables = array();
            foreach($queryTablesResult as $resultRow)
            {
                $tables[] = $resultRow->Tables_in_Christmas;
            }
            print_r($tables);
           */
            //print_r($tables);
            
        }
        
        private function makeStatementSelect($statementString, $params = array())
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
                echo "<br>select failed for ";
                print_r($params);
                print_r($mySqlConnection->errorInfo());
                echo "<br>";
            }
            
            $result = $preparedStatement->fetchAll(PDO::FETCH_CLASS);
            //print_r($result);
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
        
        public function getAddress($params)
        {
            print_r($this->addressLengths);
            print_r($params);
            foreach($params as $key=>$val)
            {
                //echo $key;
                //echo $val;
                
                if(is_string($val) && strlen($val) > $this->addressLengths[$key])
                {
                    echo strlen($val) . "\n";
                    echo $this->addressLengths[$key];
                    echo trimming;
                    $params[$key] = substr($val, 0, $this->addressLengths[$key]-1 );
                }
            }
            
            print_r($params);
            $returner = $this->makeStatementSelect($this->findAddedAddressString, $params);
            $this->endStatement();
            print_r($returner);
            return $returner;
        }
        
        public function addAddress($params)
        {
            print_r($params);
            $returner = $this->makeStatementInsert($this->addressAddingString, $params);
            $this->endStatement();
            if($returner == 0)
            {
                return $this->getAddress($params);
            }
            echo done;
            print_r($returner);
            return $returner;
        }
    }
?>