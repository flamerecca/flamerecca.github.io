## Kotlin Kata - A+B 練習 STDIN 輸入

Input

The first line contains an integer t（1<=t<=100） — the number of test cases in the input. Then t test cases follow.

Each test case is given as a line of two integers a and b （−1000<=a,b<=1000）.

Output

Print t integers — the required numbers a+b.

input

```text
4
1 5
314 15
-99 99
123 987
```

output

```text
6
329
0
1110
```

## 解答
<details>
  <summary>點擊展開解答</summary>
  
這題目用來練習如何從 STDIN 讀取資料，並轉換成需要的格式

利用 Kotlin 可以 function 內包含 function 的特性

我們可以很快的撰寫這段邏輯

```kotlin
fun main() {
    fun readLn() = readLine()!!
    fun readInt() = readLn().toInt()
    fun readStrings() = readLn().split(" ")
    fun readInts() = readStrings().map { it.toInt() }
	
    val n = readInt()
    for (i in 1..n) {
        var (a, b) = readInts()
        println(a + b)
    }
}
```
</details>

------

回到 [Kotlin Kata 列表](index.md)
