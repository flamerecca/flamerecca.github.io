Hi, here's your problem today. This problem was recently asked by LinkedIn:

Given a set of words, find all words that are concatenations of other words in the set.

class Solution(object):
  def findAllConcatenatedWords(self, words):
    # Fill this in.


input = ['rat', 'cat', 'cats', 'dog', 'catsdog', 'dogcat', 'dogcatrat']
print(Solution().findAllConcatenatedWords(input))
# ['catsdog', 'dogcat', 'dogcatrat']
