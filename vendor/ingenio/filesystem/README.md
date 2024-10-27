## PHP & JAVASCRIPT FILESYSTEM LIBRARY

##### CREATED BY: INGENIO HOSTING
##### TONI DOMENECH & MARC SANCHEZ

### VERSION 1.0

#### DOCUMENTATION
	
##### 1- INSTALLING THE LIBRARY:
###### Use your terminal and introduce the following command.

	composer require ingenio/filesystem:dev-principal

##### 2-CONFIG FEATURES

###### For it be able, first for all, create a folder called 'uploads' in the project's main root.
###### You must to declare the next constants in your index.php or controller.php
	
	<?php
         define('route_AB',$_SERVER['DOCUMENT_ROOT'].'/'.'uploads/');
        define('WEB_ROUTE','https://localhost/uploads/');
    ?>

###### We instance the class in an Object.

	<?php
 	    use Php\Filesystem\Filesystem\Filesystem;
 	    $files = new Filesystem();
	?>

##### 3-INCLUDING CSS & JS'S FILES IN YOUR PROJECT

You could use the styles and scripts of this library, using this code and add it to your HTML file:

	<link rel="stylesheet" href="vendor/ingenio/filesystem/assets/css/filesystem.css">
	<script src="vendor/ingenio/filesystem/assets/js/filesystem.js"></script>

CONCLUSION:

If your library requires essential styles and scripts to run it properly, the 1st method
(assets's publication) is the best one to suit you. If the CSS/JS's files are optional or featured files, the
2nd option it could be more flexible, allowing to the users an inclusive planning as they wish.

USING A SAMPLE CODE:


	<div class="container-fluid card press">
    		<div class="row">
        		<div class="col-lg-6">
            			<?php echo $files->getFormUpFile(); ?>
        		</div>
        		<div class="col-lg-6">
            			<?php echo $files->getTreeDirectories(); ?>
        		</div>
    		</div>
	</div>

