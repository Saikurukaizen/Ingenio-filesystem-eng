<?php
namespace Php\Filesystem\Filesystem;

class Installer{
/**
     * Method that it executed after the install.
     */
    public static function postInstall()
    {
        self::publishAssets();
    }

    /**
     * Method that it executed after the update .
     */
    public static function postUpdate()
    {
        self::publishAssets();
    }

    /**
     * Publish the assets in the project's 'public' directory
     */
    private static function publishAssets(){
        // Define the file's routes that we want to copy
        $assetSource = __DIR__ . '/assets';
        $publicPath = getcwd() . '/public/vendor/ingenio/filesystem';

        // Verify if the destination folder exists. If it's not the case, create it
        if (!is_dir($publicPath)) {
            mkdir($publicPath, 0755, true);
        }

        // Do a recurse copy from assets/ to public/vendor/mi-libreria/
        self::recurseCopy($assetSource, $publicPath);
    }

    /**
     * Aux function to copy in a recursive way
     *
     * @param string $src  origin route
     * @param string $dst  destiny route
     */
    private static function recurseCopy($src, $dst){
        $dir = opendir($src);
        @mkdir($dst);

        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    self::recurseCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }

        closedir($dir);
    }
}

class Filesystem{
    public $AB_ROUTE;
    public $WEB_ROUTE;
    public $webroute;
    public $route;   
    public $GestRoutes;
    public $FormGestRoutes;
    public $direct = "";
    public $mode = [
        ['r','r - Read only. Start at the beggining of the file.'],
        ['r+','r+ - Read/Write. Start at the beggining of the file.'],
        ['w','w -  Write. Open and truncate file. Put the pointer file at the beggining.'],
        ['w+','w+ - Read/Write.Open and truncate file. Put the pointer file at the beggining.'],
        ['a','a - Write only. Add it at the end of the file and create if it not exist.'],
        ['a+','a+ - Read/Write. Preserve and write at the end of the file'],
        ['x','x -  Write only. Create a new file. It returns FALSE and error if the file exists already.'],
        ['x+','x+ - Read/Write. Create a new file. It returns FALSE and error if the file exists already.'],
        ['c','c -  Write only. Open the file; or create a new file if not exist. Put the pointer file at the beggining.'],
        ['c+','c+ - Read/Write. Open the file; or create a new file if not exist. Put the pointer file at the beggining.']
    ];
    private $FormUpFile ="";
    private $FormSelectFile = "";
    private $method = 'get';
    private $action = 'index.php';

