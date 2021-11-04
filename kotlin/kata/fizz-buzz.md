## Kotlin Kata - Fizz Buzz

Given an integer `n`, return _a string array_ `answer` (**1-indexed**) _where_:

-   `answer[i] == "FizzBuzz"` if `i` is divisible by `3` and `5`.
-   `answer[i] == "Fizz"` if `i` is divisible by `3`.
-   `answer[i] == "Buzz"` if `i` is divisible by `5`.
-   `answer[i] == i` if non of the above conditions are true.

**Example 1:**

**Input:** `n = 3`
**Output:** `["1","2","Fizz"]`

**Example 2:**

**Input:** `n = 5`
**Output:** `["1","2","Fizz","4","Buzz"]`

**Example 3:**

**Input:** `n = 15`
**Output:** `["1","2","Fizz","4","Buzz","Fizz","7","8","Fizz","Buzz","11","Fizz","13","14","FizzBuzz"]`

```kotlin
class Solution {
    fun fizzBuzz(n: Int): List<String> {
        
    }
}
```

## 解答

這題題目的邏輯很單純

```kotlin
class Solution {
    fun fizzBuzz(n: Int): List<String> {
        val list = mutableListOf<String>()
        for (i in 1..n) {
            if(i % 15 == 0) {
                list.add("FizzBuzz")
                continue
            }
            if(i % 5 == 0) {
                list.add("Buzz")
                continue
            }
            if(i % 3 == 0) {
                list.add("Fizz")
                continue
            }
            list.add(i.toString())
        }
        return list
    }
}
```

利用 Kotlin 的 `map` 和 `when` 可以寫得更加簡潔

```kotlin
class Solution {
    fun fizzBuzz(n: Int) = (1..n).map {
        when {
            it % 15 == 0 -> "FizzBuzz"
            it % 5 == 0 -> "Buzz"
            it % 3 == 0 -> "Fizz"
            else -> it.toString()
        }
    }
}
```

-----

回到 [Kotlin Kata 列表](index.md)
