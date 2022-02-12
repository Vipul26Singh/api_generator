<?php
/**
 * get code
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_Form_Builder
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2013 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   CVS: $Id: getcode.php, v1.00 2014-01-15 02:52:40 Softdiscover $
 * @link      http://php-form-builder.zigaform.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
?>
<div class="space20"></div>
<div class="row">
<div class="col-lg-12">
          <div class="widget widget-padding span12">
            <div class="widget-header">
              <i class="fa fa-list-alt"></i><h5><?php echo __('Your Form code','FRocket_admin');?>  </h5>
            </div>
            <div class="widget-body">
              <div class="widget-forms clearfix">
                 
                  <div class="form-group">
                    <label class=" col-sm-2 control-label"><?php echo __('Widget code','FRocket_admin');?></label>
                      <div class="col-sm-10">
                        <textarea  onClick="this.select();"  style="height:100px;" rows="5"  placeholder=""  class="form-control col-md-7"><?php echo stripslashes($script)?></textarea>
                      </div>
                  </div>
                  <div class="space10"></div>
                 <div class="form-group">
                    <label class=" col-sm-2 control-label"><?php echo __('iframe','FRocket_admin');?></label>
                      <div class="col-sm-10">
                        <textarea onClick="this.select();"   style="height:100px;" rows="5"  placeholder=""  class="form-control col-md-7"><?php echo stripslashes($iframe)?></textarea>
                      </div>
                  </div>
                  <div class="space10"></div>
                 <div class="form-group">
                    <label class=" col-sm-2 control-label"><?php echo __('Url','FRocket_admin');?></label>
                      <div class="col-sm-10">
                        <textarea onClick="this.select();" style="height:100px;" rows="5"  placeholder=""  class="form-control col-md-7"><?php echo stripslashes($url)?></textarea>
                      </div>
                  </div>   
              </div>
            </div>
            <div class="widget-footer">
                <button  onClick="rocketform.modal_close();" class="btn btn-sm btn-primary" type="button" title="Close">
                    <?php echo __('Close','FRocket_admin');?>
                </button>
            </div>
          </div>
</div>
</div>