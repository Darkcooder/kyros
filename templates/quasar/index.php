<?php
JHtml::_('behavior.framework', true);
JHtml::_('bootstrap.framework');
JHTML::_('bootstrap.tooltip');

$doc = JFactory::getDocument();
$doc->setMetaData( 'cleartype', 'on', true );
JHtml::_('bootstrap.loadCss', true, $this->direction);
?>
<!doctype html>
<html class="no-js" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<jdoc:include type="head" />
    <link rel="icon" type="image/png" href="https://intent.guide/images/logo.png">
    <link rel="icon" type="image/gif" href="https://intent.guide/images/icon.png">
    <link rel="image_src" href="https://intent.guide/images/logo.png">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/selectivizr-min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/modernizr.js"></script>
<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie9-10.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/nav.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/typography.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/responsive-template.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/vm-quasar.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/iguide.css" media="screen" />
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter42979944 = new Ya.Metrika({
                    id:42979944,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>

<!-- /Yandex.Metrika counter -->
<script type="text/javascript">
  WebFontConfig = {
	google: { families: [ 'Roboto:400,300,400italic,700,700italic,900,900italic:latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>
<script type="text/javascript">  
(function(){
  var d = document, e = d.documentElement, s = d.createElement('style');
//  if (e.style.MozTransform === ''){ // gecko 1.9.1 inference
    s.textContent = 'body{visibility:hidden} .site-loading{visibility:visible !important;}';
    var r = document.getElementsByTagName('script')[0];
    r.parentNode.insertBefore(s, r);
    function f(){ s.parentNode && s.parentNode.removeChild(s); }
    addEventListener('load',f,false);
    setTimeout(f,3000);
//  }
})();
 </script>
 <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.matchHeight-min.js"></script>
 <script type="text/javascript">
 
 jQuery(function() {
    jQuery('.global-container').matchHeight({
        target:jQuery('.right-handler-inner'),
		property: 'min-height',
    });
});
 
 </script> 
 
 <?php if($this->params->get("siBackgroundImage") || $this->params->get("bodybackgroundimage") || $this->params->get("welcome_box") ) : ?>
 <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.backstretch.min.js"></script>
 <?php endif; ?>
<!--[if IE 6]> <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie6.css" media="screen" /> <![endif]-->
<!--[if IE 7]> <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie.css" media="screen" /> <![endif]-->
    <?php if($this->params->get('usetheme')==true) : ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/presets/<?php echo $this->params->get('choosetheme'); ?>.css" media="screen" />
    <?php endif; ?>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<?php if($this->params->get("usedropdown")) : ?> 
	<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/js/superfish.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/js/supersubs.js"></script>
	<script type="text/javascript">
    jQuery(document).ready(function(){ 
        jQuery("ul.menu-nav").supersubs({ 
			minWidth: <?php echo $this->params->get("dropdownhandler1"); ?>,
            extraWidth:  1
        }).superfish({ 
            delay:500,
            animation:{opacity:'<?php if($this->params->get("dropopacity")) : ?>show<?php else: ?>hide<?php endif; ?>',height:'<?php if($this->params->get("dropheight")) : ?>show<?php else: ?>hide<?php endif; ?>',width:'<?php if($this->params->get("dropwidth")): ?>show<?php else: ?>hide<?php endif; ?>'},
            speed:'<?php echo $this->params->get("dropspeed"); ?>',
            autoArrows:true,
            dropShadows:false 
        });
    }); 
	
	jQuery(function() {                      
		jQuery(".closeMenu").click(function() { 
			jQuery('#social-links').attr('style','display:none');		
		});
	});
	</script>
	<?php endif; ?>

	<?php if( $this->countModules('position-0')) : ?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#searchOpenButton" ).click(function() {
		  jQuery( "#searchpanel" ).toggle( "slow" );
		});
	});
	</script>
	<?php endif; ?>
	
	<?php if( $this->countModules('position-1')) : ?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#menupanel" ).click(function() {
		  jQuery(".global-container").css({'min-height':(jQuery("#nav").height()+150+'px')});
		  jQuery( "#nav" ).toggle( "slow" );
		});
	});
	</script>
	<?php endif; ?>
	
	<?php if( $this->countModules('header-left')) : ?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#hl-open" ).click(function() {
		  jQuery( "#header-left-panel" ).toggle( "<?php echo $this->params->get("HLboxspeed"); ?>'" ); 
		});
	});
	</script>
	<?php endif; ?>
	
	<?php if( $this->countModules('header-right')) : ?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#hr-open" ).click(function() {
		  jQuery( "#header-right-panel" ).toggle( "<?php echo $this->params->get("HRboxspeed"); ?>" );
		});
	});
	</script>
	<?php endif; ?>
	
	<?php if( $this->countModules('quick-menu')) : ?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery(".qm-open" ).click(function() {
		  jQuery( ".quick-menu-handler" ).toggle( "fast" );
		});
        jQuery(".qm-open" ).mouseover(function() {
		  jQuery( ".quick-menu-handler" ).css({display: "block"});
		});
        jQuery(".quick-menu-handler" ).mouseleave(function() {
		  jQuery( ".quick-menu-handler" ).css({display: "none"});
		});
	});
	</script>
	<?php endif; ?>

	
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#rh-open-close" ).click(function() { 
		  jQuery(".global-container").css({'min-height':(jQuery(".right-handler").height()+200+'px')});
		  jQuery( ".right-handler" ).toggle( "fast" );
		  jQuery( "#nav" ).hide( "fast" );
		});
	});	
	</script>
	
	<script type="text/javascript">
		function toggle_visibility(id) {
		var e = document.getElementById(id);
		if(e.style.display == 'block')
		e.style.display = 'none';
		else
		e.style.display = 'block';
		}
	</script>
	
	<?php echo $this->params->get("headcode"); ?>

	<?php if( $this->countModules('builtin-slideshow')) : ?>
	<!-- Built-in Slideshow -->
	<?php if($this->params->get("cam_turnOn")) : ?>
		<link rel="stylesheet" id="camera-css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/camera.css" type="text/css" media="all" /> 
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.mobile.customized.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.easing.1.3.js"></script> 
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/camera.min.js"></script> 
		<script>
			jQuery(function(){		
				jQuery('#ph-camera-slideshow').camera({
					alignment: 'topCenter',
					autoAdvance: <?php if ($this->params->get("cam_autoAdvance")) : ?>true<?php else: ?>false<?php endif; ?>,
					mobileAutoAdvance: <?php if ($this->params->get("cam_mobileAutoAdvance")) : ?>true<?php else: ?>false<?php endif; ?>, 
					slideOn: '<?php if($this->params->get("cam_slideOn")) : echo $this->params->get("cam_slideOn"); else : ?>random<?php endif; ?>',	
					thumbnails: <?php if ($this->params->get("cam_thumbnails")) : ?>true<?php else: ?>false<?php endif; ?>,
					time: <?php if($this->params->get("cam_time")) : echo $this->params->get("cam_time"); else : ?>7000<?php endif; ?>,
					transPeriod: <?php if($this->params->get("cam_transPeriod")) : echo $this->params->get("cam_transPeriod"); else : ?>1500<?php endif; ?>,
					cols: <?php if($this->params->get("cam_cols")) : echo $this->params->get("cam_cols"); else : ?>10<?php endif; ?>,
					rows: <?php if($this->params->get("cam_rows")) : echo $this->params->get("cam_rows"); else : ?>10<?php endif; ?>,
					slicedCols: <?php if($this->params->get("cam_slicedCols")) : echo $this->params->get("cam_slicedCols"); else : ?>10<?php endif; ?>,	
					slicedRows: <?php if($this->params->get("cam_slicedRows")) : echo $this->params->get("cam_slicedRows"); else : ?>10<?php endif; ?>,
					fx: '<?php if($this->params->get("cam_fx_multiple_on")) : echo $this->params->get("cam_fx_multi"); else : echo $this->params->get("cam_fx"); endif; ?>',
					gridDifference: <?php if($this->params->get("cam_gridDifference")) : echo $this->params->get("cam_gridDifference"); else : ?>250<?php endif; ?>,
					height: '<?php if($this->params->get("cam_height")) : echo $this->params->get("cam_height"); else : ?>50%<?php endif; ?>',
					minHeight: '<?php echo $this->params->get("cam_minHeight"); ?>',
					imagePath: '<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/',	
					hover: <?php if ($this->params->get("cam_hover")) : ?>true<?php else: ?>false<?php endif; ?>,
					loader: '<?php if($this->params->get("cam_loader")) : echo $this->params->get("cam_loader"); else : ?>pie<?php endif; ?>',
					barDirection: '<?php if($this->params->get("cam_barDirection")) : echo $this->params->get("cam_barDirection"); else : ?>leftToRight<?php endif; ?>',
					barPosition: '<?php if($this->params->get("cam_barPosition")) : echo $this->params->get("cam_barPosition"); else : ?>bottom<?php endif; ?>',	
					pieDiameter: <?php if($this->params->get("cam_pieDiameter")) : echo $this->params->get("cam_pieDiameter"); else : ?>38<?php endif; ?>,
					piePosition: '<?php if($this->params->get("cam_piePosition")) : echo $this->params->get("cam_piePosition"); else : ?>rightTop<?php endif; ?>',
					loaderColor: '<?php if($this->params->get("cam_loaderColor")) : echo $this->params->get("cam_loaderColor"); else : ?><?php endif; ?>', 
					loaderBgColor: '<?php if($this->params->get("cam_loaderBgColor")) : echo $this->params->get("cam_loaderBgColor"); else : ?>#222222<?php endif; ?>', 
					loaderOpacity: <?php if($this->params->get("cam_loaderOpacity")) : echo $this->params->get("cam_loaderOpacity"); else : ?>8<?php endif; ?>,
					loaderPadding: <?php if($this->params->get("cam_loaderPadding")) : echo $this->params->get("cam_loaderPadding"); else : ?>2<?php endif; ?>,
					loaderStroke: <?php if($this->params->get("cam_loaderStroke")) : echo $this->params->get("cam_loaderStroke"); else : ?>7<?php endif; ?>,
					navigation: <?php if ($this->params->get("cam_navigation")) : ?>true<?php else: ?>false<?php endif; ?>,
					playPause: <?php if ($this->params->get("cam_playPause")) : ?>true<?php else: ?>false<?php endif; ?>,
					navigationHover: <?php if ($this->params->get("cam_navigationHover")) : ?>true<?php else: ?>false<?php endif; ?>,
					mobileNavHover: <?php if ($this->params->get("cam_mobileNavHover")) : ?>true<?php else: ?>false<?php endif; ?>,
					opacityOnGrid: <?php if ($this->params->get("cam_opacityOnGrid")) : ?>true<?php else: ?>false<?php endif; ?>,
					pagination: <?php if ($this->params->get("cam_pagination")) : ?>true<?php else: ?>false<?php endif; ?>,
					pauseOnClick: <?php if ($this->params->get("cam_pauseOnClick")) : ?>true<?php else: ?>false<?php endif; ?>,
					portrait: <?php if ($this->params->get("cam_portrait")) : ?>true<?php else: ?>false<?php endif; ?>
				});
			});
		</script>
	<?php endif; ?>
	<!-- End of Built-in Slideshow -->
	<?php endif; ?>

	<style type="text/css">

	body {
		font-size: <?php echo $this->params->get('contentfontsize'); ?>;
	}
	
	


	@media (min-width: 1600px) {
		body{padding-top: <?php echo $this->params->get('topheight'); ?>px;}
		#top-navigation-bar, #logo-handler, #site-name-handler, .quick-menu .menu li a, #sn-position, #avatar {height:<?php echo $this->params->get('topheight'); ?>px; }
		#search-position #searchpanel {height:<?php echo $this->params->get('topheight'); ?>px !important; }
		#search-position .search, #search-position .finder {margin-top: <?php echo ($this->params->get('topheight') / 2) - 18; ?>px }
		.left-handler, #footer .footer-line-cover, .keep-fixed, .icon {width:<?php echo $this->params->get('topheight'); ?>px;}
		#search-position #searchpanel{right:<?php echo $this->params->get('topheight'); ?>px;}
		#vmCartModule div.panel2{top:<?php echo $this->params->get('topheight'); ?>px;}
		#logo-handler, .log-panel li a.v_register, #cartpanel, .log-panel li a.open-register-form, #search-position, #searchOpenButton, #rh-open-close, .qm-open {width:<?php echo $this->params->get('topheight'); ?>px;height:<?php echo $this->params->get('topheight'); ?>px;}
		.quick-menu .menu li a {line-height: <?php echo $this->params->get('topheight'); ?>px;}
		
		#sn-position .h1 {max-width:<?php echo $this->params->get('H1TitleMaxWidth1600'); ?>;
		top:<?php echo $this->params->get('H1TitlePositionY1600'); ?>;
		}
		
		#sn-position .h2 {max-width:<?php echo $this->params->get('H2TitleMaxWidth1600'); ?>;
		top:<?php echo $this->params->get('H2TitlePositionY1600'); ?>;
		}
		
		.footer-handler {margin-left:<?php echo $this->params->get('topheight'); ?>px;}
		
	}
	
	@media (min-width: 1200px) and (max-width: 1599px) { 
		body{padding-top: <?php echo $this->params->get('topheight') * 0.85; ?>px;}
		#top-navigation-bar, #logo-handler, #site-name-handler, .quick-menu .menu li a, #sn-position, #avatar {height:<?php echo $this->params->get('topheight') * 0.85; ?>px; }
		#search-position #searchpanel {height:<?php echo $this->params->get('topheight') * 0.85; ?>px !important; }
		#search-position .search, #search-position .finder {margin-top: <?php echo (($this->params->get('topheight') * 0.85 ) / 2) - 18; ?>px }
		.left-handler, #footer .footer-line-cover, .keep-fixed, .icon {width:<?php echo $this->params->get('topheight') * 0.85; ?>px;}
		#search-position #searchpanel{right:<?php echo $this->params->get('topheight') * 0.85; ?>px;}
		#vmCartModule div.panel2, .quick-menu .quick-menu-handler {top:<?php echo $this->params->get('topheight') * 0.85; ?>px;}
		#logo-handler, .log-panel li a.v_register, #cartpanel, .log-panel li a.open-register-form, #search-position, #searchOpenButton, #rh-open-close, .qm-open {width:<?php echo $this->params->get('topheight') * 0.85; ?>px;height:<?php echo $this->params->get('topheight') * 0.85; ?>px;}
		.quick-menu .menu li a {line-height: <?php echo $this->params->get('topheight') * 0.85; ?>px;}
		.global-left-container .right-handler{left:<?php echo $this->params->get('topheight') * 0.85; ?>px;}
		.right-handler{width:246px;}
		
		#sn-position .h1 {max-width:<?php echo $this->params->get('H1TitleMaxWidth12001599'); ?>;
		top:<?php echo $this->params->get('H1TitlePositionY12001599'); ?>;
		}
		
		#sn-position .h2 {max-width:<?php echo $this->params->get('H2TitleMaxWidth12001599'); ?>;
		top:<?php echo $this->params->get('H2TitlePositionY12001599'); ?>;
		}
		.footer-handler {margin-left:<?php echo $this->params->get('topheight') * 0.85; ?>px;}	
	}
	
	@media (min-width: 980px) and (max-width: 1199px) {
		body{padding-top: <?php echo $this->params->get('topheight') * 0.80; ?>px;}
		#top-navigation-bar, #logo-handler, #site-name-handler, .quick-menu .menu li a, #sn-position, #avatar {height:<?php echo $this->params->get('topheight') * 0.80; ?>px; }
		#search-position #searchpanel {height:<?php echo $this->params->get('topheight') * 0.80; ?>px !important; }
		#search-position .search, #search-position .finder {margin-top: <?php echo (($this->params->get('topheight') * 0.80 ) / 2) - 18; ?>px }
		.left-handler, #footer .footer-line-cover, .keep-fixed, .icon {width:<?php echo $this->params->get('topheight') * 0.80; ?>px;}
		#search-position #searchpanel{right:<?php echo $this->params->get('topheight') * 0.80; ?>px;}
		#vmCartModule div.panel2, .quick-menu .quick-menu-handler {top:<?php echo $this->params->get('topheight') * 0.80; ?>px;}
		#logo-handler, .log-panel li a.v_register, #cartpanel, .log-panel li a.open-register-form, #search-position, #searchOpenButton, #rh-open-close, .qm-open {width:<?php echo $this->params->get('topheight') * 0.80; ?>px;height:<?php echo $this->params->get('topheight') * 0.80; ?>px;}
		.quick-menu .menu li a {line-height: <?php echo $this->params->get('topheight') * 0.80; ?>px;}
		.global-left-container .right-handler{left:<?php echo $this->params->get('topheight') * 0.80; ?>px;}
		.right-handler{width:250px !important;}
		
		#sn-position .h1 {max-width:<?php echo $this->params->get('H1TitleMaxWidth9801199'); ?>;
		top:<?php echo $this->params->get('H1TitlePositionY9801199'); ?>;
		}
		
		#sn-position .h2 {max-width:<?php echo $this->params->get('H2TitleMaxWidth9801199'); ?>;
		top:<?php echo $this->params->get('H2TitlePositionY9801199'); ?>;
		}
		.footer-handler {margin-left:<?php echo $this->params->get('topheight') * 0.80; ?>px;}	
	}
	
	@media (min-width: 768px) and (max-width: 979px) { 
		body{padding-top: <?php echo $this->params->get('topheight') * 0.60; ?>px;}
		#top-navigation-bar, #logo-handler, #site-name-handler, .quick-menu .menu li a, a#menupanel, #sn-position, #avatar {height:<?php echo $this->params->get('topheight') * 0.60; ?>px; }
		#search-position #searchpanel {height:<?php echo $this->params->get('topheight') * 0.60; ?>px !important; }
		#search-position .search, #search-position .finder {margin-top: <?php echo (($this->params->get('topheight') * 0.60 ) / 2) - 18; ?>px }
		.left-handler, #footer .footer-line-cover, .keep-fixed {width:<?php echo $this->params->get('topheight') * 0.60; ?>px;}
		#search-position #searchpanel{right:<?php echo $this->params->get('topheight') * 0.60; ?>px;}
		#vmCartModule div.panel2, .quick-menu .quick-menu-handler {top:<?php echo $this->params->get('topheight') * 0.60; ?>px;}
		#logo-handler, .log-panel li a.v_register, #cartpanel, .log-panel li a.open-register-form, #search-position, #searchOpenButton, #rh-open-close, .qm-open {width:<?php echo $this->params->get('topheight') * 0.60; ?>px;height:<?php echo $this->params->get('topheight') * 0.60; ?>px;}
		.quick-menu .menu li a, a#menupanel {line-height: <?php echo $this->params->get('topheight') * 0.60; ?>px;}
		.global-left-container .right-handler{left:<?php echo $this->params->get('topheight') * 0.60; ?>px;}
		.res-ico{margin-top:  <?php echo (($this->params->get('topheight') * 0.60 ) / 2) - 10; ?>px}
		.right-handler{width:250px !important;}
		
		#sn-position .h1 {max-width:<?php echo $this->params->get('H1TitleMaxWidth768979'); ?>;
		top:<?php echo $this->params->get('H1TitlePositionY768979'); ?>;
		}
		
		<?php if($this->params->get("H1Title768979") == false ) : ?>
		#sn-position .h1 {display:none;}
		#quick-nav{width:85%;}
		<?php else: ?>
		#sn-position .h1 {display:block;}
		<?php endif; ?>
		
		#sn-position .h2 {max-width:<?php echo $this->params->get('H2TitleMaxWidth768979'); ?>;
		top:<?php echo $this->params->get('H2TitlePositionY768979'); ?>;
		}
		
		<?php if($this->params->get("H2Title768979") == false ) : ?>
		#sn-position .h2 {display:none;}
		#quick-nav{width:85%;}
		<?php else: ?>
		#sn-position .h2 {display:block;}
		<?php endif; ?>
		.footer-handler {margin-left:<?php echo $this->params->get('topheight') * 0.60; ?>px;}	
	}
	
	@media (max-width: 767px) { 
		body{padding-top: <?php echo $this->params->get('topheight') * 0.45; ?>px;}
		#top-navigation-bar, #logo-handler, #site-name-handler, .quick-menu .menu li a, a#menupanel, #sn-position, #avatar {height:<?php echo $this->params->get('topheight') * 0.45; ?>px; }
		#search-position #searchpanel {height:<?php echo $this->params->get('topheight') * 0.45; ?>px !important; }
		#search-position .search, #search-position .finder {margin-top: <?php echo (($this->params->get('topheight') * 0.45 ) / 2) - 18; ?>px }
		.left-handler, #footer .footer-line-cover, .keep-fixed, .icon {width:<?php echo $this->params->get('topheight') * 0.45; ?>px;}
		#search-position #searchpanel{left:-<?php echo $this->params->get('topheight') * 0.45; ?>px;top:<?php echo $this->params->get('topheight') * 0.45; ?>px;}
		#vmCartModule div.panel2, .quick-menu .quick-menu-handler {top:<?php echo $this->params->get('topheight') * 0.45; ?>px;}
		#logo-handler, .log-panel li a.v_register, #cartpanel, .log-panel li a.open-register-form, #search-position, #searchOpenButton, #rh-open-close, .qm-open {width:<?php echo $this->params->get('topheight') * 0.45; ?>px;height:<?php echo $this->params->get('topheight') * 0.45; ?>px;}
		.quick-menu .menu li a, a#menupanel {line-height: <?php echo $this->params->get('topheight') * 0.45; ?>px;}
		.global-left-container .right-handler{left:<?php echo $this->params->get('topheight') * 0.45; ?>px;}
		.res-ico{margin-top:  <?php echo (($this->params->get('topheight') * 0.45 ) / 2) - 10; ?>px}
		.right-handler{width:250px !important;}
		
		#sn-position .h1 {max-width:<?php echo $this->params->get('H1TitleMaxWidth767'); ?>;
		top:<?php echo $this->params->get('H1TitlePositionY767'); ?>;
		}
		
		<?php if($this->params->get("H1Title767") == false ) : ?>
		#sn-position .h1 {display:none;}
		#quick-nav{width:85%;}
		<?php else: ?>
		#sn-position .h1 {display:block;}
		<?php endif; ?>
		
		#sn-position .h2 {max-width:<?php echo $this->params->get('H2TitleMaxWidth767'); ?>;
		top:<?php echo $this->params->get('H2TitlePositionY767'); ?>;
		}
		
		<?php if($this->params->get("H2Title767") == false ) : ?>
		#sn-position .h2 {display:none;}
		#quick-nav{width:85%;}
		<?php else: ?>
		#sn-position .h2 {display:block;}
		<?php endif; ?>
		
		.fadeFromLeft > div > div { top: 10% !important; }
		.fadeFromRight > div > div { top: 25% !important; }
		.footer-handler {margin-left:<?php echo $this->params->get('topheight') * 0.45; ?>px;}	
	}
		

	
	#sn-position .h1{<?php if ($this->direction == 'rtl') : ?>right<?php else: ?>left<?php endif; ?>:<?php echo $this->params->get('H1TitlePositionX'); ?>;color:<?php echo $this->params->get('sitenamecolor'); ?>;font-size:<?php echo $this->params->get('sitenamefontsize'); ?>;}
	#sn-position .h1 a {color:<?php echo $this->params->get('sitenamecolor'); ?>;}
	#sn-position .h2 {<?php if ($this->direction == 'rtl') : ?>right<?php else: ?>left<?php endif; ?>:<?php echo $this->params->get('H2TitlePositionX'); ?>;color:<?php echo $this->params->get('slogancolor'); ?>;font-size:<?php echo $this->params->get('sloganfontsize'); ?>;line-height:<?php echo $this->params->get('sloganfontsize'); ?>;}
	#top-header-handler{margin-top:<?php echo $this->params->get('H1TitlePositionY') -2; ?>px;}
	
	<?php if( $this->countModules('header-left')) : ?>

		#header-left-handler {
			<?php echo $this->params->get('HLposition'); ?>: <?php echo $this->params->get('HLspaceFrom'); ?>px; 
			max-width: <?php echo $this->params->get('HLmaxWidth'); ?>px;
		}

		#header-left-panel {
			height: <?php echo $this->params->get('HLheight'); ?>px !important;
		}

		#hl-panel-handler {
			width: <?php echo $this->params->get('HLmaxWidth') - 60; ?>px !important; 
		}

		#hl-open {
			height: <?php echo $this->params->get('HLlabelSize'); ?>px;
			<?php if( $this->params->get('HLposition') == "bottom" ) : ?>margin-top: <?php echo $this->params->get('HLheight') - $this->params->get('HLlabelSize'); ?>px;<?php endif; ?>
		}

		#hl-open:after {
			<?php if( $this->params->get('HLposition') == "top" ) : ?>
			border-bottom-color: transparent !important;
			border-right-color: transparent !important;
			bottom: -10px;
			<?php else: ?>
			border-top-color: transparent !important;
			border-right-color: transparent !important;
			top: -10px;			
			<?php endif; ?>
		}

		#hl-open-label {
			top: <?php echo $this->params->get('HLlabelSize')/2; ?>px;
			right: -<?php echo ($this->params->get('HLlabelSize') - 40)/2; ?>px;
			width: <?php echo $this->params->get('HLlabelSize'); ?>px;

		}
	<?php endif; ?>

	<?php if( $this->countModules('header-right')) : ?>

		#header-right-handler {
			<?php echo $this->params->get('HRposition'); ?>: <?php echo $this->params->get('HRspaceFrom'); ?>px; 
			max-width: <?php echo $this->params->get('HRmaxWidth'); ?>px;
		}

		#header-right-panel {
			height: <?php echo $this->params->get('HRheight'); ?>px !important;
		}

		#hr-panel-handler {
			width: <?php echo $this->params->get('HRmaxWidth') - 60; ?>px !important; 
		}

		#hr-open {
			height: <?php echo $this->params->get('HRlabelSize'); ?>px;
			<?php if( $this->params->get('HRposition') == "bottom" ) : ?>margin-top: <?php echo $this->params->get('HRheight') - $this->params->get('HRlabelSize'); ?>px;<?php endif; ?>
		}

		#hr-open-label {
			top: <?php echo $this->params->get('HRlabelSize')/2; ?>px;
			right: -<?php echo ($this->params->get('HRlabelSize') - 40)/2; ?>px;
			width: <?php echo $this->params->get('HRlabelSize'); ?>px;

		}
	
	<?php endif; ?>	
	
	<?php if( $this->countModules('header-left or header-right')) : ?>
	@media screen and (max-width: 767px) {
	 <?php if( $this->params->get('HLmobileVisible') == "no" ) : ?>
	 #header-left-handler {display:none;}
	 <?php endif; ?>
	 <?php if( $this->params->get('HRmobileVisible') == "no" ) : ?>
	 #header-right-handler {display:none;}
	 <?php endif; ?>
	}
	<?php endif; ?>	
	
	
	
	ul.columns-2 {width: <?php echo $this->params->get('dropdownhandler2'); ?>px !important;}
	ul.columns-3 {width: <?php echo $this->params->get('dropdownhandler3'); ?>px !important;}
	ul.columns-4 {width: <?php echo $this->params->get('dropdownhandler4'); ?>px !important;}
	ul.columns-5 {width: <?php echo $this->params->get('dropdownhandler5'); ?>px !important;}

	
	<?php if ($this->direction == 'rtl') : ?>
	ul.menu-nav li li:hover ul, ul.menu-nav li li.sfHover ul {
		right: <?php echo $this->params->get("dropdownhandler1") - 1; ?>em;
	}
	<?php endif; ?>
	<?php if( $this->countModules('builtin-slideshow')) : 
	if($this->params->get("cam_turnOn")) : ?>

	.fadeFromLeft > div > div { top: <?php echo $this->params->get('cam_captionTop1'); ?>; }
	.fadeFromRight > div > div { top: <?php echo $this->params->get('cam_captionTop2'); ?>; }
	
	.camera_caption_bg {
		margin-left: 10%;
		width: 50%;
	}
	
	.move-right .camera_caption_bg {
		margin-left: 40%;
		width: 50%;
		text-align: right;
	}
	
	.camera_pie {
		width: <?php if($this->params->get("cam_pieDiameter")) : echo $this->params->get("cam_pieDiameter"); else : ?>38<?php endif; ?>px;
		height: <?php if($this->params->get("cam_pieDiameter")) : echo $this->params->get("cam_pieDiameter"); else : ?>38<?php endif; ?>px;
	}
	#slideshow-handler { min-height: <?php echo $this->params->get("cam_minHeight"); ?>; }
	<?php endif; endif; ?>
