<?php // no direct access
defined ('_JEXEC') or die('Restricted access');
vmJsApi::jPrice();
$col = 1;

if ($products_per_row == 4) { $pwidth = 'span3'; }
elseif ($products_per_row == 3) { $pwidth = 'span4'; }
elseif ($products_per_row == 2) { $pwidth = 'span6'; }
elseif ($products_per_row == 1) { $pwidth = 'span12'; }
elseif ($products_per_row == 5) { $pwidth = 'span2 sp20'; }
elseif ($products_per_row == 6) { $pwidth = 'span2'; }

if ($products_per_row > 1) {
	$float = "floatleft";
} else {
	$float = "center";
}

$GLOBALS['moddd'] = $module->id;

?>
<?php JHTML::_('behavior.modal'); ?>
<div class="vmgroup<?php echo $params->get ('moduleclass_sfx') ?>">

	<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
	<?php
}
	if ($display_style == "div") {
		?>
		<div class="vmproduct product-details row-fluid">
			<?php foreach ($products as $product) { ?>
			<div class="<?php echo $pwidth ?> <?php echo $float ?>">
				<div class="spacer">
				<div class="pr-img-handler">
				<?php
				if (!empty($product->images[0])) {
					$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE);
				} else {
					$image = '';
				}
				echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
				?>

				<?php $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id); ?>
					<div class="popout-price">
						<div class="popout-price-buttons-handler">
							<?php 
							if ($product->images) {
								echo '<div class="show-pop-up-image">'.$product->images[0]->displayMediaThumb( 'class="featuredProductImage"',true,'class="modal"' ).'</div>';
							}
							?><a href="<?php echo $url ?>" class="product-details"><?php echo vmText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ); ?></a>
							<?php if (!empty($product->customfieldsSorted['addtocart'])) { ?>
							<a href="JavaScript:;" class="show-advanced-fields" onclick="toggle_visibility('product<?php echo $GLOBALS['moddd'].$product->virtuemart_product_id; ?>');">advanced</a>
							<?php } ?>
						</div>
					</div>

					
				</div>
					<div class="action-handler">

							<h3 class="h-pr-title">
								<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a>
							</h3>
							<span class="product-price">
							<?php 
								// $product->prices is not set when show_prices in config is unchecked
								if ($show_price and  isset($product->prices)) {
									echo '<div class="product-price">'.$currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
									if ($product->prices['salesPriceWithDiscount'] > 0) {
										echo $currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
									}
									echo '</div>';
								}?>
							</span>
							<div class="productdetails">
							<?php							
								if ($show_addtocart) {
									echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));
								}
							?>
							</div>
						<div class="clear"></div>
						<div class="gr-cover"></div>
					</div>
						
				</div>
			</div>
			<?php
			if ($col == $products_per_row && $products_per_row && $col < $totalProd) {
				echo "</div><div class=\"vmproduct product-details row-fluid\">";
				$col = 1;
			} else {
				$col++;
			}
		} ?>
		</div>
		<br style='clear:both;'/>

		<?php
	} else {
		$last = count ($products) - 1;
		?>

		<ul class="vmproduct product-details row-fluid">
			<?php foreach ($products as $product) : ?>
			<li class="<?php echo $pwidth ?> <?php echo $float ?>">
				<div class="spacer">
				<div class="pr-img-handler">
				<?php
				if (!empty($product->images[0])) {
					$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE);
				} else {
					$image = '';
				}
				echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
				?>

				<?php $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id); ?>
					<div class="popout-price">
						<div class="popout-price-buttons-handler">
							<?php 
							if ($product->images) {
								echo '<div class="show-pop-up-image">'.$product->images[0]->displayMediaThumb( 'class="featuredProductImage"',true,'class="modal"' ).'</div>';
							}
							?><a href="<?php echo $url ?>" class="product-details"><?php echo vmText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ); ?></a>
							<?php if (!empty($product->customfieldsSorted['addtocart'])) { ?>
							<a href="JavaScript:;" class="show-advanced-fields" onclick="toggle_visibility('product<?php echo $GLOBALS['moddd'].$product->virtuemart_product_id; ?>');">advanced</a>
							<?php } ?>
						</div>
					</div>

					
				</div>
					<div class="action-handler">

							<h3 class="h-pr-title">
								<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a>
							</h3>
							<span class="product-price">
							<?php 
								// $product->prices is not set when show_prices in config is unchecked
								if ($show_price and  isset($product->prices)) {
									echo '<div class="product-price">'.$currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
									if ($product->prices['salesPriceWithDiscount'] > 0) {
										echo $currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
									}
									echo '</div>';
								}?>
							</span>
							<div class="productdetails">
							<?php							
								if ($show_addtocart) {
									echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));
								}
							?>
							</div>
						<div class="clear"></div>
						<div class="gr-cover"></div>
					</div>
						
				</div>
			</li>
			<?php
			if ($col == $products_per_row && $products_per_row && $last) {
				echo '
		</ul><div class="clear"></div>
		<ul  class="vmproduct product-details row-fluid">';
				$col = 1;
			} else {
				$col++;
			}
			$last--;
		endforeach; ?>
		</ul>
		<div class="clear"></div>

		<?php
	}
	if ($footerText) : ?>
		<div class="vmfooter<?php echo $params->get ('moduleclass_sfx') ?>">
			<?php echo $footerText ?>
		</div>
		<?php endif; ?>
</div>