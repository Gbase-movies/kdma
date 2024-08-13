<?php
$video 		= '';
$video		= '';
$videoTest 	= '';



class VideoStreamCurl{
    private $path = "";
    private $buffer = 102400;
    private $start  = -1;
    private $end    = -1;
    private $size   = 0;
	private $cache	='';
	private $testMODE = false;
 
    function __construct($filePath){
        $this->path = $filePath;
    }
    
	public function test($localFile,$bytes){
		$this->testMODE = true;
		$b 		= array();
		$b['Size'] 	= $this->curlSize();
		$b['MaxReadBytes'] 	= $bytes;
		$this->curlDownload(0,($bytes-1));
		$b['BytesCurl']	= $this->cache;
		$a		= fopen($localFile,'rb');
		$b['BytesLocal']	= fread($a, $bytes);
		$b['Header']	= $this->testHeader();
		$b['Start']	= $this->start;
		$b['End']	= $this->end;
		fclose($a);
		echo '<pre>';
			print_r($b);
		echo '</pre>';
	}
	
    private function open(){
     
	
		$ch = curl_init($this->path);
		curl_setopt($ch, CURLOPT_NOBODY, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		

		if(curl_exec($ch) === false)
		{
			echo 'ERROR URL';
			exit();
		}

		curl_close($ch);
    }
    
	private function testHeader(){
		ob_get_clean();
		
		$array=array();
			$array[] = 'Content-Type: video/mp4';
			$array[] = 'Cache-Control: max-age=2592000, public';
			$array[] = "Expires: ".gmdate('D, d M Y H:i:s', time()+2592000) . ' GMT';
			$this->start = 0;
			$this->size  = $this->curlSize(); //TAMAÑO DEL ARCHIVO.
			$this->end   = $this->size - 1;
			$array[] = "Accept-Ranges: 0-".$this->end;
			if (isset($_SERVER['HTTP_RANGE'])) {
				$c_start = $this->start;
            	$c_end = $this->end;
				list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
				if (strpos($range, ',') !== false) {
					$array[] = 'HTTP/1.1 416 Requested Range Not Satisfiable';
					$array[] = "Content-Range: bytes $this->start-$this->end/$this->size";
					exit;
				}
				if ($range == '-') {
					$c_start = $this->size - substr($range, 1);
				}else{
					$range = explode('-', $range);
					$c_start = $range[0];

					$c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
				}
				$c_end = ($c_end > $this->end) ? $this->end : $c_end;
				if ($c_start > $c_end || $c_start > $this->size - 1 || $c_end >= $this->size) {
					$array[] = 'HTTP/1.1 416 Requested Range Not Satisfiable';
					$array[] = "Content-Range: bytes $this->start-$this->end/$this->size";
					exit;
				}
				$this->start = $c_start;
				$this->end = $c_end;
				$length = $this->end - $this->start + 1;
				//fseek($this->stream, $this->start);
				$array[] = 'HTTP/1.1 206 Partial Content';
				$array[] = "Content-Length: ".$length;
				$array[] = "Content-Range: bytes $this->start-$this->end/".$this->size;
			}
		return $array;
	}
	
    private function setHeader(){
        ob_get_clean();
        header("Content-Type: video/mp4");
        header("Cache-Control: max-age=2592000, public");
        header("Expires: ".gmdate('D, d M Y H:i:s', time()+2592000) . ' GMT');
        
        $this->start = 0;
        $this->size  = $this->curlSize(); 
        $this->end   = $this->size - 1;
        header("Accept-Ranges: 0-".$this->end);
         
        if (isset($_SERVER['HTTP_RANGE'])) {
  
            $c_start = $this->start;
            $c_end = $this->end;
 
            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $this->start-$this->end/$this->size");
                exit;
            }
            if ($range == '-') {
                $c_start = $this->size - substr($range, 1);
            }else{
                $range = explode('-', $range);
                $c_start = $range[0];
                 
                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
            }
            $c_end = ($c_end > $this->end) ? $this->end : $c_end;
            if ($c_start > $c_end || $c_start > $this->size - 1 || $c_end >= $this->size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $this->start-$this->end/$this->size");
                exit;
            }
            $this->start = $c_start;
            $this->end = $c_end;
            $length = $this->end - $this->start + 1;
            //fseek($this->stream, $this->start);
            header('HTTP/1.1 206 Partial Content');
            header("Content-Length: ".$length);
            header("Content-Range: bytes $this->start-$this->end/".$this->size);
        }
        else
        {
            header("Content-Length: ".$this->size);
        }  
         
    }
    
