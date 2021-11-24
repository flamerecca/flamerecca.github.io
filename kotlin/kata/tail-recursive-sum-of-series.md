## Kotlin Kata - 尾遞迴版級數和

輸入正整數 n，回傳 1 + 2 + ... + n 的總和

題目保證輸入的 n > 0 且 n < 999_999_999 

題目要求必須使用尾遞迴的方式撰寫

（參考：[Kotlin 尾遞迴](../kotlin_tail_recursion.md)）

**Example 1:**

**Input:** `10`
**Output:** `55`，1 + 2 + ... + 10 = 55

**Example 2:**

**Input:** `1`
**Output:** `1`

**Example 3:**

**Input:** `999_999_999`
**Output:** `499999999500000000`

```kotlin
fun sum(n: BigInteger): BigInteger{}
```

## 解答

<details>
  <summary>點擊展開解答</summary>

要用尾遞迴的方式處理費式數列

`sum()` 函數的參數是不夠的

我們必須要宣告新的函數來進行處理

利用 BigInteger 的操作

加上利用預設參數，我們可以寫成

```kotlin
tailrec fun sum(number: BigInteger, answer: BigInteger = BigInteger.ZERO): BigInteger {  
    return when (number) {  
        BigInteger.ZERO -> answer  
        else -> sum(number - BigInteger.ONE, answer + number)  
    }  
}
```

遞迴的邏輯會變成
  
* sum(5, 0)
* sum(4, 5)
* sum(3, 9)
* sum(2, 12)
* sum(1, 14)
* sum(0, 15)
* return 15
  
</details>

------

回到 [Kotlin Kata 列表](index.md)
