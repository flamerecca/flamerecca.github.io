Hi, here's your problem today. This problem was recently asked by Apple:

Given a sorted array, convert it into a binary search tree.

Can you do this both recursively and iteratively?

class Node(object):
    def __init__(self, val, left=None, right=None):
        self.val = val
        self.left = left
        self.right = right
    def __str__(self):
      return f"{self.val}, ({self.left}, {self.right})"

class Solution(object):
    def sortedArrayToBST(self, nums):
      # Fill this in.

n = Solution().sortedArrayToBST([-10, -3, 0, 5, 9])
print(n)
# 0, (-3, (-10, (None, None), None), 9, (5, (None, None), None))
