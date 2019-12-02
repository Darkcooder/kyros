<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JFactory::getApplication()->enqueueMessage('Чтобы продолжить работу, нужно авторизироваться на сайте. Для этого нажмите
на иконку с ключом в правом верхнем углу');
?>

