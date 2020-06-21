# Dash: Dashboards in Python





## Layout Elements



### HTML



```python
from dash_html_components import html

html.H1("My H1 content")
html.Div("My div content")
```



**Nested Elements**

```python
html.Div(
    "blabla",
    children=[
    html.H1("My H1 content"),
	html.Div("My div content"),
    html.Div("Is nested"),
])


```





## Styling



https://codepen.io/chriddyp/pen/bWLwgP