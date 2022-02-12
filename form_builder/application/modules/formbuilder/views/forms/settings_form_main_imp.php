<?php
/**
 * Intranet
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   Rocket_form
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2015 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://wordpress-cost-estimator.zigaform.com
 */
if (!defined('BASEPATH')) {exit('No direct script access allowed');}
?>
<div class="uiform-set-field-wrap"  >
  
     
    <div class="space20"></div>
    <div class="row">
        <div class="col-sm-4">
            <label for=""><?php echo __('IMPORT FORM','FRocket_admin'); ?></label>
        </div>
        <div class="col-sm-8">
            <a href="javascript:void(0);"
               onclick="javascript:rocketform.importForm_openModal();"
               class="btn btn-warning"
               ><?php echo __('Import form','FRocket_admin'); ?></a>
            <a href="javascript:void(0);"
                       data-toggle="tooltip" data-placement="right" 
                       data-original-title="<?php echo __('Import the backuped form','FRocket_admin'); ?>"
                       ><span class="fa fa-question-circle"></span></a>
        </div>
    </div>
    <div class="space10"></div>
    
</div>