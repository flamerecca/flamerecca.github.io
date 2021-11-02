## Kotlin Kata - Power of Three

Given an integer `n`, return _`true`_ if it is a power of three. Otherwise, return _`false`_.

An integer `n` is a power of three, if there exists an integer `x` such that `n == 3x`.


```kotlin
class Solution {
    fun isPowerOfThree(n: Int): Boolean {
        TODO()
    }
}
```

## 解法

利用 3 是質數這件事情，加上題目保證了輸入是 `Int`

我們可以利用 `3^19`（1162261467）和 3 的冪次取 mod 必定等於零這件事

來確定輸入是否為 3 的冪次

```kotlin
class Solution {
    fun isPowerOfThree(n: Int): Boolean {
        if (n <= 0) {
            return false
        }
        return 1162261467 % n == 0
    }
}
```

------

回到 [Kotlin Kata 列表](index.md)
