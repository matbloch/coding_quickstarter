# Python Version Management



Use the following packages:

- [pyenv](https://github.com/pyenv/pyenv) for virtualizing the Python version

- [venv](https://docs.python.org/3/library/venv.html#module-venv) for virtualizing and managing the Python environment (packages)



### 1. Install Pyenv

> pyenv is not available as a pip package



- `brew install pyenv`
- (optional) `brew install openssl`

```bash
# Add pyenv to your .zshrc:
echo -e 'if command -v pyenv 1>/dev/null 2>&1; then\n eval "$(pyenv init -)"\nfi' >> ~/.zshrc

# Add pyenv to your .bashrc:
echo -e 'if command -v pyenv 1>/dev/null 2>&1; then\n eval "$(pyenv init -)"\nfi' >> ~/.bash_profile
```



### 2. Install Python via *Pyenv*

> Pyenv can determine the Python version to use from a `.python-version` file in the root directory



- List available Python versions
  - `pyenv install --list`


- Install a specific version
  - `pyenv install 3.7.3`
- Install version defined in repo
  - `pyenv install $(pyenv local)`

- (optional) set the global python version
  - `pyenv global <python-version>`



### 3. Set up *Venv*

- (optional) Verify Python and pip point to your pyenv installation
  - `which python3`
  - `which pip3`

- create a virtual environment (called `venv`) in your repo directory
  - `python3 -m venv venv`

- load the venv
  - `source venv/bin/activate`

- Install packages to your venv
  - `pip3 install -r requirements.txt`