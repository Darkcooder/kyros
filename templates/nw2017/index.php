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

	<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/style.css" media="screen" />


<?php
	if( $this->countModules('top-1') ) $a[0] = 0;
	if( $this->countModules('top-2') ) $a[1] = 1;
	if( $this->countModules('top-3') ) $a[2] = 2;
	if( $this->countModules('top-4') ) $a[3] = 3;
	if( $this->countModules('top-5') ) $a[4] = 4;
	if( $this->countModules('top-6') ) $a[5] = 5;
	$topmodules1 = count($a);
	?>
</head>
<body>
<div class="site-loading"></div>
<header id="header">
	<div id="logo">
		<img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/logo.png" />
	</div>
    <div id="title"><jdoc:include type="modules" name="title" /></div>
</header>

<section class="global">
	<div class=" global-left">
        <jdoc:include type="modules" name="menu" />
	</div>
	<div class="main">
        <jdoc:include type="component" />
	    
	</div>
</section>
<footer id="footer">
	<div class="footer-handler">
		<jdoc:include type="modules" name="bar" />
	</div>
	<div class="footer-line-cover"> </div>
</footer>
</body>
</html>