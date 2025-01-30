# Code Optimization



**Literature:**

- https://en.wikibooks.org/wiki/Optimizing_C%2B%2B







## Performance



1. No unnecessary work
   - no unnecessary copying
   - no unnecessary allocations
2. use all computing power
   - use all cores
   - use SIMD

3. Avoid waits and stalls
   - lockless data structures
   - asynchronous APIs
   - job system
4. Use hardware efficiency (speculative execution heuristic & multi-level caches)
   - cache friendliness
   - well predictable code
5. OS-level efficiency
   - thread suspension
   - thread core migration



### Performance Todo List

- TODO, see full https://www.youtube.com/watch?v=qCjEN5XRzHc&t=1806s





1. **Build Pipeline modification**

   - GCC, LLVM, ICC: `-O2 or -O3`

2. Set target architecture

   > Micro optimizations, tells compiler which SIMD to use

   - GCC, LLVM, ICC: `-mcpu=native` (for ARM), `-march=native -mtune=native` (for X86)

3. Use fast math

   > Numerical accuracy will be non-standard compliant.

   - GCC, LLVM, ICC: `-ffast-match`

4. Disable exceptions and RTTI

   -  GCC, LLVM, ICC: `-fno-exceptions`

5. Enable Link Time Optimization

   > inlining a function from a different translation unit is not possible

   - Compiler doesn't have enough optimizations options within the translationio unit

6. Use Unity Builds

   > Merges multiple source files into a single "uber" source file which only produce a few large translation units which the compiler can better optimize. Compilation is also faster (e.g. headers only need to be passed once).

   - CMake: `-DCMAKE_UNITY_BUILD=ON`
   - Downsides:
     - Cpp files aren't compiled in isolation - things defined in one .cpp file can influence compilation of another .cpp file
     - using namespaces and preprocessor defines/macros etc can clash
     - when modifying a single source files, that source file will get rebuild together with all the other source files of the same batch
     - peak memory usage increases (translation units will get bigger)

7. Link statically with dependencies

   > use static instead of shared libraries or dlls. Provides more opportinities for optimization at the call site of the function. 

   - creates bigger binaries

8. Use profile guided optimization

   > Make building code a 3-step process:
   >
   > 1. Code is compiled with performance counters embedded
   > 2. Program is run, producing a file with profiling results
   > 3. Code is compiled again using the profiling results (for better branch prediction)













## Optimizing Compilers

- always use optimization flags (gcc turnes optimization off by default,`-O0`)



Compilers are **good** at: mapping program to machine

- register allocation
- code selection and ordering
- dead code elimination
- eliminating minor inefficiencies

Compilers are **not good** at: algorithmic restructuring

- for example increase ILP, locality, etc

Compilers are **not good** at: overcoming "optimization blockers"

- potential memory aliasing
- potential procedure side-effects



#### Approaching Optimization

See also https://people.inf.ethz.ch/markusp/teaching/263-2300-ETH-spring12/slides/class05.pdf

- Remove unnecessary procedure calls
- Compiler is likeliky to do:
  - Code motion
  - Strength reduction
  - Sharing of common subexpressions
- Optimization blockers: Procedure calls
- Optimization blockers: Memory aliasing





**Example:** Sharing common subexpressions

3 mults: i*n, (i–1)*n, (i+1)*n

```cpp
/* Sum neighbors of i,j */
up = val[(i-1)*n + j ];
down = val[(i+1)*n + j ];
left = val[i*n + j-1];
right = val[i*n + j+1];
sum = up + down + left + right;
```

Optimized:

1 mult: i*n

```cpp
int inj = i*n + j;
up = val[inj - n];
down = val[inj + n];
left = val[inj - 1];
right = val[inj + 1];
sum = up + down + left + right;
```





## High-Level Code Optimization

***High-level optimization*** is a language dependent type of optimization that operates at a level in the close vicinity of the source code. High-level optimizations include inlining where a function call is replaced by the function body and partial evaluation which employs reordering of a loop, alignment of arrays, padding, layout, and elimination of tail recursion.







## Intermediate Code Optimization



### Loop Unrolling

> Small loops can be unrolled for higher performance, with the disadvantage of increased code size. When a loop is unrolled, a loop counter needs to be updated less often and fewer branches are executed. If the loop iterates only a few times, it can be fully unrolled so that the loop overhead completely disappears. The compiler unrolls loops automatically at `-O3` `-Otime`. Otherwise, any unrolling must be done in source code.

- **example**: bit counting https://www.keil.com/support/man/docs/armcc/armcc_chr1359124222660.htm



### Optimized Loop Termination

- **example:** decremental loop https://www.keil.com/support/man/docs/armcc/armcc_chr1359124222426.htm



### Operation Strength Reduction

- replace operators
  -  `x / 2` →  `x >> 1`
  - `16*x` → `x << 4`



**Speed hierarchy of operations**

- comparisons
- (u)int add, subtract, bitops, shift
- floating point add, sub (separate unit!)
- indexed array access (caveat: cache effects)
- (u)int32 mul
- FP mul
- FP division, remainder
- (u)int division, remainder









### Branching

>  A branch predictor tries to guess which way a branch (if-then-else structure) will go before this is know definitely. The purpose of the branch prediction is to improve the flow in the instruction pipeline and plays a critical role in achieving high effective performance.



**Branch predition methods**

- **static**: In case of Static branch prediction technique underlying hardware assumes that either the branch is not taken always or the branch is taken always.
- **dynamic**: Builds information over time about if the branch is strongly/weakly/not taken
- **random**: Pseudo-random branch prediction



### Chaching



**Look-up table**





**One-place cache**

- if function



## Compiler-performed optimizations





### Return Value Optimization (RVO)

- if named non-`const` object with automatic storage duration is returned
- copy/move is elided: compiler generates `a` already in the place that is reserved for the return value



```cpp
std::vector<int> getVector() {
  std::vector<int> a = {1, 2, 3};
  // temporary copy at return is avoided by RVO constructing the object in the memory
  // location of the caller
  return a;
}

auto a = getVector();
```









## Other / General Considerations



- images
  - add padding for alignment
  - store in continuous memory block
- move semantics/copy prevention
- Container choice
  - Query/add complexity
- Return Value Optimization
- Caching / memory locality / fragmentation
- inheritance: V-tables, indirection/fragmentation
- C++ aliasing: https://developers.redhat.com/blog/2020/06/02/the-joys-and-perils-of-c-and-c-aliasing-part-1#







