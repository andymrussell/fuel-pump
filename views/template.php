<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title; ?></title>

	<?php echo \Pump\Asset::less('bootstrap.css'); ?>
	
	<?php echo \Pump\Asset::js(array(
		'http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js',
		'bootstrap-dropdown.js',
		'bootstrap-alert.js',
		'bootstrap-tooltip.js',
		'bootstrap-popover.js',
		'bootstrap-tab.js',
		)); ?>

	<?php if(isset($page_meta)){ echo Html::meta($page_meta); } ?>
    
    <script>
		// $(document).ready(function(){

		// });
	</script>
</head>
<body>

	<?php echo $top_menu; ?>


	
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
			<small class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</small>
		</p>
	</footer>
		
</body>
</html>
