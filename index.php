<?php
//*****************************************************************************
//
// MICRO FILE BROWSER  -  Version: 1.3
//
// You may use this code or any modified version of it on your website.
//
// NO WARRANTY
// This code is provided "as is" without warranty of any kind, either
// expressed or implied, including, but not limited to, the implied warranties
// of merchantability and fitness for a particular purpose. You expressly
// acknowledge and agree that use of this code is at your own risk.
//
//*****************************************************************************

//  I've taken the original micro file browser and 
//	 added a bread crumb - type of menu. 
//	 Removed the "up one directory link"
//	 grouped the directories and files together, so the dirs come out on the top
//	  improved the icons, added a favicon, and spruced up the spacing
//    Added tooltips and stles for Approved, Archived, etc.
//	   Ekim Oksus 2011
//	   Fixt stuff 2013

//*****************************************************************************

// have to set the timezone otherwise it fecks up
date_default_timezone_set('Europe/London');

include("functions.php");


	$actpath = isset($_GET['path']) ? $_GET['path'] : './pictures';	
	
/*
	$sortOrder = ($_GET['sort']);
	if ($sortOrder == "") {
*/
	/* 	$sortOrder = "name"; */
	/* } */
	
/*
	if (($sortOrder == "name") || ($sortOrder == "nameInverse")) {
		$sortType = "name";
		}
*/
	/*
else if (($sortOrder == "time") || ($sortOrder == "timeInverse")) {
		$sortType = "time";
	} 
*/
?>

<!DOCTYPE HTML>

    <head>
       <meta charset="UTF-8">
       <title>PHP File Viewer</title>
	   
       <link href="style/css/style.css" rel="stylesheet" type="text/css" />     
       <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	   
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        
        <!--   javascriptz   -->   
		<script src="js/modernizr.custom.56343.js"></script> 
		<script src="js/jquery.min.js"></script> 
		<script src="js/custom.js"></script> 
	
    </head>
    <body>
	
        
            <div class="bannerWrapper">
            	<div class="banner">
		            <div class="logoLeft">
					<?php 
						echo "<a href='" .($_SERVER['PHP_SELF'])."'>"
							."<div class='php_viewer_logo'></div>
						</a>";
					?>
		            </div>
	            
		            <div class="logoRight">
		                <div class="designViewerLogo"></div>
		            </div>
	            </div>
            </div>
            <div id="divGlobalWrapper">
            <div id="contentWrapper">
                  	<?php
                  		$sortType = "name";
                        showContent($actpath, $sortType/* , $sortOrder */);        
                    ?>
             </div>
			 
        </div>
        
    </body>   
</html>
