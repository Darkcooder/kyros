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
");
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsecure/js/advanced.js"></script>');
?>

<h3><?php echo JText::_('ADVANCED_CONFIGURATION');?></h3>
<form action="index.php?option=com_jsecure&task=advanced" method="post" name="adminForm" onsubmit="return submitbutton();" id="adminForm" autocomplete="off">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#mail_config_tab" data-toggle="tab"><?php echo JText::_('MAIL_CONFIG');?></a></li>
    <li><a href="#ip_config_tab" data-toggle="tab"><?php echo JText::_('IP_CONFIG');?></a></li>
    <li><a href="#master_password_tab" data-toggle="tab"><?php echo JText::_('MASTER_PASSWORD');?></a></li>
    <li><a href="#email_master_tab" data-toggle="tab"><?php echo JText::_('EMAIL_MASTER');?></a></li>
    <li><a href="#log_tab" data-toggle="tab"><?php echo JText::_('LOG');?></a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="mail_config_tab">
      <fieldset class="adminform">
      <table class="table table-striped">
        <tr>
          <td class="paramlist_key" width="40%"><span class="editlinktip hasTip" title="Enable">
            <label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('SEND_MAIL').'::'.JText::_('SEND_MAIL_DESCRIPTION'); ?>"> <?php echo JText::_('SEND_MAIL'); ?> </label>
            </span> </td>
          <td class="paramlist_value" width="60%"><fieldset id="sendemail234" class="radio btn-group">
            <input type="radio" name="sendemail" value="0" <?php echo ($JSecureConfig->sendemail==0)? 'checked="checked"':''; ?> id="sendemail0" />
            <label class="btn" for="sendemail0"><?php echo JText::_('COM_JSECURE_NO'); ?></label>
            <input type="radio" name="sendemail" value="1" <?php echo ($JSecureConfig->sendemail==1)? 'checked="checked"':''; ?> id="sendemail1" />
            <label class="btn" for="sendemail1"><?php echo JText::_('COM_JSECURE_YES'); ?></label>
            </fieldset></td>
        </tr>
        <tr id="sendMailDetails">
          <td class="paramlist_key" width="40%"><span class="editlinktip">
            <label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('SEND_MAIL_DETAILS').'::'.JText::_('SEND_MAIL_DETAILS_DESCRIPTION'); ?>"> <?php echo JText::_('SEND_MAIL_DETAILS'); ?> </label>
            </span> </td>
          <td class="paramlist_value" width="60%"><select name="sendemaildetails">
              <option value="1" <?php echo ($JSecureConfig->sendemaildetails == 1)?"selected":''; ?>><?php echo JText::_('SEND_CORRECT_KEY'); ?></option>
              <option value="2" <?php echo ($JSecureConfig->sendemaildetails == 2)?"selected":''; ?>><?php echo JText::_('SEND_WRONG_KEY'); ?></option>
              <option value="3" <?php echo ($JSecureConfig->sendemaildetails == 3)?"selected":''; ?>><?php echo JText::_('SEND_BOTH'); ?></option>
            </select>
          </td>
        </tr>
        <tr id="emailid">
          <td class="paramlist_key" width="40%"><span class="editlinktip">
            <label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('EMAIL_ID').'::'.JText::_('EMAIL_ID_DESCRIPTION'); ?>"> <?php echo JText::_('EMAIL_ID'); ?> </label>
            </span> </td>
          <td class="paramlist_value" width="60%"><input name="emailid" type="text" value="<?php echo $JSecureConfig->emailid; ?>" size="50" />
          </td>
        </tr>
        <tr id="emailsubject">
          <td class="paramlist_key" width="40%"><span class="editlinktip">
            <label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('EMAIL_SUBJECT').'::'.JText::_('EMAIL_SUBJECT_DESCRIPTION'); ?>"> <?php echo JText::_('EMAIL_SUBJECT'); ?> </label>
            </span> </td>
          <td class="paramlist_value" width="60%"><input name="emailsubject" type="text" value="<?php echo $JSecureConfig->emailsubject; ?>" size="50" />
          </td>
        </tr>
      </table>
      </fieldset>
    </div>
    <div class="tab-pane" id="ip_config_tab">
      <fieldset class="adminform">
      <table class="table table-striped">
        <tr>
          <td class="paramlist_key" width="40%"><span class="editlinktip hasTip" title="<?php echo "Select".'::'.JText::_('IP_TYPE'); ?>"><?php echo JText::_('IP_TYPE'); ?></span></td>
          <td class="paramlist_value" width="60%"><select name="iptype" id="iptype" onchange="javascript: ipLising(this);">
              <option value="0" <?php echo ($JSecureConfig->iptype == 0)?"selected":''; ?>><?php echo JText::_('BLOCKED_IP'); ?></option>
              <option value="1" <?php echo ($JSecureConfig->iptype == 1)?"selected":''; ?>><?php echo JText::_('WHISH_IP'); ?></option>
            </select></td>
        </tr>
        <tr id="BipLisingAddbox">
          <td class="paramlist_key" width="40%"><span class="editlinktip hasTip" title="<?php echo JText::_('ADD_IP'); ?>"> <?php echo JText::_('ADD_IP'); ?> </span> </td>
          <td width="60%"><table border="0">
              <tr>
                <td align="left" valign="bottom" width="20%"><input type="text" name="blacklist_ip1" id="blacklist_ip1" value="" size="3" maxlength="3" onkeyup="isNumeric(this)" style="width:32%;"/>
                  <b>&nbsp;.</b></td>
                <td align="left" valign="bottom" width="20%"><input type="text" name="blacklist_ip2" id="blacklist_ip2" value="" size="3" maxlength="3" onkeyup="isNumeric(this)" style="width:32%;"/>
                  <b>&nbsp;.</b></td>
                <td align="left" valign="bottom" width="20%"><input type="text" name="blacklist_ip3" id="blacklist_ip3" value="" size="3" maxlength="3" onkeyup="isNumeric(this)" style="width:32%;"/>
                  <b>&nbsp;.</b></td>
                <td align="left" valign="bottom" width="20%"><input type="text" name="blacklist_ip4" id="blacklist_ip4" value="" size="3" maxlength="3" onkeyup="isNumeric(this)" style="width:32%;"/></td>
                <td align="left" width="20%"><input type="button" id="add_ipB" name="" value="<?php echo JText::_('ADD'); ?>" onclick="addIpB('blacklist_ip', 'blacklist_ips');" class="btn btn-small btn-success"/></td>
              </tr>
            </table></td>
        </tr>
        <tr id="BipLisingIpbox">
          <td align="right" class="key" width="40%"><span class="editlinktip hasTip" title="<?php echo JText::_('ACCESS_IP'); ?>"> <?php echo JText::_('ACCESS_IP_BLACKLIST'); ?> </span> </td>
          <td width="60%"><textarea cols="80" rows="10" class="text_area" type="text" name="iplistB" id="blacklist_ips"><?php echo $JSecureConfig->iplistB; ?></textarea>
          </td>
        </tr>
        <tr id="WipLisingAddbox">
          <td class="paramlist_key" width="40%"><span class="editlinktip hasTip" title="<?php echo JText::_('ADD_IP'); ?>"> <?php echo JText::_('ADD_IP'); ?> </span> </td>
          <td width="60%"><table border="0">
              <tr>
                <td align="left" width="20%" valign="bottom"><input type="text" name="whitelist_ip1" id="whitelist_ip1" value="" size="3" maxlength="3" onkeyup="isNumeric(this)" style="width:32%;"/>
                  <b>&nbsp;.</b></td>
                <td align="left" width="20%" valign="bottom"><input type="text" name="whitelist_ip2" id="whitelist_ip2" value="" size="3" maxlength="3" onkeyup="isNumeric(this)" style="width:32%;"/>
                  <b>&nbsp;.</b></td>
                <td align="left" width="20%" valign="bottom"><input type="text" name="whitelist_ip3" id="whitelist_ip3" value="" size="3" maxlength="3" onkeyup="isNumeric(this)" style="width:32%;"/>
                  <b>&nbsp;.</b></td>
                <td align="left" width="20%" valign="bottom"><input type="text" name="whitelist_ip4" id="whitelist_ip4" value="" size="3" maxlength="3" onkeyup="isNumeric(this)" style="width:32%;"/></td>
                <td align="left" width="20%"><input type="button" id="add_ipW" name="" value="<?php echo JText::_('ADD'); ?>" onclick="addIpW('whitelist_ip', 'whitelist_ips');" class="btn btn-small btn-success"/></td>
              </tr>
            </table></td>
        </tr>
        <tr id="WipLisingIpbox">
          <td align="right" class="key" width="40%"><span class="editlinktip hasTip" title="<?php echo JText::_('ACCESS_IP'); ?>"> <?php echo JText::_('ACCESS_IP_WHITELIST'); ?> </span> </td>
          <td width="60%"><textarea cols="80" rows="10" class="text_area" type="text" name="iplistW" id="whitelist_ips"><?php echo $JSecureConfig->iplistW; ?></textarea>
          </td>
        </tr>
      </table>
      </fieldset>
    </div>
    <div class="tab-pane" id="master_password_tab">
      <fieldset class="adminform">
      <table class="table table-striped">
        <tr>
          <td class="paramlist_key" width="40%"><span class="editlinktip hasTip" title="<?php echo JText::_('ENABLEMASTERPASSWORD_DESCRIPTION');?>"> <?php echo JText::_('MASTER_PASSWORD_ENABLED'); ?> </span> </td>
          <td class="paramlist_value" width="60%"><fieldset id="enableMasterPassword" class="radio btn-group">
            <input type="radio" name="enableMasterPassword" value="0" <?php echo ($JSecureConfig->enableMasterPassword == 0)? 'checked="checked"':''; ?> id="enableMasterPassword0" />
            <label class="btn" for="enableMasterPassword0"><?php echo JText::_('COM_JSECURE_NO'); ?></label>
            <input type="radio" name="enableMasterPassword" value="1" <?php echo ($JSecureConfig->enableMasterPassword == 1)? 'checked="checked"':''; ?> id="enableMasterPassword1" />
            <label class="btn" for="enableMasterPassword1"><?php echo JText::_('COM_JSECURE_YES'); ?></label>
            </fieldset></td>
        </tr>
        <tr id="master_password">
          <td class="paramlist_key" width="40%"><span class="editlinktip hasTip" title="<?php echo JText::_('MASTER_PASSWORD_DESCRIPTION');?>"> <?php echo JText::_('MASTER_PASSWORD'); ?> </span> </td>
          <td class="paramlist_value" width="60%"><input type="password" name="master_password" id="master_password" value="" size="50"/>
          </td>
        </tr>
        <tr id="verify_master_password">
          <td width="40%"><span class="editlinktip hasTip" title="<?php echo JText::_('REENTER_MASTER_PASSWORD_DESCRIPTION');?>"><?php echo JText::_('REENTER_MASTER_PASSWORD'); ?></span></td>
          <td width="60%"><input type="password" name="ret_master_password" id="ret_master_password" value="" size="50" /></td>
        </tr>
      </table>
      </fieldset>
    </div>
    <div class="tab-pane" id="email_master_tab">
      <fieldset class="adminform">
      <table class="table table-striped">
        <tr>
          <td class="paramlist_key" width="40%"><span class="editlinktip">
            <label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('CONFIGURATION_SEND_MAIL').'::'.JText::_('CONFIGURATION_SEND_MAIL_DESCRIPTION')	; ?>"> <?php echo JText::_('CONFIGURATION_SEND_MAIL'); ?> </label>
            </span> </td>
          <td class="paramlist_value" width="60%"><fieldset id="mpsendemail" class="radio btn-group">
            <input type="radio" name="mpsendemail" value="0" <?php echo ($JSecureConfig->mpsendemail == 0)? 'checked="checked"':''; ?> id="mpsendemail0" />
            <label class="btn" for="mpsendemail0"><?php echo JText::_('COM_JSECURE_NO'); ?></label>
            <input type="radio" name="mpsendemail" value="1" <?php echo ($JSecureConfig->mpsendemail == 1)? 'checked="checked"':''; ?> id="mpsendemail1" />
            <label class="btn" for="mpsendemail1"><?php echo JText::_('COM_JSECURE_YES'); ?></label>
            </fieldset></td>
        </tr>
        <tr id="mpemailsubject">
          <td class="paramlist_key" width="40%"><span class="editlinktip">
            <label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('CONFIGURATION_EMAIL_SUBJECT').'::'.JText::_('CONFIGURATION_EMAIL_SUBJECT_DESCRIPTION'); ?>"> <?php echo JText::_('CONFIGURATION_EMAIL_SUBJECT'); ?> </label>
            </span> </td>
          <td class="paramlist_value" width="60%"><input name="mpemailsubject" type="text" value="<?php echo $JSecureConfig->mpemailsubject; ?>" size="50" />
          </td>
        </tr>
        <tr id="mpemailid">
          <td class="paramlist_key" width="40%"><span class="editlinktip">
            <label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('CONFIGURATION_EMAIL_ID').'::'.JText::_('CONFIGURATION_EMAIL_ID_DESCRIPTION'); ?>"> <?php echo JText::_('CONFIGURATION_EMAIL_ID'); ?> </label>
            </span> </td>
          <td class="paramlist_value" width="60%"><input name="mpemailid" type="text" value="<?php echo $JSecureConfig->mpemailid; ?>" size="50" />
          </td>
        </tr>
      </table>
      </fieldset>
    </div>
    <div class="tab-pane" id="log_tab">
      <fieldset class="adminform">
      <table class="table table-striped">
        <tr>
          <td class="paramlist_key" width="40%"><span class="editlinktip">
            <label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('KEEP_LOG_FOR').'::'.JText::_('KEEP_LOG_FOR_DESCRIPTION'); ?>"> <?php echo JText::_('KEEP_LOG_FOR'); ?> </label>
            </span> </td>
          <td class="paramlist_value" width="60%"><select name="delete_log" id="delete_log">
              <option value="0" <?php echo ($JSecureConfig->delete_log==0)?"selected":''; ?>>Forever</option>
              <option value="1" <?php echo ($JSecureConfig->delete_log==1)?"selected":''; ?>>1 Months</option>
              <option value="2" <?php echo ($JSecureConfig->delete_log==2)?"selected":''; ?>>2 Months</option>
              <option value="3" <?php echo ($JSecureConfig->delete_log==3)?"selected":''; ?>>3 Months</option>
              <option value="4" <?php echo ($JSecureConfig->delete_log==4)?"selected":''; ?>>4 Months</option>
              <option value="5" <?php echo ($JSecureConfig->delete_log==5)?"selected":''; ?>>5 Months</option>
            </select>
          </td>
        </tr>
      </table>
      </fieldset>
    </div>
  </div>
  <input type="hidden" name="option" value="com_jsecure"/>
  <input type="hidden" name="task" value="" />
</form>

<script type="text/javascript">
ipLising(document.getElementById('iptype'));
</script>