	private function curlSize(){
		 $ch = curl_init();
	  	 curl_setopt($ch, CURLOPT_URL, $this->path);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		 curl_setopt($ch, CURLOPT_HEADER, TRUE);
		 curl_setopt($ch, CURLOPT_NOBODY, TRUE);

		 $data = curl_exec($ch);
		 $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

		 curl_close($ch);
		 return $size;
	}
     
	private function curlDownload($start,$end){
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->path);
		curl_setopt($ch, CURLOPT_RANGE, $start.'-'.$end); 	
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, 'identity');		
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $chunk){
			


			if($this->testMODE==true){
				$this->cache = $chunk;
			}else{
				echo $chunk;
			}
			
			return strlen($chunk);			
			
		});
		$result = curl_exec($ch);
		curl_close($ch);
		
	}

    private function stream(){

		
		
        $i = $this->start;
		$e = $this->end;
        set_time_limit(0);
		
		$this->curlDownload($i,$e);
		
    }
     

    function start(){
        $this->open();
        $this->setHeader();
        $this->stream();
    }
}

/* resolve fembed
* examples of usage :
* $filelink = input file
* $link --> video_link
*/

function curl_get_contents_fvs($url){
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Authority: fvs.io';
$headers[] = 'Sec-Ch-Ua: ^^';
$headers[] = 'Sec-Ch-Ua-Mobile: ?0';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'Sec-Fetch-Site: none';
$headers[] = 'Sec-Fetch-Mode: navigate';
$headers[] = 'Sec-Fetch-User: ?1';
$headers[] = 'Sec-Fetch-Dest: document';
$headers[] = 'Accept-Language: en-US,en;q=0.9';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
$curl_info = curl_getinfo($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
return $curl_info['redirect_url'];	
}
function curl_get_contents($url,$data,$filelink,$host)
{
	$ch = curl_init();
    
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

	$headers = array();
	$headers[] = 'Authority: '.$host;
	$headers[] = 'Sec-Ch-Ua: ^^';
	$headers[] = 'Accept: */*';
	$headers[] = 'X-Requested-With: XMLHttpRequest';
	$headers[] = 'Sec-Ch-Ua-Mobile: ?0';
	$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36 Edg/90.0.818.66';
	$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
	$headers[] = 'Origin: https://'.$host;
	$headers[] = 'Sec-Fetch-Site: same-origin';
	$headers[] = 'Sec-Fetch-Mode: cors';
	$headers[] = 'Sec-Fetch-Dest: empty';
	$headers[] = 'Referer: '.$filelink;
	$headers[] = 'Accept-Language: en-US,en;q=0.9';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	$res = curl_exec($ch);
	curl_close($ch);
 
	return $res;
}
$filelink = $_GET['url'];

if (preg_match("/embedsito\.com|vidsrc\.xyz|feurl\.|fcdn\.stream|fembed\.|femax\d+\.com|gcloud\.live|bazavox\.com|xstreamcdn\.com|smartshare\.tv|streamhoe\.online|animeawake\.net|mediashore\.org|sexhd\.co|streamm4u\.club/",$filelink)) {
  $host=parse_url($filelink)['host'];
  preg_match("/v\/([\w\-]*)/",$filelink,$m);
  $id=$m[1];
  $url="https://".$host."/api/source/".$id;
  $data = array('r' => '','d' => $host);
 /* $options = array(
        'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    )
  );

  $context  = stream_context_create($options);
  $h3 = @file_get_contents($url, false, $context);
  */
  $h3 = curl_get_contents($url,$data,$filelink,$host);
  $r=json_decode($h3,1);
#print_r($r);die;
  if (isset($r['player']['poster_file'])) {
   $t1=explode("userdata/",$r['player']['poster_file']);
   $t2=explode("/",$t1[1]);
   $userdata=$t2[0];
  } else {
   $userdata="";
  }
  if (isset($r["captions"][0]["path"])) {
   if (strpos($r["captions"][0]["path"],"http") === false)
    $srt="https://".$host."/asset".$r["captions"][0]["path"];
   else
    $srt=$r["captions"][0]["path"];
  } elseif (isset($r["captions"][0]["hash"])) {
    $srt="https://".$host."/asset/userdata/".$userdata."/caption/".$r["captions"][0]["hash"]."/".$r["captions"][0]["id"].".".$r["captions"][0]["extension"];
  }
  $c = count($r["data"]);
  if (strpos($r["data"][$c-1]["file"],"http") === false)
   $link="https://".$host.$r["data"][$c-1]["file"];
  else
   $link=$r["data"][$c-1]["file"];
   if (preg_match("/\#caption\=(.+)/",$filelink,$m))
     $srt=$m[1];
}
$curl2 = curl_get_contents_fvs($link);

#echo $curl2;
$stream = new VideoStreamCurl($curl2);
$stream->start();
?>
