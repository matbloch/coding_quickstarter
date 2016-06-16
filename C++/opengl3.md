# OpenGL3

## Drawing Primitives


`glBegin`(*mode*)
**modes:**
- GL_POINTS
- GL_LINES
- GL_TRIANGLES
- GL_POLYGON
- ...

### Points

```cpp
glPointSize(10.0f);	// point size: 10px
glBegin(GL_POINTS); //starts drawing of points
glVertex3f(1.0f,1.0f,0.0f);//upper-right corner
glVertex3f(-1.0f,-1.0f,0.0f);//lower-left corner
glEnd();//end drawing of points
```

##glDrawArrays

### Basic Example: Drawing a triangle in 2D

```cpp
float vertices[] = {
     0.0f,  0.5f, // Vertex 1 (X, Y)
     0.5f, -0.5f, // Vertex 2 (X, Y)
    -0.5f, -0.5f  // Vertex 3 (X, Y)
};
```
1. upload this vertex data to the graphics card
```cpp
// GLuint is simply a cross-platform substitute for unsigned int
// You will need this number to make the VBO active
GLuint vbo;
glGenBuffers(1, &vbo); // Generate buffer
```
2. make it the active object
```cpp
// to upload the actual data to it you first have to make it the active object by calling glBindBuffer:
glBindBuffer(GL_ARRAY_BUFFER, vbo);	// makes vbo the active array buffer
```
3.  Now that it's active we can copy the vertex data to it
    ```cpp
    glBufferData(GL_ARRAY_BUFFER, sizeof(vertices), vertices, GL_STATIC_DRAW);
    ```
    **Last parameter**:
    - `GL_STATIC_DRAW`: The vertex data will be uploaded once and drawn many times (e.g. the world).
    - `GL_DYNAMIC_DRAW`: The vertex data will be changed from time to time, but drawn many times more than that.
    - `GL_STREAM_DRAW`: The vertex data will change almost every time it's drawn (e.g. user interface).


##glDrawObjects

### Basic Example
```cpp
glDrawElements(
GL_TRIANGLES,
48,	// number of vertices
GL_UNSIGNED_BYTE,
(GLvoid*)0);
```

