<?php
include 'config.php';
// Latest Update SUB
$lastupdate = $APIbaseURL."/api/recently-added-sub";
if(empty($_GET['anime_ep'])){
    die('NO EPISODE DRAMA');
}
$slug = $_GET['anime_ep'];
$sluglist = substr($slug, 0, strpos($slug, "-episode"));
$listepisode = $APIbaseURL."/api/drama/".$slug;

$dataiframe = $APIbaseURL."/api/iframe/".$slug;
$arrContextOptions=array(
    "ssl"=>array(
          "verify_peer"=>false,
          "verify_peer_name"=>false,
      ),
  );
$ambil = file_get_contents($lastupdate, false, stream_context_create($arrContextOptions));
$ambillistepisode = file_get_contents($listepisode, false, stream_context_create($arrContextOptions));
$ambildataiframe = file_get_contents($dataiframe, false, stream_context_create($arrContextOptions));
$latestsub = json_decode($ambil);
$latestlistepisode = json_decode($ambillistepisode);
$latestdata = $ambildataiframe;


function unslug($text){
    $newtext = preg_replace('~[^\pL\d]+~u', '-', $text);
    $newtext = preg_replace('/[-]/', ' ', $newtext);
    $newtext = iconv('utf-8', 'us-ascii//TRANSLIT', $newtext);
    $newtext = ucwords($newtext);
    return $newtext;
}

function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}


?>
<!DOCTYPE html>
<html lang="en-US"
      xmlns="http://www.w3.org/1999/xhtml"
      itemscope itemtype="http://schema.org/WebPage">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <meta charset="UTF-8"/>
<meta name="viewport"
      content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no"/>

<link rel="profile" href="http://gmpg.org/xfn/11">

<link rel="shortcut icon" href="/img/favicon.png">

<title>Watch <?php echo unslug($slug);?> English Subbed/Dubbed online at <?php echo $Title; ?></title>

<meta name="robots" content="noodp, noydir" />
<meta name="description" content="Watch <?php echo unslug($slug);?> online at <?php echo $Title; ?>">
<meta name="keywords" content="<?php echo unslug($slug);?>, English Subbed/Dubbed">
<meta itemprop="image" content="<?php echo $latestlistepisode->img;?>"/>

<meta property="og:locale" content="en_US"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="Watch <?php echo unslug($slug);?> Subbed/Dubbed online at <?php echo $Title; ?>"/>
<meta property="og:description" content="Watch <?php echo unslug($slug);?> online at <?php echo $Title; ?>">
<meta property="og:url" content=""/>
<meta property="og:image" content="<?php echo $latestlistepisode->img;?>"/>
<meta property="og:image:secure_url" content="<?php echo $latestlistepisode->img;?>"/>

<meta property="twitter:card" content="summary"/>
<meta property="twitter:title" content="Watch <?php echo unslug($slug);?> English Subbed/Dubbed online at <?php echo $Title; ?>"/>
<meta property="twitter:description" content="Watch <?php echo unslug($slug);?> online at <?php echo $Title; ?>"/>

<link rel="canonical" href="/videos/<?php echo $slug; ?>"/>
<link rel="alternate" hreflang="en-us" href="/videos/<?php echo $slug; ?>"/>


		<link rel="stylesheet" type="text/css" href="/video/css/font-awesome.min.css??v=8.1" />
        <link rel="stylesheet" type="text/css" href="/video/css/style.css??v=8.1" />
    
		<script type="text/javascript" src="/video/js/jquery.js"></script>
   
<style>
.newzone {
    align-items: center;
    background-color: #e73737;
    border-radius: 0 0 4px 4px;
    color: #fff;
    display: flex;
    font-weight: 700;
    justify-content: space-between;
    line-height: 1.25;
    padding: .75em 1em;
    position: relative;
}
.newzone .left #episodes {
    font-family: titillium,arial;
    color: #dadada;
    width: 195px;
    padding: 1px 3px;
    border: 1px solid #161616;
    background: #111;
    border-radius: 4px;
}
</style>
</head>
<body>
<script>
        var base_url =  '//' + document.domain + '/';
