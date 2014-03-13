<?php
    require 'globalClasses.php';
    $params = array();
    $params[] = $_POST["street_number"];
    $params[] = $_POST["route"];
    $params[] = $_POST["locality"];
    $params[] = $_POST["postal_code"];
    echo "sssss";
    $dba = new databaseAcessor();
    echo "butt";
    $dba->addAddress($params);
    echo "ddddd";
    print_r($params);
?>