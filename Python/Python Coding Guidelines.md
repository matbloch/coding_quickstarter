# Python Coding Guidelines



**References**

- Google style guide: http://google.github.io/styleguide/pyguide.html



**Tooling**

- code formatting
  - `black`
- static code analysis
  - `pylint`





## Naming Conventions

- Variables, functions, methods, packages, modules
  - lower_case_with_underscores
  - `single_trailing_underscore_` for reserved variable names  to avoid conflicts  with Python keyword, e.g. `id_`
- Classes and Exceptions
  - CapWords
- Protected methods and internal functions
  - _single_leading_underscore(self, ...)
- Private methods
  - __double_leading_underscore(self, ...)
- Constants
  - ALL_CAPS_WITH_UNDERSCORES
- Avoid abbreviations
- Prefer "reverse notation"

| **YES**                                                      | **NO**                                                      |
| ------------------------------------------------------------ | ----------------------------------------------------------- |
| `elements = ... elements_active = ... elements_defunct = ...` | `elements = ... active_elements = ... defunct_elements ...` |

- Always use .py filename extension. Never use dashes.



**Paths**

Use the following explicite naming for directory and folder paths:

- file_abs_path    e.g. /tmp/result.html
- dir_abs_path     e.g.   /tmp/results/
- file_rel_path      e.g. results/result.html
- dir_rel_path      e.g. results/accuracy  
- file_path          algorithm is expected to handle both relative and absolute paths
- dir_path          algorithm is expected to handle both relative and absolute paths
- file_name

Example variable names:

- training_result_**file_abs_path**
- training_result_**dir_abs_path**



## Imports

- Import entire modules instead of individual symbols within a module. For example, for a top-level module canteen that has a file canteen/sessions.py,

**Yes**

```
import canteen
import canteen.sessions
from canteen import sessions
```

**No**

```
from canteen import get_user  # Symbol from canteen/__init__.py
from canteen.sessions import get_session  # Symbol from canteen/sessions.py
```