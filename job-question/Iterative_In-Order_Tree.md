Hi, here's your problem today. This problem was recently asked by LinkedIn:

Given a binary tree, perform an in-order traversal both recursively and iteratively.

```python
class Node:
  def __init__(self, val=0, left=None, right=None):
    self.val = val
    self.left = left
    self.right = right


def inorder(node):
  # Fill this in.

def inorder_iterative(node):
  # Fill this in.

#     12
#    /  \
#   6    4
#  / \   / \
# 2   3 7   8
n = Node(12, Node(6, Node(2), Node(3)), Node(4, Node(7), Node(8)))

inorder(n)
# 2 6 3 12 7 4 8

inorder_iterative(n)
# 2 6 3 12 7 4 8
```
