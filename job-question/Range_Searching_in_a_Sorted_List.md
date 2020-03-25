Hi, here's your problem today. This problem was recently asked by Twitter:

Given a sorted list with duplicates, and a target number n, find the range in which the number exists (represented as a tuple (low, high), both inclusive. If the number does not exist in the list, return (-1, -1)).

Here's some examples and some starter code.

def find_num(nums, target):
  # Fill this in.

print(find_num([1, 1, 3, 5, 7], 1))
# (0, 1)

print(find_num([1, 2, 3, 4], 5))
# (-1, -1)
