## Kotlin Kata - 列出最大公因數

輸入兩個數字，回傳這兩個數字的最大公因數

```kotlin
fun gcd(a: Int, b: Int): Int
```

## 解答

<details>
  <summary>點擊展開解答</summary>
基本的解決方法，可以用迴圈

從比較小的數字測試到 2

如果都沒有，則回傳 1

```kotlin
fun gcd(a: Int, b: Int): Int {  
    var bigger = a  
    var smaller = b  
    if (a < b) {  
        bigger = b  
        smaller = a  
    }  
    for (i in smaller downTo 2) {  
        if (bigger % i == 0) {  
            return i  
        }  
    }  
    return 1  
}
```

利用 `kotlin.math` 這段程式碼可以再簡化一點

```kotlin
fun gcd(a: Int, b: Int): Int {  
    for (i in kotlin.math.min(a, b) downTo 2) {  
        if (kotlin.math.max(a, b) % i == 0) {  
            return i  
        }  
    }  
    return 1  
}
```

另外我們也可以用[輾轉相除法](euclidean.md)來處理
</details>

------

回到 [Kotlin Kata 列表](index.md)
