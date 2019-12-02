<?php
// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>
<div class="product-fields">
	    <?php
	    $custom_title = null;
	    foreach ($this->product->customfieldsSorted[$this->position] as $field) {
	    	if ( $field->is_hidden ) //OSP http://forum.virtuemart.net/index.php?topic=99320.0
			continue;
			$field->row = $this->row;
			if ($field->display) {
	    ?><div class="product-field product-field-type-<?php echo $field->field_type ?> row-fluid">
		    <?php if ($field->custom_title != $custom_title && $field->show_title) { ?>
			<div class="span6">
			    <span class="product-fields-title" ><?php echo vmText::_($field->custom_title); ?></span>
			    <?php
			    if ($field->custom_tip)
				echo JHTML::tooltip($field->custom_tip, vmText::_($field->custom_title), 'tooltip.png');
			?>
			</div><?php
			}
			?>
			<div class="span6">
	    	    <span class="product-field-display"><?php echo $field->display ?></span>
			</div>
	    	    <span class="product-field-desc"><?php echo vmText::_($field->custom_field_desc) ?></span>
	    	</div>
		    <?php
		    $custom_title = $field->custom_title;
			}
	    }
	    ?>
</div>
