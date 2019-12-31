Hi, here's your problem today. This problem was recently asked by Amazon:

Given a 32 bit integer, reverse the bits and return that number.

Example:
```
Input: 1234 
# In bits this would be 0000 0000 0000 0000 0000 0100 1101 0010
Output: 1260388352
# Reversed bits is 0100 1011 0010 0000 0000 0000 0000 0000
```
Here's some starter code:
```
def to_bits(n):
  return '{0:08b}'.format(n)

def reverse_num_bits(num):
  # Fill this in.

print(to_bits(1234))
# 10011010010
print(reverse_num_bits(1234))
# 1260388352
print(to_bits(reverse_num_bits(1234)))
# 1001011001000000000000000000000
```