<?php							
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb);
}
?>

<?php if($this->params->get('usetheme')==false) : ?> 

body {
	background-color: <?php echo $this->params->get("color1"); ?>;
	color: <?php echo $this->params->get("color2"); ?>;
}

dt.tabs.open, .latest-view .spacer, .topten-view .spacer, .recent-view .spacer, .featured-view .spacer, .browse-view .spacer {
	background-color: <?php echo $this->params->get("color1"); ?>;
}

.row-fluid .spacer .pr-img-handler .popout-price .show-pop-up-image a:after,
.row-fluid .spacer .pr-img-handler .popout-price .product-details:after,
.row-fluid .spacer .pr-img-handler .popout-price .show-advanced-fields:after,
#tabs-1 .nav-tabs > li > a,
#fancybox-close {
	color: <?php echo $this->params->get("color2"); ?> !important;
}

.custom-color1{color: <?php echo $this->params->get("color3"); ?>;}
.custom-color2{color: <?php echo $this->params->get("color4"); ?>;}
.custom-color3{color: <?php echo $this->params->get("color5"); ?>;}
.custom-color4{color: <?php echo $this->params->get("color6"); ?>;}

.custom-background1{background-color: <?php echo $this->params->get("color7"); ?> !important;}
.custom-background2{background-color: <?php echo $this->params->get("color8"); ?> !important;}
.custom-background3{background-color: <?php echo $this->params->get("color9"); ?> !important;}
.custom-background4{background-color: <?php echo $this->params->get("color10"); ?> !important;}

