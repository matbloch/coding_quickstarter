# Data Transformations









### Transform

```cpp
std::vector<std::size_t> ordinals;
std::transform(s.cbegin(), s.cend(), std::back_inserter(ordinals),
                   [](unsigned char c) { return c; });
 
```



### Copy if



**Filter Map of Objects**

```cpp
std::copy_if(
    begin(mymap),
    end(mymap),
    std::inserter(output_map, begin(output_map)),
    [&start_index](std::pair<int,int> p) { return p.first >= start_index; }
);
```

