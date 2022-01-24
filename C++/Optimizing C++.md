# Optimizing C++





- https://en.wikibooks.org/wiki/Optimizing_C%2B%2B







## General Optimization Techniques



### Loop Unrolling







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
