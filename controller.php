<?php
require_once('vendor/ingenio/filesystem/src/Filesystem.php');

define('AB_ROUTE',$_SERVER['DOCUMENT_ROOT'].'/'.'uploads/');
define('WEB_ROUTE','https://localhost/libreria/uploads/');

use Php\Filesystem\Filesystem\Filesystem;
$files = new Filesystem();

?>