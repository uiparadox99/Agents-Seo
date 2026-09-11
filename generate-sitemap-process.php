 <?php 

 if ($_SERVER['HTTP_HOST'] == 'localhost') {

 	$host 		= 'localhost';
 	$username 	= 'root';
 	$password 	= '';
 	$db 		= 'visas_laravel';
 }else{
 	$host 		= 'localhost';
 	$username   = 'myungjxp_main';
  $password   = 'techPedia@786';
  $db     = 'myungjxp_agents';
 }

 $con 			= mysqli_connect($host, $username, $password, $db);
 $GLOBALS['con'] = $con;

 if (mysqli_connect_errno())
 {
 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 ob_start();


 $blog       = "SELECT slug, country_name AS country, sections_id, updated_at FROM visas WHERE deleted_at IS NULL ";
 $blog_query = mysqli_query($con, $blog) or die(mysqli_error($con));
 $total = mysqli_num_rows($blog_query);




 $write_data = '<?xml version="1.0" encoding="UTF-8"?>
 <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';


  $write_data .= '<url>
 <loc>https://agents.com.pk/cheap-umrah-packages</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';

 $write_data .= '<url>
 <loc>https://agents.com.pk/</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
 $write_data .= '<url>
 <loc>https://agents.com.pk/cities</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/about-us</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/contact-us</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/privacy-policy</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/terms-conditions</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/anti-spam-policy</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/dmca-notes</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/currency-converter</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
   $write_data .= '<url>
 <loc>https://agents.com.pk/cheap-umrah-flights-from-pakistan</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/travel-agents-in-pakistan</loc>
 <changefreq>daily</changefreq>
 <priority>0.9000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/sasti-tickets</loc>
 <changefreq>daily</changefreq>
 <priority>0.9000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/tour-packages</loc>
 <changefreq>daily</changefreq>
 <priority>0.9000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/umrah-hotels</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
  $write_data .= '<url>
 <loc>https://agents.com.pk/blogs</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
 $write_data .= '<url>
 <loc>https://agents.com.pk/airlines</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
 $write_data .= '<url>
 <loc>https://agents.com.pk/travel-news</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';
 $write_data .= '<url>
 <loc>https://agents.com.pk/airline-circulars</loc>
 <changefreq>daily</changefreq>
 <priority>0.8000</priority>
 </url>';





 $write_data .= "\n</urlset>";
 $file_ = file_put_contents('sitemap.xml', $write_data);



 ?>