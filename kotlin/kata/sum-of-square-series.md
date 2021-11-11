## Kotlin Kata - 級數平方和

輸入正整數 n，回傳 1^2 + 2^2 + ... + n^2 的總和

題目保證輸入的 n > 0 且 n < 1000

**Example 1:**

**Input:** `10`
**Output:** `55`，1^2 + 2^2 + ... + 10^2 = 385

**Example 2:**

**Input:** `1`
**Output:** `1`

**Example 3:**

**Input:** `999`
**Output:** `332833500`

```kotlin
fun squareSum(n: Int): Int{}
```

## 解法
<details>
  <summary>點擊展開解答</summary>

第一時間的想法，可以用迴圈來解決

```kotlin
fun squareSum(n: Int): Int {
    var sum = 0
    for (i in 1..n) {
        sum += i * i
    }
    return sum
}
```

有的人可能會想到數學公式解

可以將答案縮減到單行

```kotlin
fun squareSum(n: Int) = n * (n + 1) * (n * 2 + 1) / 6
```

提升語意化的寫法，參考 [級數和]() 的做法

我們可以利用 `sum()` 和 `map()` 搭配出解答

```kotlin
fun squareSum(n: Int) = (1..n).map { it * it }.sum()
```

更進一步，我們可以利用 `sumOf()` 來加以簡化

```kotlin
fun squareSum(n: Int) = (1..n).sumOf { it * it }
```
</details>

------

回到 [Kotlin Kata 列表](index.md)
