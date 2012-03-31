<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	
	<url> 
		<loc><?php  echo \Uri::create('/'); ?></loc> 
		<priority>0.7</priority>
		<changefreq>weekly</changefreq>
		<lastmod>2011-03-03</lastmod>
	</url>


	<?php foreach($data as $item){ ?>

	<url> 
		<loc><?php  echo \Uri::create($item['url']); ?></loc> 
		<priority>0.7</priority>
		<changefreq>weekly</changefreq>
		<lastmod><?php echo Date::forge( $item['lastmod'] )->format("%Y-%m-%d"); ?></lastmod>
	</url>



	<?php } ?>

</urlset>