## Kotlin Kata - Single Number

Given a **non-empty** array of integers `nums`, every element appears _twice_ except for one. Find that single one.

You must implement a solution with a linear runtime complexity and use only constant extra space.

**Example 1:**

**Input:** nums = [2,2,1]
**Output:** 1

**Example 2:**

**Input:** nums = [4,1,2,1,2]
**Output:** 4

**Example 3:**

**Input:** nums = [1]
**Output:** 1

## 解答

<details>
  <summary>點擊展開解答</summary>

利用一個位元操作的知識

當一個數字同時和另一個數字進行兩次 xor 操作後

該數字保持不變

```
a xor b xor b = a
```

我們可以很快的解答這個題目

```kotlin
class Solution {
    fun singleNumber(nums: IntArray): Int {
        var answer = 0
        for(num in nums){
            answer = answer xor num
        }
        return answer
    }
}
```

上述邏輯還可以用 `reduce()` 進行簡化

```kotlin
class Solution {
    fun singleNumber(nums: IntArray): Int {
        return nums.reduce { ans, num -> ans xor num }
    }
}
```
</details>

------

回到 [Kotlin Kata 列表](index.md)
