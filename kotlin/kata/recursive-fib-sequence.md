## Kotlin Kata - 遞迴版費式數列

費式數列（Fibonacci Number）

是指 0, 1, 1, 2, 3, 5, 8.... 這串數列

其中第一個數字是 0

第二個數字是 1

之後第 n 個數字為前兩個數字相加

輸入整數 `n`，回傳在費式數列第 n 個數字的內容

```kotlin
fun fib(n: Int): Int {

}
```

## 解答
<details>
  <summary>點擊展開解答</summary>
這題題目設計上，很適合使用遞迴解決

```kotlin
fun fib(n: Int): Int {
    return when (n) {
        1 -> 0
        2 -> 1
        else -> fib(n - 1) + fib(n - 2)
    }
}
```

不過這樣會導致數字很大時，比方說 n=30

f(30) 呼叫了 f(29) 和 f(28)

f(29) 呼叫了 f(28) 和 f(27) ⋯⋯

依此類推，會需要呼叫很多的函數

如果我們希望可以減少記憶體使用量

可以調整為 [尾遞迴版費式數列](tail-recursive-fib-sequence.md)

</details>

------

回到 [Kotlin Kata 列表](index.md)
