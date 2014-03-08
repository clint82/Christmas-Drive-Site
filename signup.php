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
            
            if($languageId == "other")
            {
                echo "yay works";
                $otherLanguageToAdd = $_POST['otherLanguage'];
                echo $otherLanguageToAdd;
                echo $dba->addLanguage($otherLanguageToAdd);
            }
            
            //add person
            $arrayOfValues = array($firstName, $lastName, $email, $primaryPhoneId, $primaryPhoneNum, $secondaryPhoneId, $secondaryPhoneNum, $languageId);
            echo $dba->addPerson($arrayOfValues);
            
            //add language
        ?>
    <body>
</html>