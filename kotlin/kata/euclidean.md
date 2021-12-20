## Kotlin Kata - 列出最大公因數 輾轉相除法

輸入兩個數字，回傳這兩個數字的最大公因數

這次要求使用輾轉相除法處理

```kotlin
fun gcd(a: Int, b: Int): Int
```

## 解答
<details>
  <summary>點擊展開解答</summary>

利用輾轉相除法的概念

可以把計算的次數減少很多

```kotlin
fun gcd(a: Int, b: Int): Int {
    var a1 = a
    var b1 = b
    while (a1 != b1) {
        if (a1 > b1)
            a1 -= b1
        else
            b1 -= a1
    }
    return a1
}
```
</details>

------

回到 [Kotlin Kata 列表](index.md)
