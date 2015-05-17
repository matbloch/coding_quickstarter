


public class MyFirstJavaProgram {

   /* This is my first java program.  
    * This will print 'Hello World' as the output
    */

    public static void main(String []args) {
       System.out.println("Hello World"); // prints Hello World
    }
} 


/*

public static void main(String args[])
Java program processing starts from the main() method which is a mandatory part of every Java program..

*/



/*------------------------------------*\
    DATATYPES
\*------------------------------------*/


/* Arrays */


/* Enums */

class FreshJuice {

   enum FreshJuiceSize{ SMALL, MEDIUM, LARGE }
   FreshJuiceSize size;
}

public class FreshJuiceTest {

   public static void main(String args[]){
      FreshJuice juice = new FreshJuice();
      juice.size = FreshJuice. FreshJuiceSize.MEDIUM ;
      System.out.println("Size: " + juice.size);
   }
}

/*------------------------------------*\
    OOP
\*------------------------------------*/


// constructors - same name as class

public class Puppy{

	int puppyAge;


   public Puppy(){		// constructor with no input argument
   }

   public Puppy(String name){
      // This constructor has one parameter, name.
   }
   
   public void setAge( int age ){
       puppyAge = age;
   }
   
   public static void main(String []args){
      // Following statement would create an object myPuppy
      Puppy myPuppy = new Puppy( "tommy" );
	  
	  
	  myPuppy.setAge( 2 );
   }
   
}


// accessing parameters & methodsd

/* First create an object */
ObjectReference = new Constructor();

/* Now call a variable as follows */
ObjectReference.variableName;

/* Now you can call a class method as follows */
ObjectReference.MethodName();


/*------------------------------------*\
    PACKAGES
\*------------------------------------*/