Hi, here's your problem today. This problem was recently asked by Facebook:

Given a file path with folder names, '..' (Parent directory), and '.' (Current directory), return the shortest possible file path (Eliminate all the '..' and '.').

Example
```
Input: '/Users/Joma/Documents/../Desktop/./../'
Output: '/Users/Joma/'
```
```
def shortest_path(file_path):
  # Fill this in.

print shortest_path('/Users/Joma/Documents/../Desktop/./../')
# /Users/Joma/
```