#logo-handler {
	background: <?php echo $this->params->get("color11"); ?>;
	background: -moz-linear-gradient(-45deg, <?php echo $this->params->get("color11"); ?> 0%, <?php echo $this->params->get("color12"); ?> 100%);
	background: -webkit-gradient(linear, left top, right bottom, color-stop(0%, <?php echo $this->params->get("color11"); ?>), color-stop(100%, <?php echo $this->params->get("color12"); ?>));
	background: -webkit-linear-gradient(-45deg, <?php echo $this->params->get("color11"); ?> 0%, <?php echo $this->params->get("color12"); ?> 100%);
	background: -o-linear-gradient(-45deg, <?php echo $this->params->get("color11"); ?> 0%, <?php echo $this->params->get("color12"); ?> 100%);
	background: -ms-linear-gradient(-45deg, <?php echo $this->params->get("color11"); ?> 0%, <?php echo $this->params->get("color12"); ?> 100%);
	background: linear-gradient(135deg, <?php echo $this->params->get("color11"); ?> 0%, <?php echo $this->params->get("color12"); ?> 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $this->params->get("color11"); ?>', endColorstr='<?php echo $this->params->get("color12"); ?>',GradientType=1 );
}

#top-navigation-bar, .orderby-displaynumber {
	background-color: <?php echo $this->params->get("color13"); ?>;
	border-bottom-color: <?php echo $this->params->get("color14"); ?>;
}

