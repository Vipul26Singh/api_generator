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
class Fields extends MX_Controller {
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
    var $table = "";
    var $per_page = 10;

    /**
     * Fields::__construct()
     * 
     * @return 
     */
    function __construct() {
        parent::__construct();
        $this->load->language_alt(model_settings::$db_config['language']);
        $this->template->set('controller', $this);
        $this->load->model('model_fields');
        $this->auth->authenticate(true);
    }
    
    
    /**
     * Fields:: ajax_refresh_captcha()
     * 
     * @return 
     */
    public function ajax_refresh_captcha() {

        $length = 5;
        $charset = 'abcdefghijklmnpqrstuvwxyz123456789';
        $phrase = '';
        $chars = str_split($charset);

        for ($i = 0; $i < $length; $i++) {
            $phrase .= $chars[array_rand($chars)];
        }

        $resp = $resp2 = array();
        $resp['txt_color_st'] = (isset($_POST['txt_color_st'])) ? Uiform_Form_Helper::sanitizeInput($_POST['txt_color_st']) : '';
        $resp['txt_color'] = (isset($_POST['txt_color'])) ? Uiform_Form_Helper::sanitizeInput($_POST['txt_color']) : '';
        $resp['background_st'] = (isset($_POST['background_st'])) ? Uiform_Form_Helper::sanitizeInput($_POST['background_st']) : '';
        $resp['background_color'] = (isset($_POST['txt_color_st'])) ? Uiform_Form_Helper::sanitizeInput($_POST['background_color']) : '';
        $resp['distortion'] = (isset($_POST['distortion'])) ? Uiform_Form_Helper::sanitizeInput($_POST['distortion']) : '';
        $resp['behind_lines_st'] = (isset($_POST['behind_lines_st'])) ? Uiform_Form_Helper::sanitizeInput($_POST['behind_lines_st']) : '';
        $resp['behind_lines'] = (isset($_POST['behind_lines'])) ? Uiform_Form_Helper::sanitizeInput($_POST['behind_lines']) : '';
        $resp['front_lines_st'] = (isset($_POST['front_lines_st'])) ? Uiform_Form_Helper::sanitizeInput($_POST['front_lines_st']) : '';
        $resp['front_lines'] = (isset($_POST['front_lines'])) ? Uiform_Form_Helper::sanitizeInput($_POST['front_lines']) : '';
        $resp['ca_txt_gen'] = $phrase;

        $captcha_options = Uiform_Form_Helper::base64url_encode(json_encode($resp));
        $resp2 = array();
        $resp2['rkver'] = $captcha_options;
        //return data to ajax callback
        header('Content-Type: application/json');
        echo json_encode($resp2);
        die();
    }
    
    
    /**
     * Fields::edit_uiform()
     * 
     * @return 
     */
    public function edit_uiform() {

        $data = array();
        echo $this->load->view('formbuilder/forms/edit_form', $data, true);
    }
    
    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_textbox($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_textbox', $data, true);
    }
    
    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_textbox_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_textbox_css', $data, true);
    }
    
    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    
    public function formhtml_textarea($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        // $data['form_id'] = (isset($_GET['form_id']) && $_GET['form_id']) ? Uiform_Form_Helper::sanitizeInput(trim($_GET['form_id'])) : 0;
        return $this->load->view('formbuilder/fields/formhtml_textarea', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_textarea_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_textarea_css', $data, true);
    }
    
    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_radiobtn($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        // $data['form_id'] = (isset($_GET['form_id']) && $_GET['form_id']) ? Uiform_Form_Helper::sanitizeInput(trim($_GET['form_id'])) : 0;
        return $this->load->view('formbuilder/fields/formhtml_radiobtn', $data, true);
    }
    
    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_radiobtn_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_radiobtn_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_checkbox($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_checkbox', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_checkbox_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_checkbox_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_select($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_select', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_select_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_select_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_multiselect($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_multiselect', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_multiselect_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_multiselect_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_fileupload($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_fileupload', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_fileupload_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_fileupload_css', $data, true);
    }

    
    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_imageupload($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_imageupload', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_imageupload_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_imageupload_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_customhtml($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_customhtml', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_customhtml_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_customhtml_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_password($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_password', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_password_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_password_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_preptext($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_preptext', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_preptext_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_textbox_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_appetext($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_appetext', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_appetext_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_textbox_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_prepapptext($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_prepapptext', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_prepapptext_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_textbox_css', $data, true);
    }
    
     public function formhtml_panelfld($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_panelfld', $data, true);
    }

    public function formhtml_panelfld_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_panelfld_css', $data, true);
    }
    
    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_slider($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_slider', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_slider_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_slider_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_range($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_range', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_range_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_range_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_spinner($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_spinner', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_spinner_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_spinner_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_captcha($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_captcha', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_captcha_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_captcha_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_recaptcha($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_recaptcha', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_recaptcha_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_recaptcha_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_datepicker($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_datepicker', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_datepicker_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_datepicker_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_timepicker($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_timepicker', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_timepicker_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_timepicker_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_datetime($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_datetime', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_datetime_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_datetime_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_submitbtn($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_submitbtn', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_submitbtn_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_submitbtn_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_hiddeninput($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_hiddeninput', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_hiddeninput_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_hiddeninput_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_ratingstar($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_ratingstar', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_ratingstar_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_ratingstar_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_colorpicker($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_colorpicker', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_colorpicker_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_colorpicker_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_divider($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_divider', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_divider_css($data) {

        return $this->load->view('formbuilder/fields/formhtml_divider_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_wizardbtn($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_wizardbtn', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_wizardbtn_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_wizardbtn_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_switch($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_switch', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_switch_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_switch_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_dyncheckbox($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_dyncheckbox', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_dyncheckbox_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_dyncheckbox_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_dynradiobtn($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_dynradiobtn', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_dynradiobtn_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_dynradiobtn_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_heading($value, $num_tab) {
        $data = array();
        $data['tab_num'] = $num_tab;
        $data = array_merge($data, $value);
        return $this->load->view('formbuilder/fields/formhtml_heading', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function formhtml_heading_css($data) {
        return $this->load->view('formbuilder/fields/formhtml_heading_css', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function preview_fields() {
        $data = array();
        echo $this->load->view('formbuilder/fields/preview_fields', $data, true);
    }

    /**
     * Fields::formhtml()
     * 
     * @return 
     */
    public function generate_templates_fields() {
        $data = array();
        $data['id_field'] = '';
        $data['quick_options'] = $this->load->view('formbuilder/fields/templates/prevpanel_quickopts', $data, true);
        $data['uiform_grid_two'] = $this->load->view('formbuilder/fields/templates/prevpanel_textbox', $data, true);
        $data['uiform_textbox'] = $this->load->view('formbuilder/fields/templates/prevpanel_textbox', $data, true);
        $content = $this->load->view('formbuilder/fields/templates/prevpanel_main', $data, true);

        $pathfile = APPPATH . '/modules/formbuilder/views/fields/templates/testing_file.php';
        $fh = fopen($pathfile, "w");

        if (fwrite($fh, $content)) {
            return true;
        }
        fclose($fh);
    }

}
