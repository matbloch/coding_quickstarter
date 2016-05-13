



# Eigen

## Containers

### Matrix

**Functions**
- `m.rows()`
- `m.cols()`
- `m.transpose()`
- `m.conjugate()`
- `m.adjoint()`

**Definition**
```cpp
// fixed size matrix
Matrix3f a;	// 3x3 of floats
MatrixXf a(10,15);	// matrixName(rowNr, columnNr)
// dynamic size matrix
MatrixXf b;	// dynamic size (initially 0x0)
MatrixXf mymatrix(rows,columns);
```

**Constructors**
```cpp
Eigen::Matrix3d p;
p << 1, 2, 3,
     4, 5, 6,
     7, 8, 9;
```

**Accessors**
- `matrixName(row, column)`

```cpp
m(1,0) = 2;
Eigen::MatrixXd A = Eigen::MatrixXd::Random(7, 9);
std::cout << "The element at fourth row and 7the column is " << A(3, 6) << std::endl;
Eigen::MatrixXd B = A.block(1, 2, 3, 3);
std::cout << "Take sub-matrix whose upper left corner is A(1, 2)" << std::endl << B << std::endl;
Eigen::VectorXd a = A.col(1); // take the second column of A
Eigen::VectorXd b = B.row(0); // take the first row of B
Eigen::VectorXd c = a.head(3);// take the first three elements of a
Eigen::VectorXd d = b.tail(2);// take the last two elements of b
```


**Operations**

```cpp
Eigen::Matrix3d p = Eigen::Matrix3d::Random(3,3);
pt = p.transpose()
p.transposeInPlace();

```


### Vector

- Eigen::Vector2d(-5, 0)).homogeneous()

**Constructors**
```cpp
VectorXf b(30);
// fixed size
Vector2d a(5.0, 6.0);
Vector3d b(5.0, 6.0, 7.0);
Vector4d c(5.0, 6.0, 7.0, 8.0);
```

**linear algebra**
```cpp
VectorXd p(10), q(10), r(10), s(10);
...
p = 5*q + 11*r - 7*s;
```


## Space Transformations

**Transformation types**
- Abstract transformations: quaternion, angle & axis etc.
- `Eigen::Transform` Matrices (such as affine transformations)

**Common API**

- `gen1 * gen2;` Concatenation of two transformations
- `vec2 = gen1 * vec1;` Apply the transformation to a vector
- `gen2 = gen1.inverse();` Get the inverse of the transformation
- `rot3 = rot1.slerp(alpha,rot2);` Spherical interpolation (Rotation2D and Quaternion only)



### Rotation
- from angle & axis: `AngleAxis<float> aa(angle_in_radian, Vector3f(ax,ay,az));`
- quaternions

**Creation**
```cpp

// 3D around multiple axis (Euler Angles)
Matrix3f m;
m = AngleAxisf(0.25*M_PI, Vector3f::UnitX())
  * AngleAxisf(0.5*M_PI,  Vector3f::UnitY())
  * AngleAxisf(0.33*M_PI, Vector3f::UnitZ());
cout << m << endl << "is unitary: " << m.isUnitary() << endl

// 2D
Rotation2D<float> rot2(angle_in_radian);
// 3D around 1 axis
AngleAxis<float> aa(angle_in_radian, Vector3f(ax,ay,az));
```

Using `Transform` container
```cpp
// using Transform
Eigen::Transform<float,3,Eigen::Affine> t(Eigen::AngleAxisf(2.1*M_PI/180,Vector3f(1,0,0)));
// or
Eigen::Transform<float,3,Eigen::Affine> t;
t = Eigen::AngleAxisf(2.1*M_PI/180,Eigen::Vector3f(1,0,0));

// ILLEGAL: Transform t = AngleAxis(angle,axis);
```

**Conversion**
- For Quarternion / AngleAxis to matrix
```cpp
Matrix3f mat;
Quaternionf q(mat);
// or
Quaternionf q;
q = mat;
q.rotation().matrix();
```
- For Transform to matrix
```cpp
Transform<float,3,Affine> t(AngleAxisf(2.1*M_PI/180,Vector3f(1,0,0)));
Matrix3d R;
R = t.rotation().matrix().cast<double>(); 	// cast from float to double (matrix3d)
```


**Quaternions**

