## Kotlin Kata 尾遞迴版費式數列

費式數列（Fibonacci Number）

是指 0, 1, 1, 2, 3, 5, 8.... 這串數列

其中第一個數字是 0

第二個數字是 1

之後第 n 個數字為前兩個數字相加

輸入整數 `n`，回傳在費式數列第 n 個數字的內容

不同於 [遞迴版費式數列](recursive-fib-sequence.md)

這邊要求必須用尾遞迴版本的方式處理

並且要能處理從 1 到 100 的輸入

```kotlin
fun fib(n: Int): BigInteger {

}
```

## 解答
<details>
  <summary>點擊展開解答</summary>
  
要用尾遞迴的方式處理費式數列

`fib()` 函數的參數是必定不夠的

我們必須要宣告新的函數來進行處理

```kotlin
fun fib(n: Int): BigInteger {  
    tailrec fun fib(n: Int, acc1: BigInteger, acc2: BigInteger): BigInteger {  
        return when (n) {  
            1 -> acc1  
            2 -> acc2  
            else -> fib(n - 1, acc2, acc1 + acc2)  
        }  
    }  
    return fib(n, BigInteger.ZERO, BigInteger.ONE)  
}
```
</details>

------

回到 [Kotlin Kata 列表](index.md)
