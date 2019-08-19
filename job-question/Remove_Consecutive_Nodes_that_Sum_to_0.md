Hi, here's your problem today. This problem was recently asked by Uber:

Given a linked list of integers, remove all consecutive nodes that sum up to 0.

Example:
```
Input: 10 -> 5 -> -3 -> -3 -> 1 -> 4 -> -4
Output: 10
```
The consecutive nodes 5 -> -3 -> -3 -> 1 sums up to 0 so that sequence should be removed. 4 -> -4 also sums up to 0 too so that sequence should also be removed.

Here's a starting point:
```
class Node:
  def __init__(self, value, next=None):
    self.value = value
    self.next = next

def removeConsecutiveSumTo0(node):
  # Fill this in.

node = Node(10)
node.next = Node(5)
node.next.next = Node(-3)
node.next.next.next = Node(-3)
node.next.next.next.next = Node(1)
node.next.next.next.next.next = Node(4)
node.next.next.next.next.next.next = Node(-4)
node = removeConsecutiveSumTo0(node)
while node:
  print node.value,
  node = node.next
# 10
```