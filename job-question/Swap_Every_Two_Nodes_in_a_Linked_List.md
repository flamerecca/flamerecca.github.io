Hi, here's your problem today. This problem was recently asked by Twitter:

Given a linked list, swap the position of the 1st and 2nd node, then swap the position of the 3rd and 4th node etc.

Here's some starter code:
```
class Node:
  def __init__(self, value, next=None):
    self.value = value
    self.next = next

  def __repr__(self):
    return f"{self.value}, ({self.next.__repr__()})"

def swap_every_two(llist):
  # Fill this in.

llist = Node(1, Node(2, Node(3, Node(4, Node(5)))))
print(swap_every_two(llist))
# 2, (1, (4, (3, (5, (None)))))
```
