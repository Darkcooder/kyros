<?php
$app  = JFactory::getApplication();
$doc  = JFactory::getDocument();
$user = JFactory::getUser();
$templateparams = $app->getTemplate(true)->params;
$this->language = $doc->language;
$this->direction = $doc->direction;
$menu = $app->getMenu();

//add class page
$itemid = JRequest::getVar('Itemid');
$active = $menu->getItem($itemid);
$params = $menu->getParams( $active->id );
$pageclass = $params->get( 'pageclass_sfx' );


// Social icons
$soc = array(
	"fa-twitter" => $this->params->get("twitter"),
	"fa-facebook" => $this->params->get("facebook"),
	"fa-flickr" => $this->params->get("flickr"),
	"fa-linkedin" => $this->params->get("linkedin"),
	"fa-youtube-play" => $this->params->get("youtube"),
	"fa-pinterest" => $this->params->get("pinterest"),
	"fa-google-plus" => $this->params->get("google"),
	"fa-dribbble" => $this->params->get("dribbble"),
	"fa-vimeo-square" => $this->params->get("vimeo"),
	"fa-instagram" => $this->params->get("instagram"),
	"fa-vk" => $this->params->get("vk")
); 

// count Modules
$left	 = $this->countModules('SidebarLeft');
$right   = $this->countModules('SidebarRight');
$search  = $this->countModules('Search');
$topmenu = $this->countModules('topMenu');
$copyrights = $this->params->get("copyrights");

// Add Stylesheets
$doc->addStyleSheet($this->baseurl."/templates/".$this->template."/bootstrap/css/bootstrap.css");
$doc->addStyleSheet($this->baseurl."/templates/".$this->template."/bootstrap/css/bootstrap-responsive.css");
$doc->addStyleSheet($this->baseurl."/templates/".$this->template."/css/font-awesome.css");
$doc->addStyleSheet($this->baseurl."/templates/".$this->template."/css/style.css");

