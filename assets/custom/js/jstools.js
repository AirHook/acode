				/*----------------------------
				 * this jquery function dynamically
				 * spreads the menu items accross
				 */
				$(document).ready(function(){
					$(".click_to_see").click(function(){
						logo_width = $("#logo").width();
						mainmenu_width = $("#mainmenu").width();
						var total_added_width = new Number;
						var count_items = 0;
						$(".menu_item").each(function(){
							this_item_width = $(this).width();
							total_added_width = total_added_width + parseInt(this_item_width);
							count_items++;
						});
						total_space = mainmenu_width - logo_width - total_added_width;
						space = Math.floor(total_space / count_items);
						pix_width = space + "px";
						$(".menu_item").each(function(){
							$(this).css("margin-left", pix_width);
						});
						alert(
							"Logo width - " + logo_width + "\n" +
							"Main menu width - " + mainmenu_width + "\n" +
							"Total menu items width - " + total_added_width + "\n" +
							"Total spance - " + total_space + "\n" +
							"Total items - " + count_items + "\n" +
							"Space in between - " + space
						);
					});
				});
/* 
* This script is to simply erase the value (content) of the input form
* when it gets focus and returns the same value (content) when blurs out.
* However, when a mnanual input has been done, it doesn't work anymore.
* Author: Webguy@bewebbled.com
*
* use on theKey:
* onfocus="clearme(this)" onblur="fillme(this)"
*/

	var input_value = '';

	function clearme(me)
	{
		input_value = me.value;
		if (input_value == 'Name *' || input_value == 'Phone' || input_value == 'Email *' || input_value == 'Comments')
		{
			me.style.color = 'black';
			me.value = '';
		}
		else
		{
			input_value = '';
			return false;
		}	
	}

	function fillme(me)
	{
		var y = me.value;
		if (y == '')
		{
			if (input_value == 'Name *' || input_value == 'Phone' || input_value == 'Email *' || input_value == 'Comments')
			{
				me.style.color = '#a1a1a1';
				if (y == '') me.value = input_value;
			}
			else
			{
				me.style.color = '#a1a1a1';
				if (me.name == 'name') me.value = 'Name *';
				if (me.name == 'phone') me.value = 'Phone';
				if (me.name == 'email') me.value = 'Email *';
				if (me.name == 'comments') me.value = 'Comments';
			}
		}
	}

	function checkme(id)
	{
		var input_name = id + '_name';
		var input_email = id + '_email';
		var input_phone = id + '_phone';
		var input_comments = id + '_comments';
		var alert_msg = '';
		name_check = document.getElementById(input_name);
		if (name_check.value == 'Name *' || name_check.value == '')
		{
			alert_msg = alert_msg + 'NAME field is required.\n';
		}
		email_check = document.getElementById(input_email);
		if (email_check.value == 'Email *' || email_check.value == '')
		{
			alert_msg = alert_msg + 'EMAIL field is required.\n';
		}
		if (alert_msg != '')
		{
			alert(alert_msg + '\nPlease try again.\n');
			return false;
		}
	}
	
/*
* Multi type popup script v1.0 (dropdown menu, tool tip, img tip etc..)
* Created: May 27rd, 2011. This notice must stay intact for usage
* Author: Webguy@bewebbled.com combined scripts from various scripts
* Main source is from Dynamic Drive at http://www.dynamicdrive.com/
*
* use on theKey:
* onmouseover="showObj(objId,me)" onmouseout="closetime()"
*
* use on theObj:
* onmouseover="cancelclosetime()" onmouseout="closetime()"
*/
/* Drop Down hidden menu */

var timeout1		= 100;
var timeout2		= 100;
var timeout3		= 0;
var closetimer		= 0;
var ddmenuitem      = 0;
var ddsubmenuitem	= 0;
var menubar			= 0;
var submenubar		= 0;
var top1			= 0;
var top2			= 0;

