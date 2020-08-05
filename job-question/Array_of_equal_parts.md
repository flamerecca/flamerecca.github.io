Hi, here's your problem today. This problem was recently asked by Twitter:

Given an array containing only positive integers, return if you can pick two integers from the array which cuts the array into three pieces such that the sum of elements in all pieces is equal.

Example 1:
```
Input: array = [2, 4, 5, 3, 3, 9, 2, 2, 2]

Output: true
```
Explanation: choosing the number 5 and 9 results in three pieces [2, 4], [3, 3] and [2, 2, 2]. Sum = 6.

Example 2:
```
Input: array =[1, 1, 1, 1],

Output: false
```
Here's a starting point:

```
class Solution(object):
  def canPick2(self, arr):
    # Fill this in.

print(Solution().canPick2([2, 4, 5, 3, 3, 9, 2, 2, 2]))
# True

print(Solution().canPick2([1, 2, 3, 4, 5]))
# False
```
