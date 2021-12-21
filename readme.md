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

##### Day 08

Part 1 didn't require much past processing the input file. For part 2 the solution made heavy use of array functions to deduce other numbers. I have to fully decode each segment, but it wasn't required in the end.

##### Day 09

Mapped the data to a flat array then used an additional map to store details about groups.

##### Day 10

PHP has a build in stack class which did the bulk of the lifting work here.

##### Day 11

Straight forward, by keeping track of a list of flashed nodes each step it ensured they only flashed once.

##### Day 12

NYI

##### Day 13

Surprisingly easy one today, did the full implementation without realising it, was already outputting the paper state and due to the data structure I had used both folds used the same code.

##### Day 14

Didn't make the same mistake this time! Saw the warning about the list getting long and built the solution to keep counts of elements and work on a pair list. Part 2 worked straight away.

##### Day 15

NYI

##### Day 16

Took a while to wrap my head around the operation packet functionality in part 1 but the recursive solution I implemented worked for part 2 and only required the per type value calculations, super fast as well =)

##### Day 17

Tried to be clever on part 1, ended up brute forcing part 2 anyway =/

##### Weekend

Turns out you don't have a lot of free time at weekends with a 1 and 2-year-old in the run-up to Christmas... I'll get to them eventually =/

##### Day 20

Fun game of life task, the real data swapping the infinite grid from light to dark caught me out at first!