// Add Script
$doc->addScript($this->baseurl."/templates/".$this->template."/javascript/custom.js");
if(version_compare(JVERSION,"3.0.0","ge")){
    JHtml::_('bootstrap.framework');
}  else {
    $doc->addScript($this->baseurl."/templates/".$this->template."/bootstrap/js/bootstrap-joomin.js");
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/javascript/jquery.min.js"></script>
	<script type="text/javascript">jQuery.noConflict();</script>


<script type="text/javascript" src="<?php echo $this->baseurl ?>/media/system/js/mootools-core.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/media/system/js/core.js"></script>



<link href='http://fonts.googleapis.com/css?family=Comfortaa:400,300,700|Abel|Dosis:400,200,300,500,600,700,800|Droid+Sans:400,700|Francois+One|Lato:400,100,300,400italic,300italic,100italic,700,700italic,900,900italic|Lobster|Lora:400,400italic,700,700italic|Open+Sans+Condensed:300,300italic,700|Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800italic,800|Oswald:400,300,700|Oxygen:400,300,700|PT+Sans+Narrow:400,700|PT+Sans:400,400italic,700,700italic|Prosto+One|Quicksand:400,300,700|Roboto+Condensed:400,300,300italic,400italic,700,700italic|Share:400,400italic,700,700italic|Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic|Ubuntu+Condensed|Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic|Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>

 <jdoc:include type="head" />
<script type="text/javascript"><?php echo $this->params->get('tracking_code')?></script>
<!--[if IE 7]> <link type="text/css" rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/style_ie7.css" /> <![endif]-->
<!--[if IE 8]> <link type="text/css" rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/style_ie8.css" /> <![endif]-->
<!--[if IE 9]> <link type="text/css" rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/style_ie9.css" /> <![endif]-->
</head>
<style type="text/css">
body {
    font-family:<?php echo $this->params->get('body_font', 'Arial, sans-serif') ?>;
    background-color:<?php echo $this->params->get('body_color')?>; 
    background-image: url('<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/<?php echo $this->params->get('body_background')?>');
}
a {
    color:<?php echo $this->params->get('body_link_color')?>;
    text-decoration:<?php echo $this->params->get('body_underline', 'underline')?>;
    font-family:<?php echo $this->params->get('links_font', 'Arial, sans-serif')?>;
}
a:hover {
    color:<?php echo $this->params->get('body_link_hover_color')?>;
    text-decoration:<?php echo $this->params->get('body_hover_underline')?>;
}
.top_menu .navbar li a {
    color:<?php echo $this->params->get('top_menu_color')?>;
    text-decoration:<?php echo $this->params->get('top_menu_underline', 'underline')?>;
    font-family:<?php echo $this->params->get('top_menu_font', 'Arial, sans-serif')?>;
}
.top_menu .navbar li a:hover {
    color:<?php echo $this->params->get('top_menu_hover_color')?>;
    text-decoration:<?php echo $this->params->get('top_menu_hover_underline')?>;
} 
.main_menu .navbar li a {
    color:<?php echo $this->params->get('main_menu_color')?>;
    text-decoration:<?php echo $this->params->get('main_menu_underline', 'underline')?>;
    font-family:<?php echo $this->params->get('main_menu_font', 'Arial, sans-serif')?>;
}
.main_menu .navbar li a:hover {
    color:<?php echo $this->params->get('main_menu_hover_color')?>;
    text-decoration:<?php echo $this->params->get('main_menu_hover_underline')?>;
}
.footer_menu .navbar li a {
    color:<?php echo $this->params->get('menu_footer_color')?>;
    text-decoration:<?php echo $this->params->get('menu_footer_underline', 'underline')?>;
    font-family:<?php echo $this->params->get('footer_menu_font', 'Arial, sans-serif')?>;
}
.footer_menu .navbar li a:hover {
    color:<?php echo $this->params->get('menu_footer_hover_color')?>;
    text-decoration:<?php echo $this->params->get('menu_footer_hover_underline')?>;
}
h1 {font-family:<?php echo $this->params->get('h1_font', 'Arial, sans-serif')?>;}
h2 {font-family:<?php echo $this->params->get('h2_font', 'Arial, sans-serif')?>;}
h3 {font-family:<?php echo $this->params->get('h3_font', 'Arial, sans-serif')?>;}
h4 {font-family:<?php echo $this->params->get('h4_font', 'Arial, sans-serif')?>;}
h5 {font-family:<?php echo $this->params->get('h5_font', 'Arial, sans-serif')?>;}
h6 {font-family:<?php echo $this->params->get('h6_font', 'Arial, sans-serif')?>;}
</style>

<body class=" <?php echo $pageclass; ?>">
	<div class="header">
		<div id="header">
			<div class="top_line">
				<div class="container">
					<div  class="row-fluid">
					  <div class="soc_icons_box span4">
					      <ul class="soc_icons" >
					      <?php foreach($soc as $key => $value) {
						 if ($value != null) { ?>
						    <li><a href="<?php echo $value ?>" class="fa <?php echo $key ?>" target="_blank" rel="nofollow"></a></li>
					      <?php } } ?>
					      </ul>
					  </div>
					<?php //if ($this->countModules('position-0')): ?>
						<div class="span4 top_phone"><jdoc:include type="modules" name="position-0" style="xhtml" /></div>
					<?php //endif; ?>

				  <?php if ($search): ?>
				  	<div id="Search" class="span4"><jdoc:include type="modules" name="Search" style="xhtml" /></div>
				  <?php endif; ?>
			  </div>
			 </div>
			</div>	
			<div class="container">
			    <?php if ($this->countModules('Top1') || $this->countModules('Top2') || $this->countModules('Top3') || $this->countModules('Top4')): ?>
				<div class="row-fluid">
					<div class="span3"><jdoc:include type="modules" name="Top1" style="xhtml" /></div>
					<div class="span3"><jdoc:include type="modules" name="Top2" style="xhtml" /></div>
					<div class="span3"><jdoc:include type="modules" name="Top3" style="xhtml" /></div>
					<div class="span3"><jdoc:include type="modules" name="Top4" style="xhtml" /></div>
				</div>
			      <?php endif; ?>

			     <div class="row-fluid">
				<div class="span4">
				    <div id="logo">
					  <a href="<?php echo $this->params->get('logo_link')?>">
					      <img style="width:<?php echo $this->params->get('logo_width')?>px; height:<?php echo $this->params->get('logo_height')?>px; " src="<?php echo $this->params->get('logo_file')?>" alt="Logo" />
					  </a>
				    </div>
				</div>
				<?php if ($this->countModules('Mainmenu')): ?>
				    <div class="main_menu span8">
					    <div class="navbar">
						    <div class="container">
							    <a class="btn btn-navbar" data-toggle="collapse" data-target=".main-collapse">
							      <span class="icon-bar"></span>
							      <span class="icon-bar"></span>
							      <span class="icon-bar"></span>
							    </a>
							    <div class="main-collapse nav-collapse collapse">
								<jdoc:include type="modules" name="Mainmenu" style="xhtml" />
							    </div>
						    </div>
					    </div>
				    </div>
				 <?php endif; ?>
			      </div>
		</div>
			</div> <!--id header-->
		 </div> <!--class header-->

		 
	 	<?php if ($this->countModules('position-1') || $this->countModules('position-3')): ?>
	 	  <div class="bg_top">
		 	<div class="container">
				<div class="row-fluid">
					<div class="span12">
						<jdoc:include type="modules" name="position-1" style="xhtml" />
						<div class="pos-3"><jdoc:include type="modules" name="position-3" style="xhtml" /></div>
					</div>
				</div>
			</div>
		  </div>	
		<?php endif; ?>
		 
		<?php if ($this->countModules('position-2')): ?>
		 	<div class="container">
				<div class="row-fluid">
					<div class="span12 pos-2">
						<jdoc:include type="modules" name="position-2" style="xhtml" />
					</div>
				</div>
			</div>	
		<?php endif; ?>

		<?php if ($this->countModules('position-4')): ?>
		 	<div class="container">
				<div class="row-fluid">
					<div class="span12 pos-4">
						<jdoc:include type="modules" name="position-4" style="xhtml" />
					</div>
				</div>
			</div>	
		<?php endif; ?>

		<?php if ($this->countModules('position-7')): ?>
		 	<div class="container">
				<div class="row-fluid">
					<div class="span12 pos-7">
						<jdoc:include type="modules" name="position-7" style="xhtml" />
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ($this->countModules('position-6')): ?>
		 	<div class="container">
				<div class="row-fluid">
					<div class="span12 pos-6">
						<jdoc:include type="modules" name="position-6" style="xhtml" />
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ($this->countModules('position-5')): ?>
			<div class="bg_middle">
			 	<div class="container">
					<div class="row-fluid">
						<div class="span12 pos-5">
							<jdoc:include type="modules" name="position-5" style="xhtml" />
						</div>
					</div>
				</div>
			</div>	
		<?php endif; ?>

		<div id="wrapper" class="container">
			<?php if ($this->countModules('Breadcrumbs')): ?>
				<div class="row-fluid">
					<div class="span12">
						<jdoc:include type="modules" name="Breadcrumbs" style="xhtml" />
					</div>
				</div>
			      <?php endif; ?>
			      <?php if ($this->countModules('Slideshow')): ?>
					<div class="row-fluid">
						<div class="span12">
						    <jdoc:include type="modules" name="Slideshow" style="xhtml" />
						</div>
					</div>
			      <?php endif; ?>

			      <?php if ($this->countModules('Feature1') || $this->countModules('Feature2') || $this->countModules('Feature3')): ?>
				<div class="row-fluid">
					<div class="span4">
						<jdoc:include type="modules" name="Feature1" style="xhtml" />
					</div>
					<div class="span4">
						<jdoc:include type="modules" name="Feature2" style="xhtml" />
					</div>
					<div class="span4">
						<jdoc:include type="modules" name="Feature3" style="xhtml" />
					</div>
				</div>
			      <?php endif; ?>

				<div id="globalContent">

					<?php if ($this->countModules('ContentTop1') || $this->countModules('ContentTop2')): ?>
						<div class="row-fluid">
							<div class="span6">
								<jdoc:include type="modules" name="ContentTop1" style="xhtml" />
							</div>
							<div class="span6">
								<jdoc:include type="modules" name="ContentTop2" style="xhtml" />
							</div>
						</div>
					<?php endif; ?>

				<div class="row-fluid">
					<?php if ($left): ?>
					      <div class="sidebar-left span3"><jdoc:include type="modules" name="SidebarLeft" style="xhtml" /></div>
					<?php endif; ?>

						<div id="contentBox" class="<?php if ($left && $right) {print('span6');} else if ($left xor $right) {print('span9');} else {print('span12');} ?>">
							<jdoc:include type="modules" name="location_map" style="xhtml" />
							<div><jdoc:include type="message" /></div>
							<div><jdoc:include type="component" /></div>	
						</div>

					<?php if ($right): ?>
					      <div class="sidebar-right span3"><jdoc:include type="modules" name="SidebarRight" style="xhtml" /></div>
					<?php endif; ?>
				</div>

				<?php if ($this->countModules('position-8')): ?>
				 	<div class="container">
						<div class="row-fluid">
							<div class="span12 pos-8">
								<jdoc:include type="modules" name="position-8" style="xhtml" />
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($this->countModules('position-9')): ?>
				 	<div class="container">
						<div class="row-fluid">
							<div class="span12 pos-9">
								<jdoc:include type="modules" name="position-9" style="xhtml" />
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($this->countModules('position-11') || $this->countModules('position-12') || $this->countModules('position-13')): ?>
					<div class="row-fluid">
						<div class="span4 pos-11">
							<jdoc:include type="modules" name="position-11" style="xhtml" />
						</div>
						<div class="span4 pos-12">
							<jdoc:include type="modules" name="position-12" style="xhtml" />
						</div>
						<div class="span4 pos-13">
							<jdoc:include type="modules" name="position-13" style="xhtml" />
						</div>
					</div>
				<?php endif; ?>

				<?php if ($this->countModules('position-10')): ?>
					<div class="row-fluid">
						<div class="span12 pos-10">
							<jdoc:include type="modules" name="position-10" style="xhtml" />
						</div>
					</div>
				<?php endif; ?>

				<?php if ($this->countModules('ContentBottom1') || $this->countModules('ContentBottom2')): ?>
					<div class="row-fluid">
						<div class="span6">
							<jdoc:include type="modules" name="ContentBottom1" style="xhtml" />
						</div>
						<div class="span6">
							<jdoc:include type="modules" name="ContentBottom2" style="xhtml" />
						</div>
					</div>
				<?php endif; ?>

				</div> <!--globalContent-->

			    <?php if ($this->countModules('Bottom1') || $this->countModules('Bottom2') || $this->countModules('Bottom3') || $this->countModules('Bottom4')): ?>
				<div class="row-fluid">
					<div class="span3">
						<jdoc:include type="modules" name="Bottom1" style="xhtml" />
					</div>
					<div class="span3">
						<jdoc:include type="modules" name="Bottom2" style="xhtml" />
					</div>
					<div class="span3">
						<jdoc:include type="modules" name="Bottom3" style="xhtml" />
					</div>
					<div class="span3">
						<jdoc:include type="modules" name="Bottom4" style="xhtml" />
					</div>
				</div>
			    <?php endif; ?>
		</div> <!--wrapper-->

		<div id="footer">
		    <div class="container">
			<?php if ($this->countModules('footerMenu')): ?>
			    <div class="row-fluid">
				<div class="footer_menu">
					<div class="navbar">
						<div class="container">
							<a class="btn btn-navbar" data-toggle="collapse" data-target=".footer-collapse">
							   <span class="icon-bar"></span>
							   <span class="icon-bar"></span>
							   <span class="icon-bar"></span>
							</a>
							<div class="footer-collapse nav-collapse collapse">
							    <jdoc:include type="modules" name="footerMenu" style="xhtml" />
							</div>
						</div>
					</div>
				</div>
			    </div>
			<?php endif; ?>

			<?php if ($this->countModules('Footer1') || $this->countModules('Footer2') || $this->countModules('Footer3') || $this->countModules('Footer4')): ?>
				<div class="row-fluid">
					<div class="span3 foo"><jdoc:include type="modules" name="Footer1" style="xhtml" /></div>
					<div class="span3 foo"><jdoc:include type="modules" name="Footer2" style="xhtml" /></div>
					<div class="span3 foo"><jdoc:include type="modules" name="Footer3" style="xhtml" /></div>
					<div class="span3 foo"><jdoc:include type="modules" name="Footer4" style="xhtml" /></div>
				</div>
			<?php endif; ?>

			 <div class="content_footer row-fluid">
			  <div class="copyrights span6"><?php echo $copyrights; ?></div>
			  <div class="soc_icons_box span6">
			      <ul class="soc_icons" >
			      <?php foreach($soc as $key => $value) {
				 if ($value != null) { ?>
				    <li><a href="<?php echo $value ?>" class="fa <?php echo $key ?>" target="_blank" rel="nofollow"></a></li>
			      <?php } } ?>
			      </ul>
			  </div>
			  </div> <!--content_footer-->

				<?php if ($this->countModules('position-14') || $this->countModules('debug')): ?>
						<div class="row-fluid">
							<div class="span6"><jdoc:include type="modules" name="position-14" style="xhtml" /></div>
						</div>
						<div class="span12"><jdoc:include type="modules" name="debug" style="xhtml" /></div>
					</div>
				<?php endif; ?>
		    </div> 
		</div> <!--id footer-->
	</body>
</html>