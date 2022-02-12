<?php

/**
 * Settings
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_Form_Builder
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2013 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   CVS: $Id: intranet.php, v2.00 2013-11-30 02:52:40 Softdiscover $
 * @link      http://php-form-builder.zigaform.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Estimator intranet class
 *
 * @category  PHP
 * @package   PHP_Form_Builder
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2013 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1.00
 * @link      http://php-form-builder.zigaform.com/
 */
class Settings extends MX_Controller {
    /**
     * max number of forms in order show by pagination
     *
     * @var int
     */

    const VERSION = '0.1';

    /**
     * name of form estimator table
     *
     * @var string
     */
    protected $modules;

    /**
     * Settings::__construct()
     * 
     * @return 
     */
    function __construct() {
        parent::__construct();
        $this->load->language_alt(model_settings::$db_config['language']);
        $this->template->set('controller', $this);
        $this->load->model('model_settings');
        $this->auth->authenticate(true);
    }

    /**
     * Settings::backup_upload_file()
     * 
     * @return 
     */
    public function backup_upload_file() {

        require_once( APPPATH . 'helpers/uiform_backup.php');
        $dbBackup = new Uiform_Backup();
        $dbBackup->uploadBackupFile();
    }

    /**
     * Settings::ajax_backup_create()
     * 
     * @return 
     */
    public function ajax_backup_create() {
        $json = array();

        $name_bkp = (isset($_POST['uifm_frm_namebackup']) && $_POST['uifm_frm_namebackup']) ? Uiform_Form_Helper::sanitizeInput($_POST['uifm_frm_namebackup']) : '';

        $name_bkp.='bkp-' . date("Y-m-d-H-i-s");
        $this->load->dbutil();
        $prefs = array(
            'format' => 'sql',
            'filename' => $name_bkp . '.sql'
        );
        $backup = & $this->dbutil->backup($prefs);
        $db_name = $name_bkp . '.sql';
        $save = FCPATH . '/backups/' . $db_name;
        $this->load->helper('file');
        write_file($save, $backup);
        //$this->load->helper('download');
        //force_download($db_name, $backup); 


        header('Content-Type: application/json');
        echo json_encode($json);
        die();
    }

    /**
     * Settings::ajax_backup_restorefile()
     * 
     * @return 
     */
    public function ajax_backup_restorefile() {
        $json = array();
        $uifm_frm_resfile = (isset($_POST['uifm_frm_resfile']) && $_POST['uifm_frm_resfile']) ? Uiform_Form_Helper::sanitizeInput($_POST['uifm_frm_resfile']) : '';
        require_once( APPPATH . 'helpers/uiform_backup.php');
        $dbBackup = new Uiform_Backup();
        $CI = & get_instance();
        $CI->load->database();

        $dbBackup->restoreBackup($uifm_frm_resfile, $CI->db->database, $CI->db->username, $CI->db->password, $CI->db->hostname);
        header('Content-Type: application/json');
        echo json_encode($json);
        die();
    }

    /**
     * Settings::ajax_backup_deletefile()
     * 
     * @return 
     */
    public function ajax_backup_deletefile() {
        $json = array();
        $uifm_frm_delfile = (isset($_POST['uifm_frm_delfile']) && $_POST['uifm_frm_delfile']) ? Uiform_Form_Helper::sanitizeInput($_POST['uifm_frm_delfile']) : '';
        $dir = FCPATH . '/backups/';
        @unlink($dir . $uifm_frm_delfile);
        header('Content-Type: application/json');
        echo json_encode($json);
        die();
    }

    /**
     * Settings::ajax_save_options()
     * 
     * @return 
     */
    public function ajax_save_options() {
        $opt_language = (isset($_POST['language']) && $_POST['language']) ? Uiform_Form_Helper::sanitizeInput($_POST['language']) : '';
        $data = array();
        $data['language'] = $opt_language;
        $where = array(
            'id' => 1
        );

        $this->db->set($data);
        $this->db->where($where);
        $this->db->update($this->model_settings->table);

        $result = $this->db->affected_rows();
        $json = array();
        if ($result > 0) {
            $json['success'] = 1;
        } else {
            $json['success'] = 0;
        }

        header('Content-Type: application/json');
        echo json_encode($json);
        die();
    }