.orderlistcontainer a {
	color: <?php echo $this->params->get("color25"); ?>;
}

#logo-handler .quick-contact {
	background-color: <?php echo $this->params->get("color16"); ?>;
	color: <?php echo $this->params->get("color17"); ?>;
}

#logo-handler .quick-contact a {
	color: <?php echo $this->params->get("color18"); ?>;
}

.left-handler, .footer-line-cover {
	background-color: <?php echo $this->params->get("color19"); ?>;
}

.left-handler .menu a:hover, #rh-open-close:hover {
	background-color: <?php echo $this->params->get("color20"); ?>;
}

.left-handler .menu li a:hover:before, #rh-open-close:hover:before {
	border-right-color: <?php echo $this->params->get("color21"); ?>;
}

.right-handler {
	background-color: <?php echo $this->params->get("color22"); ?>;
	border-right-color: <?php echo $this->params->get("color23"); ?>;
}

.right-handler [class*="moduletable"] > h3 {
	border-color: <?php echo $this->params->get("color24"); ?>;
}

.quick-menu .menu li a {
	color: <?php echo $this->params->get("color25"); ?> !important;
}

.quick-menu .menu li a:hover {
	color: <?php echo $this->params->get("color26"); ?> !important;
}

#searchOpenButton:hover, .log-panel li a:hover, .cart-button:hover, .qm-open:hover {
	background-color: <?php echo $this->params->get("color27"); ?>;
}

#searchOpenButton:hover:before, .log-panel li a:hover:before, .cart-button:hover:before, .qm-open:hover:before {
	border-bottom-color: <?php echo $this->params->get("color28"); ?>;
}

#search-position #searchpanel {
	background-color: <?php echo $this->params->get("color29"); ?>;
}

#search-position .search, #search-position .finder {
	background-color: <?php echo $this->params->get("color30"); ?>;
}

#search-position #searchpanel input.inputbox {
	color: <?php echo $this->params->get("color31"); ?>;
}

a,a:hover, .moduletable_menu ul.menu li ul li a:hover {
	color: <?php echo $this->params->get("color32"); ?>;
}
.row-fluid .spacer .pr-img-handler .popout-price .show-pop-up-image a:hover:after, .row-fluid .spacer .pr-img-handler .popout-price .product-details:hover:after, .row-fluid .spacer .pr-img-handler .popout-price .show-advanced-fields:hover:after,
#tabs-1 .nav-tabs>.active>a, #tabs-1 .nav-tabs>.active>a:hover, #tabs-1 .nav-tabs>.active>a:focus, #tabs-1 .nav-tabs>li>a:hover, a:focus, a:active, #fancybox-close:hover {
	color: <?php echo $this->params->get("color32"); ?> !important;
}
#tabs-1 .nav-tabs>.active>a:before, #tabs-1 .nav-tabs>.active>a:hover:before, #tabs-1 .nav-tabs>.active>a:focus:before, #tabs-1 .nav-tabs>li>a:hover:before {
	border-top-color: <?php echo $this->params->get("color32"); ?>;
}

.button, button, a.button, .btn, dt.tabs.closed:hover, dt.tabs.closed:hover h3 a, .closemenu, .vmproduct.product-details .spacer:hover .pr-add, .vmproduct.product-details .spacer:hover .pr-add-bottom, a.product-details, a.ask-a-question, .highlight-button, .vm-button-correct, .cartpanel span.closecart, .vm-pagination ul li a, #LoginForm .btn-group > .dropdown-menu, #LoginForm .btn-group > .dropdown-menu a, a.details, #stickymenuButton, .img_style2 .con_style2 p:before, .product-neighbours a.previous-page:before, .product-neighbours a.next-page:after, input.addtocart-button, #header-right-panel a.button {
	color: <?php echo $this->params->get("color33"); ?> !important;
	background-color: <?php echo $this->params->get("color34"); ?> !important;
	border-color: <?php echo $this->params->get("color33"); ?>;
}

.button:hover, button:hover, a.button:hover, .closemenu:hover, .btn:hover, a.product-details:hover, a.ask-a-question:hover, .highlight-button:hover, .vm-button-correct:hover, .cartpanel span.closecart:hover, .vm-pagination ul li a:hover, a.details:hover, #stickymenuButton:hover, input.addtocart-button:hover, .products-number, a#menupanel, .orderlistcontainer .title, #header-right-panel a.button:hover, .VMmenu li:hover .VmArrowdown {
	color: <?php echo $this->params->get("color35"); ?> !important;
	background-color: <?php echo $this->params->get("color36"); ?> !important;
	border-color: <?php echo $this->params->get("color36"); ?>;
}

a#menupanel:hover, .orderlistcontainer .title {
	background-color: <?php echo $this->params->get("color37"); ?>#e36e00 !important;
}

.action-handler .addtocart-bar span.quantity-box input {
	color: <?php echo $this->params->get("color2"); ?> !important;
}

#LoginForm .btn-group > .dropdown-menu a:hover {
	background: <?php echo $this->params->get("color36"); ?> !important;
	color: <?php echo $this->params->get("color35"); ?> !important;
}

#LoginForm .button:hover .caret {
	border-top-color: <?php echo $this->params->get("color35"); ?> !important;
}

.pr-add, .pr-add-bottom,.featured-view .spacer h3, .latest-view .spacer h3, .topten-view .spacer h3, .recent-view .spacer h3, .related-products-view .spacer h3, .browse-view .product .spacer h2,.featured-view .spacer .product_s_desc, .latest-view .spacer .product_s_desc, .topten-view .spacer .product_s_desc, .recent-view .spacer .product_s_desc, .related-products-view .spacer .product_s_desc, .browse-view .product .spacer .product_s_desc {
	color: <?php echo $this->params->get("color2"); ?>;
}

.category-view .row-fluid .category .spacer h2 a .cat-title {
	color: <?php echo $this->params->get("color2"); ?>;
}


.category-view .row-fluid .category .spacer:hover h2 a .cat-title {
	color: <?php echo $this->params->get("color35"); ?>;
}

.category .spacer:hover {
	background: <?php echo $this->params->get("color36"); ?>;
}

div.spacer, li.spacer, div.spacer:hover, li.spacer:hover {
	background: <?php echo $this->params->get("color1"); ?>;
}

.custom-fields-panel {
	background-color: <?php echo $this->params->get("color1"); ?>;
}

.moduletable a, div.panel2 a, .category_description a, .productdetails-view a {
	color: <?php echo $this->params->get("color32"); ?>;
}

.camera_wrap .camera_pag .camera_pag_ul li {
	background: <?php echo $this->params->get("color38"); ?>;
}

.camera_commands > .camera_play,.camera_commands > .camera_stop,.camera_prevThumbs div,.camera_nextThumbs div, .camera_prev > span,.camera_next > span {
	background-color: <?php echo $this->params->get("color39"); ?>;
}

.camera_wrap .camera_pag .camera_pag_ul li.cameracurrent > span, .camera_wrap .camera_pag .camera_pag_ul li:hover > span {
	background-color: <?php echo $this->params->get("color40"); ?>;
}

.camera_thumbs_cont ul li > img {
	border: 1px solid <?php echo $this->params->get("color41"); ?> !important;
}

.camera_caption.title > div > div {
	color: <?php echo $this->params->get("color42"); ?>;
}

.camera_caption > div > div {
	color: <?php echo $this->params->get("color42"); ?>;
}

.camera_caption.white > div > div, .camera_caption.white > div > div p, .camera_caption.white > div > div a {
	color: <?php echo $this->params->get("color43"); ?> !important;
}

.camera_caption > div > div p {
	color: <?php echo $this->params->get("color42"); ?>;
}

.camera_caption.title.white > div > div, .camera_caption.white > div > div {
	color: <?php echo $this->params->get("color43"); ?> !important;
}

.camera_caption.title.white .camera_caption_bg > span:before {
	background: <?php echo $this->params->get("color43"); ?>;
}

@media (max-width: 768px) { 
	.camera_caption.title {
		background-color: rgba(<?php echo hex2rgb($this->params->get("color44")); ?>,0.8);
	}
}

#menu .menu-nav > li > a, .moduletable_empty ul.menu > li > a {
	color: <?php echo $this->params->get("color45"); ?>;
}

#menu .menu-nav > li.active > a, .moduletable_empty ul.menu > li > a:hover {
	color: <?php echo $this->params->get("color46"); ?>;
}

#menu .menu-nav > li > a:hover, #menu .menu-nav > li.sfHover > a, .menupanel ul.selectnav li a:hover {
	background-color: <?php echo $this->params->get("color47"); ?>;
	color: <?php echo $this->params->get("color48"); ?> !important;
}

.rm-line {background-color: <?php echo $this->params->get("color35"); ?>;}


#menu .menu-nav > li > a > span small {
	background: <?php echo $this->params->get("color49"); ?>;
	color: <?php echo $this->params->get("color50"); ?>;
}

#menu .menu-nav > li > a > span small.hot {
	background: <?php echo $this->params->get("color51"); ?>;
	color: <?php echo $this->params->get("color52"); ?>;
}

#menu .menu-nav > li > a > span small.featured {
	background: <?php echo $this->params->get("color53"); ?>;
	color: <?php echo $this->params->get("color54"); ?>;
}

#menu .menu-nav ul li, .quick-menu-handler ul.menu li {
	border-top: 1px solid <?php echo $this->params->get("color55"); ?>;
}

#menu .menu-nav ul li a {
	color: <?php echo $this->params->get("color56"); ?>;
}

#menu .menu-nav ul li a:hover, .menu-nav ul li.sfHover > a {
	color: <?php echo $this->params->get("color57"); ?> !important;
	background-color: <?php echo $this->params->get("color58"); ?> !important;
}

@media (max-width: 1199px) {
	.quick-menu .menu li a:hover {
		color: <?php echo $this->params->get("color57"); ?> !important;
		background-color: <?php echo $this->params->get("color58"); ?> !important;
	}
}

@media (max-width: 979px) { 
	
	#menu #nav {
		background-color: <?php echo $this->params->get("color59"); ?>;
	}

	#menu .menu-nav ul li a {
		color: <?php echo $this->params->get("color60"); ?>;
	}
	
	#menu .menu-nav ul li a:hover, .menu-nav ul li.sfHover > a {
		color: <?php echo $this->params->get("color61"); ?> !important;
	}
}

