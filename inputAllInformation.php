<html>
    <body>
        <?php
            require 'globalClasses.php';
            $dba = new databaseAcessor();
            
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $email = $_POST["email"];
            $primaryPhoneId = $_POST["primaryPhone"];
            $primaryPhoneNum = $_POST["primaryPhoneNum"];
            $secondaryPhoneId = $_POST["secondaryPhone"];
            $secondaryPhoneNum = $_POST["secondaryPhoneNum"];
            $languageId = $_POST["languagesSpoken"];
            
            //if inputting new language
            if($languageId == "other")
            {
                $otherLanguageToAdd = $_POST['otherLanguage'];
                $languageId = $dba->addLanguage($otherLanguageToAdd);
            }
            
            
            
            //add person
            $arrayOfValues = array($firstName, $lastName, $email, $primaryPhoneId, $primaryPhoneNum, $secondaryPhoneId, $secondaryPhoneNum, $languageId);
            if(!$languageId)
            {
                echo "Failed to add language";
            }
            
            print_r($arrayOfvalues);
            
            $personId = $dba->addPerson($arrayOfValues);
            
            if(!$personId)
            {
                echo "failed to add person";
            }
            
            $params = array();
            if($_POST["addressType"] == 'apartment')
            {
                $params[] = "Bldg ".$_POST["buildingNumber"]." Apt ".$_POST["apartmentNumber"]." ".$_POST["street_number"]; 
            }
            else
            {
                $params[] = $_POST["street_number"];
            }
            $params[] = $_POST["route"];
            $params[] = $_POST["locality"];
            $params[] = $_POST["postal_code"];
            $addressKey = $dba->addAddress($params);
            $something = $dba->addPersonToHouse($personId,$addressKey);
            echo $addressKey;
            
            
            
            if($personId && $languageId && $addressKey)
            {
                echo "success";
                echo "value is " . $something;
                header("Location: christmasDriveForm.php");
            }
            
        ?>
    <body>
</html>