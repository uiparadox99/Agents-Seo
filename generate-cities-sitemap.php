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



 $cities       = "SELECT * FROM agent_cities";
 $cities_query = mysqli_query($con, $cities) or die(mysqli_error($con));
 $citiestotal = mysqli_num_rows($cities_query);



 $write_data = '<?xml version="1.0" encoding="UTF-8"?>
 <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
 


 while ($cities_row = mysqli_fetch_assoc($cities_query)) {

 	
 	$lastDate = (checkdate(1,1,date("Y", strtotime($cities_row["updated_at"]))))? date('c', strtotime($cities_row["updated_at"])) : date("c");

   $slug = preg_replace('~[^\pL\d]+~u', '-', $cities_row["name"]);

  // transliterate
  $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);

  // remove unwanted characters
  $slug = preg_replace('~[^-\w]+~', '', $slug);

  // trim
  $slug = trim($slug, '-');

  // remove duplicate -
  $slug = preg_replace('~-+~', '-', $slug);

  // lowercase
  $slug = strtolower($slug);

 

 	$write_data .= '<url>
 	<loc>https://agents.com.pk/travel-agent-in'. $slug .'</loc>
 	<lastmod>' .$lastDate. '</lastmod>
 	<changefreq>daily</changefreq>
 	<priority>0.8000</priority>
 	</url>' . "\n";


    $write_data .= '<url>
  <loc>https://agents.com.pk/jobs-in-'. $slug .'</loc>
  <lastmod>' .$lastDate. '</lastmod>
  <changefreq>daily</changefreq>
  <priority>0.8000</priority>
  </url>' . "\n";
 }
 $write_data .= "\n</urlset>";
 $file_ = file_put_contents('cities_sitemap.xml', $write_data);



 ?>