#menu .menu-nav li a .sf-sub-indicator {
	border-left-color: <?php echo $this->params->get("color62"); ?> !important;
}

#menu .menu-nav li a:hover .sf-sub-indicator,
#menu .menu-nav li.sfHover > a .sf-sub-indicator  {
	border-left-color: <?php echo $this->params->get("color63"); ?> !important;
}

#menu .menu-nav li ul, #menu .menu-nav li ul li ul, #nav ol, #nav ul, #nav ol ol, #nav ul ul, div.panel2 {
	background-color: <?php echo $this->params->get("color64"); ?> !important;
}

.quick-menu-handler {
	background-color: <?php echo $this->params->get("color64"); ?>;
}

.cartpanel a {
	color: <?php echo $this->params->get("color65"); ?>;
}

thead th, table th, tbody th, tbody td {
	border-top: 1px solid <?php echo $this->params->get("color66"); ?>;
}
tbody th, tbody td, .search-results dt.result-title, #cart-panel2 .product_row, .moduletable_products.quick li,
[class*="moduletable"] > h3, .moduletable > h3, .category-view h4, .featured-view h4, .latest-view h4, .topten-view h4, .recent-view h4 {
	border-bottom: 1px solid <?php echo $this->params->get("color66"); ?>;
}

.pr-img-handler {
	border-bottom-color: <?php echo $this->params->get("color66"); ?>;
}

.product-price, div.PricebillTotal.vm-display.vm-price-value span.PricebillTotal {
	color: <?php echo $this->params->get("color67"); ?>;
}

.h-pr-title a {
	color: <?php echo $this->params->get("color68"); ?>;
}

.owl-theme .owl-controls .owl-page span {
	background-color: <?php echo $this->params->get("color69"); ?>;
	color: <?php echo $this->params->get("color70"); ?>;
}

.owl-theme .owl-controls .owl-buttons div {
	background-color: <?php echo $this->params->get("color71"); ?>;
}

.owl-theme .owl-controls .owl-buttons div.owl-prev:before, .owl-theme .owl-controls .owl-buttons div.owl-next:before {
	border-color: <?php echo $this->params->get("color72"); ?>;
}

.owl-theme .owl-controls .owl-page.active span,.owl-theme .owl-controls.clickable .owl-page:hover span{
	background: <?php echo $this->params->get("color73"); ?>;
	color: <?php echo $this->params->get("color74"); ?>;
}

.moduletable_banner {
	background-color: <?php echo $this->params->get("color75"); ?>;
	color: <?php echo $this->params->get("color76"); ?>;
}
.moduletable_banner a {
	color: <?php echo $this->params->get("color76"); ?>;
}

.moduletable_banner:hover {
	background-color: <?php echo $this->params->get("color77"); ?>;
	color: <?php echo $this->params->get("color78"); ?> !important;
}
.moduletable_banner:hover a, .moduletable_banner:hover * {
	color: <?php echo $this->params->get("color78"); ?> !important;
}

[class*="moduletable"] > h3 .h-cl {
	color: <?php echo $this->params->get("color79"); ?>;
}

.moduletable_menu > h3 {
	color: <?php echo $this->params->get("color80"); ?>;
}

.moduletable_menu .module-content {
	background: <?php echo $this->params->get("color81"); ?>;
}

.moduletable_menu ul.menu li a, .latestnews_menu li a, .VMmenu li div a {
	color: <?php echo $this->params->get("color82"); ?>;
}

.moduletable_menu ul.menu li a:hover, ul.latestnews_menu li a:hover, .VMmenu li div a:hover {
	color: <?php echo $this->params->get("color83"); ?>;
	background-color: <?php echo $this->params->get("color84"); ?>;
}

.moduletable_menu .VmOpen ul.menu li a, .moduletable_menu ul.menu li ul li a {
	color: <?php echo $this->params->get("color85"); ?>;
}

.moduletable_menu .VmOpen ul.menu li a:hover, .moduletable_menu ul.menu li ul li a:hover {
	color: <?php echo $this->params->get("color86"); ?>;
}

.customers-box-handler .owl-wrapper-outer {
	background-color: <?php echo $this->params->get("color87"); ?>;
	color: <?php echo $this->params->get("color88"); ?>;
}

#header-left-panel, #hl-open {
	background-color: <?php echo $this->params->get("color89"); ?>;
	color: <?php echo $this->params->get("color90"); ?> !important;
}

#header-left-panel h3, #header-left-panel a {
	color: <?php echo $this->params->get("color90"); ?> !important;
}

#header-left-panel .button {
	color: <?php echo $this->params->get("color90"); ?>;
	border-color: <?php echo $this->params->get("color90"); ?>;
}

#header-left-panel .button:hover {
	background-color: <?php echo $this->params->get("color90"); ?> !important;
	color: <?php echo $this->params->get("color89"); ?> !important;
	border-color: <?php echo $this->params->get("color90"); ?>;
}

#header-right-panel, #hr-open {
	background-color: <?php echo $this->params->get("color91"); ?>;
	color: <?php echo $this->params->get("color92"); ?> !important;
}

#header-right-panel h3, #header-right-panel a {
	color: <?php echo $this->params->get("color93"); ?> !important;
}

#header-right-panel .button:hover {
	background-color: <?php echo $this->params->get("color93"); ?> !important;
	color: <?php echo $this->params->get("color94"); ?> !important;
}

#footer {
    background-color: <?php echo $this->params->get("color95"); ?>;
    border-top-color: <?php echo $this->params->get("color96"); ?>;
	color: <?php echo $this->params->get("color97"); ?>;
}

#footer a {
	color: <?php echo $this->params->get("color98"); ?> !important;
}

#footer a:hover {
	color: <?php echo $this->params->get("color99"); ?> !important;
}
<?php endif; ?>
</style>
<?php if( $this->countModules('top-1 or top-2 or top-3 or top-4 or top-5 or top-6')) : 
	if( $this->countModules('top-1') ) $a[0] = 0;
	if( $this->countModules('top-2') ) $a[1] = 1;
	if( $this->countModules('top-3') ) $a[2] = 2;
	if( $this->countModules('top-4') ) $a[3] = 3;
	if( $this->countModules('top-5') ) $a[4] = 4;
	if( $this->countModules('top-6') ) $a[5] = 5; 
	$topmodules1 = count($a); 
	if ($topmodules1 == 1) $tm1class = "span12";
	if ($topmodules1 == 2) $tm1class = "span6";
	if ($topmodules1 == 3) $tm1class = "span4";
	if ($topmodules1 == 4) $tm1class = "span3";
	if ($topmodules1 == 5) { $tm1class = "span2"; $tm1class5w = "20.0%"; };
	if ($topmodules1 == 6) $tm1class = "span2";
	endif; 
	
	if( $this->countModules('top-7 or top-8 or top-9 or top-10 or top-11 or top-12')) : 
	if( $this->countModules('top-7') ) $b[0] = 0;
	if( $this->countModules('top-8') ) $b[1] = 1;
	if( $this->countModules('top-9') ) $b[2] = 2;
	if( $this->countModules('top-10') ) $b[3] = 3;
	if( $this->countModules('top-11') ) $b[4] = 4;
	if( $this->countModules('top-12') ) $b[5] = 5; 
	$topmodules2 = count($b); 
	if ($topmodules2 == 1) $tm2class = "span12";
	if ($topmodules2 == 2) $tm2class = "span6";
	if ($topmodules2 == 3) $tm2class = "span4";
	if ($topmodules2 == 4) $tm2class = "span3";
	if ($topmodules2 == 5) { $tm2class = "span2"; $tm2class5w = "17.9%"; };
	if ($topmodules2 == 6) $tm2class = "span2";
	endif; 
	
	if( $this->countModules('intro-1 or intro-2 or intro-3 or intro-4 or intro-5 or intro-6')) :
	if( $this->countModules('intro-1') ) $itr[0] = 0; 
	if( $this->countModules('intro-2') ) $itr[1] = 1; 
	if( $this->countModules('intro-3') ) $itr[2] = 2; 
	if( $this->countModules('intro-4') ) $itr[3] = 3; 
	if( $this->countModules('intro-5') ) $itr[4] = 4; 
	if( $this->countModules('intro-6') ) $itr[5] = 5; 
	$intromodules = count($itr); 
	if ($intromodules == 1) $introclass = "span12";
	if ($intromodules == 2) $introclass = "span6";
	if ($intromodules == 3) $introclass = "span4";
	if ($intromodules == 4) $introclass = "span3";
	if ($intromodules == 5) { $introclass = "span2"; $introclass5w = "17.7%"; };
	if ($intromodules == 6) $introclass = "span2";
	endif; 	

	if( $this->countModules('bottom-1 or bottom-2 or bottom-3 or bottom-4 or bottom-5 or bottom-6')) :
	if( $this->countModules('bottom-1') ) $c[0] = 0; 
	if( $this->countModules('bottom-2') ) $c[1] = 1; 
	if( $this->countModules('bottom-3') ) $c[2] = 2; 
	if( $this->countModules('bottom-4') ) $c[3] = 3; 
	if( $this->countModules('bottom-5') ) $c[4] = 4; 
	if( $this->countModules('bottom-6') ) $c[5] = 5; 
	$botmodules = count($c); 
	if ($botmodules == 1) $bmclass = "span12";
	if ($botmodules == 2) $bmclass = "span6";
	if ($botmodules == 3) $bmclass = "span4";
	if ($botmodules == 4) $bmclass = "span3";
	if ($botmodules == 5) { $bmclass = "span2"; $bmclass5w = "17.7%"; };
	if ($botmodules == 6) $bmclass = "span2";
	endif; 
	
	if( $this->countModules('bottom-7 or bottom-8 or bottom-9 or bottom-10 or bottom-11 or bottom-12')) :
	if( $this->countModules('bottom-7') ) $cb[0] = 0; 
	if( $this->countModules('bottom-8') ) $cb[1] = 1; 
	if( $this->countModules('bottom-9') ) $cb[2] = 2; 
	if( $this->countModules('bottom-10') ) $cb[3] = 3; 
	if( $this->countModules('bottom-11') ) $cb[4] = 4; 
	if( $this->countModules('bottom-12') ) $cb[5] = 5; 
	$botmodules2 = count($cb); 
	if ($botmodules2 == 1) $bm2class = "span12";
	if ($botmodules2 == 2) $bm2class = "span6";
	if ($botmodules2 == 3) $bm2class = "span4";
	if ($botmodules2 == 4) $bm2class = "span3";
	if ($botmodules2 == 5) { $bm2class = "span2"; $bm2class5w = "17.7%"; };
	if ($botmodules2 == 6) $bm2class = "span2";
	endif; 
	
	if( $this->countModules('top-a or top-b or top-c or top-d')) :
	if( $this->countModules('top-a') ) $d[0] = 0; 
	if( $this->countModules('top-b') ) $d[1] = 1; 
	if( $this->countModules('top-c') ) $d[2] = 2; 
	if( $this->countModules('top-d') ) $d[3] = 3; 
	$topamodules = count($d); 
	if ($topamodules == 1) $tpaclass = "span12";
	if ($topamodules == 2) $tpaclass = "span6";
	if ($topamodules == 3) $tpaclass = "span4";
	if ($topamodules == 4) $tpaclass = "span3";
	endif; 
	
	if( $this->countModules('bottom-a or bottom-b or bottom-c or bottom-d')) :
	if( $this->countModules('bottom-a') ) $e[0] = 0; 
	if( $this->countModules('bottom-b') ) $e[1] = 1; 
	if( $this->countModules('bottom-c') ) $e[2] = 2; 
	if( $this->countModules('bottom-d') ) $e[3] = 3; 
	$bottomamodules = count($e); 
	if ($bottomamodules == 1) $bmaclass = "span12";
	if ($bottomamodules == 2) $bmaclass = "span6";
	if ($bottomamodules == 3) $bmaclass = "span4";
	if ($bottomamodules == 4) $bmaclass = "span3";
	endif; 
	
	if( $this->countModules('top-right-1 or top-right-2 or position-6 or bottom-right-1 or bottom-right-2') && $this->countModules('top-left-1 or top-left-2 or position-7 or bottom-left-1 or bottom-left-2')  ) : $mcols = 'span5'; 
	elseif( $this->countModules('top-right-1 or top-right-2 or position-6 or bottom-right-1 or bottom-right-2') && !$this->countModules('top-left-1 or top-left-2 or position-7 or bottom-left-1 or bottom-left-2')  ) : $mcols = 'span8'; 
	elseif( !$this->countModules('top-right-1 or top-right-2 or position-6 or bottom-right-1 or bottom-right-2') && $this->countModules('top-left-1 or top-left-2 or position-7 or bottom-left-1 or bottom-left-2')  ) : $mcols = 'span9'; else : $mcols = 'span12'; endif; ?>
	<?php if ($this->direction == 'rtl') : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap-rtl.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template_rtl.css" media="screen" />
	
	<style type="text/css">
	@media (min-width: 1200px) {
		.row-fluid [class*="span"] {
			margin-right:2.564102564102564%;
			*margin-right:2.5109110747408616%;
		}
	}

	@media (min-width: 768px) and (max-width: 979px) {
		.row-fluid [class*="span"] {
			margin-right:2.564102564102564%;
			*margin-right:2.5109110747408616%;
		}
	}
	</style>
	<?php endif; ?>
	<?php
	$socials = false;
	if($this->params->get('twitterON') || $this->params->get('gplusON') || $this->params->get('facebookON') || $this->params->get('RSSON') || $this->params->get('linkedinON')  || $this->params->get('youtubeON') || $this->params->get('vimeoON') || $this->params->get('pinterestON')  || $this->params->get('instagramON') || $this->params->get('stumbleuponON') || $this->params->get('diggON') || $this->params->get('bloggerON') ) : 
	$socials = true;
	endif;
	?>
