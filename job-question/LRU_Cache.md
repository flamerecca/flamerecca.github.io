Hi, here's your problem today. This problem was recently asked by Apple:

LRU cache is a cache data structure that has limited space, and once there are more items in the cache than available space, it will preempt the least recently used item. What counts as recently used is any item a key has 'get' or 'put' called on it.

Implement an LRU cache class with the 2 functions 'put' and 'get'. 'put' should place a value mapped to a certain key, and preempt items if needed. 'get' should return the value for a given key if it exists in the cache, and return None if it doesn't exist.

Here's some examples and some starter code.

```
class LRUCache:
  def __init__(self, space):
    # Fill this in.

  def get(self, key):
    # Fill this in.

  def put(self, key, value):
    # Fill this in.

cache = LRUCache(2)

cache.put(3, 3)
cache.put(4, 4)
print(cache.get(3))
# 3
print(cache.get(2))
# None

cache.put(2, 2)

print(cache.get(4))
# None (pre-empted by 2)
print(cache.get(3))
# 3
```
