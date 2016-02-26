# PHP Cheatsheet


## Design Patterns


### Factory

Used to create class instances.
```php
class Automobile
{
    private $vehicleMake;
    private $vehicleModel;

    public function __construct($make, $model)
    {
        $this->vehicleMake = $make;
        $this->vehicleModel = $model;
    }

    public function getMakeAndModel()
    {
        return $this->vehicleMake . ' ' . $this->vehicleModel;
    }
}

class AutomobileFactory
{
    public static function create($make, $model)
    {
        return new Automobile($make, $model);
    }
}

// have the factory create the Automobile object
$veyron = AutomobileFactory::create('Bugatti', 'Veyron');

print_r($veyron->getMakeAndModel()); // outputs "Bugatti Veyron"
```

### Singleton

- Makes sure only one class instance exists at a time (e.g. Configuration class or shared ressource)

```php
class Singleton
{
    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;
    
    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}

class SingletonChild extends Singleton
{
}

$obj = Singleton::getInstance();
var_dump($obj === Singleton::getInstance());             // bool(true)

$anotherObj = SingletonChild::getInstance();
var_dump($anotherObj === Singleton::getInstance());      // bool(false)

var_dump($anotherObj === SingletonChild::getInstance()); // bool(true)
```


## OOP

As of PHP 5, all objects are passed and assigned by reference.

**Class Definition**

```php
class Auth
{

	/*
	called on:
	$auth = new Auth;
	*/
    function __construct()
    {
	}

	/* STATIC: method can be called without initialization of the object:
		Auth::handleLogin();
	*/

	/* self referencing */
	public static $my_static = 'foo';
    public static function handleLogin()
    {

		// Use self:: instead of $this-> for static methods. $ needed for variables
        return self::$my_static;
    }

    public function currentUserCan($action){
    }

}
```


**Accessing the Properties**


- For reserved names:
`$obj->{'date'}`



## Namespaces

**Definition**

```php
namespace MyProject\Blog\Admin;
namespace MyNamespace;
```

**Referencing**


```php
My\Foo\Bar // class in My\Foo namespace
\My\Foo\myFunction() // function
```

**Example**

file1.php
```php
namespace Mymodule1;

class Testclass
{
	public static function hello()
	{
		echo 'hello';
	}

}
```
file2.php: NO NAMESPACE

```php
include file1.php

class Testclass
{
	public static function welcome()
	{
		echo 'welcome';
	}

}

// this class
Testclass::welcome();

// the imported class
\Mymodule\Testclass::hello();
```

file3.php
```php
namespace Mymodule2;

class Testclass
{
	public static function clone_welcome()
	{
		include file2.php
		// call class in file that has no/top namespace
		\Testclass::welcome();
	}

}
```



**Combination**

```php
namespace \MyProject;
require_once "file1.php";
class myClass {}
function myFunction() {}

// fully-qualified names
\MyProject\myFunction();
\MyProject\Blog\myFunction();

// qualified name
\Blog\myFunction(); //resolves to \MyProject\Blog\myFunction();

// unqualified name
$test = new myClass();
```



## Array Handling


/* array_filter */
$new_array = array_filter($array, function($obj){
    if (isset($obj->admins)) {
        foreach ($obj->admins as $admin) {
            if ($admin->member == 11) return false;
        }
    }
    return true;
});

/* apply function to all elements */

array_walk($array, 'myfuncname');



/* gibt array zurück */

$func = function($value) { return $value * 2; };
print_r(array_map($func, range(1, 5)));

/* indexing */

$reindexed_array = array_values($old_array);

/* sorting */

ksort($array) 	// Sorts an array by key (ascending: A-Z, 1-9)
ksort($array)  // Sort array by key descending (9-1, Z-A)


## Typecasting

/* object to array */
$array =  (array) $yourObject;

/* array to object */
$myObj = (object) $array;


/* to int */

intval($string);


## CURL

/* standard method (does not work with SSL) */

// init
$curl = curl_init();
// options
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://testcURL.com/?item1=value&item2=value2',
    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
    CURLOPT_POST => 1, // $_POST request
    CURLOPT_POSTFIELDS => array(  // our data
        'item1' => 'value',
        'item2' => 'value2'
    )
));
// Send the request
$resp = curl_exec($curl);
// Close request
curl_close($curl);


/* options */

CURLOPT_RETURNTRANSFER - Return the response as a string instead of outputting it to the screen
CURLOPT_CONNECTTIMEOUT - Number of seconds to spend attempting to connect
CURLOPT_TIMEOUT - Number of seconds to allow cURL to execute
CURLOPT_USERAGENT - Useragent string to use for request
CURLOPT_URL - URL to send request to
CURLOPT_POST - Send request as POST
CURLOPT_POSTFIELDS - Array of data to POST in request



## Debugging and Exceptions

try {
	$ch = curl_init();

	if (FALSE === $ch)
		throw new Exception('failed to initialize');

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, 'http://www.test.com');
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

	$content = curl_exec($ch);

	if (FALSE === $content)
		throw new Exception(curl_error($ch), curl_errno($ch));

	// ...process $content now
} catch(Exception $e) {

	trigger_error(sprintf(
			'Curl failed with error #%d: %s',
			$e->getCode(), $e->getMessage()),
		E_USER_ERROR);

}

## Error handling

function inverse($x) {
    if (!$x) {
        throw new Exception('Division by zero.');
    }
    return 1/$x;
}

try {
    echo inverse(5) . "\n";
    echo inverse(0) . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// Continue execution
echo "Hello World\n";


# Design patterns

## Interfaces

- Defines the functionality of an object

## Traits

- Gives object ability to do smth.
- Does not rely on inheritance
- Reduce code duplicates

```php
// define shared methods in trait
trait Sharable {
  public function share($item)
  {
    return 'share this item';
  }
}

// define class
class Post {
  use Sharable;
}

$post = new Post;
echo $post->share(''); // 'share this item'

```


# Example patterns

## 01: Database adapters

```php
namespace LibraryDatabase;
 
class PdoAdapter implements DatabaseAdapterInterface
{
    protected $config = array();
    protected $connection;
    protected $statement;
     
    public function __construct($dsn, $username = null, $password = null, array $options = array())
    {
        // fail early if the PDO extension is not loaded
        if (!extension_loaded("pdo")) {
            throw new InvalidArgumentException(
                "This adapter needs the PDO extension to be loaded.");
        }
        // check if a valid DSN has been passed in
        if (!is_string($dsn) || empty($dsn)) {
            throw new InvalidArgumentException(
                "The DSN must be a non-empty string.");
        }
        $this->config = compact("dsn", "username",
            "password", "options");
    }
     
    public function connect()
    {
        if ($this->connection) {
            return;
        }
        try {
            $this->connection = new PDO(
                $this->config["dsn"], 
                $this->config["username"], 
                $this->config["password"], 
                $this->config["options"]
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(
                PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }
     
    public function disconnect()
    {
        $this->connection = null;
    }
     
    public function executeQuery($sql, array $parameters = array())
    {
        $this->connect();
        try {
           $this->statement = $this->connection->prepare($sql);
           $this->statement->execute($parameters);
           return $this->statement->fetchAll(PDO::FETCH_CLASS,
               "stdClass"); 
        }
        catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }
}
```


Usage:

```php
$adapter = new PdoAdapter("mysql:dbname=mydatabase",
    "myfancyusername", "myhardtoguespassword");
 
$guests = $adapter->executeQuery("SELECT * FROM users WHERE role = :role", array(":role" => "Guest"));
 
foreach($guests as $guest) {
    echo $guest->name . " " . $guest->email . "<br>";
}
```



