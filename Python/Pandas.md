# Pandas

- [Introduction](https://www.geeksforgeeks.org/python-pandas-dataframe/)





## Series

- see [introduction](https://www.geeksforgeeks.org/python-pandas-series/)

![pandas_series](/Users/matthias/dev/coding_quickstarter/Python/img/pandas_series.png)

### Initialization

```python
data = np.array(['g','e','e','k','s'])
data = ['g', 'e', 'e', 'k', 's']
series = pd.Series(data)
```

### Accessing Data

```python
series[:5]
```

### Labeling Data

```python
data = np.array(['g','e','e','k','s','f', 'o','r','g','e','e','k','s'])
ser = pd.Series(data,index=[10,11,12,13,14,15,16,17,18,19,20,21,22])
# accessing a element using index element
print(ser[16])
```

### Naming

```python
In [1]: my_series.name
In [2]: my_series.rename("new_name")
```

**`Dataframe` from Dict with `Series`**

```python
In [1]: s1 = pd.Series([1, 2], index=['A', 'B'], name='s1')
In [2]: s2 = pd.Series([3, 4], index=['A', 'B'], name='s2')
In [3]: pd.concat([s1, s2], axis=1)
Out[3]:
   s1  s2
A   1   3
B   2   4
```

### Manipulation

```python
In [1]: my_series.tolist()
```



## Dataframe

### Initialization

**From list**

```python
import pandas as pd
lst = ['Geeks', 'For', 'Geeks', 'is', 
            'portal', 'for', 'Geeks']
df = pd.DataFrame(lst)
```

**From Dict**

```python
import pandas as pd
data = {'Name':['Tom', 'nick', 'krish', 'jack'],
        'Age':[20, 21, 19, 18]}
df = pd.DataFrame(data)
```





### Indexing

- **`Dataframe.[ ]`**This function also known as indexing operator
- **`Dataframe.loc[ ]`** for labels
- **`Dataframe.iloc[ ]`** for positions or integer based
- **`Dataframe.ix[]`**  for both label and integer based



##### **[]** Indexer Operator

- Single/list selections

##### .loc[] Operator

- internally uses indexer operator
- allows subqueries and result composition

##### .iloc[] Operator

- internally uses indexer operator

##### .ix[] Operator





### Misc Methods

- `df.empty`





### Row/Column Selection

**Column Selection**

```python
columns = ['Name', 'Qualification']
df[columns]
```

**Column Names**

```python
# iterating the columns 
for col in data.columns: 
    print(col) 
# 1
column_names = list(data.columns) 
# 2
column_names = list(data.columns.values)
# 3
column_names = list(data.columns.values.tolist())
```

**Row Selection**

```python
# by value
row = df.loc["Avery Bradley"]
# by row index
row = df.iloc[3]
```

**Row Names**

```python
# iteration
for row in data.index: 
    print(row, end= " ") 
# 1
data_top = data.head() 
row_names = list(data_top.index)
```

### Iterating

```python
columns = list(df)
for i in columns:
    # printing the third element of the column
    print (df[i][2])
```



### Loading From Files

```python
data = pd.read_csv("nba.csv", index_col ="Name")
```



### Joining Dataframes

- [reference](https://pandas.pydata.org/pandas-docs/stable/user_guide/merging.html)



**Appending Rows**

- Same columns

```python
result = df1.append(s2, ignore_index=True)
```

**Concatenate**

```python
frames = [df1, df2, df3]
result = pd.concat(frames, axis=1)
```

**Concatenate List of Dataframes**

```python
df = pd.concat(list_of_dataframes)
```

**Merging**

```python

```





### Sorting

**Sorty by Column/Row names**

```python
df.sort_index(axis = 0)
```









### Manipulating Dataframes

**Flip Rows and Columns**

```python
d1 = {'col1': [1, 2], 'col2': [3, 4]}
d2 = d1.transpose()
```



### Adding Data



### Slicing and Data Access

**Slicing rows**

```python
# by integer
dataframe[0]
dataframe[0:3]
dataframe[-1:]

# by condition: df[{condition}]
df[df.A > 3]
```



**Slicing rows AND columns**

- `iloc` integer based indexing
- `loc` label based indexing

```python
# iloc[row slicing, column slicing]
dataframe.iloc[0:3, 1:4]
dataframe.loc[[0, 10], :]
dataframe.loc[0, ['species_id', 'plot_id', 'weight']]
dataframe.loc[[0, 10, 35549], :]
```

**Serie from column/row**

- slicing with a single row/column

```python
df.iloc[:,0]
```

