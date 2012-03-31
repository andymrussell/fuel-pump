<div class="row">
	<div class="span12">
		<ul class="breadcrumb">
<?php 
$i =1; 
foreach($crumbs as $title => $url){
	if($i == count($crumbs))
	{ 
		echo '<li class="active">';
	}
	else
	{
		echo '<li>';
	}

	echo '<a href="'.$url.'">'.$title.'</a>';

	if($i <= count($crumbs)-1){
		echo '<span class="divider">/</span>';
	}

$i++;
}
?>
		</ul>
	</div>
</div>