    public function __construct(){
        $this->route = AB_ROUTE;
        $this->AB_ROUTE = AB_ROUTE;
        $this->WEB_ROUTE = WEB_ROUTE;        
        $this->formGestRoute();
        $this->gestRoute();
        $this->direct = "";       
        $this->getDirectoryStructure(AB_ROUTE,WEB_ROUTE);
        $this->setFormUpFile();
        $this->setFormSelectFile();
    }
    public function setMethodAction($method,$action){
        $this->$method = $method;
        $this->action = $action;
    }
    private function setFormSelectFile(){
        $this->FormSelectFile .= '            
            <form class="form-control container" method="'.$this->method.'" action="'.$this->action.'">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>SELECT FILE</h3>
                    </div>
                    <div class="col-lg-4">
                        <label>Filename:</label>
                        <input type="text" id="namefile" class="form-control" name="namefile" />
                    </div>
                    <div class="col-lg-4">
                        <label>Select Mode</label>
                    
                        <select class="form-select" name="mode" >
                            <option></option>';        
                               
                                for($i=0; $i < count($this->mode); $i++){
                                    $this->FormSelectFile .= '<option value="'.$this->mode[$i][0].'" >'.$this->mode[$i][1].'</option>';
                                }
                        $this->FormSelectFile .= '   
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Action type:</label>
                        <select class="form-select" name="type" onchange="showText(this.value)">
                            <option></option>
                            <option value="1">READ</option>
                            <option value="2">WRITE</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="content" style="display:none;">            
                            <label>File Content</label>
                            <textarea class="form-control" id="content" name="content" ></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <input type="hidden" id="action" name="action" value="OPEN_A_FILE" />
                        <input type="hidden" id="fileroute" name="route" value="'.$this->route.'" />
                        <input id="btn-files" class="btn btn-success" type="submit" value="OPEN_FILE" />
                        <input class="btn btn-danger" type="reset" value="RESET" />
                    </div>
                </div>
            </form>        
        ';
    }
    public function getFormSelectFile(){
        return $this->FormSelectFile;
    }
    private function setFormUpFile(){
        $this->FormUpFile = '            
            <form class="form-control" method="post" action="'.$this->action.'" enctype="multipart/form-data" >
                <h3>UP A FILE</h3>
                <input class="form-control" type="text" name="name" placeholder="Name of the owner" />
                <br>
                <label>Up a file:</label>
                <input id="file" class="form-control" type="file" name="file" placeholder="Upload a file..."  />
                <input type="hidden" name="action" value="UP_FILE" />
                <input class="btn btn-primary" type="submit" value="UP" />
            </form>
        ';
    }
    public function getFormUpFile(){
        return $this->FormUpFile;
    }
    public function setDirect($route){
        $this->direct = "";
        $this->GetDirectoryStructure($route,WEB_ROUTE);
    }
    public function openFiles(array $mdata){
        $file = fopen($mdata['route'].$mdata['namefile'],$mdata['mode']);
        //$mdata = fgets($file);
        $item = fread($file,filesize($mdata['route'].$mdata['namefile']));
        return $item;   
        fclose($file);
                
    }
    public function writeFile(array $mdata){
        $file = fopen($mdata['route'].$mdata['namefile'],$mdata['mode']);
        if(isset($mdata['content']) && !empty($mdata['content'])){
            return $item = fwrite($file, $mdata['content']);                   
        }
        fclose($file);
    }
    public function getDirectoryStructure(string $route,string $webroute = WEB_ROUTE){
        // The logic writes the root dir of the route.
        // Open the established route's directory in the form and it obtain folders and files.
        // .. / .
        
        $files = opendir($route);
        
        $this->direct .= '<ul id="list" ondragover="dragOverHandler(event);">';
        $there_files = false;
       
        // Loop that run the route and it obtain files and sub-folders.
        while(($file = readdir($files)) !== false){
    
            $route = rtrim($route, '/');
            $routew = rtrim($webroute,'/');
            $complete_route = $route."/".$file;        
            
            if($file != '.' && $file != '..'){
                //$webroute = $routew."/".$file;
                $there_files = true;
                if(is_dir($complete_route)){
                    $webroute = WEB_ROUTE."/".$file;
                    $wfile =  $file;
                    // is a subdirectory
                    $this->direct .= '<li ondrop="dropHandler(event);">
                                    <a href="#" id="btn-'.$file.'" class="btn-file" onclick="showInput(\''.$complete_route.'\',\''.$file.'\')">
                                    <i class="fa-solid fa-pen-to-square"></i></a>';
                                    if($there_files){
                                        $this->direct .= '<a href="#" class="btn-file" onclick="removeDir(\''.$complete_route.'\')"><i class="fa-solid fa-trash"></i></a>';    
                                    }
                                    else
                                    {
                                        $this->direct .= '<a href="#" class="btn-file" onclick=""><i class="fa-solid fa-trash"></i></a>';      
                                    }
                                    $this->direct .= '
                                    <a href="#" ondblclick="showInput(\''.$complete_route.'\',\''.$file.'\')">
                                            <i class="fa-regular fa-folder"></i><span id="span-'.$file.'"> '.$file.'</span></a>'.
                                            '<input id="btn-rename-'.$file.'" class="rename" type="text" value="'.$file.'" onchange="rename(this.value,\''.$complete_route.'\',\''.$route.'/'.'\')" onmouseleave="ocultarInput(\''.$file.'\')"/>'; 
                                            //$direct .= '<ul>';
                                            $this->direct .= $this->getDirectoryStructure($complete_route,$webroute);
                                            //$direct .= '</ul>';
                     $this->direct .='</li>';
                }
                else
                {
                    // files
                    $webroute = WEB_ROUTE.'';
                    $this->direct .= '<li ondrop="dropHandler(event);">                
                    <a href="#" id="btn-'.str_ireplace('.','-',$file).'" class="btn-file" onclick="showInput(\''.$complete_route.'\',\''.str_ireplace('.','-',$file).'\')">
                    <i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="#" class="btn-file" onclick="removeFile(\''.$complete_route.'\')"><i class="fa-solid fa-trash"></i></a>
                    <a href="#" ondblclick="showInput(\''.$complete_route.'\',\''.str_ireplace('.','-',$file).'\')" onclick="selectFile(\''.$routew.'/'.'\',\''.$route.'/'.'\',\''.$file.'\')">
                    
                    <i class="fa-solid fa-file"></i> 
                     <span id="span-'.str_ireplace('.','-',$file).'">'.$file.'</span></a>'.
                     '<input id="btn-rename-'.str_ireplace('.','-',$file).'" class="rename" type="text" value="'.$file.'" onchange="rename(this.value,\''.$complete_route.'\',\''.$route.'/'.'\')" onmouseleave="hideInput(\''.str_ireplace('.','-',$file).'\')"/> ';
                     $this->direct .= '</li>';
                }           
               
            }
        }
        if (!$there_files) {
            $this->direct .= '<li><em>This directory are empty</em></li>';
        }
        $this->direct .= '</ul>';
        closedir($files);        
    }
    public function filterFileName($file_name){
        $file_name = trim($file_name);
        $file_name = str_ireplace(" ","-",$file_name);
        $num = strlen($file_name);
        $ext = substr($file_name,strripos($file_name,'.',-1),10);   
        if($num > 1 && $num < 250){
            return $file_name;
        }
        else
        {
            return "default-file".$ext;
        }    
    }
    private function gestRoute(){       
        $this->GestRoutes .= $this->FormGestRoutes;
        $this->GestRoutes .='<span id="alert-route">'.$this->route.'</span>';
        $this->GestRoutes .='<button id="btn-1" class="btn btn-primary" onclick="showRem()"><i class="fa-solid fa-pen-to-square"></i></button>';
    }
    private function formGestRoute(){
        $this->FormGestRoutes .='
        <form id="form-direc" class="row g-3" method="get" action="index.php" style="display:none">
            <div class="col-auto">
                <input id="routeo" class="form-control" type="text" placeholder="Write a route.." name="route" 
            value="'.AB_ROUTE.'" />
            </div>
            <div class="col-auto">    
                <input type="hidden" name="action" value="SELECT_ROUTE" />
                <input type="submit" class="btn btn-success" value="SELECT" />
            </div>
            <div class="col-auto"> 
                <input type="reset" class="btn btn-danger" value="RESET" />
            </div>
        </form>';
        

    }
    public function upFile($mdata){
        $file_name = $_FILES['file']['name'];
        $complete_route = $_FILES['file']['full_path'];
        $type = $_FILES['file']['type'];
        $tmp = $_FILES['file']['tmp_name'];
        $error = $_FILES['file']['error'];
        $size = $_FILES['file']['size'];
        $file_name = $this->FilterFileName($file_name);        
        if(move_uploaded_file($tmp , AB_ROUTE.$file_name)){
            return $msn = "Successfully uploaded file";
        }
        else
        {
            return $msn = "This File could not be uploaded";
        }           
    }
    private function readFile(){
        $filename = "file.txt";
        $sep_row = "\n"; // separator for each row in txt file
        $sep_col = "|"; // separator for each col in txt file

        $fp = fopen($filename, "r");
        $rows = array();

        if(filesize($filename) > 0){
        $content = fread($fp, filesize($filename));
        $rows = explode($sep_row, $content);
        fclose($fp);
        }

        foreach($rows as $row){
        $cols = explode($sep_col, $row);
        foreach($cols as $col) echo $col . ", ";
        echo "<hr/>";
        }
    }
    public function readCSV(string $file, string $mode){
        $file = fopen($file,$mode);
        $csv = fgetcsv($file);
        fclose($file);
        return $csv;        
    }
    public function createCSV(string $file, string $mode, array $myarray){
       
          
          $file = fopen($file,$mode);
          
          foreach ($myarray as $line) {
            fputcsv($file, $line);
          }
          
          fclose($file);
    }
    public function renameFilesAjax(array $mdata){
        if(rename($mdata['complete_route'],$mdata['route'].$mdata['new'])){
            $res['msn'] = 'File or Folder renamed correctly';
            $res['val'] = true;
            return json_encode($res);  
        }
        else
        {
            $res['msn'] = 'File or folder renaming failed';
            $res['val'] = false;
            return json_encode($res); 
        }
    }
    public function deleteFileAjax(array $mdata){
        if(unlink($mdata['complete_route'])){
            $res['msn'] = 'File succesfully deleted';
            $res['val'] = true;
            return json_encode($res);  
        }
        else
        {
            $res['msn'] = 'file deleting failed';
            $res['val'] = false;
            return json_encode($res); 
        }
    }
    public function deleteDirectoryAjax(array $mdata){
        if(rmdir($mdata['comeplete_route'])){
            $res['msn'] = 'Directory successfully deleted ';
            $res['valor'] = true;
            return json_encode($res);  
        }
        else
        {
            $res['msn'] = 'Directory deleting failed, or it containe files';
            $res['val'] = false;
            return json_encode($res); 
        }
    }
   
}