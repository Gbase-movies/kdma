<?php
include ('config.php');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
if(empty($_GET['keyword'])){
    
$noresult = [
      'content' => ''
];
echo json_encode($noresult);
die();
}

$searchresult = $APIbaseURL."/api/search/".$_GET['keyword'];
$arrContextOptions=array(
    "ssl"=>array(
          "verify_peer"=>false,
          "verify_peer_name"=>false,
      ),
  ); 
$ambil = file_get_contents($searchresult, false, stream_context_create($arrContextOptions));
$searchresult = json_decode($ambil);

$div = '<ul style="margin-bottom: 0;">';
foreach ($searchresult as $drama) :
$name = substr($drama->name, 0, stripos($drama->name, "episode"));
$div .= '<li><a href="'.$drama->link.'" class="ss-title">'.trim($name).'</a></li>';
endforeach;
$div .= '</ul>';

$result = [
      'content' => $div
];
echo json_encode($result);
}
?>