Eigen::Quaterniond q(2, 0, 1, -3); 

  std::cout << "This quaternion consists of a scalar " << q.w() << " and a vector " << std::endl << q.vec() << std::endl;


  q.normalize();

  std::cout << "To represent rotation, we need to normalize it such that its length is " << q.norm() << std::endl;


  Eigen::Vector3d v(1, 2, -1);

  Eigen::Quaterniond p;

  p.w() = 0;

  p.vec() = v;

  Eigen::Quaterniond rotatedP = q * p * q.inverse(); 

  Eigen::Vector3d rotatedV = rotatedP.vec();

  std::cout << "We can now use it to rotate a vector " << std::endl << v << " to " << std::endl << rotatedV << std::endl;


  Eigen::Matrix3d R = q.toRotationMatrix(); // convert a quaternion to a 3x3 rotation matrix

  std::cout << "Compare with the result using an rotation matrix " << std::endl << R * v << std::endl;

 

  Eigen::Quaterniond a = Eigen::Quterniond::Identity();

  Eigen::Quaterniond b = Eigen::Quterniond::Identity();

  Eigen::Quaterniond c; // Adding two quaternion as two 4x1 vectors is not supported by the EIgen API. That is, c = a + b is not allowed. We have to do this in a hard way

  c.w() = a.w() + b.w();

  c.x() = a.x() + b.x();

  c.y() = a.y() + b.y();

  c.z() = a.z() + b.z();


### Translation


### General Transformation - `Transform` Container

**Isometry**

`typedef Transform<float,3,Isometry> Isometry3f;`
```cpp

Eigen::Isometry3d relativePose;
relativePose.setIdentity();
```


**Affine**

`typedef Transform<float,3,Affine> Affine3f;`

```cpp
Transform<float,N,Affine> t = concatenation_of_any_transformations;
// translation, rotation and scaling
Transform<float,3,Affine> t = Translation3f(p) * AngleAxisf(a,axis) * Scaling(s);

```
### Component Access

**Coefficients**
```cpp
t(i,j) = scalar;   <=>   t.matrix()(i,j) = scalar;
scalar = t(i,j);   <=>   scalar = t.matrix()(i,j);
```
**Translation Part**
```cpp
t.translation() = vecN;
vecN = t.translation();
```
**linear part**
```cpp
t.linear() = matNxN;
matNxN = t.linear();
```

**rotation matrix**
```cpp
matNxN = t.rotation();
```
**Matrix Conversion/Component Access**
```cpp
Eigen::Isometry3d campos;
campos.setIdentity();

// edit elementwise
campos.matrix()(1,2) = 2;

// change translation only
Eigen::Vector3d v(1,2,3);
campos.translation().matrix() = v;
```

### Application
when applying the transform to points, the latters are automatically promoted to homogeneous vectors before doing the matrix product
```cpp
v' = T * v
```

####Stacking Transformations

**Translation**
```cpp
t.translate(Vector_(tx,ty,..));t *= Translation_(tx,ty,..);
t.pretranslate(Vector_(tx,ty,..));t = Translation_(tx,ty,..) * t;
```
**Rotation**
```cpp
t.rotate(any_rotation);t *= any_rotation;
t.prerotate(any_rotation);t = any_rotation * t;
```
####Examples
```cpp
Eigen::Affine3f tempTrans;
// add 90° rotation around X-Axis
tempTrans.rotate(Eigen::AngleAxisf(M_PI/2,Eigen::Vector3f(1,0,0)));
// translate along vector
tempTrans.translate(Eigen::Vector3f(1,0,0));
tempTrans.scale(1.32);
```
## I/O


```cpp
Eigen::Matrix3d R;
Eigen::IOFormat CleanFmt(4, 0, ", ", "\n", "[", "]");
std::cout << R.format(CleanFmt) << std::endl;


```


