<?php
/**
 * Intranet
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
 * Estimator dashboard class
 *
 * @category  PHP
 * @package   PHP_Form_Builder
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2013 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1.00
 * @link      http://php-form-builder.zigaform.com/
 */
class Dashboard extends CI_Controller {

    /**
     * Intranet::__construct()
     * 
     * @return 
     */
    function __construct() 
    {
        parent::__construct();
        $this->load->language_alt(model_settings::$db_config['language']);
        $this->template->set('controller', $this);

        $this->load->model('user/model_user');
        $this->load->model('visitor/model_visitor');
        $this->auth->authenticate(true);
    }

    /**
     * Intranet::index()
     * Print the dashboard of the HTML page.
     * 
     * @return void
     */
    public function index() 
    {
         
        redirect(site_url() . 'formbuilder/forms/list_uiforms');
    }

}