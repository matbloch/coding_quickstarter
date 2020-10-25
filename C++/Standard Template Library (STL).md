## Standard Template Library (STL)





## std::string

- automatically managed memory of character sequence





**Data Pointer**

```cpp
char * c_str = my_string.c_str();
```





## C-Style Strings

- `\0` terminated character sequence



#### Definition



```cpp
char c[] = "abcd";
char c[50] = "abcd";
char c[] = {'a', 'b', 'c', 'd', '\0'};
char c[5] = {'a', 'b', 'c', 'd', '\0'};
```



#### Const Strings

**Static strings**

- stored inside binary itself
- does not need to be deleted

```cpp
// constant assignment
const char[] tmp = "hey";
// constant reference
static const std::string my_static = "123";
const char* tmp = my_static.c_str();
```



#### Mutable Strings

**Option 1:** Allocate string on the caller's behalf

- caller must free memory using `delete[]`

```cpp
char * get_string () { 
   int length_required = strlen("lorem ipsum") + 1;
   // allocate the memory
   char* my_string = new char[length_required];
   // copy the memory
   strcpy(my_string, "lorem ipsum");
   return my_string;
}
```

**Option 2:** Force pre-allocation

```cpp
int get_string (char* destination, size_t outstr_len) {
   // Write the output into outstr using strcpy or similar
   // and return an error code if outstr_len is smaller than
   // the space required to store the string
   std::string my_string("lorem ipsum");
   strcpy_s(destination, outstr_len, my_string.c_str());
}
```



#### std::string to char *

**Access as char ***

```cpp
std::string str = "string";
const char *cstr = str.c_str();
```

**Copy to char ***

```cpp
std::string str = "string";
char *cstr = new char[str.length() + 1];
strcpy(cstr, str.c_str());
delete [] cstr;
```







## Vector





**Call function on every item**

```cpp
void foo(int a);
std::vector<int> v;
std::for_each(v.begin(), v.end(), &foo);
```

