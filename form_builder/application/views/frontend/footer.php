<?php
/**
 * Footer
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_Form_Builder
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2013 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   CVS: $Id: frontend_est_footer.php, v2.00 2013-11-30 02:52:40 Softdiscover $
 * @link      http://php-form-builder.zigaform.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
?>
<div id="footer" class="clearfix">
      <div class="container wrapper">
        <p class="text-muted">
            Powered by <?php echo model_settings::$db_config['site_title']; ?>
             .</p>
      </div>
    </div>