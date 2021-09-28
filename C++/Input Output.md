# Input / Output







### Printing of Custom Classes

As free function:

```cpp
ostream& operator<<(ostream& os, const CustomType & type) {
    os << type.my_member;
    return os;
}
```

As class member:

```cpp
class CustomType {
  public:
	friend ostream &operator<<( ostream &output, const Distance &D ) { 
    output << type.my_member;
    return output;        
  }
}
```

