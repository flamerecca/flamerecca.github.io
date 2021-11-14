## Kotlin Kata - Binary Search

Given an array of integers `nums` which is sorted in ascending order, and an integer `target`, write a function to search `target` in `nums`. If `target` exists, then return its index. Otherwise, return `-1`.

You must write an algorithm with `O(log n)` runtime complexity.

**Example 1:**

**Input:** nums = [-1,0,3,5,9,12], target = 9
**Output:** 4
**Explanation:** 9 exists in nums and its index is 4

**Example 2:**

**Input:** nums = [-1,0,3,5,9,12], target = 2
**Output:** -1
**Explanation:** 2 does not exist in nums so return -1


```kotlin
class Solution {
    fun search(nums: IntArray, target: Int): Int {
        
    }
}
```

## 解答

<details>
  <summary>點擊展開解答</summary>

`nums` 已經排序過

利用 Binary Search 的邏輯

我們可以每次去除一半的選項

讓時間複雜度限制在 `O(log n)`

實作的部分

我們可以用一個 while 迴圈搜尋

```kotlin
class Solution {
    fun search(nums: IntArray, target: Int): Int {
        var left = 0
        var right = nums.size - 1
        while (left <= right) {
            val pivot = left + (right - left) / 2
            when {
                nums[pivot] == target -> return pivot
                nums[pivot] > target -> right = pivot - 1
                nums[pivot] < target -> left = pivot + 1
            }
        }
        return -1
    }
}
```
</details>

------

回到 [Kotlin Kata 列表](index.md)
