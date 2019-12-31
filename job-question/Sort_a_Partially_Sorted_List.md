Hi, here's your problem today. This problem was recently asked by Uber:

By the way, check out our NEW project AlgoPro (http://algopro.com) for over 60+ video coding sessions with ex-Google/ex-Facebook engineers.

You are given a list of n numbers, where every number is at most k indexes away from its properly sorted index. Write a sorting algorithm (that will be given the number k) for this list that can solve this in O(n log k)

Example:
```
Input: [3, 2, 6, 5, 4], k=2
Output: [2, 3, 4, 5, 6]
```
As seen above, every number is at most 2 indexes away from its proper sorted index.

Here's a starting point:
```
def sort_partially_sorted(nums, k):
  # Fill this in.

print sort_partially_sorted([3, 2, 6, 5, 4], 2)
# [2, 3, 4, 5, 6]
```
