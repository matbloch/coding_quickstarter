
/*------------------------------------*\
	SELECTORS
\*------------------------------------*/


/* check if element exists */
if($(selector).length > 0){}



/* DOM up */
.parents() // multiple levels up, collect all
.parent()  // one level up
.closest() // DOM up, starting with current, ending as soon as found

.last() // last element in DOM selection

/* DOM down */

.find(selector)
.children(selector) // children filtered by optional selector
.first()  // select first element


/* index based */
$('li').slice(start, end);  // range

$("li:gt(3)");  // greater than index 3
$("li:lt(3)");  // lower than index 3


/* storing selectors */

var elements = $("#mySelector");
$elements.on("dblclick", function(event){

    console.log($elements.selector);
	
});​

/* selector intersection */

$selectors.thumbs.filter('.selected') // = $('.thumbs.selected')

/* combining selectors */

$selectors.thumbs.add('.selected') // = $('.thumbs, .selected')

/*------------------------------------*\
	ITERATION
\*------------------------------------*/

/* iterate over DOM elements */

$( "li" ).each( function( index, element ){
	console.log( $( this ).text() );
});

/* iterate over an object */

var sum = 0;
var obj = {
foo: 1,
bar: 2
}

$.each( obj, function( key, value ) {
	sum += value;
});


/*------------------------------------*\
	INDEXING
\*------------------------------------*/

.index()  // get the index of the element

.filter(':eq(' + index + ')')  // get element by index
$("your-pure-css-selector").eq(index)  // same but faster
$( "td:gt(4)" ).css( "backgroundColor", "yellow" );  // elements with index greater than

/*------------------------------------*\
	THIS
\*------------------------------------*/

/* use this - direct selector */
$('#myTask').children().click(function () {
  $(this).remove()
});

/* context */
$( "span", this ) == $( this ).find( "span" )

/* event.target - event handler bound */
$('#myTask').on('click', 'li', function (event) {

  $(event.target).remove();
  
  $(this).hide(); // works also
});



/* this vs $(this) */

$(this) // allows jquery functionss


/*------------------------------------*\
	ON
\*------------------------------------*/

function greet( event ) {
  alert( "Hello " + event.data.name );
}

$( "button" ).on( "click", {
  name: "Karl" // pass data to function
}, greet );

/*------------------------------------*\
	FUNCTIONS
\*------------------------------------*/
function foo(a){
	a = typeof a !== 'undefined' ? a : 42;
}

/*------------------------------------*\
	FUNCTION TIMING
\*------------------------------------*/

var ctime = setTimeout ("myfunc", 30000); // call myfunc after 30 seconds
clearTimeout (ctime); // cancel delayed function call

/*------------------------------------*\
	ANIMATIONS
\*------------------------------------*/

// append & fadeIn
$(HTML.new_question).appendTo('#survey_editor .questions').hide().fadeIn('slow');

// fadeout & remove
$(selector).fadeOut(300, function() { $(this).remove(); });



/*------------------------------------*\
	FUNCTION BINDING
\*------------------------------------*/

<input id="myTextBox" type="text"/>

$("#myTextBox").bind("change paste keyup", function() {
   alert($(this).val()); 
});


/* CUSTOM EVENTS - triggering functions */

methods.show_previous_item = function (){
	$selectors.thumbs_wrp.addClass('selected');
	$selectors.container.trigger('itemChange');
}

// update position: when item is changed
$selectors.container.bind('itemChange', methods.update_item_position);


/*------------------------------------*\
	PLUGINS
\*------------------------------------*/

/*!
 * jQuery lightweight plugin boilerplate
 * Original author: @ajpiano
 * Further changes, comments: @addyosmani
 * Licensed under the MIT license
 */


// the semi-colon before the function invocation is a safety 
// net against concatenated scripts and/or other plugins 
// that are not closed properly.
;(function ( $, window, document, undefined ) {
    
    // undefined is used here as the undefined global 
    // variable in ECMAScript 3 and is mutable (i.e. it can 
    // be changed by someone else). undefined isn't really 
    // being passed in so we can ensure that its value is 
    // truly undefined. In ES5, undefined can no longer be 
    // modified.
    
    // window and document are passed through as local 
    // variables rather than as globals, because this (slightly) 
    // quickens the resolution process and can be more 
    // efficiently minified (especially when both are 
    // regularly referenced in your plugin).

    // Create the defaults once
    var pluginName = 'defaultPluginName',
        defaults = {
            propertyName: "value"
        };

    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        // jQuery has an extend method that merges the 
        // contents of two or more objects, storing the 
        // result in the first object. The first object 
        // is generally empty because we don't want to alter 
        // the default options for future instances of the plugin
        this.options = $.extend( {}, defaults, options) ;
        
        this._defaults = defaults;
        this._name = pluginName;
        
        this.init();
    }

    Plugin.prototype.init = function () {
        // Place initialization logic here
        // You already have access to the DOM element and
        // the options via the instance, e.g. this.element 
        // and this.options
    };

    // A really lightweight plugin wrapper around the constructor, 
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, 
                new Plugin( this, options ));
            }
        });
    }

})( jQuery, window, document );







