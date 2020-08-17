Hi, here's your problem today. This problem was recently asked by Facebook:

Given two binary trees that are duplicates of one another, and given a node in one tree, find that correponding node in the second tree.

For instance, in the tree below, we're looking for Node #4.

For this problem, you can assume that:
- There can be duplicate values in the tree (so comparing node1.value == node2.value isn't going to work).

Can you solve this both recursively and iteratively?

```python
class Node:
  def __init__(self, val):
    self.val = val
    self.left = None
    self.right = None

def findNode(a, b, node):
  # Fill this in.

#  1
# / \
#2   3
#   / \
#  4*  5
a = Node(1)
a.left = Node(2)
a.right = Node(3)
a.right.left = Node(4)
a.right.right = Node(5)

b = Node(1)
b.left = Node(2)
b.right = Node(3)
b.right.left = Node(4)
b.right.right = Node(5)

print(findNode(a, b, a.right.left))
# 4
```
