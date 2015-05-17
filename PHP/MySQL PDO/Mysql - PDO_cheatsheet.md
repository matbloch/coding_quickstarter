<?php


/*------------------------------------*\
    CONNECTION
\*------------------------------------*/






/*------------------------------------*\
    INPUT VARIANTEN
\*------------------------------------*/


// 1. Input variante (associative array)

$data_array = array('anrede' => 'Herr', 'name' => 'Müller');

$query = 'INSERT INTO tablename SET anrede = :anrede, name = :name';
$stmt = $pdo->prepare($query);
$result = $stmt->execute($data_array);

// 2. Input variante (quickform)

$sql = "INSERT INTO books (title,author) VALUES (:title,:author)";
$q = $conn->prepare($sql);
$q->execute(array(':author'=>$author,':title'=>$title));

// 3. Input variante  (quickform)

$sql = "UPDATE books 
        SET title=?, author=?
		WHERE id=?";
		
$q = $pdo->prepare($sql);
$q->execute(array($title,$author,$id));

/*------------------------------------*\
    STANDARD OPERATIONS
\*------------------------------------*/

/* delete */
DELETE FROM suppliers
WHERE supplier_name = 'IBM';

/*------------------------------------*\
    AND/OR
\*------------------------------------*/

// AND

SELECT * FROM Users WHERE FirstName = 'John' AND (LastName = 'Smith' OR LastName = 'Jones');
SELECT * FROM Users WHERE (FirstName = 'John' OR FirstName = 'Jennifer') AND (LastName = 'Smith' OR LastName = 'Jones');

// OR

SELECT * FROM Customers WHERE City IN ('Paris','London'); // paris or london


/*------------------------------------*\
    NOT
\*------------------------------------*/

Select * From EmployeeAddressTable Where FirstName NOT IN ('Mary', 'Sam') 

/*------------------------------------*\
    CHECK IF VALUES EXIST
\*------------------------------------*/

$query = 'SELECT username FROM userdb WHERE username=? LIMIT 1';
$stmt = $dbhandler->prepare($query);
$result = $stmt->execute(array($username));

// user does not exist
if(!$stmt->rowCount()) throw new invalidUserException();

/*------------------------------------*\
    ID OF INSERT
\*------------------------------------*/

$stmt = $pdo->prepare($sql);
$stmt->execute(array($data));
$insertedId = $pdo->lastInsertId() ;

/*------------------------------------*\
    COMBINE QUERIES
\*------------------------------------*/

/* =============== UNION: addieren  */


/* Select all the Cities from Customers and Suppliers table */

// DIFFERENT cities

SELECT City FROM Customers
UNION
SELECT City FROM Suppliers
ORDER BY City; 

// INC DUPLICATE cities
UNION ALL

/* =============== IN: subquery  */

/* gruppenname der gruppe des users mit ID==1 */

SELECT group_name
	from usergroups
	WHERE group_id IN (
		SELECT user_group 
		FROM users 
		where user_id = 1
	)




Select group_name 
       from usergroups
       inner join
            users
       on usergroups.group_id = users.group_id


/*------------------------------------*\
    AGGREGATE FUNCTIONS
\*------------------------------------*/

Sum
Count
Min
Max

/*------------------------------------*\
    ORDER RESULTS
\*------------------------------------*/

/* =============== GROUP by: selektiert Werte gruppieren  */

Select Item, Max(Price) as MaxPrice
From Antiques
Group by Item 

/* =============== ORDER by: selektiert Werte gruppieren  */
/*
	primär: nach Staat, danach nach dem Nachnahmen
*/

SELECT State,LastName,FirstName FROM EmployeeAddressTable
WHERE State = 'Ohio' OR State = 'New York'
ORDER BY State, LastName

/* =============== ASC/DESC: aufwärts abwärts  */

Select *
From EmployeeStatisticsTable
Order By Salary ASC,
Benefits Desc 

/*------------------------------------*\
    GET THE RESULTS
\*------------------------------------*/


$query = $this->db->prepare($sql);
$query->execute();

/* get all results */
$return = $query->fetchAll();

/* get first result */
$return = $query->fetch();


/*------------------------------------*\
    EXAMPLES
\*------------------------------------*/

/* select all entries from user_groups plus count the entries of table users, which have the same id*/

SELECT user_groups.*, count(users.user_id) AS nr_members 
FROM user_groups LEFT JOIN users 
ON user_groups.group_id = users.user_group group by user_groups.group_id







?>