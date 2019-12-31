Hi, here's your problem today. This problem was recently asked by Google:

Given two strings, find if there is a one-to-one mapping of characters between the two strings.

Example
```
Input: abc, def
Output: True # a -> d, b -> e, c -> f

Input: aab, def
Ouput: False # a can't map to d and e 
```
Here's some starter code:
```
def has_character_map(str1, str2):
  # Fill this in.

print(has_character_map('abc', 'def'))
# True
print(has_character_map('aac', 'def'))
# False
```
