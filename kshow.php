<?php 
include ('config.php');
// KShow
$newseason = $APIbaseURL."/api/kshow";
if(isset($_GET['page'])){
$newseason = $APIbaseURL."/api/kshow?page=".$_GET['page'];
}
$arrContextOptions=array(
    "ssl"=>array(
          "verify_peer"=>false,
          "verify_peer_name"=>false,
      ),
  );  
$ambil = file_get_contents($newseason, false, stream_context_create($arrContextOptions));
$newseason = json_decode($ambil);


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

<title><?php echo $NewSeasonTitle; ?> - Watch Korea videos from everywhere</title>
<meta name="robots" content="noodp, noydir" />
<meta name="description" content="<?php echo $Title; ?> - Watch Korea videos from everywhere">
<meta name="keywords" content="<?php echo $Title; ?> , upload drama , streaming drama,watch drama online">
<meta itemprop="image" content="/images/logo.png"/>

<meta property="og:locale" content="en_US"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="Kshow - <?php echo $Title; ?> - Watch Korea videos from everywhere"/>
<meta property="og:description" content="<?php echo $Title; ?> - Watch Korea videos from everywhere">
<meta property="og:url" content=""/>
<meta property="og:image" content="/images/logo.png"/>
<meta property="og:image:secure_url" content="/images/logo.png"/>

<meta property="twitter:card" content="summary"/>
<meta property="twitter:title" content="Kshow - <?php echo $Title; ?> - Watch Korea videos from everywhere"/>
<meta property="twitter:description" content="<?php echo $Title; ?> - Watch Korea videos from everywhere"/>

<link rel="canonical" href="/kshow"/>
<link rel="alternate" hreflang="en-us" href="/kshow"/>



    
        <link rel="stylesheet" type="text/css" href="/video/css/font-awesome.min.css??v=8.1" />
        <link rel="stylesheet" type="text/css" href="/video/css/style.css??v=8.1" />
    
    <script type="text/javascript" src="/video/js/jquery.js"></script>
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
            <img src="/img/logo_vid.png?3" class="retina-header" alt="<?php echo $NewSeasonTitle; ?> : - Watch Korea videos from everywhere" />            </a>
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
            <li><a href="/"><?php echo $RecentlyAddedSubTitle; ?></a></li>
            <li><a href="/recently-added-raw"><?php echo $RecentlyAddedRawTitle; ?></a></li>
			<li><a href="/movies"><?php echo $MoviesTitle; ?></a></li>
            <li class="active"><a href="/kshow"><?php echo $NewSeasonTitle; ?></a></li>
            <li><a href="/popular"><?php echo $PopularTitle; ?></a></li>
            <li><a href="/ongoing-series"><?php echo $OngoingTitle; ?></a></li>
        </ul>
    </div>
</div>
<div class="clearfix"></div>
                <div class="main-content">
                    
<div class="main-inner">
    <div class="section-header">
        <h3 class="widget-title"><i class="fa fa-play"></i> <?php echo $NewSeasonTitle; ?></h3>
    </div>
    <div class="clearfix"></div>
    <div class="vc_row wpb_row vc_row-fluid vc_custom_1404913114846">
        <div class="vc_col-sm-12 wpb_column column_container">
            <div class="wpb_wrapper">
                    <div class="video_player followed  default">
                        <!-- for -->
                        <ul class="listing items">
                            
                <?php foreach ($newseason as $drama) : ?><li class="video-block ">
            <a href="<?php echo $drama->link; ?>">
                
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
        <div style="margin-right: auto ; margin-left: auto"> 
            <div class="contus_tablenav-pages">
                <div class="pagination">
                    <nav>
					 <?php

					$wrap = "<ul class='pagination'>";
					$current_page = isset($_GET['page'])?$_GET['page'] : 1;
					$nextpage = $current_page + 1;
					$prevpage = $current_page - 1;

					if($current_page >= 2){
					$wrap .= "<li class='previous'><a href='?page=$prevpage' data-page='$prevpage'> < </a></li>";
					}

					for($i = $current_page-1 ; $i <= $current_page+4 ; $i++){
					if($i == 0){continue;}
						$active = "";
						if($i==$current_page)
						{
						  $active = "active";
					 
						}

						$wrap .= "<li class='$active'><a href='?page=".$i."'>".$i."</a><li>";
					}
					echo $wrap . "<li class='next'><a href='?page=$nextpage' data-page='$nextpage'> > </a></li></ul>";
					?>
                    </nav>
                </div>
            </div>
        </div>
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


</body>
</html>