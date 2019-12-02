<?php 
/**
 * jSecure Authentication components for Joomla!
 * jSecure Authentication extention prevents access to administration (back end)
 * login page without appropriate access key.
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2011
 * @package     jSecure2.1.10
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php  $
 */
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
$JSecureConfig = $this->JSecureConfig;

JHtml::_('behavior.framework', true);
JHTML::_('script','system/modal.js', false, true);
JHTML::_('stylesheet','system/modal.css', array(), true);

$document =& JFactory::getDocument();
$document->addScriptDeclaration("window.addEvent('domready', function() {
			$$('.hasTip').each(function(el) {
				var title = el.get('title');
				if (title) {
					var parts = title.split('::', 2);
					el.store('tip:title', parts[0]);
					el.store('tip:text', parts[1]);
				}
			});
			var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false});
		});
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});
			SqueezeBox.assign($$('a.modal'), {
				parse: 'rel'
			});
		});
		window.onload = function(){showUpdates();}
");
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsecure/js/basic.js"></script>');
?>

<h3><?php echo JText::_('BASIC_CONFIGURATION');?></h3>
<form action="index.php?option=com_jsecure" method="post" name="adminForm" onsubmit="return submitbutton();" id="adminForm" autocomplete="off">
     <fieldset class="adminform">
      <table class="table table-striped">
        <tr>
          <td class="paramlist_key"><span class="bold hasTip" title="<?php echo JText::_('ENABLE')."::".JText::_('PUBLISHED_DESCRIPTION');?>"> <?php echo JText::_('ENABLE'); ?> </span> </td>
          <td class="paramlist_value">
		<fieldset id="jform_home" class="radio btn-group">
  			<input  type="radio" name="publish" value="1" <?php echo ($JSecureConfig->publish == 1)? 'checked="checked"':''; ?> id="publish1" />
  			<label class="btn" for="publish1">Yes</label>
  			<input type="radio" name="publish" value="0" <?php echo ($JSecureConfig->publish == 0)?  'checked="checked"':''; ?> id="publish0" />
  			<label class="btn" for="publish0">No</label>
		</fieldset>
          </td>
        </tr>
		
        <tr>
          <td class="paramlist_key"><span class="bold hasTip" title="<?php echo JText::_('PASS_KEY').'::'.JText::_('KEY_DESCRIPTION'); ?>"> <?php echo JText::_('PASS_KEY'); ?> </span> </td>
          <td class="paramlist_value">
			<fieldset id="passkeytype" class="radio btn-group">
  			<input type="radio" name="passkeytype" value="url" <?php echo ($JSecureConfig->passkeytype == "url")? 'checked="checked"':''; ?> id="url" />
  			<label class="btn" for="url"><?php echo JText::_('URL'); ?></label>
  			<input type="radio" name="passkeytype" value="form" <?php echo ($JSecureConfig->passkeytype == "form")? 'checked="checked"':''; ?> id="form" />
  			<label class="btn" for="form"><?php echo JText::_('FORM'); ?></label>
			</fieldset>
          </td>
        </tr>
		
        <tr>
          <td class="paramlist_key"><span class="bold hasTip" title="<?php echo JText::_('KEY').'::'.JText::_('KEY_DESCRIPTION'); ?>"> <?php echo JText::_('KEY'); ?> </span> </td>
          <td class="paramlist_value"><input type="password" name="key" id="key" value="" size="50"/>
          </td>
        </tr>
		
        <tr>
          <td class="paramlist_key"><span class="bold hasTip" title="<?php echo JText::_('REDIRECT_OPTIONS').'::'.JText::_('REDIRECT_OPTIONS_DESCRIPTION'); ?>"> <?php echo JText::_('REDIRECT_OPTIONS'); ?> </span> </td>
          <td class="paramlist_value">
		  	<fieldset id="options" class="radio btn-group">
  			<input type="radio" name="options" value="0" <?php echo ($JSecureConfig->options == 0)? 'checked="checked"':''; ?> id="options0" />
  			<label class="btn" for="options0"><?php echo JText::_('REDIRECT_INDEX'); ?></label>
  			<input type="radio" name="options" value="1" <?php echo ($JSecureConfig->options == 1)? 'checked="checked"':''; ?> id="options1" />
  			<label class="btn" for="options1"><?php echo JText::_('CUSTOM_PATH'); ?></label>
			</fieldset>
          </td>
        </tr>
		
        <tr id="custom_path">
          <td class="paramlist_key"><span class="bold hasTip" title="<?php echo JText::_('CUSTOM_PATH').'::'.JText::_('CUSTOM_PATH_DESCRIPTION'); ?>"> <?php echo JText::_('CUSTOM_PATH'); ?> </span> </td>
          <td class="paramlist_value"><input name="custom_path" type="text" value="<?php echo $JSecureConfig->custom_path; ?>" size="50" />
          </td>
        </tr>
		
      </table>
      </fieldset>
  <input type="hidden" name="option" value="com_jsecure"/>
  <input type="hidden" name="task" value="saveBasic" />
  <input name="sendemail" type="hidden" value="<?php echo $JSecureConfig->sendemail; ?>" size="50" />
