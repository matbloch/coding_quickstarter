# Dash: Dashboards in Python





**Main components**

- Layout:
- Callbacks:
- Interaction: 





## Application Skeleton



```python
from dash import Dash, html, dcc
import plotly.express as px
import pandas as pd

# 01. initialize the Dash application
app = Dash(__name__)

# 02. define the layout
app.layout = html.Div(children=[
    html.H1(children='Hello Dash'),
    html.Div(children='Dash: A web application framework for your data.'),
])

# 03. run the application
if __name__ == '__main__':
    app.run_server(debug=True)
```





## Layout Elements



### 01. HTML

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







