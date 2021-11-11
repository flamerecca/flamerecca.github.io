## Kotlin Kata - 階乘

輸入正整數 n，回傳 1 * 2 * ... * n 的總和

題目保證輸入的 n > 0 且 n < 10 

**Example 1:**

**Input:** `5`
**Output:** `120`，1 * 2 * 3 * 4 * 5 = 120

**Example 2:**

**Input:** `1`
**Output:** `1`

**Example 3:**

**Input:** `9`
**Output:** `362880`

```kotlin
fun multiple(n: Int): Int{}
```

## 解答

<details>
  <summary>點擊展開解答</summary>
第一時間的想法，可以用迴圈來解決

```kotlin
fun multiple(n: Int): Int {
    var sum = 0
    for (i in 1..n) {
        sum *= i
    }
    return sum
}
```

如果對函數式編程的思維熟悉

我們可以用 `reduce()` 的想法

來架構這段邏輯

```kotlin
fun multiple(n: Int) = (1..n)
    .reduce { ans, element -> ans * element }
```
</details>

------

回到 [Kotlin Kata 列表](index.md)