</form>
<!-- Footer Start -->
<table class="basic_config_cls">
  <tr>
    <td valign="top" width="60%"><!-- log start here -->		  
      <table class="table table-striped">
        <thead>
          <tr>
            <th width="1%"> <?php echo JText::_( 'Num' ); ?> </th>
            <th> <?php echo JText::_( 'IP' ); ?> </th>
            <th nowrap="nowrap"> <?php echo JText::_( 'User Name' ); ?> </th>
            <th> <?php echo JText::_( 'Code' ); ?> </th>
            <th> <?php echo JText::_( 'Log' ); ?> </th>
            <th> <?php echo JText::_( 'Date' ); ?> </th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td colspan="6" style="text-align:right;padding-right:40px;"><a href="index.php?option=com_jsecure&amp;task=log">Read More... </a> </td>
          </tr>
        </tfoot>
        <tbody>
          <?php
				$i=0;$k = 0;
				foreach($this->data as $row){
					$user = JUser::getInstance($row->userid);
				?>
          <tr class="<?php echo "row$k"; ?>">
            <td><?php echo  $i+1; ?> </td>
            <td align="left">		
				<span class="bold hasTip" title="<?php echo JText::_('IP Address')."::".JText::_('Click here to view information of this IP address');?>">
	       			<a class="modal" href="index.php?option=com_jsecure&amp;task=ipinfo&amp;ip=<?php echo $row->ip;?>&amp;tpl=component" rel="{handler: 'iframe', size: {x: 800, y: 500}}"><?php echo $row->ip; ?></a>
				</span>
			</td>
            <td align="left"><?php echo $user->username; ?> </td>
            <td align="left"><?php echo JText::_($row->code); ?> </td>
            <td align="left"><?php echo str_replace("\n","<br/>",$row->change_variable); ?> </td>
            <td align="left"><?php echo str_replace("\n","<br/>",$row->date); ?> </td>
          </tr>
          <?php
					$k = 1 - $k;	$i++;
				}
				?>
        </tbody>
      </table>
      <!-- log end here -->
    </td>
	<td>&nbsp;</td>
    <td valign="top"><table cellpadding="0" cellspacing="0" border="1" class="table table-striped" bordercolor="#DDDDDD">
        <tr>
          <th colspan="2">
		  		<div align="center">
					<a href="http://www.joomlaserviceprovider.com" title="Joomla Service Provider" target="_blank">
						<img src="components/com_jsecure/images/logo.jpg" alt="Joomla Service Provider" border="none"/>
					</a>
				</div>
            	<div align="center"><?php echo JText::_( 'jSecure Authentication' ); ?></div></th>
        </tr>
        <tr>
          <td><?php echo JText::_( 'VERSION_TEXT' ); ?></td>
          <td><?php echo JText::_( 'VERSION_DESCRIPTION' ); ?></td>
        </tr>
        <tr>
          <td><?php echo JText::_( 'SUPPORT' ); ?></td>
          <td><a href="http://www.joomlaserviceprovider.com/component/kunena/5-jsecure-authentication.html" target="_blank"><?php echo JText::_( 'JSECURE_AUTHENTICATION_FORUM' ); ?></a></td>
        </tr>
		<tr>
          <td><?php echo JText::_( 'UPDATES' ); ?></td>
         <td>
		 	<div id="image" name="image"><img src="components/com_jsecure/images/sh-ajax-loader-wide.gif" /></div>
		 	<div id="version"></div>
		  	<button id="chkupdates" class="btn btn-small" onclick="showUpdates();" href="#">Check For Update</button>	 
		</td>
        </tr>
		
		<tr id="show_notes">
          <td><?php echo JText::_( 'NOTES' ); ?></td>
          <td><div id="notes"></div></td>
        </tr>
		
      </table></td>
  </tr>
</table>
<!-- Footer End  -->