</script>
<div id="wrapper_bg" class="">
        <section id="wrapper" class="wrapper">
            <div id="main_bg" class="main">
                <div class="main-content">
    <header class="header vc_row wpb_row vc_row-fluid">
    <div class="top-header vc_col-sm-12">
        <div class="logo vc_col-sm-2">
            <a href="/">
            <img src="/img/logo_vid.png?3" class="retina-header" alt="Watch <?php echo unslug($slug);?> English Subbed/Dubbed online at <?php echo $Title; ?>" />            </a>
        </div>
        <div class="header_search">
            <div class="search sb-search" id="sb-search">
            <div class="form">
   <form onsubmit="" id="search-form" action="" method="get" class=" gray-form lap">
       <div class="row">
           <input placeholder="Search here..." class="footer_search_input" name="keyword_search" id="keyword" type="text" value="" autocomplete="off" onclick="" type="text">          
           <input class="btngui btn btn-primary sb-search-submit" type="submit" onclick="do_search();">
           <input id="key_pres" name="key_pres" value="" type="hidden" />
           <input id="link_alias" name="link_alias" value="" type="hidden" />
           <input id="keyword_search_replace" name="keyword_search_replace" value="" type="hidden" />
           <span class="sb-icon-search icon-search blue-button" onclick="do_search();">
                <i class="fa fa-search" aria-hidden="true"></i>
           </span>
       </div>
       <div class="load search"></div>
       <div id="header_search_autocomplete">
               
       </div>
  </form>
</div><div class="clr"></div>
            </div>
        </div>
       
        <div class="clearfix"></div>
    </div>
</header>
</div>
<div class="clearfix"></div>
<div id="navigation-wrapper">
    <div class="main-content">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
        </button>
        <ul id="menu-header-menu">
            <li class="active"><a href="/"><?php echo $RecentlyAddedSubTitle; ?></a></li>
            <li><a href="/recently-added-raw"><?php echo $RecentlyAddedRawTitle; ?></a></li>
			<li><a href="/movies"><?php echo $MoviesTitle; ?></a></li>
            <li><a href="/kshow"><?php echo $NewSeasonTitle; ?></a></li>
            <li><a href="/popular"><?php echo $PopularTitle; ?></a></li>
            <li><a href="/ongoing-series"><?php echo $OngoingTitle; ?></a></li>
        </ul>
    </div>
</div>
<div class="clearfix"></div>
                <div class="main-content">
                   
    <div class="video-info">
        <div class="video-info-left">
            <h1><?php echo unslug($slug);?> English <?php echo $latestlistepisode->type;?></h1>
            <div class="watch_play">
                <div class="play-video">
    <iframe id="iframe-to-load" src="//<?php echo $latestdata; ?>" allowfullscreen="true" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"></iframe>
</div>
<div class="clr"></div>
<div class="newzone">
<div class="left">
			<select class="btn btn-secondary btn-block dropdown-toggle" id="select-iframe-to-display">
					<option class="btn-video dropdown-item" value="/player-fembed.php<?php echo strstr($latestdata, '?id='); ?>-#-main-fembed">(Server) Fembed</option>
					<option class="btn-video dropdown-item" value="<?php echo $latestdata; ?>-#-backup">(Server) Asianload</option>	
			</select>
