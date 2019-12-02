<?php // no direct access
defined ('_JEXEC') or die('Restricted access');
vmJsApi::jPrice();
$col = 1;

if ($products_per_row > 1) {
	$float = "floatleft";
} else {
	$float = "center";
}
?>

<?php 
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$temps = $doc->baseurl.'/templates/'.$doc->template;

$templateparams = $app->getTemplate(true)->params;

if($params->get('moduleclass_sfx') == "_products single") {
	$slitems = "1";
	$slitemsDesktop = "1";
	$slitemsDesktopSmall = "1";
	$slitemsTablet = "1";
	$slitemsTabletSmall = "1";
	$slitemsMobile = "1";
	$slpag = "false";
} else {
	/*
	$slitems = $templateparams->get('sl_items');
	$slitemsDesktop = $templateparams->get('sl_itemsDesktop');
	$slitemsDesktopSmall = $templateparams->get('sl_itemsDesktopSmall');
	$slitemsTablet = $templateparams->get('sl_itemsTablet');
	$slitemsTabletSmall = $templateparams->get('sl_itemsTabletSmall');
	$slitemsMobile = $templateparams->get('sl_itemsMobile');
	*/
	$slitems = $products_per_row;
	$slitemsDesktop = $products_per_row;
	$slitemsDesktopSmall = $products_per_row - 1;
	$slitemsTablet = $products_per_row - 2;
	$slitemsTabletSmall = $products_per_row - 3;
	$slitemsMobile = $products_per_row - 4;
	
	if($slitemsDesktopSmall < 1) : $slitemsDesktopSmall = 1; endif;
	if($slitemsTablet < 1) : $slitemsTablet = 1; endif;
	if($slitemsTabletSmall < 1) : $slitemsTabletSmall = 1; endif;
	if($slitemsMobile < 1) : $slitemsMobile = 1; endif;
	
	if ($templateparams->get('sl_pagination')) : $slpag = "true"; else : $slpag = "false"; endif;
}

if ($templateparams->get('sl_stopOnHover')) : $slstopOnHover = "true"; else : $slstopOnHover = "false"; endif;
if ($templateparams->get('sl_navigation')) : $slnavigation = "true"; else : $slnavigation = "false"; endif;
if ($templateparams->get('sl_scrollPerPage')) : $slscrollPerPage = "true"; else : $slscrollPerPage = "false"; endif;
if ($templateparams->get('sl_paginationNumbers')) : $slpaginationNumbers = "true"; else : $slpaginationNumbers = "false"; endif;
if ($templateparams->get('sl_responsive')) : $slresponsive = "true"; else : $slresponsive = "false"; endif;
if ($templateparams->get('sl_dragBeforeAnimFinish')) : $sldragBeforeAnimFinish = "true"; else : $sldragBeforeAnimFinish = "false"; endif;
if ($templateparams->get('sl_mouseDrag')) : $slmouseDrag = "true"; else : $slmouseDrag = "false"; endif;
if ($templateparams->get('sl_touchDrag')) : $sltouchDrag = "true"; else : $sltouchDrag = "false"; endif;

$doc->addScript($temps.'/js/owl.carousel.min.js'); 
$doc->addCustomTag('
	<script type="text/javascript">
	jQuery(document).ready(function() {
	  var owl = jQuery("#owl-id-'.$module->id.'");
	  owl.owlCarousel({
		pagination: '.$slpag.',
		items: '.$slitems.',
		itemsDesktop : [1600, '.$slitemsDesktop.'],
		itemsDesktopSmall : [1440, '.$slitemsDesktopSmall.'],
		itemsTablet : [980, '.$slitemsTablet.'],
		itemsTabletSmall : [768, '.$slitemsTabletSmall.'],
		itemsMobile : [480, '.$slitemsMobile.'],
		
		slideSpeed: '.$templateparams->get('sl_slideSpeed').',
		paginationSpeed: '.$templateparams->get('sl_paginationSpeed').',
		rewindSpeed: '.$templateparams->get('sl_rewindSpeed').',
		
		autoPlay: '.$templateparams->get('sl_autoPlay').',
		stopOnHover: '.$slstopOnHover.',
		navigation: '.$slnavigation.',
		scrollPerPage: '.$slscrollPerPage.',
		paginationNumbers: '.$slpaginationNumbers.',
		responsive: '.$slresponsive.',
		responsiveRefreshRate: '.$templateparams->get('sl_responsiveRefreshRate').',
		dragBeforeAnimFinish: '.$sldragBeforeAnimFinish.',
		mouseDrag: '.$slmouseDrag.',
		touchDrag: '.$sltouchDrag.'
		
	  });
	});
	</script>
');		

$GLOBALS['moddd'] = $module->id;

?>


<?php JHTML::_('behavior.modal'); ?>
<div class="vmgroup<?php echo $params->get('moduleclass_sfx') ?> product-sl-handler">

	<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
	<?php
}
	if ($display_style == "div") {
		?>
		<div class="sl-products vmproduct product-details owl-carousel owl-theme" id="owl-id-<?php echo($module->id); ?>">
			<?php 
			$a = 0;
			foreach ($products as $product) : ?>
			<div class="<?php echo "sl-item-".$a++%$products_per_row; ?>">
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

					<div class="popout-price">
					
					</div>
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
		endforeach; ?>
		</div>
		<div class="clear"></div>

		<?php
	} else {
		$last = count ($products) - 1;
		?>
	
		<ul class="sl-products vmproduct product-details owl-carousel owl-theme" id="owl-id-<?php echo($module->id); ?>">
			<?php 
			$a = 0;
			foreach ($products as $product) : ?>
			<li class="<?php echo "sl-item-".$a++%$products_per_row; ?>">
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