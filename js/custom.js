//  MAIN JQUERY LOOP   //
//
$(document).ready(function(){

//  this block is for the little arrow that points up or down depending on your sort order
// 	the sort order row divs (which appear at the top of the file list) - (and the associated php code) are commented out at the moment.

	var whatSortOrder = fixUpLinks();
	
	if ((whatSortOrder == "name") || (whatSortOrder == "nameInverse")) {
		$(".selectionRow .sortByName").toggleClass("selected"); 
		$(".selectionRow .sortByName .fileSortOrder").toggleClass("backgroundArrowVisible");
		
	}
	else if ((whatSortOrder == "time") || (whatSortOrder == "timeInverse")) {
		$(".selectionRow .sortByDate").toggleClass("selected");
		$(".selectionRow .sortByDate .dateSortOrder").toggleClass("backgroundArrowVisible");
	}
	
	if (whatSortOrder == "name") {
		$(".selectionRow .sortByName .fileSortOrder").toggleClass("sorted");
	}
	
	
	if (whatSortOrder == "time") {
		$(".selectionRow .sortByDate .dateSortOrder").toggleClass("sorted");
	}
		
	fixLines(".leftColFile");
	 // fixLines(".leftColDir");
	 
//	 fixUpLinks();
	 
	$(".selectionRow .sortByName").on("click", function(){
		var whichSort = (fixUpLinks());
		
		if ((whichSort == "name" ) || (whichSort == "" )) {
			sortMe("nameInverse");	
		}
		else if ((whichSort = "nameInverse")) {
			sortMe("name");
		}			
		
	});
	
	$(".selectionRow .sortByDate").on("click", function(){
		
		var whichSort = (fixUpLinks());
		if (whichSort == "time") {
			sortMe("timeInverse");	
		}
		else if (whichSort = "timeInverse") {
			sortMe("time");
		}	
	});

});


function fixUpLinks() {
	// returns the value of the current query string //
	var fName = window.location.href;
	fName = fName.split('&');
	fName = (fName[fName.length - 1]).split('=');
	// console.log (fName[fName.length - 1]);
	return (fName[fName.length - 1]);
	
}

function sortMe(how) {
	
	// splits off extra query strings and puts just one on //
	var fName = window.location.href;
	fName = fName.split('&');
	fName = fName[0] + "&sort=" + how;
	window.location = fName;
}


function fixLines(whatLines) {	
/*
	 This adds classes to stacked menu list items based on their height. It is made to reposition arrows in :after pseudo classes. The reason it does not try to simply alter the height attribute on the pseudo class is that this is not possible. The only way to increase the height is to add another class with the height already
baked in.
*/
	
	if ($(whatLines)) {
		
		$(whatLines).each(function(){
			var rowHeight = $(this).height();
			
			// console.log(rowHeight)
			if (rowHeight < 25)	{  							// single line do nothing
															
			}
				else if (rowHeight > 24 && rowHeight < 49)  // double line
			{
				$(this).addClass('twoLines')
			}
				else if (rowHeight > 48 && rowHeight < 73)  // triple line
			{			
				$(this).addClass('threeLines')
			}
				else 										// fourple line
			{
				$(this).addClass('fourLines')				
			}
					
		});
	}
}