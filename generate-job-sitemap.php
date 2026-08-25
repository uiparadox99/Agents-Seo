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


 $jobs       = "SELECT * FROM agent_jobs where active = 1";
 $jobs_query = mysqli_query($con, $jobs) or die(mysqli_error($con));
 $jobstotal = mysqli_num_rows($jobs_query);

 $write_data = '<?xml version="1.0" encoding="UTF-8"?>
 <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
 


 while ($job_row = mysqli_fetch_assoc($jobs_query)) {

 	
 	$lastDate = (checkdate(1,1,date("Y", strtotime($job_row["updated_at"]))))? date('c', strtotime($job_row["updated_at"])) : date("c");
 	$write_data .= '<url>
 	<loc>https://agents.com.pk/job/'. $job_row["slug"] .'</loc>
 	<lastmod>' .$lastDate. '</lastmod>
 	<changefreq>daily</changefreq>
 	<priority>0.8000</priority>
 	</url>' . "\n";
 }
 $write_data .= "\n</urlset>";
 $file_ = file_put_contents('job_sitemap.xml', $write_data);



 ?>