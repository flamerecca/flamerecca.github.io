Hi, here's your problem today. This problem was recently asked by Apple:

Create a class that initializes with a list of numbers and has one method called sum. sum should take in two parameters, start_idx and end_idx and return the sum of the list from start_idx (inclusive) to end_idx` (exclusive).

You should optimize for the sum method.

Here's the class:
```
class ListFastSum:
  def __init__(self, nums):
    self.nums = nums

  def sum(self, start_idx, end_idx):
    # Fill this in.

print(ListFastSum([1, 2, 3, 4, 5, 6, 7]).sum(2, 5))
# 12 because 3 + 4 + 5 = 12
```
