# Visual Basic for Applications


## Basic Syntax

**Comments**

```vbnet
' This is a comment
```

**String Concatenation**

```vbnet
 MsgBox "Passowrd is " & password & Chr(10) & "Value of num is " & num & Chr(10) & "Value of Birthday is " & BirthDay
```

## Examples

**Calculate sum**
```vbnet
Sub test4()
    Dim book As Workbook
    Dim a

    Set book = Workbooks.Open("C:\Book1.xlsx")

    a = sumrange(book.Worksheets(1).Range("A1:A4"))

    MsgBox a
End Sub

Function sumrange(rng As Range)
    summ = 0
    For Each cell In rng
    summ = summ + cell.Value
    Next
    sumrange = summ
End Function
```



## Control Structures

###for each

```vbnet
For each Mitglied In Gruppe
  Machwas
Next Mitglied
```
**Example: Iterate over worksheets**
```vbnet
Public Sub NurTabellenBlattNamen()
    Dim g As Worksheet
    For Each g In ThisWorkbook.Worksheets
        MsgBox g.Name
    Next g
End Sub

Public Sub BlattNamen()
	' use sheetobject
    Dim g As Object
    For Each g In ThisWorkbook.Sheets
        MsgBox g.Name
    Next g
End Sub
```



### Examples
**for each**

```vbnet

Dim SourceWB As Workbook
' open workbook
Set SourceWB = Workbooks.Open(srcName, False, True)
' find last row
srcLastRow = SourceWB.Sheets(1).Cells(Rows.Count, "B").End(xlUp).Row
' select first sheet and iterate till last row
For Each listVal In SourceWB.Sheets(1).Range("B2:B" & srcLastRow)
	.AddItem listVal.Value
	'Offset(0,-1) gets second column of data from cell to the left
	.List(.ListCount - 1, 1) = listVal.Offset(0, -1).Value
```

## Variables

`Dim <<variable_name>> As <<variable_type>>`

### Datatypes

**Numeric**
- `Byte` 	0 to 255
- `Integer` 	-32,768 to 32,767
- `Long` 	-2,147,483,648 to 2,147,483,648
- `Single` 	-3.402823E+38 to -1.401298E-45 for negative values 1.401298E-45 to 3.402823E+38 for positive values.
- `Double` 	-1.79769313486232e+308 to -4.94065645841247E-324 for negative values 4.94065645841247E-324 to 1.79769313486232e+308 for positive values.
- `Currency` 	-922,337,203,685,477.5808 to 922,337,203,685,477.5807
- `Decimal` 	+/- 79,228,162,514,264,337,593,543,950,335 if no decimal is use +/- 7.9228162514264337593543950335 (28 decimal places).

**Non-numeric**
- String(fixed length) 	1 to 65,400 characters
- String(variable length) 	0 to 2 billion characters
- Date 	January 1, 100 to December 31, 9999
- Boolean 	True or False
- Object 	Any embedded object
- Variant(numeric) 	Any value as large as Double
- Variant(text) 	Same as variable-length string 

## Modules
- Where VBA Code is written.
- Create new module: Insert >> Module

### Function

- Start with `Function` end with `End Function`

### Sub Procedures
- Start with `Sub` end with `End Sub`
- No return value

```vbnet
Private Sub say_helloworld_Click()
    MsgBox "Hi"
End Sub
```

## I/O

### Message Box
```vbnet
Function MessageBox_Demo()
  'Message Box with just prompt message
  MsgBox("Welcome")
  'Message Box with title, yes no and cancel Butttons 
  a = MsgBox("Do you like blue color?",3,"Choose options")
  ' Assume that you press No Button
  msgbox ("The Value of a is " & a)
End Function
```

### Input Box


```vbnet
Function findArea()
  Dim Length As Double
  Dim Width As Double

  Length = InputBox("Enter Length ", "Enter a Number")
  Width = InputBox("Enter Width", "Enter a Number")
  findArea = Length * Width
End Function
```