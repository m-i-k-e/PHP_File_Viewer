<?php
function showContent($path, $sortType/* , $sortOrder */){

if ($handle = opendir($path))	
{

	$temp = dirname($path);
	
	echo "<div class='tabMenu'>";
		
	if ($path != "./pictures")  {	
	// Add the current path and directory to the $crumbArray	
		$crumbArray[] = $path;
	
		$crumbArray[] = $temp;
    // Build $crumbArray
			while  ($temp != "./pictures")	{
		
				$temp2 = dirname($temp);
				$crumbArray[] = $temp2;
				
			$temp = $temp2;
			}	
	 // Reverse it		
			$revCrumbArray = array_reverse($crumbArray);
		
		for ($i=0; $i<= count($revCrumbArray) -2; $i++)  {
			
	// Output it	
		if (basename($revCrumbArray[$i] != "./pictures"))	{
			
				echo "<a href='".$_SERVER['PHP_SELF']."?path=".$revCrumbArray[$i]."'>"
			   .basename($revCrumbArray[$i])."</a> 
			   <span class='topMenuSpacer'> > </span>" ;
			}  
			
		else	{
					echo "<a href='".$_SERVER['PHP_SELF']."?path=".$revCrumbArray[$i]."'>
				   Home</a> 
				   <span class='topMenuSpacer'> > </span>" ;
				}

			}
				// the current directory name - not a link
				echo "<div class='basename'>" .basename($revCrumbArray[$i]) ."</div>";
			
			}
		else	{
					// the home link
					echo "Home" ;
				}
			
	echo "</div>" ;
	
	// sorter row  - for the future?
	
	// echo "<div class='selectionRow'>
    //        	<div class='sortByName'><div>File name</div><span class='fileSortOrder'></span></div>
   //         	<div class='sortByDate'><div>Date Created</div><span class='dateSortOrder'></span></div>
   //         </div>"	;		
   
       while (false !== ($file = readdir($handle))) {
           if ($file != "." && $file != "..") {
               $fName = $file;
               $file = $path.'/'.$file;
            	if(is_file($file)) {
		  	
				// Hide Directories we don't want to display //
				
					$fext = substr($fName, strrpos($fName, '.') + 1);
		 
						
					if ((substr($fName,0,1) != '.') 
						&& ($fName != 'Thumbs.db') 
						&& ($fName != 'AC_RunActiveContent.js') 
						&& ($fext != 'inc') 
						&& ($fext != 'swf') )	{
		  
						// read the stuff into arrays, so directories and files can be seperated.				
					
							$fileArray[] = $file;
							$fileTimeArray[] = date ('d-m-Y H:i:s', filemtime($file));
						}
						
				 // Hide filetypes we don't want to display //
						
				  } elseif (is_dir($file) 
						&& ($fName != '.TemporaryItems') 
						&& ($fName != 'Scripts') 
						&& ($fName != 'jquery') 
						&& ($fName != 'CSS') 
						&& ($fName != 'css') 
						&& ($fName != 'images') 
						&& ($fName != 'js') 
						&& ($fName != 'JS') 
						&& ($fName != 'Images')  
						&& ($fName != 'styles')
						&& ($fName != 'scripts') 
						&& ($fName != 'includes')
						&& ($fName != 'Includes') 
						&& ($fName != 'SpryAssets')
						&& ($fName != '_notes')
						&& ($fName != 'img')
						&& ($fName != 'old')
						&& ($fName != '.sass-cache')
						&& ($fName != 'stylesheets')) {
							
							$dirArray[] = $file;
						}
          			 }
       			}
			closedir($handle);
		}	
 // print out directories
 
   if ($dirArray){
  // 	echo $sortOrder;
   		
   			subval_sort($dirArray, $sortType/* , $sortOrder */);
   	
   		
   		foreach ($dirArray as $value) {
   			   			
			$dirName = basename($value);
			
			 /* print "<a href='".$_SERVER['PHP_SELF']."?path=".$value."&sort=name'> */
			 print "<a href='".$_SERVER['PHP_SELF']."?path=".$value."'>
					<div class='div_1 directoryList'>
						<div class='leftColDir'>
							<img class='folder-image' src='style/images/dir.gif' width='16' height='16' alt='dir'/>
							   <span class='dirName'>".$dirName."</span>
						</div>"
						."<div class='middleCol bottomLine' ><span>"
						.date ('d-m-Y H:i:s', filemtime($value))
						."</span></div>"
					."</div>
				</a>";
			
		}
	}
	
// 	Print out files

printOut($fileArray, $sortType/* , $sortOrder */);

}

