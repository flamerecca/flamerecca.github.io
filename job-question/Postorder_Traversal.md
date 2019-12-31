Hi, here's your problem today. This problem was recently asked by Uber:

Given a postorder traversal for a binary search tree, reconstruct the tree. A postorder traversal is a traversal order where the left child always comes before the right child, and the right child always comes before the parent for all nodes.

Here's some starter code:
```
class Node():
  def __init__(self, value, left=None, right=None):
    self.value = value
    self.left = left
    self.right = right

  def __repr__(self):
    return "(" + str(self.value) + ", " + self.left.__repr__() + ", " + self.right.__repr__() + ")"


def create_tree(postorder):
  # Fill this in.

# 2 is the root node, with 1 as the left child and 3 as the right child
print(create_tree([1, 3, 2]))
```
