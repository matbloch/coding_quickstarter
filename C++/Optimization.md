# Code Optimization



**Literature:**

- https://en.wikibooks.org/wiki/Optimizing_C%2B%2B



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









## Other







- move semantics/copy prevention, Return Value Optimization
- C++ aliasing: https://developers.redhat.com/blog/2020/06/02/the-joys-and-perils-of-c-and-c-aliasing-part-1#
