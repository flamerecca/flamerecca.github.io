## Kotlin Kata - Are We Alternate

Create a function `isAlt()` that accepts a string as an argument and validates whether the vowels (a, e, i, o, u) and consonants are in alternate order.

```kotlin
isAlt("amazon")
// true
isAlt("apple")
// false
isAlt("banana")
// true
```

Arguments consist of only lowercase letters.

## 解答
<details>
  <summary>點擊展開解答</summary>
  
用 Kotlin 的 regular expression 來處理

```kotlin
fun isAlt(s: String): Boolean {  
    return !Regex("""[aeiou]{2}|[^aeiou]{2}""").containsMatchIn(s)  
}
```
</details>


------

回到 [Kotlin Kata 列表](index.md)
