## Kotlin Kata - 級數和

輸入正整數 n，回傳 1 + 2 + ... + n 的總和

題目保證輸入的 n > 0 且 n < 10000 

**Example 1:**

**Input:** `10`
**Output:** `55`，1 + 2 + ... + 10 = 55

**Example 2:**

**Input:** `1`
**Output:** `1`

**Example 3:**

**Input:** `9999`
**Output:** `49995000`

```kotlin
fun sum(n: Int): Int{}
```
## 解答
<details>
  <summary>點擊展開解答</summary>

第一時間的想法，可以用迴圈來解決

```kotlin
fun sum(n: Int): Int {
    var sum = 0
    for (i in 1..n) {
        sum += i
    }
    return sum
}
```

有的人可能會想到數學公式解

可以將答案縮減到單行

```kotlin
fun sum(n: Int) = n * (n + 1) / 2
```

更語意化的寫法，我們可以利用 range 的 `sum()` 函數進行操作

```kotlin
fun sum(n: Int) = (1..n).sum()
```
</details>

------

回到 [Kotlin Kata 列表](index.md)
