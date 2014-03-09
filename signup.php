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
            
            if(!$dba->addPerson($arrayOfValues))
            {
                echo "failed to add person";
            }
            
            if($dba->addPerson($arrayOfValues) && $languageId)
            {
                header("Location: christmasDriveForm.php");
            }
            //add language
        ?>
    <body>
</html>