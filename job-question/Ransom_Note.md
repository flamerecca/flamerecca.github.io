Hi, here's your problem today. This problem was recently asked by Google:

A criminal is constructing a ransom note. In order to disguise his handwriting, he is cutting out letters from a magazine.

Given a magazine of letters and the note he wants to write, determine whether he can construct the word.

class Solution(object):
  def canSpell(self, magazine, note):
    # Fill this in.
    
print(Solution().canSpell(['a', 'b', 'c', 'd', 'e', 'f'], 'bed'))
# True

print(Solution().canSpell(['a', 'b', 'c', 'd', 'e', 'f'], 'cat'))
# False

Can you do this in linear time?
