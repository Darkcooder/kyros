jQuery(document).ready(function () {

  if (jQuery("[rel=tooltip]").length) {jQuery("[rel=tooltip]").tooltip();}
  jQuery('button').addClass('btn');
// ____________________________________________________________________________________________ resize display
/*
        var myWidth = 0;
        myWidth = window.innerWidth;
        jQuery('body').prepend('<div id="size" style="background:#000;padding:5px;position:fixed;z-index:999;color:#fff;">Width = '+myWidth+'</div>');
        jQuery(window).resize(function(){
            var myWidth = 0;
            myWidth = window.innerWidth;
            jQuery('#size').remove();
            jQuery('body').prepend('<div id="size" style="background:#000;padding:5px;position:fixed;z-index:999;color:#fff;">Width = '+myWidth+'</div>');
        });
*/
// ____________________________________________________________________________________________ responsive menu

	var mainMenu = jQuery('.main_menu ul.menu');
  mainMenu.find('li.parent > a').append('<span class="arrow"></span>');
  mainMenu.find(' > li').last().addClass('lastChild');
// ____________________________________________________________________________________________

 });

 window.addEvent('load', function() {
 document.getElements('.block_icons, .photo_block').each(function(element, i) {
  elementsToAnimate.push(['queue_anim', element, element.getPosition().y]);
 });
});
// scroll effects
//
// animations
var elementsToAnimate = [];
// scroll event
window.addEvent('scroll', function() {
 // animate all right sliders
 if(elementsToAnimate.length > 0) {  
  // get the necessary values and positions
  var currentPosition = window.getScroll().y;
  var windowHeight = window.getSize().y;
  // iterate throught the elements to animate
  if(elementsToAnimate.length) {
   for(var i = 0; i < elementsToAnimate.length; i++) {
    if(elementsToAnimate[i][2] < currentPosition + (windowHeight / 1.25)) {
     // create a handle to the element
     var element = elementsToAnimate[i][1];
     // if there is a queue animation
     if(elementsToAnimate[i][0] == 'queue_anim') {
      element.getElements('.rhombus, .photojs').each(function(item, j) {
       AddClass(item, 'animations-effects', j);
      });
      // clean the array element
      elementsToAnimate[i] = null;
     }
    }
   }
   // clean the array
   elementsToAnimate = elementsToAnimate.clean();
  }
 }
});
//
function AddClass(element, cssclass, i) {
 var delay = element.getProperty('');
 if(!delay) {
  delay = (i !== false) ? i * 150 : 0;
 }
 setTimeout(function() {
  element.addClass(cssclass);
 }, delay);
}





















