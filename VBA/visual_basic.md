# Visual Basic for Applications


## Introduction

**Modules**




## Basic Syntax

**Comments**

```vbnet
' This is a comment
```

**String Concatenation**

```vbnet
 MsgBox "Passowrd is " & password & Chr(10) & "Value of num is " & num & Chr(10) & "Value of Birthday is " & BirthDay
```
**Comparison Operators**
- `=`	Equal To
- `<>`	!= Not Equal To
- `<`	Less Than
- `>`	Greater Than
- `<=`	Less Than or Equal To
- `>=`	Greater Than or Equal To


**Multiple Commands in same Line**

```vbnet
Dim clientToTest As String:  clientToTest = "blabla"
```

## Control Structures


###if
```vbnet
Sub WennSonntagSonstMsg()
   If Weekday(Date) = 1 Then
      MsgBox "Heute ist Sonntag"
   ElseIf Weekday(Date) = 7 Then
      MsgBox "Heute ist Samstag"
   Else
      MsgBox "Heute ist " & Format(Weekday(Date), "dddd")
   End If
End Sub
```

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

## Debugging
- Console öffnen: View > Immediate Window oder Ansicht > Direktfenster

```vbnet
Debug.Print myVariableName
```

## Objects

### Worksheet

####Range


```vbnet
Worksheets("Sheet1").Range("A1").Select
Worksheets(1).Range("A1").Select
Worksheets(2).Range("A1", "B7").Select
Worksheets("Sheet2").Range("A1:B7").Select
```

- Windows(secondWorkbook).Activate



### Cells

- Cells(i,j).Value
- Cells(i,j).Text (displayed value)

**Iterate over cells**

```vbnet
Dim i As Integer, j As Integer
For i = 2 To RowCount
  For j = 1 To 2
  	MsgBox Cells(i, j).Value
  Next j
Next i
```

**Set value**

```vbnet
Dim MyString As String
MyString = "Some text"
Cells(i, j).Value = MyString
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

**Type Conversion**
- `CInt` to integer
- `CString` to string

#### Strings

- str.Substring(str.Length - 5)

### Containers

####Collection
```vbnet
' This function returns a collection object which can hold multiple values.
Public Function GetCollection() As Collection
    
    Dim var As Collection
    Set var = New Collection
    
    ' Add two items to the collection
    var.Add "John"
    var.Add "Star"
    
    Set GetCollection = var
End Function

Private Sub cmbGetCollection_Click()
    Dim Employee As Collection
    Set Employee = GetCollection()
            
    ' Use the collection's first index to retrieve the first item.
    ' This is also valid: Debug.Print Employee(1)
    Debug.Print Employee.Item(1)
    Debug.Print Employee.Item(2)
End Sub
```
**Loop over collection**
```vbnet


Dim Item As Object

For Each Item In Collection

'do something to the item

Next Item

```

####Dictionary
```vbnet
' This function returns a dictionary object which can hold multiple values.
Public Function GetDict() As Dictionary
    Dim var As Dictionary
    Set var = New Dictionary
    ' The "key" is the item name and the "value" is the description.
    var.Add "First Name", "John"
    var.Add "Last Name", "Star"
    Set GetDict = var
End Function

Private Sub cmdGetDictionary_Click()
    Dim Employee As Dictionary
    Set Employee = GetDict()
    ' Use an item's key name to get its value.
    Debug.Print Employee.Item("First Name")
    Debug.Print Employee.Item("Last Name")
    ' Use an item's index number to get its key.
    Debug.Print Employee.Keys(0)
    ' Use an item's index number to get its value.
    Debug.Print Employee.Items(0)
End Sub
```
####Loop over Dictionary

```vbnet
For Each key In dic.Keys
	Debug.Print "Key: " & key & " Value: " & dic(key)
Next
```

####Arrays
```vbnet
Dim numbers() As Integer, size As Integer, i As Integer
size = 5
ReDim numbers(size)
For i = 1 To size
    numbers(i) = Cells(i, 1).Value
Next i
```

## Modules
- Where VBA Code is written.
- Create new module: Insert >> Module

### Function

- Start with `Function` end with `End Function`

**Multiple arguments**

```vbnet
Function ProcedureName(ArgumentName as DataType) As DataType
	' save value back
	ProcedureName = 123
End Function
```

**Optional Arguments**

```vbnet
Function notify(ByVal company As String, Optional ByVal office As String = "QJZ")
    If office = "QJZ" Then
        Debug.WriteLine("office not supplied -- using Headquarters")
        office = "Headquarters"
    End If
    ' Insert code to notify headquarters or specified office.
End Function
```

**Pass by Value/Reference**
Function Calculate(ByVal rate As Double, ByRef debt As Double)
	debt = debt + (debt * rate / 100)
End Function

### Sub Procedures
- Start with `Sub` end with `End Sub`
- No return value

```vbnet
Private Sub say_helloworld_Click()
    MsgBox "Hi"
End Sub
```

**Argument by value**

```vbnet
Sub PostAccounts(ByVal intAcctNum as Integer)
   .
   . ' Place statements here.
   .
End Sub
```


**By reference**

```vbnet
Sub CallingProcedure()
   Dim intX As Integer
   intX = 12 * 3
   Foo(intX)
End Sub

Sub Foo(Bar As String)
   MsgBox Bar   'The value of Bar is the string "36".
End Sub
```

**Multiple arguments**
```vbnet
Public Sub setInterest(account As String, dmonth As Integer)
    ...somecode...
End Sub


setInterest "myAccount", 3
Call setInterest("myAccount", 3)
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

## Classes
- **Note:** Class modules are saved in files with the extension .cls.
- Change Name: "Eigenschaftsfenster" `F4`


**Declaration**
```vbnet
Option Explicit

' Declare properties
Public Name As String
Private mdtmCreated As Date

' Define properties
Property Get Created() As Date
   Created = mdtmCreated
End Property

' Define Subprocedures (with no return values)
Public Sub ReverseName()
   Dim intCt As Integer
   Dim strNew As String
   For intCt = 1 To Len(Name)
      strNew = Mid$(Name, intCt, 1) & strNew
   Next
   Name = strNew
End Sub



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

**Number of Rows/Columns**
```vbnet
Dim lastRow As Long
lastRow = Sheet1.Cells(Rows.Count, 1).End(xlUp).Row
MsgBox lastRow
// columns
Dim lastColumn As Long
lastColumn = Sheet1.Cells(1, Columns.Count).End(xlToLeft).Column
MsgBox lastColumn
```



