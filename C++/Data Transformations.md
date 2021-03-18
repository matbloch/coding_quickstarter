# Data Transformations







**Filter Map of Objects**

```cpp
std::copy_if(
    begin(mymap),
    end(mymap),
    std::inserter(output_map, begin(output_map)),
    [&start_index](std::pair<int,int> p) { return p.first >= start_index; }
);
```

