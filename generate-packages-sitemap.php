 <?php 

 if ($_SERVER['HTTP_HOST'] == 'localhost') {

 	$host 		= 'localhost';
 	$username 	= 'root';
 	$password 	= '';
 	$db 		= 'visas_laravel';
 }else{
 	$host 		= 'localhost';
 	$username 	= 'myungjxp_main';
 	$password 	= 'techPedia@786';
 	$db 		= 'myungjxp_visas_com_pk';
 }

 $con 			= mysqli_connect($host, $username, $password, $db);
 $GLOBALS['con'] = $con;

 if (mysqli_connect_errno())
 {
 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 ob_start();



  $packages       = "SELECT * FROM umrah_packages where active = 1";
 $packages_query = mysqli_query($con, $packages) or die(mysqli_error($con));
 $packagestotal = mysqli_num_rows($packages_query);



 $write_data = '<?xml version="1.0" encoding="UTF-8"?>
 <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
 
  while ($packages_row = mysqli_fetch_assoc($packages_query)) {

 	
 	$lastDate = (checkdate(1,1,date("Y", strtotime($packages_row["updated_at"]))))? date('c', strtotime($packages_row["updated_at"])) : date("c");
 	$write_data .= '<url>
 	<loc>https://agents.com.pk/'. $packages_row["slug"] .'</loc>
 	<lastmod>' .$lastDate. '</lastmod>
 	<changefreq>daily</changefreq>
 	<priority>0.8000</priority>
 	</url>' . "\n";
 }
 
 $write_data .= "\n</urlset>";
 $file_ = file_put_contents('package_sitemap.xml', $write_data);



 ?>