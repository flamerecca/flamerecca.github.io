Hi, here's your problem today. This problem was recently asked by Microsoft:

An IP Address is in the format of A.B.C.D, where A, B, C, D are all integers between 0 to 255.

Given a string of numbers, return the possible IP addresses you can make with that string by splitting into 4 parts of A, B, C, D.

Keep in mind that integers can't start with a 0! (Except for 0)

Example:
```
Input: 1592551013
Output: ['159.255.101.3', '159.255.10.13']
```
```
def ip_addresses(s, ip_parts=[]):
  # Fill this in.

print ip_addresses('1592551013')
# ['159.255.101.3', '159.255.10.13']
```
