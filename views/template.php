<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title; ?></title>

	<?php echo \Pump\Asset::less('bootstrap.css'); ?>
	<?php echo \Pump\Asset::css('jquery.fancybox-1.3.4.css'); ?>
	
	<?php echo \Pump\Asset::js(array(
		'http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js',
		'bootstrap-dropdown.js',
		'bootstrap-alert.js',
		'bootstrap-tooltip.js',
		'bootstrap-popover.js',
		'bootstrap-tab.js',
		'jquery.fancybox-1.3.4.pack.js',
		)); ?>

	<?php if(isset($page_meta)){ echo Html::meta($page_meta); } ?>
    
    <script>
		// $(document).ready(function(){

		// });
	</script>
</head>
<body>

	<div class="navbar">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo Uri::create('/'); ?>"><?php echo SITE_NAME; ?></a>

        </div>
      </div>
    </div>


	
	<div class="container">
		<?php if(isset($breadcrumbs) && !empty($breadcrumbs)){ echo $breadcrumbs; } ?>
		<div class="row">
			<?php if(isset($left_col) && !empty($left_col)){ ?>
				<div class="span<?php echo $dimensions['left_col']['dimensions']; ?>">
				<?php echo $left_col; ?>
				</div>
			<?php } ?>

			<div class="span<?php echo $dimensions['middle_col']['dimensions']; ?>">
			<?php echo $message.$content; ?>
			</div>

			<?php if(isset($right_col) && !empty($right_col)){ ?>
				<div class="span<?php echo $dimensions['right_col']['dimensions']; ?>">
				<?php echo $right_col; ?>
				</div>
			<?php } ?>

		</div>

	</div>

	<footer>
		<p>
			<?php echo SITE_NAME; ?><br>
			<small>Version: <?php echo SITE_VERSION; ?></small>
		</p>
			<hr>	
		<p>
			<small class="pull-right">CERTAIN CONTENT THAT APPEARS ON THIS SITE COMES FROM AMAZON EU S.à r.l. THIS CONTENT IS PROVIDED ‘AS IS’ AND IS SUBJECT TO CHANGE OR REMOVAL AT ANY TIME.</small>
		</p>
	</footer>
		
</body>
</html>
