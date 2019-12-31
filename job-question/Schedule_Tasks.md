Hi, here's your problem today. This problem was recently asked by Amazon:

A task is a some work to be done which can be assumed takes 1 unit of time. Between the same type of tasks you must take at least n units of time before running the same tasks again.

Given a list of tasks (each task will be represented by a string), and a positive integer n representing the time it takes to run the same task again, find the minimum amount of time needed to run all tasks.

Here's an example and some starter code:
```
def schedule_tasks(tasks, n):
  # Fill this in.

print(schedule_tasks(['q', 'q', 's', 'q', 'w', 'w'], 4))
# print 6
# one of the possible orders to run the task would be
# 'q', 'w', idle, idle, 'q', 'w'
```
