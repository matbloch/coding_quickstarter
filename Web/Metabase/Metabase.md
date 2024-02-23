# Metabase







## Input Fields

- see https://www.metabase.com/learn/sql-questions/sql-variables 





**01. Variable definition in Query**

- To include a variable in your query, simply wrap the variable name in double braces, like this: `{{ variable }}`.

```sql
SELECT *
FROM orders
WHERE subtotal > {{subtotal_var}}
```



**02. UI component**

- When we add a variable to a SQL query, Metabase will add a filter widget at the top of the question, and slide out a sidebar to present options for the variable.





**03. Saving as snippet**













## Combining Charts







### Group By incl Aggregate




