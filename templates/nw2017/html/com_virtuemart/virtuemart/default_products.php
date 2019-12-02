<?php defined('_JEXEC') or die('Restricted access');
vmJsApi::jPrice();

// Separator
$verticalseparator = " vertical-separator";

foreach ($this->products as $type => $productList ) {
// Calculating Products Per Row
$products_per_row = VmConfig::get ( 'homepage_products_per_row', 3 ) ;
//$cellwidth = ' width'.floor ( 100 / $products_per_row );

		if ($products_per_row == 4) { $cellwidth = 'span3'; }
		elseif ($products_per_row == 3) { $cellwidth = 'span4'; }
		elseif ($products_per_row == 2) { $cellwidth = 'span6'; }
		elseif ($products_per_row == 1) { $cellwidth = 'span12'; }
		elseif ($products_per_row == 5) { $cellwidth = 'span2 ex-span2'; }
		elseif ($products_per_row == 6) { $cellwidth = 'span2 ex-span1_5'; }

// Category and Columns Counter
$col = 1;
$nb = 1;

$productTitle = vmText::_('COM_VIRTUEMART_'.$type.'_PRODUCT');

?>

<div class="<?php echo $type ?>-view">

	<h4><?php echo $productTitle ?></h4>

<?php // Start the Output

foreach ( $productList as $product ) {

	// Show the horizontal seperator
	if ($col == 1 && $nb > $products_per_row) { ?>
	<div class="horizontal-separator"></div>
	<?php }

	// this is an indicator wether a row needs to be opened or not
	if ($col == 1) { ?>
	<div class="row-fluid">
	<?php }

	// Show the vertical seperator
	if ($nb == $products_per_row or $nb % $products_per_row == 0) {
		$show_vertical_separator = ' ';
	} else {
		$show_vertical_separator = $verticalseparator;
	}

		// Show Products ?>
		<div class="product floatleft <?php echo $cellwidth . $show_vertical_separator ?>">
			<div class="spacer">
				<div class="spacer-handler">
					<div class="pr-img-handler">
					<?php // Product Image
					if ($product->images) {
						echo JHTML::_ ( 'link', JRoute::_ ( 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id ), $product->images[0]->displayMediaThumb( 'class="featuredProductImage" border="0"',false,'' ) ) ;
					}
					?>
					
					<div class="popout-price">
						<div class="popout-price-buttons-handler">
							<?php 
							if ($product->images) {
								echo '<div class="show-pop-up-image">'.$product->images[0]->displayMediaThumb( 'class="featuredProductImage"',true,'class="modal"' ).'</div>';
							}
							echo JHTML::link ( JRoute::_ ( 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id ), vmText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ), array ('title' => $product->product_name, 'class' => 'product-details' ) );				
							?>
						</div>
					</div>
					
					
					
					</div>
					<div class="action-handler">
						<h3 class="h-pr-title">
						<?php // Product Name
						echo JHTML::link ( JRoute::_ ( 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id ), $product->product_name, array ('title' => $product->product_name ) ); ?>
						</h3>


							<span class="product-price">
							<?php
							if (VmConfig::get ( 'show_prices' ) == '1') {
							//				if( $featProduct->product_unit && VmConfig::get('vm_price_show_packaging_pricelabel')) {
							//						echo "<strong>". vmText::_('COM_VIRTUEMART_CART_PRICE_PER_UNIT').' ('.$featProduct->product_unit."):</strong>";
							//					} else echo "<strong>". vmText::_('COM_VIRTUEMART_CART_PRICE'). ": </strong>";

							if ($this->showBasePrice) {
								echo $this->currency->createPriceDiv( 'basePrice', 'COM_VIRTUEMART_PRODUCT_BASEPRICE', $product->prices );
								echo $this->currency->createPriceDiv( 'basePriceVariant', 'COM_VIRTUEMART_PRODUCT_BASEPRICE_VARIANT', $product->prices );
							}
							echo $this->currency->createPriceDiv( 'variantModification', 'COM_VIRTUEMART_PRODUCT_VARIANT_MOD', $product->prices );
							if (round($product->prices['basePriceWithTax'],$this->currency->_priceConfig['salesPrice'][1]) != $product->prices['salesPrice']) {
								echo '<div class="price-crossed">' . $this->currency->createPriceDiv( 'basePriceWithTax', 'COM_VIRTUEMART_PRODUCT_BASEPRICE_WITHTAX', $product->prices ) . "</div>";
							}
							if (round($product->prices['salesPriceWithDiscount'],$this->currency->_priceConfig['salesPrice'][1]) != $product->prices['salesPrice']) {
								echo $this->currency->createPriceDiv( 'salesPriceWithDiscount', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_WITH_DISCOUNT', $product->prices );
							}
							echo $this->currency->createPriceDiv( 'salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices );
							if ($product->prices['discountedPriceWithoutTax'] != $product->prices['priceWithoutTax']) {
								echo $this->currency->createPriceDiv( 'discountedPriceWithoutTax', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_WITHOUT_TAX', $product->prices );
							} else {
								echo $this->currency->createPriceDiv( 'priceWithoutTax', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_WITHOUT_TAX', $product->prices );
							}
							echo $this->currency->createPriceDiv( 'discountAmount', 'COM_VIRTUEMART_PRODUCT_DISCOUNT_AMOUNT', $product->prices );
							echo $this->currency->createPriceDiv( 'taxAmount', 'COM_VIRTUEMART_PRODUCT_TAX_AMOUNT', $product->prices );
							} ?>

							</span>

							<div class="hand-product-details">
						

							<?php // Add to cart
							  if (!VmConfig::get('use_as_catalog', 0) and !empty($product->prices)) {?>
							<div class="addtocart-area"><form method="post" class="product js-recalculate" action="index.php">
							  
							<div class="addtocart-bar">

							 

								  <!-- Display the quantity box END -->
								 
								  <?php // Add the button
								  $button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
								  $button_cls = 'addtocart-button'; //$button_cls = 'addtocart_button';
								  $button_name = 'addtocart'; //$button_cls = 'addtocart_button';
								 
								 
								  // Display the add to cart button
								  $stockhandle = VmConfig::get('stockhandle','none');
								  if(($stockhandle=='disableit' or $stockhandle=='disableadd') and ($product->product_in_stock - $product->product_ordered)<1){
								  $button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
								  $button_cls = 'notify-button';
								  $button_name = 'notifycustomer';
								  }
								  vmdebug('$stockhandle '.$stockhandle.' and stock '.$product->product_in_stock.' ordered '.$product->product_ordered);
								  ?>
								  <span class="addtocart-button">
								  <?php if ($button_cls == "notify-button") { ?>
										 <span class="outofstock"><?php echo JText::_('COM_VIRTUEMART_CART_PRODUCT_OUT_OF_STOCK'); ?></span>
								 
										   <?php } else {?>
										   <input name="<?php echo $button_name ?>" class="<?php echo $button_cls ?>" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" type="submit" />
										<?php } ?>
								  </span>
									<span class="quantity-box">
										<input type="text" class="quantity-input js-recalculate" name="quantity[]" value="<?php if (isset($product->min_order_level) && (int)$product->min_order_level > 0) {
											echo $product->min_order_level;
										} else {
											echo '1';
										} ?>"/>
									</span>
									<span class="quantity-controls js-recalculate">
										<input type="button" class="quantity-controls quantity-plus"/>
										<input type="button" class="quantity-controls quantity-minus"/>
									</span>
								  <div class="clear"> </div>
							  </label></div>
							 
							  <?php // Display the add to cart button END ?>
							  <input class="pname" value="<?php echo $product->product_name ?>" type="hidden" />
							  <input name="option" value="com_virtuemart" type="hidden" />
							  <input name="view" value="cart" type="hidden" />
							 
							  <input name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>" type="hidden" />
							  <?php /** @todo Handle the manufacturer view */ ?>
							  <input name="virtuemart_manufacturer_id" value="<?php // echo $product->virtuemart_manufacturer_id ?>" type="hidden" />
							  <input name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" type="hidden" />
							  </form>
									</div>
							  <?php }  // Add To Cart Button END ?>


							
							
							</div>
						<div class="gr-cover"></div>
					</div>
				</div>

			</div>
		</div>
	<?php
	$nb ++;

	// Do we need to close the current row now?
	if ($col == $products_per_row) { ?>
	<div class="clear"></div>
	</div>
		<?php
		$col = 1;
	} else {
		$col ++;
	}
}
// Do we need a final closing row tag?
if ($col != 1) { ?>
	<div class="clear"></div>
	</div>
<?php
}
?>
</div>
<?php }
