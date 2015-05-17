Regular expressions cheatsheet
================



NOTATION
==========

##### Modifikatoren


[Begrenzungszeichen][RegEx][Begrenzungszeichen][Modifikator(en)]   // z.B. :  /(Mein|Ausdruck)/im 
• i: Case-Insensitivity: Groß- und Kleinschreibung nicht beachten

##### Delimiters (für preq_match nötig)


`#` oder `~` oder `/`			// Falls delimiter sonst gebraucht wird: muss mit "\" escaped werden


##### Einzelnes zeichen


`[REGEX]` 		alles in Klammer: oder
`[REGEX][REGEX]` 	zwei zeichen


##### Klammerung und Speicherung


`Ba(na)*ne`   			// Banananane

##### Gruppierung ohne Speicherung


`(?:abc)`	"?:" am Anfang der Klammer

Sonderzeichen escapen (mit "\")
`[/. \-]` 	ein "/", ".", " ", "-"

Characters which must be escaped:
```\ ^ . $ | ( ) [ ]  * + ? { } ,  ```


Special Character Definitions
==========

`\` Quote the next metacharacter  
`^` Match the beginning of the line  
`.` Match any character (except newline)  
`$` Match the end of the line (or before newline at the end)  
`|` Alternation  
`()` Grouping  
`[]` Character class  
`*` Match 0 or more times  
`+` Match 1 or more times  
`?` Match 1 or 0 times  
`{n}` Match exactly n times  
`{n,}` Match at least n times  
`{n,m}` Match at least n but not more than m times  
More Special Character Stuff  
`\t` tab (HT, TAB)  
`\n` newline (LF, NL)  
`\r` return (CR)  
`\f` form feed (FF)  
`\a` alarm (bell) (BEL)  
`\e` escape (think troff) (ESC)  
`\033` octal char (think of a PDP-11)  
`\x1B` hex char  
`\c[` control char  
`\l` lowercase next char (think vi)  
`\u` uppercase next char (think vi)  
`\L` lowercase till \E (think vi)  
`\U` uppercase till \E (think vi)  
`\E` end case modification (think vi)  
`\Q` quote (disable) pattern metacharacters till \E  
Even More Special Characters  
`\w` Match a "word" character (alphanumeric plus "_")  
`\W` Match a non-word character  
`\s` Match a whitespace character  
`\S` Match a non-whitespace character  
`\d` Match a digit character  
`\D` Match a non-digit character    
`\b` Match a word boundary  
`\B`` Match a non-(word boundary)  
`\A` Match only at beginning of string  
`\Z` Match only at end of string, or before newline at the end  
`\z` Match only at end of string  
`\G` Match only where previous m//g left off (works only with /g)  



Usage with PHP
==========

return: (bool) match found
```php
preg_match($pattern, $subject);
```

extract pattern
```php
preg_match($pattern, $subject, $matches);
```

all hits
```php
preg_match_all($pattern, $subject, $matches);
$matches[0]	// zeichen, die auf suchmuster passen
$matches[1] // zeichen zwischen tags (eingeklammerte teilsuchmuster)
```

remove search result
```php
$trimmed = str_replace($search, '', $subject);
```

Filters
==========

##### Single characters

`[ab13c]`    a, b, 1, 3, c

##### Classes
`[1-6]` 		 Zahl 1-6   
`[a-g]` 		 von a bis g   
`\w \d \s`	     word, digit, whitespace   

`[1-9][a-dA-D]` Zahl 1-9 und Buchstaben inc. gross/klein

##### optional wiederholte zeichen
`a{1,5}`		 {min_anz_zeichen, max_anz_zeichen}   
`a{3,}` 		 mindestens 3   
`a+` 			 1 oder mehr wiederholungen   
`a*`			 0 oder mehr wiederholungen   
`a* a+ a?`	 0 or more, 1 or more, 0 or 1   

##### beliebiges Zeichen
`.`  				 ohne Zeilenumbrüche   
`(?s).*`  	 alles: dot matches newlines, too  


##### Inversion
`[^0-9]`   Zeichen, nicht 0-9

##### Alternativen

`toll|richtig schlecht`  durch "|" teilen   
`ab|cd`	match ab or cd

##### Negation
`q(?!u)`	q gefolgt von einem zeichen != u