    /**
     * Settings::view_settings()
     * 
     * @return 
     */
    public function view_settings() {
        $data = array();
        $query = $this->model_settings->getOptions();

        $list_lang = array();
        $list_lang[] = array('val' => '', 'label' => __('Select language', 'FRocket_admin'));
        $list_lang[] = array('val' => 'en_US', 'label' => __('english', 'FRocket_admin'));
        $list_lang[] = array('val' => 'es_ES', 'label' => __('spanish', 'FRocket_admin'));
        $list_lang[] = array('val' => 'fr_FR', 'label' => __('french', 'FRocket_admin'));
        $list_lang[] = array('val' => 'de_DE', 'label' => __('german', 'FRocket_admin'));
        $list_lang[] = array('val' => 'it_IT', 'label' => __('italian', 'FRocket_admin'));
        $list_lang[] = array('val' => 'pt_BR', 'label' => __('portuguese', 'FRocket_admin'));
        $list_lang[] = array('val' => 'ru_RU', 'label' => __('russian', 'FRocket_admin'));
        $list_lang[] = array('val' => 'zh_CN', 'label' => __('chinese', 'FRocket_admin'));
        $data['language'] = $query->language;
        $data['lang_list'] = $list_lang;

        $this->template->loadPartial('layout', 'settings/view_settings', $data);
    }

    /**
     * Settings::backup_settings()
     * 
     * @return 
     */
    public function backup_settings() {
        if (isset($_POST['_uifm_bkp_submit_file']) && intval($_POST['_uifm_bkp_submit_file']) === 1) {
            $this->backup_upload_file();
        }

        $data = array();
        $dir = FCPATH . '/backups/';
        $data_files = array();
        if (is_dir($dir)) {
            $getDir = dir($dir);
            while (false !== ($file = $getDir->read())) {

                if ($file != "." && $file != ".." && $file != "index.php") {
                    $temp_file = array();
                    $temp_file['file_name'] = $file;
                    $temp_file['file_url'] = base_url() . '/backups/' . $file;
                    $temp_file['file_date'] = date("F d Y H:i:s.", filemtime($dir . $file));
                    $temp_file['file_size']=Uiform_Form_Helper::human_filesize(filesize($dir.$file));
                    $data_files[] = $temp_file;
                }
            }
        }
        $data['files'] = $data_files;
        $this->template->loadPartial('layout', 'settings/backup_settings', $data);
    }
    
    public function system_check() {
        $data = array();
      
        $all_tables=$this->model_settings->getAllDatabases();
         
        $uiform_tbs=array();
        $uiform_tbs[] = $this->db->dbprefix . "uiform_form";
        $uiform_tbs[] = $this->db->dbprefix . "uiform_form_records";
        $uiform_tbs[] = $this->db->dbprefix . "uiform_fields";
        $uiform_tbs[] = $this->db->dbprefix . "uiform_fields_type";
        $uiform_tbs[] = $this->db->dbprefix . "uiform_settings";
 
        
        //tables
        $name_tb=array();
        $name_tb[$this->db->dbprefix . "uiform_form"]="Forms";
        $name_tb[$this->db->dbprefix . "uiform_form_records"]="Records";
        $name_tb[$this->db->dbprefix . "uiform_fields"]="Fields";
        $name_tb[$this->db->dbprefix . "uiform_fields_type"]="Types";
        $name_tb[$this->db->dbprefix . "uiform_settings"]="Settings";

        
        
        $uiform_tbs_tmp=array();
        foreach ($uiform_tbs as $value) {
           $tmp_tb=array();
            $tmp_tb['table']=$name_tb[$value];
            (in_array($value, $all_tables))?$tmp_tb['status']=1:$tmp_tb['status']=0;
            $uiform_tbs_tmp[]=$tmp_tb; 
        }
        
        $data['database_int']=$uiform_tbs_tmp;
         
        $this->template->loadPartial('layout', 'formbuilder/settings/system_check', $data);    
    }
    
    

}
