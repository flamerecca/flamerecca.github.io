# Add Digits

本題在 Amazon 的面試題出現過：
給定一個數字，比方說 159，不斷將每位數相加，直到最後得到一個數字

範例：
輸入 159，1 + 5 + 9 = 15，1 + 5 = 6
所以答案是 6

## Kotlin Solutions

這一題我們可以從以前學的數學發現，一個數字和他每位數相加之後的結果，相減之後一定是 9 的倍數：

```
159 - (1 + 5 + 9) 
= (1*100 + 5*10 + 9) - (1 + 5 + 9)
= (1*99 + 5*9)
```

所以，這兩個數除以 9 的餘數會一樣。

也就是說，大多數時候，答案就是輸入的內容除以 9 的餘數。

除了一種特例：如果輸入的內容不是 0，而且是 9 的倍數，那麼答案是 9，而不是這個數除以 9 的餘數 0。

範例：
輸入 918，9 + 1 + 8 = 18，1 + 8 = 9
所以答案是 9

以口語說明的解法如下：
如果輸入是 0，回傳 0
如果輸入是 9 的倍數，回傳 9
回傳輸入除以 9 的餘數

```kotlin
fun addDigits(num: Int): Int {
}
```

[參考解答](./kotlin/AddDigits)

##  參考資料

https://leetcode.com/problems/add-digits/
