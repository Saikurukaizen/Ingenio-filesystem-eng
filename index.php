<?php
require_once('controller.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="vendor/ingenio/filesystem/assets/css/filesystem.css">
</head>
<body>   
    <div class="container-fluid card press">
        <div class="row">
            <div class="col-lg-6">
                <?php echo $files->getFormUpFile(); ?>
            </div>
            <div class="col-lg-6">
                <?php 
                    /* echo $files->getTreeDirectorios(); */
                    echo $files->GetDirectoryStructure(AB_ROUTE,WEB_ROUTE);
                ?>
            </div>
        </div>
    </div>

</body>
<script src="/vendor/ingenio/filesystem/assets/js/Filesystem.js"></script>
</html>