
/*------------------------------------*\
	Namespaces
\*------------------------------------*/


var AppSpace = AppSpace || {};

AppSpace.Podcast = function {
    this.title = 'Astronomy Cast';
    this.description = 'A fact-based journey through the galaxy.';
    this.link = 'http://www.astronomycast.com';
};

AppSpace.Podcast.prototype.toString = function() {
    return 'Title: ' + this.title;
}

/*------------------------------------*\
	OOP
\*------------------------------------*/


// global namespace
var MYAPP = MYAPP || {};

// sub namespace
MYAPP.event = {};


// Create container called MYAPP.commonMethod for common method and properties
MYAPP.commonMethod = {
  regExForName: "", // define regex for name validation
  regExForPhone: "", // define regex for phone no validation
  validateName: function(name){
    // Do something with name, you can access regExForName variable
    // using "this.regExForName"
  },
 
  validatePhoneNo: function(phoneNo){
    // do something with phone number
  }
}

// Object together with the method declarations
MYAPP.event = {
    addListener: function(el, type, fn) {
    //  code stuff
    },
   removeListener: function(el, type, fn) {
    // code stuff
   },
   getEvent: function(e) {
   // code stuff
   }
  
   // Can add another method and properties
}

//Syntax for Using addListner method:
MYAPP.event.addListener("yourel", "type", callback);


/*------------------------------------*\
	Arrays
\*------------------------------------*/

// initialize array
var arr = [
    "Hi",
    "Hello",
    "Bonjour"
];

// append new value to the array
arr.push("Hola");

// display all values
for (var i = 0; i < arr.length; i++) {
    alert(arr[i]);
}

/*------------------------------------*\
	CLASSES
\*------------------------------------*/

function User (theName, theEmail) {
    this.name = theName;
    this.email = theEmail;
    this.quizScores = [];
    this.currentScore = 0;
}

// all instances can access these functions
User.prototype = {
    constructor: User, // constructor method gets overwritten by writing to the prototype property
    saveScore:function (theScoreToAdd)  {
        this.quizScores.push(theScoreToAdd)
    },
    showNameAndScores:function ()  {
        var scores = this.quizScores.length > 0 ? this.quizScores.join(",") : "No Scores Yet";
        return this.name + " Scores: " + scores;
    },
    changeEmail:function (newEmail)  {
        this.email = newEmail;
        return "New Email Saved: " + this.email;
    }
}




/*------------------------------------*\
	ELSE IF
\*------------------------------------*/

if (time < 20) {
     greeting = "Good day";
 } else {
     greeting = "Good evening";
 }

if (time < 10) {
     greeting = "Good morning";
 } else if (time<20) {
     greeting = "Good day";
 } else {
     greeting = "Good evening";
 }
 
/* shorthand/ternary */

var num = div == "choice1" ? 1 : 2;
 
 /* multiple operations (separation by comma) */
nAge > 18 ? (
    alert("Ok, you can go."),
    location.assign("continue.html")
) : (
    bStop = true,
    alert("Sorry, you are much too young!")
);
 