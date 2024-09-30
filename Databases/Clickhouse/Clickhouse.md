# Clickhouse





## Window operations

- see https://clickhouse.com/docs/en/sql-reference/window-functions#moving--sliding-average-per-3-rows





# groupArray











## Common Table Expressions (CTE)



```sql
with all_data as (
	SELECT
     key1 as my_key
  FROM
     my_database
), sorted_data as (
	SELECT
    my_key
  FROM all_data
  ORDER BY my_key
)
```

