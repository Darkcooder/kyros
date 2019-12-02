<?php // no direct access
defined('_JEXEC') or die('Restricted access');

//dump ($cart,'mod cart');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>

<!-- Virtuemart 2 Ajax Card -->
<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?>" id="vmCartModule">

	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#cartpanel").click(function() {
		  jQuery( "#cart-panel2").toggle( "fast" );
		});
	});
	</script>

<?php
if ($show_product_list) {
	?>
	<div class="show-cart"><a id="cartpanel" class="cart-button open-cart-panel-button" href="javascript:void(0);" title="<?php echo JText::_('COM_VIRTUEMART_CART_SHOW') ?>">
	<span class="products-number"><div class="total_products"><?php echo $data->totalProductTxt ?></div></span></a></div>

	<div class="panel2" id="cart-panel2">
		<div class="cartpanel">
			<div class="arrow"></div>
			<div class="show_cart show-cart-link">
				<?php if ($data->totalProduct) echo  $data->cart_show; ?>
			</div>
			<div style="clear:both;"></div>
			<div class="payments_signin_button" ></div>
					
			<div id="hiddencontainer" class="hiddencontainer" style=" display: none; ">
				<div class="vmcontainer">
					<div class="product_row">
						<span class="quantity"></span>&nbsp;x&nbsp;<span class="product_name"></span>

					<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
						<div class="subtotal_with_tax" style="float: right;"></div>
					<?php } ?>
					<div class="customProductData"></div>
					</div>
				</div>
			</div>
			<div class="vm_cart_products">
				<div class="vmcontainer">

				<?php
					foreach ($data->products as $product){
						?><div class="product_row">
							<span class="quantity"><?php echo  $product['quantity'] ?></span>&nbsp;x&nbsp;<span class="product_name"><?php echo  $product['product_name'] ?></span>
						<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
						  <div class="subtotal_with_tax" style="float: right;"><?php echo $product['subtotal_with_tax'] ?></div>
						<?php } ?>
						<?php if ( !empty($product['customProductData']) ) { ?>
							<div class="customProductData"><?php echo $product['customProductData'] ?></div>

						<?php } ?>

					</div>
				<?php }
				?>
				

				
				</div>
			</div>
			<div class="total">
				<div class="total_products"><?php echo  $data->totalProductTxt ?></div>	
				<?php if ($data->totalProduct and $show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
				<?php echo $data->billTotal; ?>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>

<noscript>
<?php echo vmText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
</noscript>
</div>




