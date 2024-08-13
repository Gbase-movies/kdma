<?php
require 'vendor/curl.php';

$id = $_GET['id'];
// Create DOM from URL or file
$html = file_get_html("https://asianload.cc/streaming.php?id=$id");

 foreach($html->find('ul li') as $element)
	$data = $element->getAttribute('data-video');


// redirect to index if no id
 if(empty($id)  ){
 header('Location: /');
 die;
 }
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Proxy Player</title>
	
	<!-- Meta -->
	<meta charset="utf-8">

	<!-- JavaScript -->
	<script src="https://raw.githack.com/juandfar/tfr5t/main/video.js"></script>


</head>
<body>
  <style type="text/css">*{margin:0;padding:0;outline:none;}#container{position:absolute;width:100%!important;height:100%!important;}*:focus{outline:none;}</style>
	<div id="container"></div>
	<script>
	jwplayer("container").setup({

		    controls: true,
		    displaytitle: false,
		    fullscreen: "true",
		    primary: 'html5',
		    stretching: "exactfit",
		    autostart: true,

		    

		    //sharing: {
		    	//sites: ["reddit","facebook","twitter"]
		    //},
		     
		    

		  playlist: [{
		    title: "",
		    description: "",
		    image: "https://i.imgur.com/q4YmlpU.png",
			advertising: {
			client: "vast",
			schedule: {
			adbreak1: {
			offset : "pre",                         
				tag: "https://raw.githubusercontent.com/Pacifierjr/TagAnime/main/vastads.xml",
				skipoffset: 5
						},
			adbreak2: {
			offset: "50%",
				tag: "https://raw.githubusercontent.com/Pacifierjr/TagAnime/main/vastads.xml",
				skipoffset: 5
						},
					},
					}, 
		    sources: [{
		    file: <?php if (preg_match('/embedsito/', $data)){ ?>"/player-proxy.php?url=<?php echo $element->getAttribute('data-video');?>",
		      label: 'Origignal',
		      'type': 'mp4',
		      primary: 'html5',
			<?php }else{
									 
									 header ('Location: https://asianload.cc/streaming.php?id='.$id);
									 ?>
								
								  <?php }?>
		    },],
		    
		    
		  }]
		});
	</script>
</body>
</html>