## Lookup
```cpp
#include <Eigen/Dense>

Matrix<double, 3, 3> A;               // Fixed rows and cols. Same as Matrix3d.
Matrix<double, 3, Dynamic> B;         // Fixed rows, dynamic cols.
Matrix<double, Dynamic, Dynamic> C;   // Full dynamic. Same as MatrixXd.
Matrix<double, 3, 3, RowMajor> E;     // Row major; default is column-major.
Matrix3f P, Q, R;                     // 3x3 float matrix.
Vector3f x, y, z;                     // 3x1 float matrix.
RowVector3f a, b, c;                  // 1x3 float matrix.
VectorXd v;                           // Dynamic column vector of doubles
double s;


// Basic usage
// Eigen          // Matlab           // comments
x.size()          // length(x)        // vector size
C.rows()          // size(C,1)        // number of rows
C.cols()          // size(C,2)        // number of columns
x(i)              // x(i+1)           // Matlab is 1-based
C(i,j)            // C(i+1,j+1)       //

A.resize(4, 4);   // Runtime error if assertions are on.
B.resize(4, 9);   // Runtime error if assertions are on.
A.resize(3, 3);   // Ok; size didn't change.
B.resize(3, 9);   // Ok; only dynamic cols changed.
                  
A << 1, 2, 3,     // Initialize A. The elements can also be
     4, 5, 6,     // matrices, which are stacked along cols
     7, 8, 9;     // and then the rows are stacked.
B << A, A, A;     // B is three horizontally stacked A's.
A.fill(10);       // Fill A with all 10's.

// Eigen                            // Matlab
MatrixXd::Identity(rows,cols)       // eye(rows,cols)
C.setIdentity(rows,cols)            // C = eye(rows,cols)
MatrixXd::Zero(rows,cols)           // zeros(rows,cols)
C.setZero(rows,cols)                // C = ones(rows,cols)
MatrixXd::Ones(rows,cols)           // ones(rows,cols)
C.setOnes(rows,cols)                // C = ones(rows,cols)
MatrixXd::Random(rows,cols)         // rand(rows,cols)*2-1        // MatrixXd::Random returns uniform random numbers in (-1, 1).
C.setRandom(rows,cols)              // C = rand(rows,cols)*2-1
VectorXd::LinSpaced(size,low,high)   // linspace(low,high,size)'
v.setLinSpaced(size,low,high)        // v = linspace(low,high,size)'


// Matrix slicing and blocks. All expressions listed here are read/write.
// Templated size versions are faster. Note that Matlab is 1-based (a size N
// vector is x(1)...x(N)).
// Eigen                           // Matlab
x.head(n)                          // x(1:n)
x.head<n>()                        // x(1:n)
x.tail(n)                          // x(end - n + 1: end)
x.tail<n>()                        // x(end - n + 1: end)
x.segment(i, n)                    // x(i+1 : i+n)
x.segment<n>(i)                    // x(i+1 : i+n)
P.block(i, j, rows, cols)          // P(i+1 : i+rows, j+1 : j+cols)
P.block<rows, cols>(i, j)          // P(i+1 : i+rows, j+1 : j+cols)
P.row(i)                           // P(i+1, :)
P.col(j)                           // P(:, j+1)
P.leftCols<cols>()                 // P(:, 1:cols)
P.leftCols(cols)                   // P(:, 1:cols)
P.middleCols<cols>(j)              // P(:, j+1:j+cols)
P.middleCols(j, cols)              // P(:, j+1:j+cols)
P.rightCols<cols>()                // P(:, end-cols+1:end)
P.rightCols(cols)                  // P(:, end-cols+1:end)
P.topRows<rows>()                  // P(1:rows, :)
P.topRows(rows)                    // P(1:rows, :)
P.middleRows<rows>(i)              // P(i+1:i+rows, :)
P.middleRows(i, rows)              // P(i+1:i+rows, :)
P.bottomRows<rows>()               // P(end-rows+1:end, :)
P.bottomRows(rows)                 // P(end-rows+1:end, :)
P.topLeftCorner(rows, cols)        // P(1:rows, 1:cols)
P.topRightCorner(rows, cols)       // P(1:rows, end-cols+1:end)
P.bottomLeftCorner(rows, cols)     // P(end-rows+1:end, 1:cols)
P.bottomRightCorner(rows, cols)    // P(end-rows+1:end, end-cols+1:end)
P.topLeftCorner<rows,cols>()       // P(1:rows, 1:cols)
P.topRightCorner<rows,cols>()      // P(1:rows, end-cols+1:end)
P.bottomLeftCorner<rows,cols>()    // P(end-rows+1:end, 1:cols)
P.bottomRightCorner<rows,cols>()   // P(end-rows+1:end, end-cols+1:end)

// Of particular note is Eigen's swap function which is highly optimized.
// Eigen                           // Matlab
R.row(i) = P.col(j);               // R(i, :) = P(:, i)
R.col(j1).swap(mat1.col(j2));      // R(:, [j1 j2]) = R(:, [j2, j1])

// Views, transpose, etc; all read-write except for .adjoint().
// Eigen                           // Matlab
R.adjoint()                        // R'
R.transpose()                      // R.' or conj(R')
R.diagonal()                       // diag(R)
x.asDiagonal()                     // diag(x)
R.transpose().colwise().reverse(); // rot90(R)
R.conjugate()                      // conj(R)

// All the same as Matlab, but matlab doesn't have *= style operators.
// Matrix-vector.  Matrix-matrix.   Matrix-scalar.
y  = M*x;          R  = P*Q;        R  = P*s;
a  = b*M;          R  = P - Q;      R  = s*P;
a *= M;            R  = P + Q;      R  = P/s;
                   R *= Q;          R  = s*P;
                   R += Q;          R *= s;
                   R -= Q;          R /= s;

// Vectorized operations on each element independently
// Eigen                  // Matlab
R = P.cwiseProduct(Q);    // R = P .* Q
R = P.array() * s.array();// R = P .* s
R = P.cwiseQuotient(Q);   // R = P ./ Q
R = P.array() / Q.array();// R = P ./ Q
R = P.array() + s.array();// R = P + s
R = P.array() - s.array();// R = P - s
R.array() += s;           // R = R + s
R.array() -= s;           // R = R - s
R.array() < Q.array();    // R < Q
R.array() <= Q.array();   // R <= Q
R.cwiseInverse();         // 1 ./ P
R.array().inverse();      // 1 ./ P
R.array().sin()           // sin(P)
R.array().cos()           // cos(P)
R.array().pow(s)          // P .^ s
R.array().square()        // P .^ 2
R.array().cube()          // P .^ 3
R.cwiseSqrt()             // sqrt(P)
R.array().sqrt()          // sqrt(P)
R.array().exp()           // exp(P)
R.array().log()           // log(P)
R.cwiseMax(P)             // max(R, P)
R.array().max(P.array())  // max(R, P)
R.cwiseMin(P)             // min(R, P)
R.array().min(P.array())  // min(R, P)
R.cwiseAbs()              // abs(P)
R.array().abs()           // abs(P)
R.cwiseAbs2()             // abs(P.^2)
R.array().abs2()          // abs(P.^2)
(R.array() < s).select(P,Q);  // (R < s ? P : Q)

// Reductions.
int r, c;
// Eigen                  // Matlab
R.minCoeff()              // min(R(:))
R.maxCoeff()              // max(R(:))
s = R.minCoeff(&r, &c)    // [s, i] = min(R(:)); [r, c] = ind2sub(size(R), i);
s = R.maxCoeff(&r, &c)    // [s, i] = max(R(:)); [r, c] = ind2sub(size(R), i);
R.sum()                   // sum(R(:))
R.colwise().sum()         // sum(R)
R.rowwise().sum()         // sum(R, 2) or sum(R')'
R.prod()                  // prod(R(:))
R.colwise().prod()        // prod(R)
R.rowwise().prod()        // prod(R, 2) or prod(R')'
R.trace()                 // trace(R)
R.all()                   // all(R(:))
R.colwise().all()         // all(R)
R.rowwise().all()         // all(R, 2)
R.any()                   // any(R(:))
R.colwise().any()         // any(R)
R.rowwise().any()         // any(R, 2)

// Dot products, norms, etc.
// Eigen                  // Matlab
x.norm()                  // norm(x).    Note that norm(R) doesn't work in Eigen.
x.squaredNorm()           // dot(x, x)   Note the equivalence is not true for complex
x.dot(y)                  // dot(x, y)
x.cross(y)                // cross(x, y) Requires #include <Eigen/Geometry>

//// Type conversion
// Eigen                           // Matlab
A.cast<double>();                  // double(A)
A.cast<float>();                   // single(A)
A.cast<int>();                     // int32(A)
A.real();                          // real(A)
A.imag();                          // imag(A)
// if the original type equals destination type, no work is done

// Note that for most operations Eigen requires all operands to have the same type:
MatrixXf F = MatrixXf::Zero(3,3);
A += F;                // illegal in Eigen. In Matlab A = A+F is allowed
A += F.cast<double>(); // F converted to double and then added (generally, conversion happens on-the-fly)

// Eigen can map existing memory into Eigen matrices.
float array[3];
Vector3f::Map(array).fill(10);            // create a temporary Map over array and sets entries to 10
int data[4] = {1, 2, 3, 4};
Matrix2i mat2x2(data);                    // copies data into mat2x2
Matrix2i::Map(data) = 2*mat2x2;           // overwrite elements of data with 2*mat2x2
MatrixXi::Map(data, 2, 2) += mat2x2;      // adds mat2x2 to elements of data (alternative syntax if size is not know at compile time)

// Solve Ax = b. Result stored in x. Matlab: x = A \ b.
x = A.ldlt().solve(b));  // A sym. p.s.d.    #include <Eigen/Cholesky>
x = A.llt() .solve(b));  // A sym. p.d.      #include <Eigen/Cholesky>
x = A.lu()  .solve(b));  // Stable and fast. #include <Eigen/LU>
x = A.qr()  .solve(b));  // No pivoting.     #include <Eigen/QR>
x = A.svd() .solve(b));  // Stable, slowest. #include <Eigen/SVD>
// .ldlt() -> .matrixL() and .matrixD()
// .llt()  -> .matrixL()
// .lu()   -> .matrixL() and .matrixU()
// .qr()   -> .matrixQ() and .matrixR()
// .svd()  -> .matrixU(), .singularValues(), and .matrixV()

// Eigenvalue problems
// Eigen                          // Matlab
A.eigenvalues();                  // eig(A);
EigenSolver<Matrix3d> eig(A);     // [vec val] = eig(A)
eig.eigenvalues();                // diag(val)
eig.eigenvectors();               // vec
// For self-adjoint matrices use SelfAdjointEigenSolver<>
```