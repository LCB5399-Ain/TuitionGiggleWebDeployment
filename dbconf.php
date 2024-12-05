<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Content-Type');

define('db_server', "mysql-10a0243e-haziqimac-894f.e.aivencloud.com");
define('db_username', "avnadmin");
define('db_password', "AVNS_eLMssnTB234OoLL-_Fk");
define('db_name', "defaultdb");
define('db_port', 25615);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $link = mysqli_connect(db_server, db_username, db_password, db_name, db_port);

    // echo "Connected to the database successfully!";

} catch (mysqli_sql_exception $e) {
    echo "ERROR: Connection failed. " . $e->getMessage();
}

?>
