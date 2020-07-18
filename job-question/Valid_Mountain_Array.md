Hi, here's your problem today. This problem was recently asked by Microsoft:

Given an array of heights, determine whether the array forms a "mountain" pattern. A mountain pattern goes up and then down.

Like
  /\
 /  \
/    \
class Solution(object):
  def validMountainArray(self, arr):
    # Fill this in.

print(Solution().validMountainArray([1, 2, 3, 2, 1]))
# True

print(Solution().validMountainArray([1, 2, 3]))
# False