// open hidden layer
function mopen(id1,id2,top1,top2) {
	// cancel close timer if from another menu link
	mcancelclosetime();

	// close old layer and refresh old menu bar if from another menu link
	if (typeof id1 == "string") {
		id1 = document.getElementById(id1);
	}
	if (menubar!=id1) {
		if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
	}
	if (menubar) {
		if (top1 != 'na' || top2 != 'na') {					// if not store item, proceed as is
			menubar.style.position="relative";
			menubar.style.top=top1a;
		}
	}

	// get new layer id and show it
	ddmenuitem = document.getElementById(id2);
	opentimer = window.setTimeout(mopentime, timeout1);

	// color or change styles of menu bar upon mouseover
		menubar = id1;
		if (top1 != 'na' || top2 != 'na') {					// if not store item, proceed as is
			menubar.style.position="relative";
			menubar.style.top=top2;

			top1a = top1;
		}
}
// delay show of hidden layer (main and sub)
function mopentime() {
	if(ddmenuitem) ddmenuitem.style.visibility = 'visible';
}
function msubopentime() {
	if(ddsubmenuitem) ddsubmenuitem.style.visibility = 'visible';
}
// close shown layer
function mclose() {
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
	if(ddsubmenuitem) ddsubmenuitem.style.visibility = 'hidden';

	// refresh menu bar
	if(menubar) {
		if (top1 != 'na' || top2 != 'na') {					// if not store item, proceed as is
			menubar.style.position="relative";
			menubar.style.top=top1a;
		}
	}

	// reset variables
	menubar = 0;
	ddmenutiem = 0;
	ddsubmenuitem = 0;
}
// go close timer and sub timer - this is on mouse out
function mclosetime() {
	closetimer = window.setTimeout(mclose, timeout2);
}
function msubclosetime() {
	closesubtimer = window.setTimeout(msubclose, timeout3);
}
// cancel close timer
function mcancelclosetime() {
	if(closetimer) {
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}
function msubcancelclosetime() {
	if(closesubtimer) {
		window.clearTimeout(closesubtimer);
		closesubtimer = null;
	}
}

// open sub menu
function msubopen(id3, id4) {
	// cancel close timer if from another menu link
	mcancelclosetime();
	//msubcancelclosetime();
	
	// get id elements and show
	if (typeof id3 == "string") {
		id3 = document.getElementById(id3);
	}
	
	// if not saved submenu bar and submenu items exists, close submenu items
	if (submenubar!=id4) {
		if(ddsubmenuitem) {
			ddsubmenuitem.style.visibility = 'hidden';
		}
	}
	
	// assign and open submenu items
	ddsubmenuitem = id3;
	opensubtimer = window.setTimeout(msubopentime, timeout3);
	
	// remember submenu bar
	submenubar = id4;
}

// close sub menu
function msubclose() {
	if(ddsubmenuitem) ddsubmenuitem.style.visibility = 'hidden';
	ddsubmenuitem = 0;
}

var content;
var oldContent;
var newContent;

function color_me(id) {
	// get id elements 
	if (typeof id == "string") {
		id = document.getElementById(id);
	}
	oldContent = id.innerHTML;
	id.innerHTML = '<span style="color:#846921">' + oldContent + '</span>';
}

function uncolor_me(id) {
	// get id elements 
	if (typeof id == "string") {
		id = document.getElementById(id);
	}
	id.innerHTML = oldContent;
}

	/* ---------------------------------
	 * Used for mosue over on product detail page
 	 */

	// set the object variable (drop down menu div, tool tip div, img tool tip div, etc..)
	var theObj = 0;

	var theKey			= 0;			// the object initiating script theObj
	var opentimeout		= 100;			// time delay for the hidden object to pop out
	var closetimeout	= 300;			// time delay for the object to hide again
	
	// show theObj
	function showObj(objID,me) {
		theKey = me;
		// cancel close timeout if from another theKey
		cancelclosetime();
		// get div element by id
		if (typeof objID == "string") {
			objID = document.getElementById(objID);
		}
		// close any other theObj open usually from another theKey
		if (theObj && theObj != objID) theObj.style.visibility = 'hidden';
		// get the ID and show theObj using time delay
		theObj = objID;
		opentimer = window.setTimeout(opentime, opentimeout);
	}

	// move theObj near mouse before showing via updatePos
	function opentime() {
		if (theObj) theObj.style.visibility = 'visible';
	}

	// hiding theObj
	function close() {
		if (theObj) theObj.style.visibility = 'hidden';
		// reset var
		theObj = 0;
	}

	// closing theObj on mouseout
	function closetime() {
		closetimer = window.setTimeout(close, closetimeout);
	}

	// cancel close timer (this is when mouse hovers out of theKey on to theObj
	function cancelclosetime() {
		if (closetimer) {
			window.clearTimeout(closetimer);
			closetimer = null;
		}
	}

	// close theObj when click-out
	document.onclick = close;
	

	/* ---------------------------------
	 * Modal Script
 	 */
	// Get the modal
	var modal = document.getElementById('modal-regular2');

	// Get the button that opens the modal
	var btn = document.getElementById("send_inquiry");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on the button, open the modal
	/*
	btn.onclick = function() {
		modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function() {
			modal.style.display = "none";
	}
	*/
