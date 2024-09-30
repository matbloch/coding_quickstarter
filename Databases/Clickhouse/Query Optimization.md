# Clickhouse Query Optimization



1. Reduce reads
2. Restructure joins to reduce data scanning



## Clickhouse Features



#### Pre-Where

The `[PRE]WHERE` clause is a special optimization in ClickHouse designed to filter out rows early in the query execution process, even before reading all data columns. This reduces I/O and speeds up queries by only reading necessary parts of the data.



#### Split indices





## Examples



#### Column Selection

**AVOID** `SELECT * FROM`, instead use `SELECT col1, col5 FROM`

ClickHouse uses column-oriented storage. This means, fetching data for an additional column is expensive, while fetching data from additional rows is cheap.



#### Restructuring JOINs