function printOut($fileArray, $sortType/* , $sortOrder */) {
	if ($fileArray)	{
			 
			 for ($i=0; $i<= count($fileArray) -1 ; $i++)  {
				
				$tempName = basename($fileArray[$i]);
				$tempurl = $fileArray[$i];
				$tiempo = filemtime($fileArray[$i]);
				$tempMeta = get_meta_tags($tempurl);
				$tempMetaTag = $tempMeta['state'];
				
		//	Build arrays as I can't figure out how to sort the array by 'state' then name :(			
													
				$big[] = array("state" => $tempMetaTag, "loc" => $tempurl, "name" => $tempName, "time" =>$tiempo );
		
			}
		
	// These extra arrays will come in handy if you want to enable the meta tag reading of the files 
	// (set in the FW export by a customised Slices.XTT file). They enable to set an unique style tag for any type of
	// predefined array.
		
		if ($big) {	
			for ($i=0; $i<= count($big) -1 ; $i++)  {
							
				if ($big[$i]['state'] == "Approved") {
					$approvedArray[] = $big[$i];
				}
				elseif ($big[$i]['state'] == "In Progress") {
					$inProgressArray[] = $big[$i];
				}
				elseif ($big[$i]['state'] == "Archived") {
					$archivedArray[] = $big[$i];
				}
				else
				$junkArray[] = $big[$i];
			}
				
			if ($approvedArray) {
				outputArray($approvedArray, $sortType/* , $sortOrder */);
			}
			if ($inProgressArray) {
				outputArray($inProgressArray, $sortType/* , $sortOrder */);
			}
			if ($archivedArray) {
				outputArray($archivedArray, $sortType/* , $sortOrder */);
			}
			if ($junkArray) {
				outputArray($junkArray, $sortType/* , $sortOrder */);
			}		
				
		}
	}  

}

// This picks up the 'state' meta tag (if any) which can be written by FW on output. It sets styles depending on what the tag says //

function outputArray($arrayName, $sortType/* , $sortOrder */)	{
	$arrayName = subval_sort($arrayName,$sortType/* , $sortOrder */);
	$styleTag =  $arrayName[0]['state'];
	
	switch ($styleTag)	{
		case "Approved":
			$theStyle = "approved";
			break;
		case "Archived":
			$theStyle = "historical";
			break;
		case "In Progress":
			$theStyle = " ";
			break;
	}


	for ($i=0; $i<= count($arrayName) -1 ; $i++)  {
	 
	 $fileName = $arrayName[$i]['name'];

	 $modTime = date ('d-m-Y H:i:s', $arrayName[$i]['time']);
	 $fileUrl = $arrayName[$i]['loc'];
	 $stateMetaTag = $arrayName[$i]['state'];

	 echo "<a href='".$fileUrl."'>
	 			<div class='div_1'>	
		 			<div class='leftColFile ".$theStyle."'>
					<span class='fileName'>".$fileName."</span>
				</div>
				<div class='middleCol bottomLine ".$theStyle."'>
					<span>"
					.$modTime."</span>
				</div>
			</div>
		 </a>";	
	}
/* removed .$stateMetaTag. from div above	  */
/*  REMOVED <div class='rightCol bottomLine ".$theStyle."'></div>   */
}


function subval_sort($a,$subkey/* ,$sortOrder */) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
/* These commented out lines - and all the "$sortOrder" comments are to turn off the file and date sort options.
	when turned on, these display a bar at the top of the file list that is clickable to sort by filename, inverse filename,
	date, and inverse date. They are not completed, as it works on the file sorts, but is not yet working on the directory sorts -
	directory sorts and file name sorts are done differently.
/*

if ($sortOrder == "nameInverse" || $sortOrder == "timeInverse") {
		arsort($b);
		foreach($b as $k=>$v) {
			$c[] = $a[$k];
		}
		return $c;
	}
	else {
*/
		asort($b);
		foreach($b as $k=>$v) {
			$c[] = $a[$k];
		}
		return $c;
	/* } */
	
}

?>