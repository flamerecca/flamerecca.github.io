## kotlin Kata - 判斷質數

輸入一個正整數，判斷輸入的數字是否為質數

```kotlin

fun isPrime(number: Int): Boolean
```

## 解答
<details>
  <summary>點擊展開解答</summary>
  
這題目我們可以用迴圈處理

```kotlin
fun isPrime(number: Int): Boolean {
    for (i in 2 until number) {
        if (number % i == 0) {
            return false
        }
    }
    return true
}
```
</details>

------

回到 [Kotlin Kata 列表](index.md)
