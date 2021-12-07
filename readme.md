# Advent of Code 2021

https://adventofcode.com/2021

## Notes

##### Day 01

Refactored for part 2 allowing for arbitrary window size so the same code works for both parts.

##### Day 02

Extended the 3D position class from utility library to bootstrap the positional system.

##### Day 03

There's probably a more efficient way of doing it but it's not slow and doesn't run out of memory so...

##### Day 04

The way I had setup the board data structures meant part 2 was just run until the end with a skip if the board is already won.

##### Day 05

Was pretty late in the day when I got around to this and it runs slower than expected and required more memory so I've done something badly somewhere...

##### Day 06

Didn't really pay attention to the obvious exponential growth hint so part 1 was a mice clean model of the school that would never work for part 2. Re-thought it through and simply kept a count of numbers of fish at the 9 different stages.

##### Day 07

Grouped the crabs by position rather than trying to model them all and calculated distance to move for each group. This allowed part 2 to just require a tweak to the calculation to use triangular numbers.
