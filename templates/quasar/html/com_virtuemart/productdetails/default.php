<?php
defined('_JEXEC') or die('Restricted access');

/* Let's see if we found the product */
if (empty($this->product)) {
	echo vmText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
	echo '<br /><br />  ' . $this->continue_link_html;
	return;
}

echo shopFunctionsF::renderVmSubLayout('askrecomjs',array('product'=>$this->product));


if(vRequest::getInt('print',false)){
?>
<body onload="javascript:print();">
<?php }

// addon for joomla modal Box
JHtml::_('behavior.modal');

// This is the rows for the customfields, as long you have only one product, just increase it by one,
// if you have more than one product, reset it for every product
$this->row = 0;
?>

<div class="productdetails-view productdetails">
<div><?php echo $this->edit_link; ?></div>


	<div class="row-fluid">


		<div class="span6">
			<?php echo $this->loadTemplate('images'); ?>
		</div>

		<div id="b-area" class="span6">
			<div class="spacer-buy-area">

				<?php
				// PDF - Print - Email Icon
				if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_button_enable')) {
				?>
				<div class="icons hidden-phone">
					<?php
					//$link = (JVM_VERSION===1) ? 'index2.php' : 'index.php';
					$link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
					$MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';

					if (VmConfig::get('pdf_icon', 1) == '1') {
					echo "<span class=\"vm-pdf-button\">".$this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_button_enable', false)."</span>";
					}
					echo "<span class=\"vm-print-button\">".$this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon')."</span>";
					echo "<span class=\"vm-email-button\">".$this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend')."</span>";
					?>
					<div class="clear"></div>
				</div>
				<?php } // PDF - Print - Email Icon END
				?>

				<?php // Product Title   ?>
				<h1><?php echo $this->product->product_name ?> </h1>
				<?php // Product Title END   ?>
				<?php // afterDisplayTitle Event
				echo $this->product->event->afterDisplayTitle ?>

				<?php

				if (!empty($this->product->customfieldsSorted['ontop'])) {
					$this->position = 'ontop';
					echo $this->loadTemplate('customfields');
				} // Product Custom ontop end
				?>

			<?php

			echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$this->showRating,'product'=>$this->product));
			
			?>
			
			



			<?php
			// TODO in Multi-Vendor not needed at the moment and just would lead to confusion
			/* $link = JRoute::_('index2.php?option=com_virtuemart&view=virtuemart&task=vendorinfo&virtuemart_vendor_id='.$this->product->virtuemart_vendor_id);
			$text = vmText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL');
			echo '<span class="bold">'. vmText::_('COM_VIRTUEMART_PRODUCT_DETAILS_VENDOR_LBL'). '</span>'; ?><a class="modal" href="<?php echo $link ?>"><?php echo $text ?></a><br />
			*/

			// Product Short Description
			if (!empty($this->product->product_s_desc)) {
			?>
				<div class="product-short-description"><span class="module-arrow"></span>
					<?php
					/** @todo Test if content plugins modify the product description */
					echo nl2br($this->product->product_s_desc);
					?>
				</div>
			<?php
			} // Product Short Description END
			?>

			<?php
			// Manufacturer of the Product
			if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
				echo $this->loadTemplate('manufacturer');
			}
			?>

			<?php

			if (is_array($this->productDisplayShipments)) {
				foreach ($this->productDisplayShipments as $productDisplayShipment) {
					echo $productDisplayShipment . '<br />';
				}
			}
			if (is_array($this->productDisplayPayments)) {
				foreach ($this->productDisplayPayments as $productDisplayPayment) {
					echo $productDisplayPayment . '<br />';
			}
			}
			// Product Price
			// the test is done in show_prices
			//if ($this->show_prices and (empty($this->product->images[0]) or $this->product->images[0]->file_is_downloadable == 0)) {
			echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$this->product,'currency'=>$this->currency));
			//}
			?>

			<?php
			echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$this->product));
			?>

			<?php
			// Ask a question about this product
			if (VmConfig::get('ask_question', 0) == 1) {
				$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component', FALSE);
				?>
				<div class="ask-a-question" style="clear:both;">
					<a class="ask-a-question" href="<?php echo $askquestion_url ?>" rel="nofollow" ><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
				</div>
			<?php
			}
			?>


			<?php
			// Availability
			$stockhandle = VmConfig::get('stockhandle', 'none');
			$product_available_date = substr($this->product->product_available_date,0,10);
			$current_date = date("Y-m-d");
			if (($this->product->product_in_stock - $this->product->product_ordered) < 1) {
			if ($product_available_date != '0000-00-00' and $current_date < $product_available_date) {
			?>	<div class="availability">
			<?php echo vmText::_('COM_VIRTUEMART_PRODUCT_AVAILABLE_DATE') .': '. JHtml::_('date', $this->product->product_available_date, vmText::_('DATE_FORMAT_LC4')); ?>
			</div>
			<?php
			} else if ($stockhandle == 'risetime' and VmConfig::get('rised_availability') and empty($this->product->product_availability)) {
			?>	<div class="availability">
			<?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability'))) ? JHtml::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability', '7d.gif'), VmConfig::get('rised_availability', '7d.gif'), array('class' => 'availability')) : vmText::_(VmConfig::get('rised_availability')); ?>
			</div>
			<?php
			} else if (!empty($this->product->product_availability)) {
			?>
			<div class="availability">
			<?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability)) ? JHtml::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability, $this->product->product_availability, array('class' => 'availability')) : vmText::_($this->product->product_availability); ?>
			</div>
			<?php
			}
			}
			else if ($product_available_date != '0000-00-00' and $current_date < $product_available_date) {
			?>	<div class="availability">
			<?php echo vmText::_('COM_VIRTUEMART_PRODUCT_AVAILABLE_DATE') .': '. JHtml::_('date', $this->product->product_available_date, vmText::_('DATE_FORMAT_LC4')); ?>
			</div>
			<?php
			}
			?>

			</div>
		</div>
		<div class="clear"></div>
	</div>

	<?php // event onContentBeforeDisplay
	echo $this->product->event->beforeDisplayContent; ?>

	<?php
	// Product Description
	if (!empty($this->product->product_desc)) {
	    ?>
        <div class="product-description">
	<?php /** @todo Test if content plugins modify the product description */ ?>
    	<span class="title"><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?></span>
	<?php echo $this->product->product_desc; ?>
        </div>
	<?php
    } // Product Description END
	
	
	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'normal'));

    // Product Packaging
    $product_packaging = '';
    if ($this->product->product_box) {
	?>
        <div class="product-box">
	    <?php
	        echo vmText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') .$this->product->product_box;
	    ?>
        </div>
    <?php } // Product Packaging END
    ?>

	
    <?php 
	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'onbot'));

    echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'related_products','class'=> 'product-related-products','customTitle' => true ));

	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'related_categories','class'=> 'product-related-categories'));
	
	echo $this->product->event->afterDisplayContent;

	echo $this->loadTemplate('reviews');

	?>
	
	
