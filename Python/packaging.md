# Packaging Python Applications



**Overview of packaging approaches**

- Binary/source distribution

  > Libraries and tools are commonly distribute through pip as source/binary distributions

  - sdist/bdist/wheel

- Packaging for pre-installed Python

  > All approaches depend on a pre-installed Python

  - [PEX](https://github.com/pantsbuild/pex#pex) (Python EXecutable)
  - [zipapp](https://docs.python.org/3/library/zipapp.html) (does not help manage dependencies, requires Python 3.5+)

- Packaging together with Python

  > Embed Python interpreter and other dependencies

  - [pyInstaller](http://www.pyinstaller.org/) - Cross-platform
  - [cx_Freeze](https://anthony-tuininga.github.io/cx_Freeze/) - Cross-platform



## Libraries and Tool Packaging

> A distribution is an archive of zero or more packages built by `setuptools` through setup.py



**Types of distributions**

- **sdist**: Simple, source-only .tar.gz
  - great for pure-Python modules and packages
- **bdist/wheel**: package format designed to ship libraries with compiled artifacts
  - New binary distribution, or *bdist*
  - pip e.g. prefers wheels



**Static vs Dynamic Linking**

- Pip cannot install operating system packages (libpng etc)
- `setuptools` does static linking at compile time to include system dependencies > some wheels are bigger than others



![py_pkg_tools_and_libs](img/py_pkg_tools_and_libs.png)

## Minimal Package Structure

**Package name and folder structure**

```
package_name/        # e.g. the repository
    package_name/    # the main source code
        __init__.py
    tests/
    setup.py
    LICENSE
    README.md
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
      install_requires=[
          'markdown',
      ],
      zip_safe=False)
```

#### Managing Dependencies

- Packages on pypi:
  - `install_requires=[‘A==1.0’, ‘B>=1,<2’]` 
- Independent source:
  - `dependency_links=[‘http://github.com/user/repo/tarball/master#egg=package-1.0']` 

#### Non-Python Files

- By default only .py and predefined files (e.g. `README.md`) get copied when installing the package.
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



## Building, Distribution and Installation

#### Building a package

```python
python setup.py sdist bdist_wheel
```

> Default output folder: `/dist`

- `sdist` will build the source-file distribution (`.tar.gz`)
- `bdist_wheel` will build the binary distribution, *wheel* (`.whl`)



#### Publishing packages

- `python setup.py register` upload package metadata, create pypi.python.org webpackge
  - Package will be available at http://pypi.python.org/pypi/your_package_name/<version>



#### Installing a local package

- Local install
  - `pip install .`
- Local install for development  (creates symlink to package source for continuous development)
  - `pip install -e .`







## Additional Knowledge

### Adding Unit Tests

```
package_name/        # e.g. the repository
    package_name/    # the main source code
        __init__.py
        utils.py
        tests/		 # unit tests
        	__init__.py
        	test_utils.py
    setup.py
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



