<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.

if($item->note == "NEW") {
	$note_class = ' class="new"';
} elseif($item->note == "HOT") {
	$note_class = ' class="hot"';
} elseif($item->note == "FEATURED") {
	$note_class = ' class="featured"';
}

$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
$note = $item->note ? '<br /><small'.$note_class.'>'.$item->note.'</small>' : ''; 
if ($item->menu_image) {
		$item->params->get('menu_text', 1 ) ?
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
}
else { $linktype = $item->title;
}

?><span class="separator"><?php echo $title; ?><?php echo $linktype; ?><?php echo $note; ?></span>
