
# MacOS C++ Development Environment



## Checklist


- inverted scrolling
- right click: open terminal here
- terminal styling
- window manager


**Key assignment**
- Windows + left/right: switch desktops
- invert command and windows keys
- ctrl + up/down: move line of code
- brackets
- Show hidden items: CMD + SHIFT + .
- move folder tree up
- shift + up/down: mark lines of code
- alt + f4: close window
- return in finder: open folder, not rename it



## Hotkeys
- cmd + space: quicksearch
- alt + space: ...
- Shift-Command-4: Screenshot of custom area
- Command + w: close window


- alt + tab: switch through windows


## Package Installations


**Zlib**
`brew install zlib`

**libiconv**
`brew install libiconv`
`echo 'export PATH="/usr/local/opt/libiconv/bin:$PATH"' >> ~/.bash_profile`

Will be installed to:
- `L/usr/local/opt/libiconv/lib`
- `I/usr/local/opt/libiconv/include`



### Brew/Homebrew
- Package manager for OSX (instead of e.g. apt)
- find modules at brewformulas.org
- installs packages in own directory at `/usr/local/cellar/` and then symlinks files into `/usr/local/`
- packages installed at `I/usr/local/opt/`
- dynamic libraries at `/usr/lib`


#### Commands
**Brew**
- `brew doctor` resolve brew problems
- `brew update` update brew

**Packages**
- `brew install python` install package
- `brew info python` display info about `python` package
- `brew --cellar python` display installation folder of `python` package


#### Installation
**Install to Utilities**
`cd /Applications/Utilities`
`/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`

**Package installation without `sudo`**
- Change /usr/local/* to be owned by $USER, not root, so you can have write permissions and not need sudo
- `sudo chown -R $(whoami) /usr/local/lib/pkgconfig /usr/local/share/locale /usr/local/share/man`

**General Fixes**
- `brew doctor`

## General Optimizations

### Input Controls
**Install Swiss Keyboard Layout**
- Install **Ukulele**
- Download swiss keyboard layout: [Download](https://www.krenger.ch/blog/mac-os-x-standard-de_ch-keymap/)
- Copy Layout to: `/Users/Matthias/Library/Keyboard Layouts`
- Go to "preferences > Language & Region > Keyboard settings" and add "Logitech Swiss German" from the "Others" tab
- Also check "show in menubar"
- restart if icon to switch layout does not show up

**Speed up scroll speed**
- Go to Preferences > Keyboard > Keyboard
- Scale up "Key Repeat", shorten "Delay untili Repeat"

**Lock Menu Bar and Scroll Bars**
- Go to Preferences > General
- Select "Show scroll bars" > "Always
- Disable hide menu bar

**Windows Preview on Dock Hover**
- [HyperDock](https://bahoom.com/hyperdock/)

**Customizable Window Grid**
- [SLATE](http://nicholas.charriere.com/blog/2014/12/basic-slate)
- Example config:
    ```bash
    config defaultToCurrentScreen true
    # Abstract positions
    alias full move screenOriginX;screenOriginY screenSizeX;screenSizeY
    alias lefthalf move screenOriginX;screenOriginY screenSizeX/2;screenSizeY
    alias righthalf move screenOriginX+screenSizeX/2;screenOriginY screenSizeX/2;screenSizeY
    alias tophalf move screenOriginX;screenOriginY screenSizeX;screenSizeY/2
    alias bottomhalf move screenOriginX;screenOriginY+screenSizeY/2 screenSizeX;screenSizeY/2
    alias topleft corner top-left resize:screenSizeX/2;screenSizeY/2
    alias topright corner top-right resize:screenSizeX/2;screenSizeY/2
    alias bottomleft corner bottom-left resize:screenSizeX/2;screenSizeY/2
    alias bottomright corner bottom-right resize:screenSizeX/2;screenSizeY/2
    alias center move screenOriginX+screenSizeX/6;screenOriginY+screenSizeY/6 2*screenSizeX/3;2*screenSizeY/3
    alias bigCenter move screenOriginX+screenSizeX/12;screenOriginY+screenSizeY/12 10*screenSizeX/12;10*screenSizeY/12

    # The triple keys
    alias triple ctrl;alt;cmd

    # Location bindings
    bind left:cmd ${lefthalf}
    bind right:cmd ${righthalf}
    ```




### Terminal

- [Dowload](http://www.iterm2.com/downloads.html) and install iTerm2
- Or: `brew cask install iterm2`

**Commands**
- ...

**Add often used python scripts to PATH (permanently)**
- `echo $PATH` show current PATH
- `cd` head to home directory
- `nano .bash_profile` create `.bash_profile`
- Add: `export PYTHONPATH="${PYTHONPATH}:/my/other/path"`
- Save: [ctrl] + [o]
- Confirm: [return]
- Quit: [ctrl] + [q]



**Custom Theme**
- Follow instructions on: [Github](https://gist.github.com/kevin-smets/8568070)

**Remove Username**
- See [Stackoverflow](https://stackoverflow.com/questions/31848957/zsh-hide-computer-name-in-the-terminal)

`vim ~/.oh-my-zsh/themes/agnoster.zsh-theme`

Change code:
```bash
prompt_context() {
if [[ "$USER" != "$DEFAULT_USER" || -n "$SSH_CLIENT" ]];
```
to
```bash
prompt_context() {
if [[ "$USER" = "$DEFAULT_USER" || -n "$SSH_CLIENT" ]];
```

## IDE: CLion

**Edit configurations**
- Run - Edit configurations

## CMake Based Projects

### 1. Building from console
```bash
mkdir build
cd build
cmake ..
make -j8
```
- Same as in e.g. Ubuntu since it's Unix.

### 2. Build with CLion
- CLion is based on CMake...

**To build project**
1. Import project (with existing CMakeLists.txt)
2. Create new project (CLion will create CMakeLists.txt for you)

**Specify build directory**
- Default *cmake-build-YOURCONFIG*
- or: File > settings, search for CMAKE and configure your build types

**Preprocessor Directives**
- add to build tipes in preferences