<?php
    // Product Navigation
    if (VmConfig::get('product_navigation', 1)) {
	?>
        <div class="product-neighbours">
					

	    <?php
	    if (!empty($this->product->neighbours ['next'][0])) {
		$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
		echo JHTML::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'], array('class' => 'next-page'));
	    }
		 if (!empty($this->product->neighbours ['previous'][0])) {
		$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
		echo JHTML::_('link', $prev_link, $this->product->neighbours ['previous'][0]
			['product_name'], array('class' => 'previous-page'));
	    }
	    ?>
    	<div class="clear"></div>
		</div>
		<?php // Back To Category Button
						if ($this->product->virtuemart_category_id) {
							$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id);
							$categoryName = $this->product->category_name ;
						} else {
							$catURL =  JRoute::_('index.php?option=com_virtuemart');
							$categoryName = vmText::_('COM_VIRTUEMART_SHOP_HOME') ;
						}
					?>
					<div class="back-to-category">
						<a href="<?php echo $catURL ?>" class="" title="<?php echo $categoryName ?>"><?php echo JText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
					</div>
        
    <?php } // Product Navigation END ?>
	

	<?php // onContentAfterDisplay event



// Show child categories
if (VmConfig::get('showCategory', 1)) {
	echo $this->loadTemplate('showcategory');
}

$j = 'jQuery(document).ready(function($) {
	Virtuemart.product(jQuery("form.product"));

	$("form.js-recalculate").each(function(){
		if ($(this).find(".product-fields").length && !$(this).find(".no-vm-bind").length) {
			var id= $(this).find(\'input[name="virtuemart_product_id[]"]\').val();
			Virtuemart.setproducttype($(this),id);

		}
	});
});';
//vmJsApi::addJScript('recalcReady',$j);

/** GALT
	 * Notice for Template Developers!
	 * Templates must set a Virtuemart.container variable as it takes part in
	 * dynamic content update.
	 * This variable points to a topmost element that holds other content.
	 */
$j = "Virtuemart.container = jQuery('.productdetails-view');
Virtuemart.containerSelector = '.productdetails-view';";

vmJsApi::addJScript('ajaxContent',$j);

echo vmJsApi::writeJS();
?> </div>

