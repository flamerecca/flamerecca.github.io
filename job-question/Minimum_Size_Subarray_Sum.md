Hi, here's your problem today. This problem was recently asked by Amazon:

Given an array of n positive integers and a positive integer s, find the minimal length of a contiguous subarray of which the sum ≥ s. If there isn't one, return 0 instead.

Example:

```python
Input: s = 7, nums = [2,3,1,2,4,3]
Output: 2
```

Explanation: the subarray [4,3] has the minimal length under the problem constraint.

Here is the method signature:

```python
class Solution:
  def minSubArrayLen(self, nums, s):
    # Fill this in

print Solution().minSubArrayLen([2, 3, 1, 2, 4, 3], 7)
# 2
```

