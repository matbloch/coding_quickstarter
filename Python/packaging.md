# Module Packaging in Python



## Minimal Structure

**Package name and folder structure**

```
package_name/        # e.g. the repository
    package_name/    # the main source code
        __init__.py
        utils.py
    setup.py
    .gitignore
```

**`.gitignore`**

```
# Compiled python modules.
*.pyc

# Setuptools distribution folder.
/dist/

# Python egg metadata, regenerated from source files by setuptools.
/*.egg-info
```


**`setup.py`**

```python
from setuptools import setup

setup(name='package_name',
      version='0.1',
      description='A minimal package',
      url='http://github.com/pckg_manager/package_name',
      author='Matt',
      author_email='example@example.com',
      license='MIT',
      packages=['package_name'],
      zip_safe=False)
```

**`/package_name/__init__.py`**

```python
from .utils import do_something
```



## Installation

**Installing the package**

`pip install .`

**Installing the package for development**

``pip install -e .``    (creates symlink to package source for continuous development)

**Using the package**

```bash
>>> import package_name
>>> print package_name.do_something()
```



--------------



## Additional Knowledge

### **Dependencies**

```python
from setuptools import setup

setup(name='package_name',
	  # ...
      install_requires=[
          'markdown',		# install "markdown" package
      ]
      # ...
     )
```

### **Custom Dependencies** (not on PyPI)

```python
setup(
    ...
    dependency_links=['http://github.com/user/repo/tarball/master#egg=package-1.0']
    ...
)

```

### Non-Python Files

- By default only .py files get copied when installing the package
- Specify additional files in``MANIFEST.in`` ( root directory)

Example content:

```
include README.rst
include docs/*.txt
include funniest/data.json
```

install.py:

```
setup(
    ...
    include_package_data=True
    ...
)
```



### Unit Tests

```
package_name/        # e.g. the repository
    package_name/    # the main source code
        __init__.py
        utils.py
        tests/		 # unit tests
        	__init__.py
        	test_utils.py
    setup.py
    .gitignore
```

**`/package_name/tests/test_utils.py`**

```python
from unittest import TestCase

import package_name

class TestUtils(TestCase):
    def test_something(self):
        s = package_name.get_name()
        self.assertTrue(isinstance(s, basestring))
```

Intergration in setup.py:

```
setup(
    ...
    test_suite='nose.collector',
    tests_require=['nose'],
)
```

Running the tests:

`$ python setup.py test`



