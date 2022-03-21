# CTypes

> Making calls to C functions from within a Python script

- Documentation: https://docs.python.org/3/library/ctypes.html#ctypes-callback-functions



### Loading a Library

```python
import ctypes as ct
libc = ct.cdll.LoadLibrary('my-awesome-lib.so')
```





### Passing Python Variables







## Fundamental Datatypes



### Structures

- inherit from `ctypes.Structure`

**definition**

```python
class _ScSize(ct.Structure):
    _fields_ = [("width", ct.c_uint32), ("height", ct.c_uint32)]
```

**initialization**

```python
size = _ScSize(resolution[0], resolution[1])
```





## Dynamic Memory



### Pointers



**nullptr**

- Use `None` for nullptrs



**Function Pointers**

```python
EventFuncType = ct.CFUNCTYPE(None, ct.c_uint32, ct.c_void_p)
EventFuncPointerType = ct.pointer(EventFuncType)
```

**Pointer to Python classes**



**Pointer to Struct**



### Pointer Casting





## Advanced Usage



### Allocating Heap Memory in Python





### Callbacks

> [`ctypes`](https://docs.python.org/3/library/ctypes.html#module-ctypes) allows creating C callable function pointers from Python callables. These are sometimes called *callback functions*.



- **Note**: Make sure you keep references to [`CFUNCTYPE()`](https://docs.python.org/3/library/ctypes.html#ctypes.CFUNCTYPE) objects as long as they are used from C code. [`ctypes`](https://docs.python.org/3/library/ctypes.html#module-ctypes) doesn’t, and if you don’t, they may be garbage collected, crashing your program when a callback is made.

```python
import ctypes as ct

# define the signature
EventFuncType = ct.CFUNCTYPE(None, ct.c_uint32, ct.c_void_p)

def

```



**Casting ctype pointer to Python class**



```python
```

