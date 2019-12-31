Hi, here's your problem today. This problem was recently asked by Twitter:

By the way, check out our NEW project AlgoPro (http://algopro.com) for over 60+ video coding sessions with ex-Google/ex-Facebook engineers.

Given a string with only ( and ), find the minimum number of characters to add or subtract to fix the string such that the brackets are balanced.

Example:
```
Input: '(()()'
Output: 1
```
Explanation:

The fixed string could either be ()() by deleting the first bracket, or (()()) by adding a bracket. These are not the only ways of fixing the string, there are many other ways by adding it in different positions!


Here's some code to start with:
```
def fix_brackets(s):
  # Fill this in.

print fix_brackets('(()()')
# 1
```
