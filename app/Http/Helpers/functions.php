<?php
use Illuminate\Support\Str;

if (!function_exists('str_limit')) {
    function str_limit($value, $limit = 100, $end = '...')
    {
        return Str::limit($value, $limit, $end);
    }
}
function Guid() { 
	$s = strtoupper(md5(uniqid(rand(),true))); 
	$guidText = 
	substr($s,0,8) . '-' . 
	substr($s,8,4) . '-' . 
	substr($s,12,4). '-' . 
	substr($s,16,4). '-' . 
	substr($s,20); 
	return $guidText;
}
function slugify($text){
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	$text = preg_replace('~[^-\w]+~', '', $text);
	$text = trim($text, '-');
	$text = preg_replace('~-+~', '-', $text);
	$text = strtolower($text);

	if (empty($text)) {
		return 'n-a';
	}

	return $text;
}

function str_slug($text){
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	$text = preg_replace('~[^-\w]+~', '', $text);
	$text = trim($text, '-');
	$text = preg_replace('~-+~', '-', $text);
	$text = strtolower($text);

	if (empty($text)) {
		return 'n-a';
	}

	return $text;
}

function secureData($data) {
	return $data;
    // return htmlspecialchars(stripslashes(trim($data)));
}

function unslug($value)
{
	return ucwords(str_replace('-',' ',$value));
}
function unslugperm($value)
{
	return ucwords(str_replace('_',' ',$value));
}

function renderHTML($data)
{
	return html_entity_decode(htmlspecialchars_decode(stripslashes($data)));
}

function getCountryCode($country)
{
	$countries = array_flip(config("countries"));

	$country = trim($country);
	$country = str_replace(' (Dubai)','', $country);
	$keyCode = in_array($country, array_keys($countries));

	if ($keyCode) {
		$keyCode = $countries[$country];
	}else{
		$keyCode = "";
	}
	return $keyCode;
}

function getSettings(){
	$array = App\Setting::get(["key", "value"]);
	$settings = array();
	foreach ($array as $s) {
		$settings[$s->key] = $s->value;
	}
	return (object)$settings;
}
function CheckPermission($id, $cps) {
    if ($cps == 'verified_agent') {
        $agent = App\Agents::where('id', $id)->first();
        return ($agent && $agent->verified == 1);
    }
    return true;
}

function renderFlags($content)
{
	$tags = getContents($content, '[', ']');
	$flag = array();
	foreach ($tags as $key => $value) {
		if(!empty(getCountryCode($value))){
			$flag["[".$value."]"] = '<i class="flag-icon flag-icon-'.strtolower(getCountryCode($value)).'" ><span>'.$value.'</span></i>';
		}else{
			$flag["[".$value."]"] = $value." Embassy";
		}
	}
	$content =  replaceTags($content, $flag);
	return $content;
}

function replaceTags($message, $variables = []){
	if(count($variables) !== 0){
		$searchArray	=	array_keys($variables);
		$replaceArray	=	array_values($variables);
		return str_replace($searchArray,$replaceArray,$message);
	}else{
		return $message;
	}
}

function shortName($string)
{
	$words = explode(" ", $string);
	$letters = "";
	foreach ($words as $value) {
		$letters .= substr($value, 0, 1);
	}
	return $letters;
}

function getContents($str, $startDelimiter, $endDelimiter) {
	$contents = array();
	$startDelimiterLength = strlen($startDelimiter);
	$endDelimiterLength = strlen($endDelimiter);
	$startFrom = $contentStart = $contentEnd = 0;
	while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
		$contentStart += $startDelimiterLength;
		$contentEnd = strpos($str, $endDelimiter, $contentStart);
		if (false === $contentEnd) {
			break;
		}
		$contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
		$startFrom = $contentEnd + $endDelimiterLength;
	}

	return $contents;
}
function strCount($content)
{
	return substr_count($content, "<p>");
}
function lastDayOfMonth(){
	return \Carbon\Carbon::now()->endofMonth();
}
function CurrentDate(){
	return \Carbon\Carbon::now();
}

function firstDayOfMonth(){
	return \Carbon\Carbon::now()->firstofMonth();
}
function xTimeAgo($date)
{
	return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
}
function get_minutes ( $start, $end ) { 

	while ( strtotime($start) <= strtotime($end) ) { 
		$minutes[] = date("H:i", strtotime( "$start" ) ); 
		$start = date("H:i", strtotime( "$start + 30 mins")) ;     
	} 
	return $minutes; 
}  
function dateformate($value) {
	echo date("d M Y", strtotime($value));
}
function getTimeDiff($start, $end)
{
	$time1 = $start;
	$time2 = $end;
	list($hours, $minutes) = explode(':', $time1);
	$startTimestamp = mktime($hours, $minutes);

	list($hours, $minutes) = explode(':', $time2);
	$endTimestamp = mktime($hours, $minutes);

	$seconds = abs($endTimestamp - $startTimestamp);
	$diff = (24*60*60)-$seconds;
	if ($diff < $seconds) {
		$seconds = $diff;
	}

	$minutes = ($seconds / 60) % 60; 
	$hours = round($seconds / (60 * 60));

	return "{$hours}h {$minutes}m";
}
function showRatingStars($rate = 0){
	$star = "";
	for ($i=1; $i <= 5; $i++) { 
		$fullStar = $i <= $rate ? "fas fa-star" : "far fa-star";
		$star .= '<i class="'.$fullStar.'" aria-hidden="true"></i> ';
	}
	return $star;
}
function jobCount($id)
{	$today =  date('Y-m-d h:i:s');
	$count = App\AgentJobs::join('agent_subscriptions','agent_subscriptions.agents_id','agent_jobs.agents_id')
	->join('plan','agent_subscriptions.plan_id','plan.id')
	->join('transactions','transactions.subscription_id','agent_subscriptions.id')
	->join('plan_has_plans_permissions','plan.id','plan_has_plans_permissions.plan_id')
	->join('plans_permissions','plans_permissions.id','plans_permissions_id')
	->where('transactions.status','paid')
	->where('plan.active','1')
	->where('agent_subscriptions.active','1')
	->where('plans_permissions.active','1')
	->where('agent_subscriptions.expairy_date','>=',$today)
	->where('plans_permissions.code','jobs')
	->where('agent_jobs.agent_cities_id',$id)->where('agent_jobs.active',1)->whereDate('agent_jobs.apply_date','>=',date('Y-m-d',strtotime('today')))->groupby('agent_jobs.id')->count();
	return $count;
}
function generateCode() {
        $number = mt_rand(10000, 99999); // better than rand()
        // call the same function if the barcode exists already
        if (App\Agents::where('code',$number)->exists()) {
        	return generateCode();
        }

        // otherwise, it's valid and can be used
        return $number;
    }

   

    ?>
