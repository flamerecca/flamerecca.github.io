## Kotlin Kata - 確定輸入為電話號碼

輸入一段字串，回傳這段字串是否是電話格式

這邊處理的是簡單版本，允許 `-` 和純數字，

不允許短於 5 個字或超過 20 個字

match：0910123456
match：0910-123-456
match：06-1234567
skip：1234
skip：456a456456
skip：+886-910-123-456
skip：886-910-123-456-789-789

```kotlin
fun isPhoneNumber(s: String): Boolean {

}
```

## 解答

<details>
  <summary>點擊展開解答</summary>

這題用來練習如何使用 regular expression 來進行字串判斷

我們可以嘗試用 `when` 將上述條件寫成單一表達式

```kotlin
fun isPhoneNumber(s: String) = when (true) {
    s.length < 5 || s.length > 20 -> false
    Regex("""[0-9-]+""") matches s -> true
    else -> false
}
```

</details>

------

回到 [Kotlin Kata 列表](index.md)
  
