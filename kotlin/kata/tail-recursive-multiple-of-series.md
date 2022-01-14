## Kotlin Kata - 尾遞迴版階乘

輸入正整數 n，回傳 1 * 2 * ... * n 的總和

題目保證輸入的 n > 0 且 n < 100

題目要求必須使用尾遞迴的方式撰寫

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
fun multiple(n: BigInteger): BigInteger{}
```

## 解答

<details>
  <summary>點擊展開解答</summary>
要用尾遞迴的方式處理階乘

`multiple()` 函數的參數是不夠的

我們必須要宣告新的函數來進行處理

利用 BigInteger 的操作

加上利用預設參數，我們可以寫成

```kotlin
tailrec fun multiple(number: BigInteger, answer: BigInteger = BigInteger.ONE): BigInteger {  
    return when (number) {  
        BigInteger.ONE -> answer  
        else -> sum(number - BigInteger.ONE, answer * number)  
    }  
}
```
</details>

-----

回到 [Kotlin Kata 列表](index.md)
