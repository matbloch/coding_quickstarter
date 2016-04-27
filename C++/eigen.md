# Eigen

## Containers

### Matrix

**Functions**
- `m.rows()`
- `m.cols()`
- `m.transpose()`
- `m.conjugate()`
- `m.adjoint()`

**Constructors**
```cpp
// fixed size matrix
Matrix3f a;	// 3x3 of floats
MatrixXf a(10,15);	// matrixName(rowNr, columnNr)
// dynamic size matrix
MatrixXf b;	// dynamic size (initially 0x0)
MatrixXf mymatrix(rows,columns);
```

**Accessors**
- `matrixName(row, column)`
```cpp
m(1,0) = 2;
```


### Vector

**Constructors**
```cpp
VectorXf b(30);
// with values
Vector3d v(1,2,3);
```

## Transformations