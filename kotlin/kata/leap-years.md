## Leap Years

寫程式計算某個西元年份是否是閏年

- 如果該年份可以被 400 整除，比方說西元 2000 年，是閏年
- 如果該年份可以被 100 整除，比方說西元 2100 年，不是閏年
- 如果該年份可以被 4 整除，比方說西元 2004 年，是閏年


```kotlin
fun isLeapYear(year: Int) : Boolean {
    TODO()
}
```

## 解答

我原本的做法是用 if 判斷，用 `return when` 作法更好

```kotlin
fun isLeapYear(year: Int) : Boolean {
     return when {
        year % 400 == 0 -> true
        year % 100 == 0 -> false
        else -> year % 4 == 0
    } 
}
```
