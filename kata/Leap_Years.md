
我原本的做法是用 if 判斷，這個作法更好

```
fun isLeapYear(year: Int) : Boolean {
     return when {
        year % 400 == 0 -> true
        year % 100 == 0 -> false
        else -> year % 4 == 0
    } 
}
```
