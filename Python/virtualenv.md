# Virtual Environments: Python 2
- `virtualenv` is a tool to create isolated Python environments.
- The basic problem being addressed is one of dependencies and versions, and indirectly permissions.

## Installation

**Ubuntu**
- `sudo apt-get install virtualenv`

**PIP**
- `pip install virtualenv`

## Usage
- Create directory `mkdir ~/env && cd ~/env`
- Create Python3 environment `virtualenv -p python3 py3`
- Activate it `source ~/env/py3/bin/activate`

## Virtualenvwrapper
- Set of commands to make working with virtualenv more pleasant

#### Installation
**Ubuntu**
- `sudo apt-get install virtualenvwrapper`

#### Quickstart
- Create Python3 environment `mkvirtualenv -p /usr/bin/python3 --system-site-packages <venv-name>`
    - `--system-site-packages` allows to share globally installed packages to virtual environment
- Activate it `workon <venv-name>`
- Deactivate it `deactivate`
- Remove the environment `rmvirtualenv <venv-name>`


# Virtual Environments: Python 3

- `venv`
- directly integrated into Python3