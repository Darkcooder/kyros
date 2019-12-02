<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$col= 1 ;

?>

<?php 
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$temps = $doc->baseurl.'/templates/'.$doc->template;

$templateparams = $app->getTemplate(true)->params;

if ($templateparams->get('man_pagination')) : $manpag = "true"; else : $manpag = "false"; endif;
if ($templateparams->get('man_stopOnHover')) : $manstopOnHover = "true"; else : $manstopOnHover = "false"; endif;
if ($templateparams->get('man_navigation')) : $mannavigation = "true"; else : $mannavigation = "false"; endif;
if ($templateparams->get('man_scrollPerPage')) : $manscrollPerPage = "true"; else : $manscrollPerPage = "false"; endif;
if ($templateparams->get('man_paginationNumbers')) : $manpaginationNumbers = "true"; else : $manpaginationNumbers = "false"; endif;
if ($templateparams->get('man_responsive')) : $manresponsive = "true"; else : $manresponsive = "false"; endif;
if ($templateparams->get('man_dragBeforeAnimFinish')) : $mandragBeforeAnimFinish = "true"; else : $mandragBeforeAnimFinish = "false"; endif;
if ($templateparams->get('man_mouseDrag')) : $manmouseDrag = "true"; else : $manmouseDrag = "false"; endif;
if ($templateparams->get('man_touchDrag')) : $mantouchDrag = "true"; else : $mantouchDrag = "false"; endif;

$doc->addScript($temps.'/js/owl.carousel.min.js'); 
$doc->addCustomTag('
	<script type="text/javascript">
	jQuery(document).ready(function() {
	  var owl = jQuery("#owl-id-'.$module->id.'");
	  owl.owlCarousel({
		pagination: '.$manpag.',
		items: '.$templateparams->get('man_items').',
		itemsDesktop : [1600, '.$templateparams->get('man_itemsDesktop').'],
		itemsDesktopSmall : [1260, '.$templateparams->get('man_itemsDesktopSmall').'],
		itemsTablet : [1000, '.$templateparams->get('man_itemsTablet').'],
		itemsTabletSmall : [768, '.$templateparams->get('man_itemsTabletSmall').'],
		itemsMobile : [480, '.$templateparams->get('man_itemsMobile').'],
		
		slideSpeed: '.$templateparams->get('man_slideSpeed').',
		paginationSpeed: '.$templateparams->get('man_paginationSpeed').',
		rewindSpeed: '.$templateparams->get('man_rewindSpeed').',
		
		autoPlay: '.$templateparams->get('man_autoPlay').',
		stopOnHover: '.$manstopOnHover.',
		navigation: '.$mannavigation.',
		scrollPerPage: '.$manscrollPerPage.',
		paginationNumbers: '.$manpaginationNumbers.',
		responsive: '.$manresponsive.',
		responsiveRefreshRate: '.$templateparams->get('man_responsiveRefreshRate').',
		dragBeforeAnimFinish: '.$mandragBeforeAnimFinish.',
		mouseDrag: '.$manmouseDrag.',
		touchDrag: '.$mantouchDrag.'
		
	  });
	});
	</script>
');		

?>

<div class="vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">

<?php if ($headerText) : ?>
	<div class="vmheader"><?php echo $headerText ?></div>
<?php endif;
if ($display_style =="div") { ?>
	<div class="row-fluid vmmanufacturer" class="owl-carousel owl-theme" id="owl-id-<?php echo($module->id); ?>">
	<?php foreach ($manufacturers as $manufacturer) {
		$link = JROUTE::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id);

		?>
		<div>
			<div class="man-sp-handle">
			
				<a href="<?php echo $link; ?>">
			<?php
			if ($manufacturer->images && ($show == 'image' or $show == 'all' )) { ?>
				<?php echo $manufacturer->images[0]->displayMediaThumb('',false);?>
			<?php
			}
			if ($show == 'text' or $show == 'all' ) { ?>
			 <div><?php echo $manufacturer->mf_name; ?></div>
			<?php
			} ?>
				</a>
			</div>
		</div>
		<?php
		if ($col == $manufacturers_per_row) {
			echo "</div><div style='clear:both;'>";
			$col= 1 ;
		} else {
			$col++;
		}
	} ?>
	</div>
	<br style='clear:both;' />

<?php
} else {
	$last = count($manufacturers)-1;
?>
	<div class="man-main-handler product-sl-handler">
	<ul class="row-fluid vmmanufacturer" class="owl-carousel owl-theme" id="owl-id-<?php echo($module->id); ?>">
	<?php

	foreach ($manufacturers as $manufacturer) {
		$link = JROUTE::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id);
		?>
		<li>
			<div class="man-sp-handle">
				<a href="<?php echo $link; ?>">
				
				<?php
				if ($manufacturer->images && ($show == 'image' or $show == 'all' )) { ?>
					<?php echo $manufacturer->images[0]->displayMediaThumb('',false);?>
				<?php
				}
				if ($show == 'text' or $show == 'all' ) { ?>
				 <div><?php echo $manufacturer->mf_name; ?></div>
				<?php
				}
				?>
				</a>
			</div>
		</li>
		<?php
	} ?>
	</ul>
	</div>

<?php }
	if ($footerText) : ?>
	<div class="vmfooter<?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
<?php endif; ?>
</div>
