<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (class_exists('Uiform_Backup')) {
    return;
}

class Uiform_Backup {
     
    /**
     * Constructor
     *
     * @mvc Controller
     */
    public function __construct() {
      
        define('nl', "\r\n");
    }
    
    public function uploadBackupFile(){
       $target_dir = FCPATH . '/backups/';
        $target_file = $target_dir . basename($_FILES["uifm_bkp_fileupload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        
        // Check if file already exists
        if (file_exists($target_file)) {
          
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["uifm_bkp_fileupload"]["size"] > 5048576) {
          
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "sql") {
           
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk === 0) {
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["uifm_bkp_fileupload"]["tmp_name"], $target_file)) {
               
            } else {
                
            }
        }
        
    }
    
    public function restoreBackup($file,$db_name,$db_user,$db_pass,$db_host){
        
        $dir = FCPATH . '/backups/';
        $database_file=$dir.$file;
        $database_name=$db_name;
        $database_user=$db_user;				
        $datadase_password=$db_pass;
        $database_host=$db_host;
        
        if((trim((string)$database_name) != '') && (trim((string)$database_user) != '') 
	 
	  && (trim((string)$database_host) != '') 
	  && ($conn = @mysql_connect((string)$database_host, (string)$database_user, (string)$datadase_password))) {
		/*BEGIN: Select the Database*/
		if(!mysql_select_db((string)$database_name, $conn)) {
                        $sql = "CREATE DATABASE IF NOT EXISTS `".(string)$database_name."`";
			mysql_query($sql, $conn);
			mysql_select_db((string)$database_name, $conn);
		}
		/*END: Select the Database*/
		
		/*BEGIN: Remove All Tables from the Database*/
		
             
		/*END: Remove All Tables from the Database*/
		
		/*BEGIN: Restore Database Content*/
		if(isset($database_file))
		{
		
		$database_file=$database_file;
		$sql_file = @file_get_contents($database_file, true);
		$sql_queries = explode(";\n", $sql_file);
		
		for($i = 0; $i < count($sql_queries); $i++) {
			mysql_query($sql_queries[$i], $conn);
		}
		}
		}
        
    }
    
}
?>
