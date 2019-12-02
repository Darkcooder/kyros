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
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<h3><?php echo JText::_('HELP');?></h3>
<table>
	<tr>
		<td>
			<p><b>Drawback:</b></p>
			<p>Joomla has one drawback, any web user can easily know the site is created in Joomla! by typing the URL to access the administration area <b>(i.e. www.site name.com/administration).</b> This makes hackers hack the site easily once they crack id and password for Joomla!. </p>
		</td>
	</tr>
</table>

<table class="table-striped-jsecure" width="100%">
	<tr>
		<td>
			<p><b>Instructions</b></p>
			<p>jSecure Authentication module prevents access to administration (back end) login page without appropriate access key.</p>
		</td>
	</tr>
</table>
<br/>
<table style="border:1px solid #0088CC;">
	<tr>
		<td style="background-color:#F5FAFD; line-height:18px; padding:8px;">
			<p><b>Important!</b></p>
			<p style="color:#0088CC;">In order for jSecure to work the jSecure <b>plugin</b> must be enabled. Go to Extensions>Plugin Manager and look for the "<b>System - jSecure Authentication plugin</b>". Make sure this plug in is enabled.</p>
		</td>
	</tr>
</table>

<div>
<p>&nbsp;</p>
</div>

<div>
	<ul class="nav nav-tabs">
	<li class="active"><a href="#basic_config_tab" data-toggle="tab"><?php echo JText::_('Basic Configuration');?></a></li>
	<li><a href="#advance_config_tab" data-toggle="tab"><?php echo JText::_('Advanced Configuration');?></a></li>
	<li><a href="#view_log_tab" data-toggle="tab"><?php echo JText::_('View Log');?></a></li>
	<li><a href="#change_log_tab" data-toggle="tab"><?php echo JText::_('Change Log');?></a></li>
	<li><a href="#license_tab" data-toggle="tab"><?php echo JText::_('License');?></a></li>
	</ul>

	<div class="tab-content">
	<div class="tab-pane active" id="basic_config_tab">
		<table class="table-striped-jsecure" width="100%">
		<tr>
		<td>
			<p>The basic configuration will hide your administrator URL from public access. This is all most people need.</p>
		</td>
		</tr>
		</table>
		<table>
		<tr>
			<td style="line-height:18px; padding:8px;">
			1) Set <b>"enable"</b> to <b>"yes"</b>.<br/><br/>
			2) Set the <b>"Pass Key"</b> to <b>"URL"</b> This will hide the administrator URL.<br/><br/>
			3) In the <b>"Key"</b> field enter the key that will be part of your new administrator URL. For example, if you enter <b>"test"</b> into the key field, then the administrator URL will be <a href="#">http://www.yourwebsite/administrator/?test</a>. Please note that you cannot have a key that is only numbers.<br/>
			   <br/>If you do not enter a key, but enable the jSecure component, then the URL to access the administrator area is /?jSecure <a href="#">(http://www.yourwebsite/administrator/?jSecure)</a>.<br/><br/>
			4) Set the <b>"Redirect Options"</b> field. By default, if someone tries to access you /administrator URL without the correct key, they will be redirected to the home page of your Joomla site. You can also set up a <b>"Custom Path"</b> is you would like the user to be redirected somewhere else, such as a <b>404 error</b> page.</li>
			</td>
		</tr>
		</table>
	</div>

	<div class="tab-pane" id="advance_config_tab">
		<table class="table-striped-jsecure" width="100%">
		<tr>
		<td>
			<p>The Advanced Configuration tab has additional features that you can activate.</p>
		</td>
		</tr>
		</table>
		<table>
		<tr>
			<td style="line-height:18px; padding:8px;">
			<p><b>Mail tab:</b> This sets whether you want an email to be sent every time there is a failed login attempt into the Joomla administration area. You can set it to send the jSecure key or the incorrect key that was entered</p>
			<p><b>IP tab:</b> This tab allows you to control which IPs have access to your administrator URL.</p>
			<p><b>White Listed IPs:</b> If set to <b>"White Listed IPs"</b> you can make a white list for certain IPs. Only those specific IPS will be allowed to access your administrator URL.</p>
			<p><b>Blocked IPs:</b> If set to <b>"Blocked IPs"</b> you can block certain IPs form accessing your administrator URL.</p>
			<p><b>Master Password:</b> You can block access to the jSecure component from other administrators. Setting to <b>"Yes"</b>, allows you to create a password that will be required when any administrator tries to access the jSecure configuration settings in the Joomla administration area. If you do not enter a master password, the default password will be "jSecure".</p>
			<p><b>Master Mail:</b> These setting allow you to have an email sent every time the jSecure configuration is changed.</p>
			<p><b>Log:</b> This setting allows you to decide how long the jSecure logs should remain in the database. The longer this is set for, the more database space will be used.</p>
			</td>
		</tr>
		</table>
	</div>
	
	<div class="tab-pane" id="view_log_tab">
		<table class="table-striped-jsecure" width="100%">
		<tr>
		<td>
			<p>jSecure will record any attempt that is made to access the Joomla /administrator directory. It will record the users IP, user name (if the login is successful), the nature of their login attempt, and the date the login attempt occurred.</p>
		</td>
		</tr>
		</table>
		<table>
		<tr>
			<td style="line-height:18px; padding:8px;">
			<p>For More information visit <a href="http://joomlaserviceprovider.com" title="visit the site" target="_blank">http://joomlaserviceprovider.com</a></p>
			<p><b>Thanks to</b> the team (Ajay Lulia, Bhavin Shah, Anurag Soni) for developing the Component and Plugin.</p>
			<p><b>Thanks to</b> Aaron Handford, Ajay Lulia for help with the component conceptualization.</p>
			<p><b>Thanks to</b> Sam Moffatt for converting Joomla! 1.0 module to a Joomla! 1.5 system plugin.</p>
			</td>
		</tr>
		</table>
	</div>
	
	<div class="tab-pane" id="change_log_tab">
		<table>
		<tr>
			<td style="line-height:18px; padding:8px;">
			<p><b>2.1.10(3-Feb-2012):</b><br/>
			1) Fixed JSecureConfig::$iplistB and JSecureConfig::$iplistW bug for Joomla 1.5.X, Joomla 1.6.X & Joomla 1.7.0.<br/>
			2) Fixed issues with mail headers for Joomla 2.5 .<br/>
			3) Added text input feild instead of text area in the form option of Basic Parameters for Joomla 1.5.X, Joomla 1.6.X & Joomla 1.7.0.
			</p>
			
			<p>
			<b>2.1.9(18-August-2011):</b><br/>
			1) Separate boxes added for blacklist and whitelist IP Addresses for Joomla 1.5.X, Joomla 1.6.X & Joomla 1.7.0.<br/>
			2) Multiple IP Addresses problem resolved for Joomla 1.5.X, Joomla 1.6.X & Joomla 1.7.0.<br/>
			3) Fixed Master Password & Verify Master field bug for Joomla 1.5.X, Joomla 1.6.X & Joomla 1.7.0.<br/>
			4) Language files updated for description of Verify Master Password field.<br/>
			5) Updated validations for Master Password & Verify Master Password fields.<br/>
			6) Fixed issues with tabs for Joomla 1.7.0 on IE7.
			</p>
			
			<p>
			<b>2.1.9(21-Mar-11):</b><br/>
			Fixed language related issues.
			</p>
			
			<p>
			<b>2.1.8(14-Jan-11):</b><br/>
			Fixed the code for redirection.
			</p>
			
			<p>
			<b>2.1.7(04-Aug-10):</b><br/>
			Fixed save functionality issue on IE8
			</p>
			
			<p>
			<b>2.1.6(28-July-10):</b><br/>
			Fixed notices issue.
			</p>
			
			<p>
			<b>2.1.5(20-July-10):</b><br/>
			1) Added condition to check the configuration file is writable or not.<br/>
			2) Added redirection on login page after correct key entered.
			</p>
			
			<p>
			<b>2.1.4(03-July-10):</b><br/>
			Fixed Email Validation issue.
			</p>
			
			<p>
			<b>2.1.3(02-July-10):</b><br/>
			1) Added log feature.<br/>
			2) Fixed white listed ip issue.<br/>
			3) Changed the component parameters to convert in Basic and Advanced configuration.<br/>
			4) Changed the layout of backend.<br/>
			5) Created jSecure component and plugin for Joomla 1.6.
			</p>
			
			<p>
			<b>2.1.2(02-June-10):</b><br/>
			Fixed small error.
			</p>
			
			<p>
			<b>2.1.1(31-May-10):</b><br/>
			1) Added Master Password to access the jSecure Authentication.<br/>
			2) Added E-mail option to send the change log in jSecure Authentication.<br/>
			3) User can choose from White Listed IPs / Blocked IPs.<br/>
			4) User Friendly option to add ip address.<br/>
			5) Enter specific IPs(White Listed IPs) that will allow access to administration area.<br/>
			</p>
			
			<p>
			<b>2.1.0(19-Apr-10):</b><br/>
			Fixed security bug.
			</p>
			
			<p>
			<b>2.0.1(14-Apr-10):</b><br/>
			1) Optimized the code.<br/>
			2) Fixed the IP issue in mail.<br/>
			3) Added Licenses information in files.
			</p>
			
			<p>
			<b>2.0(01-Apr-10):</b><br/>
			Added new features
			</p>
			
			<p>
			<b>1.0.9(10-Jun-09):</b><br/>
			Fixed warning message.
			</p>
			
			<p>
			<b>1.0.8(02-Jun-09):</b><br/>
			Fixed the case sensitivity check.
			</p>
			
			<p>
			<b>1.0.7(21-Mar-09):</b><br/>
			Fixed the code for redirection.
			</p>
			
			<p>
			<b>1.0.6(23-Dec-08):</b><br/>
			Fixed security bug. Updated the readme file.
			</p>
			
			<p>
			<b>1.0.5(16-Oct-08):</b><br/>
			Fixed redirection issue.
			</p>
			
			<p>
			<b>1.0.4(26-Sep-08):</b><br/>
			Fix for J1.5 to use proper custom tag and fixed a php error.
			</p>
			
			<p>
			<b>1.0.3(15-Sep-08):</b><br/>
			Fix for J1.5 call to admin login page using index2.php, please update your copy of jSecure Authentication.
			</p>
			
			<p>
			<b>1.0.2(30-Aug-08):</b><br/>
			Fix for J1.5 params (Thanks to Christer)
			</p>
			
			<p>
			<b>1.0: Initial Version 1.0.1:</b><br/>
			Fix for J1.5 Native
			</p>
			</td>
		</tr>
		</table>
	</div>
	
	<div class="tab-pane" id="license_tab">
		<table class="table-striped-jsecure" width="100%">
		<tr>
		<td>
			<p>This is free software and you may redistribute it under the GPL. jSecure comes with absolutely no warranty. Use at your own risk. For details, see the license at <a href="http://www.gnu.org/licenses/gpl.txt" target="_blank">http://www.gnu.org/licenses/gpl.txt</a> Other licenses can be found in LICENSES folder. </p>
		</td>
		</tr>
		</table>
	</div>
	
	</div>
</div>