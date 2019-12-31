Hi, here's your problem today. This problem was recently asked by Microsoft:

You are given a doubly linked list. Determine if it is a palindrome.

Can you do this for a singly linked list?
```
class Node(object):
  def __init__(self, val):
    self.val = val
    self.next = None
    self.prev = None

def is_palindrome(node):
  # Fill this in.

node = Node('a')
node.next = Node('b')
node.next.prev = node
node.next.next = Node('b')
node.next.next.prev = node.next
node.next.next.next = Node('a')
node.next.next.next.prev = node.next.next

print is_palindrome(node)
# True
```
