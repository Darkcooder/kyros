<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_custom
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<?php 
$style1 = '_style1';
$style2 = '_banner';
if( strpos($params->get('moduleclass_sfx'), $style1) !== false && $params->get('backgroundimage') )  : ?>
<div class="custom<?php echo $moduleclass_sfx ?> has-image1" style="background-image: url(<?php echo $params->get('backgroundimage'); ?>);">
	<div class="con_style1"><?php echo $module->content;?></div>
	<div class="clear"> </div>
	
</div>
<?php elseif( strpos($params->get('moduleclass_sfx'), $style2) !== false && $params->get('backgroundimage') )  : ?>
<div class="custom<?php echo $moduleclass_sfx ?>">
	<div class="img_banner"><img src="<?php echo JURI::base(); ?>/<?php echo $params->get('backgroundimage'); ?>"></div>
	<div class="con_banner"><?php echo $module->content;?></div>
	<div class="clear"> </div>
</div>
<?php else: ?>
<div class="custom<?php echo $moduleclass_sfx ?>" <?php if ($params->get('backgroundimage')): ?> style="background-image:url(<?php echo $params->get('backgroundimage');?>)"<?php endif;?> >
	<?php echo $module->content;?>
</div>
<?php endif; ?>