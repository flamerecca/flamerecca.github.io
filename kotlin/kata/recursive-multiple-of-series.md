## Kotlin Kata - 遞迴版階乘

輸入正整數 n，回傳 1 * 2 * ... * n 的總和

題目保證輸入的 n > 0 且 n < 999 

題目要求必須使用遞迴的方式撰寫

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

利用 BigInteger 的操作

我們可以用下面的方式遞迴

```kotlin
fun multiple(number: BigInteger): BigInteger {  
    return when (number) {  
        BigInteger.ONE -> BigInteger.ONE
		else -> sum(number - BigInteger.ONE) * number
    }  
}
```

這個遞迴的寫法，導致數字很大時，比方說 n=999

f(999) 呼叫了 f(998)

f(998) 呼叫了 f(997) ⋯⋯

依此類推，會需要呼叫很多的函數

如果我們希望可以減少記憶體使用量

可以調整為 [Kotlin Kata 尾遞迴版階乘](tail-recursive-multiple-of-series.md)
</details>
  
-----

回到 [Kotlin Kata 列表](index.md)
