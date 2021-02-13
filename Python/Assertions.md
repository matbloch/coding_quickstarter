# Assertions

- convenience method to add debug messages
- should only be used for conditions that should never happen not for control flow
- can be disable by running `python -O` (see [docs](https://docs.python.org/3/using/cmdline.html#cmdoption-O))
  - removes all code conditioned on `__debug__`



```python
assert expression #, optional_message
```

```python
if __debug__:
    if not expression: raise AssertionError #(optional_message)
```



#### Useful Checks



- `all()` Checks if all items in a list are `True`

```python
mylist = [True, False, True]
assert all(mylist)
```





