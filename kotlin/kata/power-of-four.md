## Kotlin Kata - Power of Four

Given an integer `n`, return _`true` if it is a power of four. Otherwise, return `false`_.

An integer `n` is a power of four, if there exists an integer `x` such that `n == 4x`.

```kotlin
class Solution {
    fun isPowerOfFour(n: Int): Boolean {
        TODO()
    }
}
```
## 解法

由於 4 不是質數，不能使用 [Power of Three](power-of-three.md) 時的解法

我們改利用 `log()` 的特性

如果某個數字是 4 的冪次

那麼他的 `log()` 一定會是整數

------

利用 `kotlin.math`

可以很快速的實現上述的邏輯

```kotlin
import kotlin.math.ceil
import kotlin.math.floor
import kotlin.math.log

class Solution {
    fun isPowerOfFour(n: Int): Boolean {
        if (n <= 0) {
            return false
        }
        return (floor(log(n.toDouble(), 4.0)) == ceil(log(n.toDouble(), 4.0)))
    }
}
```

------

回到 [Kotlin Kata 列表](index.md)
