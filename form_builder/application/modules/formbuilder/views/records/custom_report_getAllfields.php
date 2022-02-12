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
 * @link      http://www.zigaform.com/wordpress-form-builder
 */
if (!defined('BASEPATH')) {exit('No direct script access allowed');}
?>
<div class="uifm-customreport">
    <?php
    foreach ($list_fields as $value) {
     ?>
    <div class="checkbox-inline"> 
         <label> 
             <input  
                    name="field_<?php echo $value->fmf_uniqueid;?>" 
                    value="<?php echo $value->fmf_uniqueid;?>"
                    type="checkbox"
                    <?php if(isset($value->fmf_status_qu) && intval($value->fmf_status_qu)===1){ ?>
                    checked
                    <?php }?>
                    >
             <input name="<?php echo $value->fmf_uniqueid;?>" 
                    type="number" 
                    class="uifm-cusreport-order-rec"
                    value="<?php echo intval($value->order_rec);?>"/>
 <?php echo $value->fieldname;?>
         </label>  
     </div>
   <?php   
    }
    ?>
</div>