<?php
require_once dirname(__FILE__) . '/_/composer/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$db_host =  getenv('OPENSHIFT_MYSQL_DB_HOST') . ':' . getenv('OPENSHIFT_MYSQL_DB_PORT');
if ($db_host == ':'){
  $db_host = getenv('MY_DB_HOST');
}

$db_user = getenv('OPENSHIFT_MYSQL_DB_USERNAME') ?: getenv('MY_DB_USER');
$db_password = getenv('OPENSHIFT_MYSQL_DB_PASSWORD') ?: getenv('MY_DB_PASSWORD');
$db_name = getenv('OPENSHIFT_GEAR_NAME') ?: getenv('MY_DB_NAME');

define('DB_HOST',$db_host);
define('DB_USER',$db_user);
define('DB_PASSWORD',$db_password);
define('DB_NAME',$db_name);

define('ADMIN_ROOT', dirname(__FILE__) . "/");

$db = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>
