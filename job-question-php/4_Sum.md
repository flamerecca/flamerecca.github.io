以下問題在微軟的面試出現過：

給定一個數字列表，以及目標數字 n，找出列表內數字a、b、c、d 令 a + b + c + d = n

```php
function fourSum(array $nums, int $target):
  # Fill this in.

echo(fourSum([1, 1, -1, 0, -2, 1, -1], 0))
# print [[-1, -1, 1, 1], [-2, 0, 1, 1]]

echo(fourSum([3, 0, 1, -5, 4, 0, -1], 1))
# print [[-5, -1, 3, 4]]

echo(fourSum([0, 0, 0, 0, 0], 0))
# print ([0, 0, 0, 0])
```
