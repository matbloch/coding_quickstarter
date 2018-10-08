
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

```cpp
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



## Misc notes



### 2D Arrays

**Pass Array of Strings**
```cpp
static void func(char *p[])
{
    p[0] = "Hello";
    p[1] = "World";
}
static void func(char **p)
{
    p[0] = "Hello";
    p[1] = "World";
}
int main(int argc, char *argv[])
{
    char *strings[2];
    func(strings);
    printf("%s %s\n", strings[0], strings[1]);
    return 0;
}
```


**Allocating 2D Arrays**
Option 1: allocate rows, then columns
```cpp
char **array1 = malloc(nrows * sizeof(char *)); // Allocate row pointers
for(i = 0; i < nrows; i++) {
  array1[i] = malloc(ncolumns * sizeof(char));  // Allocate each row separately
}
```



**`char` to std::string**

```cpp
char** c;
vector<string> v(c, c + nr_elements);
```

**Allocate**
```cpp
int ** allocateTwoDimenArrayOnHeapUsingNew(int row, int col) {
	int ** ptr = new int*[row];
	for(int i = 0; i < row; i++) {
		ptr[i] = new int[col];
	}
	return ptr;
}

int ** allocateTwoDimenArrayOnHeapUsingMalloc(int row, int col) {
	int ** ptr = (int **) malloc(sizeof(int *)*row);
	for(int i = 0; i < row; i++) {
		ptr[i] = (int *) malloc(sizeof(int)*col);
	}
	return ptr;
}
```


**Deallocate**

```cpp

void destroyTwoDimenArrayOnHeapUsingDelete(int ** ptr, int row, int col){
	for(int i = 0; i < row; i++) {
		delete [] ptr[i];
	}
	delete [] ptr;
}

void destroyTwoDimenArrayOnHeapUsingFree(int ** ptr, int row, int col) {
	for(int i = 0; i < row; i++){
		free(ptr[i]);
	}
	free(ptr);
}
```

**Example:** `std::vector<std::string>` to `char`

```cpp
std::vector<std::string> my_images;
const size_t nr_images = my_images.size();
std::vector<std::vector<char>> vstrings;
std::vector<char*> cstrings;
vstrings.reserve(nr_images);
cstrings.reserve(nr_images);

// convert to c string vector
for (size_t i = 0; i < nr_images; ++i) {
	// copy to vector of characters
    vstrings.emplace_back(my_images[i].begin(), my_images[i].end());
    // add string terminator
    vstrings.back().push_back('\0');
    // copy pointer to data
    cstrings.push_back(vstrings.back().data());
}

char **my_c_array = (char **) malloc(nr_images * sizeof(char *));
for (size_t i = 0; i < nr_images; i++) {
    const size_t size = vstrings[i].size() * sizeof(char);
    // allocate data in array
    my_c_array[i] = (char *) malloc(size);
    // copy data to array
    memcpy(my_c_array[i], cstrings[i], size);
}
```




