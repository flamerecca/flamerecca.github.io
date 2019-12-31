Daily Interview Pro
Hi, here's your problem today. This problem was recently asked by Google:

Given a nested dictionary, flatten the dictionary, where nested dictionary keys can be represented through dot notation.

Example:
```
Input: {
  'a': 1,
  'b': {
    'c': 2,
    'd': {
      'e': 3
    }
  }
}
Output: {
  'a': 1,
  'b.c': 2,
  'b.d.e': 3
}
```
You can assume there will be no arrays, and all keys will be strings.

Here's some starter code:
```
def flatten_dictionary(d):
  # Fill this in.

d = {
    'a': 1,
    'b': {
        'c': 2,
        'd': {
            'e': 3
        }
    }
}
print(flatten_dictionary(d))
# {'a': 1, 'b.c': 2, 'b.d.e': 3}
```
