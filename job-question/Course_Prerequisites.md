Hi, here's your problem today. This problem was recently asked by Google:

You are given a hash table where the key is a course code, and the value is a list of all the course codes that are prerequisites for the key. Return a valid ordering in which we can complete the courses. If no such ordering exists, return NULL.

Example:
```
{
  'CSC300': ['CSC100', 'CSC200'], 
  'CSC200': ['CSC100'], 
  'CSC100': []
}
```

This input should return the order that we need to take these courses:
```
 ['CSC100', 'CSC200', 'CSCS300']
```
Here's your starting point:
```
def courses_to_take(course_to_prereqs):
  # Fill this in.

courses = {
  'CSC300': ['CSC100', 'CSC200'], 
  'CSC200': ['CSC100'], 
  'CSC100': []
}
print courses_to_take(courses)
# ['CSC100', 'CSC200', 'CSC300']
```