</head>
<body>
<div class="site-loading"></div>
<header id="top-navigation-bar">
	<div id="logo-handler">
		<?php if( $this->countModules('quick-contact')) : ?><div class="quick-contact"><jdoc:include type="modules" name="quick-contact" /></div><?php endif; ?>
		<?php if($this->params->get('logoLinked')) : ?><a href="<?php echo JURI::root(); ?>"><?php endif; ?>
		<img src="<?php echo $this->params->get("logoimage"); ?>" />
		<?php if($this->params->get('logoLinked')) : ?></a><?php endif; ?>
	</div>
	<div id="top-handler">
		<div id="sn-position">
			<?php if($this->params->get('logoLinked')) : ?>
			<?php if($this->params->get('H1TitleImgText') == true) : ?>
			<div class="h1"><a href="<?php echo JURI::root(); ?>"><img alt="<?php echo strip_tags($this->params->get("H1Title")); ?>" src="<?php echo $this->params->get("H1Titleimage"); ?>" /></a></div>
			<?php else : ?>
			<div class="h1"><a href="<?php echo JURI::root(); ?>"> <?php echo $this->params->get("H1Title"); ?></a></div>
			<?php endif; ?>
			<?php else : ?>
			<?php if($this->params->get('H1TitleImgText') == true) : ?>
			<div class="h1"><img alt="<?php echo strip_tags($this->params->get("H1Title")); ?>" src="<?php echo $this->params->get("H1Titleimage"); ?>" /></div>
			<?php else : ?>
			<div class="h1"> <?php echo $this->params->get("H1Title"); ?> </div>
			<?php endif; ?>
			<?php endif; ?>
			<?php if($this->params->get('H2TitleImgText') == true) : ?>
			<div class="h2"><img alt="<?php echo strip_tags($this->params->get("H2Title")); ?>" src="<?php echo $this->params->get("H2Titleimage"); ?>" /></div>
			<?php else : ?>
			<div class="h2"><?php echo $this->params->get("H2Title"); ?></div>
			<?php endif; ?>
		</div>
 <!--		<div id="quick-nav">
		
			<?php if( $this->countModules('cart')) : ?>
			<div class="cl-handler">
				<jdoc:include type="modules" name="cart" />
			</div>
			<?php endif; ?> !-->

		   	<?php if( $this->countModules('loginform')&JRequest::getVar("view", "null")!="vk") : ?>
			<ul class="log-panel">
                <jdoc:include type="modules" name="loginform" />

			</ul>
			<?php endif; ?><!--
			
			<?php if( $this->countModules('position-0')) : ?>
			<div id="search-position">
				<div id="searchOpenButton"><i class="fa fa-search"></i></div>
				<div id="searchpanel">
					<jdoc:include type="modules" name="position-0" />
				</div>
			</div>
			<?php endif; ?>
		
			<?php if( $this->countModules('quick-menu')) : ?>
			<div class="quick-menu">
				<div class="qm-open"> </div>
				<div class="quick-menu-handler"><jdoc:include type="modules" name="quick-menu" /></div>
			</div>
			<?php endif; ?>

		</div>!-->
	</div>
</header>

