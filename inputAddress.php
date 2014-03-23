<?php
    require 'globalClasses.php';
    $params = array();
    $params[] = $_POST["street_number"];
    $params[] = $_POST["route"];
    $params[] = $_POST["locality"];
    $params[] = $_POST["postal_code"];
    $dba = new databaseAcessor();
    $addressKey = $dba->addAddress($params);
    echo $addressKey;
?>