</div>
  </div>
            </div>
            <div class="row video-options">
                    <div class="col-sm-4 col-xs-6 box-comment">
                        <a href="javascript:void(0)" class="option comments-scrolling" id="click_comment">
                            <i class="fa fa-comments"></i>
                            <span class="option-text">Comments</span>
                        </a>
                    </div>
                   
                    <div class="col-sm-4 col-xs-6 box-share">
                        <a class="option share-button" id="share" href="javascript:;" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent('<?php echo 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>') + '', 'facebook-share-dialog', 'width=626,height=436');return false;">
                            <i class="fa fa-share"></i>
                            <span class="option-text">Share</span>
                        </a>
                    </div>

                    <div class="col-sm-4 col-xs-6 box-turn-off-light">
                        <!-- LIGHT SWITCH -->
                        <a href="javascript:void(0)" class="option switch-button" id="off_light">
                            <i class="fa fa-lightbulb-o"></i>
                            <span class="option-text">Turn off Light</span>
                        </a>  
                    </div>
                </div>
                <div class="clr"></div>
            <div class="video-details">
                <span class="date">
                        <?php echo unslug($sluglist);?>                </span>
                <div class="post-entry">
                    <div class="content-more-js" id="rmjs-1">
                        <p><?php echo $latestlistepisode->description;?></p></div>
                </div>  
            </div>
            <h3 class="list_episdoe">List episode</h3>
<!-- for -->
                        <ul class="listing items lists">  
                <?php
               
                $arraySize = count($latestlistepisode->links);
                for( $i=0; $i < $arraySize; $i++ ) : ?><li class="video-block ">
            <a href="<?php echo $latestlistepisode->links[$i]; ?>">
               
                   <div class="img">
                        <div class="picture">
                            <img src="<?php echo $latestlistepisode->img; ?>" alt="<?php echo $latestlistepisode->episodes[$i]; ?>" />
                        </div>
                        <div class="hover_watch"><div class="watch"></div></div>
                         <div class="type <?php echo $latestlistepisode->type;?>"><span><?php echo $latestlistepisode->type;?></span></div>
                </div>
                <div class="name">
                        <?php echo $latestlistepisode->episodes[$i]; ?>      
                </div>
                <div class="meta">
                    <span class="date"><?php echo $latestlistepisode->dates[$i]; ?></span>
                 </div>
            </a>
        </li>
          <?php endfor; ?>
        <div class="clr"></div>
                        </ul>
                        <!-- end for -->
            <div class="clr"></div>
<div class="comment">
    <div id="disqus_thread"></div>
   

</div>
        </div>
        <div class="video-info-right">
            <h4 class="widget-title">Latest Episodes</h4>
            <!-- for -->
                        <ul class="listing items videos">
                           
                <?php foreach ($latestsub as $drama) : ?><li class="video-block ">
            <a href="<?php echo slugify($drama->name); ?>">
               
                   <div class="img">
                        <div class="picture">
                            <img src="<?php echo $drama->img; ?>" alt="<?php echo $drama->name; ?>" />
                        </div>
                        <div class="hover_watch"><div class="watch"></div></div>
                       
                </div>
                <div class="name">
                        <?php echo $drama->name; ?>  
                </div>
                <div class="meta">
                    <span class="date"><?php echo $drama->date; ?></span>
                 </div>
            </a>
        </li><?php endforeach ?>
         
        <div class="clr"></div>                        </ul>
                        <!-- end for -->
        </div>
    </div>

                </div>
                <div class="clearfix"></div>
            </div>
            <div id="footer">
        <div class="main-content">
            <div class="clearfix"></div>
            <div class="copyright">
                <p>Copyright <?php echo $Title; ?> All rights reserved.</p>
            </div>
        </div>
</div>
        </section>
</div>
<div id="off_light"></div>
<div class="clr"></div>
<div class="mask"></div>
<script type="text/javascript" src="/video/js/hamfunction.js?v=8.1"></script>
<script type="text/javascript" src="/video/js/combo.js?v=8.1"></script>
<script type="text/javascript">
        $("body").delegate('#select-iframe-to-display','change',function () {
            var value=$(this).val()
            var afterSplitted=value.split('-#-');
            var host=afterSplitted[afterSplitted.length-1];
            var videoLink=afterSplitted[0];
            if(host=="main-streamsb"){
                $("#iframe-to-load").attr('src',""+videoLink);
            }else if(host=="backup"){
                $("#iframe-to-load").attr('src',"//"+videoLink);
            }
        })
</script>

</body>
</html>