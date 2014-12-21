<!doctype html>

<html <?=$this->theme->getClassAttributeFor("html", "no-js {$this->request->getRouteAsCssClass()}");?> lang='<?=$lang?>'>

<head>
<meta charset='utf-8'/>
<title><?=$title . $title_append?></title>
<?php if(isset($favicon)): ?><link rel='icon' href='<?=$this->url->asset($favicon)?>'/><?php endif; ?>
<?php foreach($stylesheets as $stylesheet): ?>
<link rel='stylesheet' type='text/css' href='<?=$this->url->asset($stylesheet)?>'/>
<?php endforeach; ?>
<?php if(isset($style)): ?><style><?=$style?></style><?php endif; ?>
<script src='<?=$this->url->asset($modernizr)?>'></script>
</head>

<!-- body -->
<body <?=$this->theme->getClassAttributeFor("body")?>>

<div id='wrapper'>
    
<!-- header -->
<header id='wrapper--header' class='t-clearfix'>
    <div id='header'>
    <?php if(isset($header)) echo $header?>
    <?php $this->views->render('header')?>
    </div>
    <!-- navbar TODO why is code not needed?-->
    <?php if ($this->views->hasContent('navbar')) : ?>
    <div id='navbar'>
    <?php $this->views->render('navbar')?>
    </div>
    <?php endif; ?>
    <!-- <p>.</p> -->
</header>
<!-- flash -->
<?php if ($this->views->hasContent('flash')) : ?>
<div id='flash'><?php $this->views->render('flash')?></div>
<?php endif; ?>
<!-- featured 1-3 -->
<?php if ($this->views->hasContent('featured-1', 'featured-2', 'featured-3')) : ?>
<div id='wrap-featured'>
    <div id='featured-1'><?php $this->views->render('featured-1')?></div>
    <div id='featured-2'><?php $this->views->render('featured-2')?></div>
    <div id='featured-3'><?php $this->views->render('featured-3')?></div>
</div>
<?php endif; ?>

<!-- #sidebar--left, #main, #sidebar--right, or -->
<!-- #sidebar--left, #main, or -->
<!-- #main, #sidebar--right or -->
<!-- #main -->
<div id='wrap-main' >
    <!-- sidebar fix, there is no css selector that selects the previous element-->
    <!-- To make it possible to style main to full width (all columns) when aside is not present. -->
    <?php if ($this->views->hasContent('sidebar--left') && $this->views->hasContent('sidebar--right')) : ?>
    <div id='sidebar--both--fix' hidden></div>
    <?php else: ?>
        <?php if($this->views->hasContent('sidebar--right')): ?>
            <div id='sidebar--only-right--fix' hidden></div>
        <?php endif; ?>    
    <?php endif; ?>
    <!-- sidebar--left -->
    <?php if ($this->views->hasContent('sidebar--left')) : ?>
    <div id='sidebar--left'><?php $this->views->render('sidebar--left')?></div>
    <?php endif; ?>
    <!-- main -->
    <div id='main'>
    <?php if(isset($main)) echo $main?>
    <?php $this->views->render('main')?>
    </div>
    <!-- sidebar--right -->
    <?php if ($this->views->hasContent('sidebar--right')) : ?>
    <div id='sidebar--right'><?php $this->views->render('sidebar--right')?></div>
    <?php endif; ?>
</div>


<!-- triptych 1-3 -->
<?php if ($this->views->hasContent('triptych-1', 'triptych-2', 'triptych-3')) : ?>
<div id='wrap-triptych'>
    <div id='triptych-1'><?php $this->views->render('triptych-1')?></div>
    <div id='triptych-2'><?php $this->views->render('triptych-2')?></div>
    <div id='triptych-3'><?php $this->views->render('triptych-3')?></div>
</div>
<?php endif; ?>
<!-- footer-col 1-4 -->
<?php if ($this->views->hasContent('footer-col-1', 'footer-col-2', 'footer-col-3', 'footer-col-4')) : ?>
<div id='wrap-footer-col'>
    <div id='footer-col-1'><?php $this->views->render('footer-col-1')?></div>
    <div id='footer-col-2'><?php $this->views->render('footer-col-2')?></div>
    <div id='footer-col-3'><?php $this->views->render('footer-col-3')?></div>
    <div id='footer-col-4'><?php $this->views->render('footer-col-4')?></div>
</div>
<?php endif; ?>
<!-- footer -->
<div id='wrap-footer' class='t-clearfix'>
    <div id='footer' class='t-clearfix'>
    <?php if(isset($footer)) echo $footer?>
    <?php $this->views->render('footer')?>
    </div>
    <!-- <p class='columns-background-error-fix'>.</p> -->
</div>
<?php /*echo $this->request->getCurrentUrl();  echo ("<br />" . getCurrentUrl())*/?>
<?php /*echo($this->request->extractRoute() . "<br />"); 
echo($this->request->getRouteAsCssClass() . "<br />");
dump( $this->request->getRouteParts()); */?>
</div>

<?php if(isset($jquery)):?><script src='<?=$this->url->asset($jquery)?>'></script><?php endif; ?>

<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
<script src='<?=$this->url->asset($val)?>'></script>
<?php endforeach; endif; ?>

<?php if(isset($google_analytics)): ?>
<script>
  var _gaq=[['_setAccount','<?=$google_analytics?>'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif; ?>

</body>
</html>
