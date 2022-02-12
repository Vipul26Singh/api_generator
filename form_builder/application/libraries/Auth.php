<?php
/**
 * Auth
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_Form_Builder
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2013 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   CVS: $Id: Auth.php, v2.00 2013-11-30 02:52:40 Softdiscover $
 * @link      http://php-form-builder.zigaform.com/
 */

/**
 * Auth
 *
 * @category  PHP
 * @package   PHP_Form_Builder
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2013 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1.00
 * @link      http://php-form-builder.zigaform.com/
 */
class Auth
{
    var $CI;
    var $_username;
    
    /**
     * Auth::__construct()
     * 
     * @return 
     */
    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->helper('string');
        $this->CI->load->helper('cookie');
    }
    
    /**
     * Auth::Auth
     * 
     * @return void
     */
    function Auth()
    {
        self::__construct();
    }
    
    /**
     * login user
     *
     * @param string $username    username
     * @param string $password    password
     * @param string $redirect_to url to redirect
     * 
     * @return	array
     */
    function login($username, $password, $redirect_to = null)
    {
        $query = $this->CI->db->get_where($this->CI->db->dbprefix.'uiform_user', array('use_login' => $username, 'use_password' => md5($password), 'flag_status' => 1), 1);
        if ($query->num_rows() === 1) {
            $row  = $query->row();
            session_start();
            $data = array(
                'loggedIn' => true,
                'sess_expire_on_close' => true,
                'time_stmp'=>strtotime(date("Y-m-d H:i:s")),
                'use_login' => $row->use_login,
                'use_id' => $row->use_id,
                'tmp_sess'=>session_id()
            );
            $this->CI->session->set_userdata($data);
            $_SESSION['all_data'] = $this->CI->session->all_userdata();
            redirect($redirect_to);
        } else {
            $this->CI->session->set_flashdata('message', 'danger: Access denied');
            redirect('/admin');
        }
    }
    
    /**
     * login user
     *
     * @param string $username    username
     * @param string $password    password
     * @param string $redirect_to url to redirect
     * 
     * @return	array
     */
    function checkupdate()
    {
        
            $version= UIFORM_VERSION;
            $install_ver = model_settings::$db_config['version'];
             
            if (!$install_ver || version_compare($version,$install_ver, '>')) {
                
                if (!$install_ver || version_compare($install_ver,"1.4", '<')) {
                    $tbname = "fbcf_uiform_form_records";
                    
                    $query2 = $this->CI->db->query("SHOW TABLES LIKE '$tbname'");
                    $row = (Array)$query2->row();
                    
                    if ((string)reset($row) === $tbname) {
                        
                        $query2 = $this->CI->db->query("SHOW COLUMNS FROM " . $tbname . " LIKE 'fbh_data_rec'");
                        $row = (Array)$query2->row();
                        
                        if (empty($row)) {
                            $sql = "ALTER TABLE " . $tbname . " ADD  fbh_data_rec longtext NOT NULL;";
                            $this->CI->db->query($sql);
                        }

                        $query2 = $this->CI->db->query("SHOW COLUMNS FROM " . $tbname . " LIKE 'fbh_data_xml'");
                        $row = (Array)$query2->row();
                        if (!empty($row)) {
                            $sql = "ALTER TABLE " . $tbname . " CHANGE fbh_data_xml fbh_data_rec_xml longtext;";
                            $this->CI->db->query($sql);
                        }
                    }
                     
                }
                
                
                if (!$install_ver || version_compare($install_ver,"1.4.7", '<')) {
                    $tbname = "fbcf_uiform_fields";
                    
                    $query2 = $this->CI->db->query("SHOW TABLES LIKE '$tbname'");
                    $row = (Array)$query2->row();
                    
                    if ((string)reset($row) === $tbname) {
                        
                        $query2 = $this->CI->db->query("SHOW COLUMNS FROM " . $tbname . " LIKE 'order_frm'");
                        $row = (Array)$query2->row();
                        
                        if (empty($row)) {
                            $sql = "ALTER TABLE " . $tbname . " ADD  order_frm smallint(5) DEFAULT NULL;";
                            $this->CI->db->query($sql);
                        }

                        $query2 = $this->CI->db->query("SHOW COLUMNS FROM " . $tbname . " LIKE 'order_rec'");
                        $row = (Array)$query2->row();
                        
                        if (empty($row)) {
                            $sql = "ALTER TABLE " . $tbname . " ADD  order_rec smallint(5) DEFAULT NULL;";
                            $this->CI->db->query($sql);
                        }
                    }
                     
                }
                
                //update
               
                $data = array(
                    'version' => $version
                );
                 $where = array(
                    'id' => 1
                );
                
                $this->CI->db->set($data);
                $this->CI->db->where($where);
                $this->CI->db->update($this->CI->db->dbprefix.'uiform_settings');
                
                $this->CI->cache->delete('settings');
              
            }
    }
    
    
    /**
     * check logged in status
     * 
     * @return array
     */
    function loggedIn()
    {
        return $this->CI->session->userdata('loggedIn');
    }
    
    /**
     * logout user
     * 
     * @param string $redirect_to link to redirect
     * 
     * @return array
     */
    function logout($redirect_to = null)
    {
        $this->CI->session->sess_destroy();
        delete_cookie('ci_cest');
        if ($redirect_to != null) {
            redirect($redirect_to);
        }
    }
    
    /**
     * authenticate user
     * 
     * @param string $restrict_to link to restrict
     * @param string $redirect_to link to redirect
     * 
     * @return array
     */
    function authenticate($restrict_to = null, $redirect_to = null)
    {
        $redirect_to = ($redirect_to == null) ? $this->CI->config->item('site_url') . 'default/intranet/login' : $redirect_to;
        
        if ($restrict_to !== null) {
            if ($this->loggedIn() == true) {
                return true;
            } else {
                redirect($redirect_to);
            }
        } else {
            show_error("area restricted");
        }
    }
    
}
