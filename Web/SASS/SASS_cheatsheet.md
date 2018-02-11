
# SCSS
## Nesting

```css
nav {
  ul {
    margin: 0;
    padding: 0;
    list-style: none;
  }

  li { display: inline-block; }

  a {
    display: block;
    padding: 6px 12px;
    text-decoration: none;
  }
}

```


## SASS Compiler

1. Install Ruby 2.4
2. cd to `/Ruby2.4/bin` and `gem install scss`
3. Add filewatcher in Jetbrains Tool:
	- Program: C:\lib\Ruby24-x64\bin\sass.bat
	- Arguments: --no-cache --update $FileName$:$FileNameWithoutExtension$.css
	- Working directory: $FileDir$
	- Output path: $FileNameWithoutExtension$.css:$FileNameWithoutExtension$.css.map