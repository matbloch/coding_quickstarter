
## Structures in C

**Definition**

```cpp
struct database {
  int id_number;
  float salary;
};
```

**Creation**
```cpp
// create empty struct
struct database employee;
// create struct from a function return
struct database fn();
```

**Property Access**

```cpp
employee.id_number = 1;
employee.salary = 12000.21;
```


## Data structures



### 1D Arrays


- Declaration: `type arrayName [ arraySize ]`

```cpp
// declaration
double balance[10];
double balance[] = {1000.0, 2.0, 3.4, 7.0, 50.0};	// automatic size

// access
balance[4] = 50.0;
```

**Unit offset Arrays**  
- **Problem**: Some algorithms want to start with `arrayName[1]` istead of `arrayName[0]` 


**Solution 1: Additional pointer**
```cpp
int numbers[] = {1,2,3,4};
int *p;
p = numbers-1; /* p points to the address one field before the array */
```

**Solution 2: Manipulate function input**
```c
someMethod(numbers-1, 4);	/* use the shifted address */
```

### 2D Arrays

- Declaration: `type arrayName [ m ][ n ]`

```cpp
// declaration
int a[3][4] = {  
 {0, 1, 2, 3} ,   /*  initializers for row indexed by 0 */
 {4, 5, 6, 7} ,   /*  initializers for row indexed by 1 */
 {8, 9, 10, 11}   /*  initializers for row indexed by 2 */
};
int a[3][4] = {0,1,2,3,4,5,6,7,8,9,10,11};

// access
int val = a[2][3];
```

### Pointers

- `type *ptr_name = NULL`: Init pointer with value NULL
- `ptr_name`: access pointer address
- `*ptr_name`: access value at pointer address
- - `&var_name`: access address of variable

```cpp
int  var = 20;   		/* actual variable declaration */
int  *ptr = NULL;       /* pointer variable declaration */

ip = &var;  /* store address of var in pointer variable*/

/* access address */
cout << ip << endl;
/* access value at address ip */
cout << *ip << endl;

/* modify value at address ip */
*ip = 1000;

```

**Pointer to array**  
Array name is a constant pointer to `&arrayName[0]`, the address of the first array element.


```cpp
double *p;
double balance[10];

// assign pointer
p = balance;	/* balance = &balance[0] */

// access pointer
cout << *p<< endl;
cout << *(p+2)<< endl;
```

**Pointer to Pointers**  


```cpp
   int  var;
   int  *ptr;
   int  **pptr;

   var = 3000;
   
   ptr = &var;
   pptr = ptr;
```

### Strings

**Utilities**
- `strcpy( char * destination, const char * source )`: copy strings

### Misc


**`memcpy`**
```cpp
void *memcpy(void *str1, const void *str2, size_t n)
```
- str1: pointer to copy destination
- str2: pointer to source
- n: number of bytes to be copied
- return: pointer to str1


## Functions


** Arrays as Arguments**

```
// pointer
void myFunction(int *param) {
}
// sized array
void myFunction(int param[10]) {
}
// unsized array
void myFunction(int param[]) {
}
double getAverage(int arr[], int size) {
}
```