<section class="global-container">
	<div class=" global-left-handler">

		<div class="global-left-container">
		  <!--	<div class="left-handler">
				<?php if($this->params->get('keepfixed')==true) : ?><div class="keep-fixed"><?php endif; ?>
					<div id="rh-open-close">&nbsp;</div>
					<jdoc:include type="modules" name="quick-categories" />
				<?php if($this->params->get('keepfixed')==true) : ?></div><?php endif; ?>
				&nbsp;
			</div> !-->
			<?php /*<div class="right-handler">
				<div class="right-handler-inner">
					<div class="row-fluid">
						<?php if( $this->countModules('position-1')) : ?>
						<nav id="menu">
							<div id="menu-handler" class="row-fluid">
								<a href="JavaScript:;" id="menupanel"><span class="res-ico"><span class="s1 rm-line"></span><span class="s2 rm-line"></span><span class="s3 rm-line"></span></span><?php jimport( 'joomla.application.module.helper' ); $module_menu = JModuleHelper::getModules('position-1'); ?><?php echo $module_menu[0]->title; ?></a>
								<div class="responsive-menu"><jdoc:include type="modules" name="position-1" /></div>
							</div>
						</nav>
						<?php endif; ?>
						
						<?php if( $this->countModules('info-line')) : ?>
						<div class="info-line-handler">
							<jdoc:include type="modules" name="info-line" style="vmdefault" />
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>*/?>
		</div>
	

	
	</div>
	<div class="global-right-handler">

		<?php if( $this->countModules('builtin-slideshow or slideshow') ) : ?>
		<div id="slideshow-handler-bg">
			<div id="slideshow-handler"> 
				<?php if( $this->countModules('builtin-slideshow') ) : ?>
				<?php
				$count_slides = JDocumentHTML::countModules('builtin-slideshow');
				$module = JModuleHelper::getModules('builtin-slideshow');
				$moduleParams = new JRegistry();
				echo "<div class=\"camera_wrap\" id=\"ph-camera-slideshow\">"; 
				for($sld_a=0;$sld_a<$count_slides;$sld_a++) { 
					$moduleParams->loadString($module[$sld_a]->params);
					$bgimage[$sld_a] = $moduleParams->get('backgroundimage', 'defaultValue'); 
					$caption_effect[$sld_a] = $moduleParams->get('moduleclass_sfx', 'defaultValue'); 
				?>
				<div data-thumb="<?php if($bgimage[$sld_a] == "defaultValue") : echo $this->baseurl."/templates/".$this->template."/images/slideshow/no-image.png"; else : echo $this->baseurl."/".$bgimage[$sld_a]; endif; ?>" data-src="<?php if($bgimage[$sld_a] == "defaultValue") : echo $this->baseurl."/templates/".$this->template."/images/slideshow/no-image.png"; else : echo $this->baseurl."/".$bgimage[$sld_a]; endif; ?>">
				
					
					<div class="camera_caption title <?php if(($caption_effect[$sld_a] == "defaultValue")) : ?>fadeFromLeft<?php else: echo "fadeFromLeft ".$caption_effect[$sld_a]; endif; ?>" style="<?php if(empty($module[$sld_a]->title)) : ?>display:none !important;visibility: hidden !important; opacity: 0 !important;<?php endif; ?>">
						<div><div class="container-fluid"><div class="camera_caption_bg"><span><?php echo $module[$sld_a]->title; ?></span></div></div></div>
					</div>
				
					<div class="camera_caption <?php if(($caption_effect[$sld_a] == "defaultValue")) : ?>fadeFromRight<?php else: echo "fadeFromRight ".$caption_effect[$sld_a]; endif; ?>" style="<?php if(empty($module[$sld_a]->content)) : ?>display:none !important;visibility: hidden !important; opacity: 0 !important;<?php endif; ?>">
						<div><div class="container-fluid"><div class="camera_caption_bg"><?php echo $module[$sld_a]->content; ?></div></div></div>
					</div>
				</div>
				<?php } echo "</div>"; // End of camera_wrap ?> 
				<?php elseif( $this->countModules('slideshow') ) : ?>
				<div class="sl-3rd-parties">
					<jdoc:include type="modules" name="slideshow" />
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="inner-right-handler">
		
			<?php if( $this->countModules('position-2')) : ?>
			<div id="breadcrumb-line" class="container-fluid">
				<div class="row-fluid">
					<div class="span12" id="brcr"><jdoc:include type="modules" name="position-2" /></div>
				</div>
			</div>
			<?php endif; ?>
	
			<?php if( $this->countModules('tabs-1')) : 
			$count_tabs = JDocumentHTML::countModules('tabs-1');
			$tabs1 = JModuleHelper::getModules('tabs-1');
			?>
			<section id="tabs">
				<div class="container-fluid">
					<div id="tabs-1" class="nav-tabs-handler row-fluid tabbable">
					
						<ul class="nav nav-tabs" id="Tab1">
						<?php 
						for($tab_a=0;$tab_a<$count_tabs;$tab_a++) { 
						?>
						  <li <?php if($tab_a==0):?>class="active"<?php endif; ?>><a href="#tabid<?php echo $tabs1[$tab_a]->id; ?>" data-toggle="tab" title="<?php echo $tabs1[$tab_a]->title; ?>"><span class="visible-phone"><?php echo $tab_a; ?></span><span class="hidden-phone"><?php echo $tabs1[$tab_a]->title; ?></span></a></li>
						<?php } ?>
						</ul>
						<div class="tab-content">
							<jdoc:include type="modules" name="tabs-1" style="vmtab" />			
						</div>

						
						<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery( ".tab-content .tab-pane:first-child" ).addClass( "active" );
						});
						</script>

					</div>
				</div>
			</section>
			<?php endif; ?>
			
			<?php if( $this->countModules('top-1 or top-2 or top-3 or top-4 or top-5 or top-6')) : ?>
			<section id="tab-modules">
				<div class="container-fluid">
					<div id="tab-modules-handler" class="row-fluid">
						<?php if( $this->countModules('top-1')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-1" style="vmdefault" /></div><?php endif; ?>
						<?php if( $this->countModules('top-2')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-2" style="vmdefault" /></div><?php endif; ?>
						<?php if( $this->countModules('top-3')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-3" style="vmdefault" /></div><?php endif; ?>
						<?php if( $this->countModules('top-4')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-4" style="vmdefault" /></div><?php endif; ?>
						<?php if( $this->countModules('top-5')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-5" style="vmdefault" /></div><?php endif; ?>
						<?php if( $this->countModules('top-6')) : ?><div class="<?php echo $tm1class; ?>" style="<?php if ($topmodules1 == 5) {echo "width:".$tm1class5w;} ?>"><jdoc:include type="modules" name="top-6" style="vmdefault" /></div><?php endif; ?>
					</div>
				</div>
			</section>
			<?php endif; ?>

			<?php if( $this->countModules('top-long')) : ?>
			<div id="top-long">
				<div class="container-fluid">
					<div class="row-fluid">
						<div class="span8 offset2"><jdoc:include type="modules" name="top-long" style="vmdefault" /></div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			
			<?php if( $this->countModules('top-7 or top-8 or top-9 or top-10 or top-11 or top-12')) : ?>
			<section id="top-modules">
				<div class="container-fluid">
					<div class="row-fluid">
						<?php if( $this->countModules('top-7')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-7" style="vmdefault" /></div><?php endif; ?>
						<?php if( $this->countModules('top-8')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-8" style="vmdefault" /></div><?php endif; ?>
						<?php if( $this->countModules('top-9')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-9" style="vmdefault" /></div><?php endif; ?>
						<?php if( $this->countModules('top-10')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-10" style="vmdefault" /></div><?php endif; ?>
						<?php if( $this->countModules('top-11')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-11" style="vmdefault" /></div><?php endif; ?>
						<?php if( $this->countModules('top-12')) : ?><div class="<?php echo $tm2class; ?>" style="<?php if ($topmodules2 == 5) {echo "width:".$tm2class5w;} ?>"><jdoc:include type="modules" name="top-12" style="vmdefault" /></div><?php endif; ?>
					</div>
				</div>
			</section>
			<?php endif; ?>
			
			<div class="container-fluid">
				<div id="main-content-handler">
					<div class="row-fluid">
						<?php if( $this->countModules('top-left-1 or top-left-2 or position-7 or bottom-left-1 or bottom-left-2')) : ?>
						<div class="span3">
							<jdoc:include type="modules" name="top-left-1" style="vmdefault" />
							<jdoc:include type="modules" name="top-left-2" style="vmdefault" />
							<jdoc:include type="modules" name="position-7" style="vmdefault" />
							<jdoc:include type="modules" name="bottom-left-1" style="vmdefault" />
							<jdoc:include type="modules" name="bottom-left-2" style="vmdefault" />
						</div>
						<?php endif; ?>
						<div class="<?php echo $mcols; ?>">

							<?php if( $this->countModules('top-a or top-b or top-c or top-d')) : ?>
							<div id="top-content-modules">
								<div class="row-fluid">
									<?php if( $this->countModules('top-a')) : ?><div class="<?php echo $tpaclass; ?>"><jdoc:include type="modules" name="top-a" style="vmdefault" /></div><?php endif; ?>
									<?php if( $this->countModules('top-b')) : ?><div class="<?php echo $tpaclass; ?>"><jdoc:include type="modules" name="top-b" style="vmdefault" /></div><?php endif; ?>
									<?php if( $this->countModules('top-c')) : ?><div class="<?php echo $tpaclass; ?>"><jdoc:include type="modules" name="top-c" style="vmdefault" /></div><?php endif; ?>
									<?php if( $this->countModules('top-d')) : ?><div class="<?php echo $tpaclass; ?>"><jdoc:include type="modules" name="top-d" style="vmdefault" /></div><?php endif; ?>
								</div>
							</div>
							<?php endif; ?>
							<div class="tmp-content-area">
							
							<?php if(JFactory::getApplication()->getMessageQueue()) : ?>
							<div id="top-com-handler">
								<jdoc:include type="message" />
							</div>
							<?php endif; ?>
							
							<jdoc:include type="component" />
							</div>
							<?php if( $this->countModules('bottom-a or bottom-b or bottom-c or bottom-d')) : ?>
							<div id="bottom-content-modules">
								<div class="row-fluid">
									<?php if( $this->countModules('bottom-a')) : ?><div class="<?php echo $bmaclass; ?>"><jdoc:include type="modules" name="bottom-a" style="vmdefault" /></div><?php endif; ?>
									<?php if( $this->countModules('bottom-b')) : ?><div class="<?php echo $bmaclass; ?>"><jdoc:include type="modules" name="bottom-b" style="vmdefault" /></div><?php endif; ?>
									<?php if( $this->countModules('bottom-c')) : ?><div class="<?php echo $bmaclass; ?>"><jdoc:include type="modules" name="bottom-c" style="vmdefault" /></div><?php endif; ?>
									<?php if( $this->countModules('bottom-d')) : ?><div class="<?php echo $bmaclass; ?>"><jdoc:include type="modules" name="bottom-d" style="vmdefault" /></div><?php endif; ?>
								</div>	
							</div>
							<?php endif; ?>
							
							<?php if( $this->countModules('position-3')) :

							$testislitems = $this->params->get('testisl_items');
							$testislitemsDesktop = $this->params->get('testisl_itemsDesktop');
							$testislitemsDesktopSmall = $this->params->get('testisl_itemsDesktopSmall');
							$testislitemsTablet = $this->params->get('testisl_itemsTablet');
							$testislitemsTabletSmall = $this->params->get('testisl_itemsTabletSmall');
							$testislitemsMobile = $this->params->get('testisl_itemsMobile');
							if ($this->params->get('testisl_pagination')) : $testislpag = "true"; else : $testislpag = "false"; endif;


							if ($this->params->get('testisl_stopOnHover')) : $testislstopOnHover = "true"; else : $testislstopOnHover = "false"; endif;
							if ($this->params->get('testisl_navigation')) : $testislnavigation = "true"; else : $testislnavigation = "false"; endif;
							if ($this->params->get('testisl_scrollPerPage')) : $testislscrollPerPage = "true"; else : $testislscrollPerPage = "false"; endif;
							if ($this->params->get('testisl_paginationNumbers')) : $testislpaginationNumbers = "true"; else : $testislpaginationNumbers = "false"; endif;
							if ($this->params->get('testisl_responsive')) : $testislresponsive = "true"; else : $testislresponsive = "false"; endif;
							if ($this->params->get('testisl_dragBeforeAnimFinish')) : $testisldragBeforeAnimFinish = "true"; else : $testisldragBeforeAnimFinish = "false"; endif;
							if ($this->params->get('testisl_mouseDrag')) : $testislmouseDrag = "true"; else : $testislmouseDrag = "false"; endif;
							if ($this->params->get('testisl_touchDrag')) : $testisltouchDrag = "true"; else : $testisltouchDrag = "false"; endif;

							$temp_path = $this->baseurl."/templates/".$this->template; 

							$doc->addScript($temp_path.'/js/owl.carousel.min.js'); 
							$doc->addCustomTag('
								<script type="text/javascript">
								jQuery(document).ready(function() {
								  var owl = jQuery("#owl-id-testimonial");
								  owl.owlCarousel({
									pagination: '.$testislpag.',
									items: '.$testislitems.',
									itemsDesktop : [1600, '.$testislitemsDesktop.'],
									itemsDesktopSmall : [1260, '.$testislitemsDesktopSmall.'],
									itemsTablet : [1000, '.$testislitemsTablet.'],
									itemsTabletSmall : [768, '.$testislitemsTabletSmall.'],
									itemsMobile : [480, '.$testislitemsMobile.'],
									
									slideSpeed: '.$this->params->get('testisl_slideSpeed').',
									paginationSpeed: '.$this->params->get('testisl_paginationSpeed').',
									rewindSpeed: '.$this->params->get('testisl_rewindSpeed').',
									
									autoPlay: '.$this->params->get('testisl_autoPlay').',
									stopOnHover: '.$testislstopOnHover.',
									navigation: '.$testislnavigation.',
									scrollPerPage: '.$testislscrollPerPage.',
									paginationNumbers: '.$testislpaginationNumbers.',
									responsive: '.$testislresponsive.',
									responsiveRefreshRate: '.$this->params->get('testisl_responsiveRefreshRate').',
									dragBeforeAnimFinish: '.$testisldragBeforeAnimFinish.',
									mouseDrag: '.$testislmouseDrag.',
									touchDrag: '.$testisltouchDrag.'
									
								  });
								});
								</script>
							');	

							?>
							<section id="testimonials">
							<div id="customers-box">
								<div class="container-fluid">
									<div class="row-fluid">
										<div class="span12">
											<div class="customers-box-handler moduletable">
												<h3 class="testi-title"><?php
													$title = $this->params->get('testi_title');
													$title = explode(' ', $title);
													$title[0] = '<span class="h-cl">'.$title[0].'</span>';
													$title= join(' ', $title);
													echo $title; ?></h3>
												<div class="owl-carousel owl-theme" id="owl-id-testimonial">
													<jdoc:include type="modules" name="position-3" style="testimonial" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							</section>
							<?php endif; ?>
							
							<?php if( $this->countModules('bottom-long')) : ?>
							<section id="bottom-long" class="container-fluid">
								<div class="row-fluid">
									<div class="span12">
										<jdoc:include type="modules" name="bottom-long" style="vmdefault" />
									</div>
								</div>
							</section>
							<?php endif; ?>
							
							
						</div>
						<?php if( $this->countModules('top-right-1 or top-right-2 or position-6 or bottom-right-1 or bottom-right-2')) : ?>
						<div class="span4">
							<jdoc:include type="modules" name="top-right-1" style="vmdefault" />
							<jdoc:include type="modules" name="top-right-2" style="vmdefault" />
							<jdoc:include type="modules" name="position-6" style="vmdefault" />
							<jdoc:include type="modules" name="bottom-right-1" style="vmdefault" />
							<jdoc:include type="modules" name="bottom-right-2" style="vmdefault" />
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
						
			<?php if( $this->countModules('bottom-1 or bottom-2 or bottom-3 or bottom-4 or bottom-5 or bottom-6 or bottom-7 or bottom-8 or bottom-9 or bottom-10 or bottom-11 or bottom-12')  ) : ?>
			<section id="bottom-bg">
				<div class="container-fluid">

					<?php if( $this->countModules('bottom-1 or bottom-2 or bottom-3 or bottom-4 or bottom-5 or bottom-6')) : ?>
					<div id="bot-modules">
						<div class="row-fluid">
							<?php if( $this->countModules('bottom-1')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-1" style="vmdefault" /></div><?php endif; ?>
							<?php if( $this->countModules('bottom-2')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-2" style="vmdefault" /></div><?php endif; ?>
							<?php if( $this->countModules('bottom-3')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-3" style="vmdefault" /></div><?php endif; ?>
							<?php if( $this->countModules('bottom-4')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-4" style="vmdefault" /></div><?php endif; ?>
							<?php if( $this->countModules('bottom-5')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-5" style="vmdefault" /></div><?php endif; ?>
							<?php if( $this->countModules('bottom-6')) : ?><div class="<?php echo $bmclass; ?>" style="<?php if ($botmodules == 5) {echo "width:".$bmclass5w;} ?>"><jdoc:include type="modules" name="bottom-6" style="vmdefault" /></div><?php endif; ?>
						</div>
					</div>
					<div class="clear"> </div>
					<?php endif; ?>
					<?php if( $this->countModules('bottom-7 or bottom-8 or bottom-9 or bottom-10 or bottom-11 or bottom-12')) : ?>
					<div id="bot-modules-2">
						<div class="row-fluid">
							<?php if( $this->countModules('bottom-7')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-7" style="vmdefault" /></div><?php endif; ?>
							<?php if( $this->countModules('bottom-8')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-8" style="vmdefault" /></div><?php endif; ?>
							<?php if( $this->countModules('bottom-9')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-9" style="vmdefault" /></div><?php endif; ?>
							<?php if( $this->countModules('bottom-10')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-10" style="vmdefault" /></div><?php endif; ?>
							<?php if( $this->countModules('bottom-11')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-11" style="vmdefault" /></div><?php endif; ?>
							<?php if( $this->countModules('bottom-12')) : ?><div class="<?php echo $bm2class; ?>" style="<?php if ($botmodules2 == 5) {echo "width:".$bm2class5w;} ?>"><jdoc:include type="modules" name="bottom-12" style="vmdefault" /></div><?php endif; ?>
						</div>
					</div>
					<div class="clear"> </div>
					<?php endif; ?>
				</div>
			</section>
			<?php endif; ?>
		
		</div>
		<!-- END OF RIGHT COLUMN -->
	</div>
</section>
<footer id="footer">
	<div class="footer-handler">
		<div class="container-fluid">
			<?php if( $this->countModules('footer or footer-left or footer-right') || $socials ) : ?>
			<div id="footer-line" class="row-fluid">
				<?php if( $this->countModules('footer-left or footer-right') || $socials ) : ?>
				<div id="foo-left-right">
					<?php if( $this->countModules('footer-left')) : ?><div class="<?php if( $this->countModules('footer-left and footer-right') ) : ?>span6<?php else: ?>span12<?php endif;?>"><jdoc:include type="modules" name="footer-left" />
					<?php if( $socials ) : ?><a data-toggle="modal" href="#socialModal" class="open-social-links"><i class="fa fa-heart"></i> <?php echo $this->params->get('FollowUsLabel'); ?></a><?php endif; ?>
					</div><?php endif; ?>
					<?php if( $this->countModules('footer-right')) : ?>
					<div class="<?php if( $this->countModules('footer-left and footer-right') ) : ?>span6<?php else: ?>span12<?php endif;?>">
						<jdoc:include type="modules" name="footer-right" />
						
					</div>
					<?php endif; ?>
					<div class="clear"> </div>
				</div>
				<?php endif; ?>
				<?php if( $this->countModules('footer')) : ?><div class="row-fluid"><div class="span12"><jdoc:include type="modules" name="footer" /></div></div><?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="footer-line-cover"> </div>
</footer>


<?php if( $this->countModules('loginform')) : ?>
<div id="LoginForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-header"><span id="myModalLabel"><?php //echo $module_login[0]->title; ?></span> <a class="close-lgform-button" data-dismiss="modal">&times;</a></div>
	<div class="modal-body"><jdoc:include type="modules" name="loginform" /></div>
</div>
<?php endif; ?>

<?php if( $this->countModules('header-left') ) : ?>
<div id="header-left-handler">
	<div id="header-left-panel"><div id="hl-panel-handler"><jdoc:include type="modules" name="header-left" style="vmdefault" /></div></div>
	<div id="hl-open"><div id="hl-open-label"><?php jimport( 'joomla.application.module.helper' ); $module_hl = JModuleHelper::getModules('header-left'); ?><?php echo $module_hl[0]->title; ?> &nbsp;<i class="fa fa-arrow-circle-o-up"></i>
</div></div>
</div>
<?php endif; ?>

<?php if( $this->countModules('header-right') ) : ?>
<div id="header-right-handler">
	<div id="header-right-panel"><div id="hr-panel-handler"><jdoc:include type="modules" name="header-right" style="vmdefault" /></div></div>
	<div id="hr-open"><div id="hr-open-label"><?php jimport( 'joomla.application.module.helper' ); $module_hr = JModuleHelper::getModules('header-right'); ?><?php echo $module_hr[0]->title; ?></div></div>
</div>
<?php endif; ?>

<?php if( $socials ) : ?>
<div id="socialModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none;">
	<div class="modal-header"><span id="myModalLabel2"><?php echo $this->params->get('FollowUsLabel'); ?></span><a class="Follow-Us-close" data-dismiss="modal">&times;</a></div>
	<div class="modal-body">
		<ul id="social-links">
			<?php if($this->params->get('twitterON') == true ) : ?><li><a href="<?php echo $this->params->get('twitter'); ?>" title="Twitter" id="twitter" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/twitter.png"></span></a></li><?php endif; ?>
			<?php if($this->params->get('gplusON') == true ) : ?><li><a href="<?php echo $this->params->get('gplus'); ?>" title="Google Plus" id="gplus" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/gplus.png"></span></a></li><?php endif; ?>
			<?php if($this->params->get('facebookON') == true ) : ?><li><a href="<?php echo $this->params->get('facebook'); ?>" title="Facebook" id="facebook" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/facebook.png"></span></a></li><?php endif; ?>
			<?php if($this->params->get('RSSON') == true ) : ?><li><a href="<?php echo $this->params->get('RSS'); ?>" title="RSS" id="rss" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/rss.png"></span></a></li><?php endif; ?>
			<?php if($this->params->get('linkedinON') == true ) : ?><li><a href="<?php echo $this->params->get('linkedin'); ?>" title="Linkedin" id="linkedin" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/linkedin.png"></span></a></li><?php endif; ?>
			<?php if($this->params->get('youtubeON') == true ) : ?><li><a href="<?php echo $this->params->get('youtube'); ?>" title="youtube" id="youtube" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/youtube.png"></span></a></li><?php endif; ?>
			<?php if($this->params->get('vimeoON') == true ) : ?><li><a href="<?php echo $this->params->get('vimeo'); ?>" title="vimeo" id="vimeo" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/vimeo.png"></span></a></li><?php endif; ?>
			
			<?php if($this->params->get('pinterestON') == true ) : ?><li><a href="<?php echo $this->params->get('pinterest'); ?>" title="pinterest" id="pinterest" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/pinterest.png"></span></a></li><?php endif; ?>
			<?php if($this->params->get('instagramON') == true ) : ?><li><a href="<?php echo $this->params->get('instagram'); ?>" title="instagram" id="instagram" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/instagram.png"></span></a></li><?php endif; ?>
			
			<?php if($this->params->get('stumbleuponON') == true ) : ?><li><a href="<?php echo $this->params->get('stumbleupon'); ?>" title="stumbleupon" id="stumbleupon" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/stumbleupon.png"></span></a></li><?php endif; ?>
			<?php if($this->params->get('diggON') == true ) : ?><li><a href="<?php echo $this->params->get('digg'); ?>" title="digg" id="digg" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/digg.png"></span></a></li><?php endif; ?>
			<?php if($this->params->get('bloggerON') == true ) : ?><li><a href="<?php echo $this->params->get('blogger'); ?>" title="Blogger" id="blogger" target="_blank"><span><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/blogger.png"></span></a></li><?php endif; ?>
		</ul>
	</div>
</div>
<?php endif; ?>

<?php if($this->params->get("bodybackgroundimage") || $this->params->get("top_long") || $this->params->get("customers_box") ) : ?>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.backstretch.min.js"></script>
<script type="text/javascript">
<?php if($this->params->get("bodybackgroundimage")) : ?>
jQuery.backstretch("<?php echo JURI::base().$this->params->get("bodybackgroundimage"); ?>");
<?php endif; ?>

</script>
<?php endif; ?>

<jdoc:include type="modules" name="debug" />
<?php echo $this->params->get("footercode"); ?>
<div><img src="https://mc.yandex.ru/watch/42979944" style="position:absolute; left:-9999px;" alt="" /></div>
</body>
</html>