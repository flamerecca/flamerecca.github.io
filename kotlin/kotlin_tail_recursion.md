## Kotlin 尾遞迴

## 遞迴的問題

遞迴的撰寫雖然簡潔，但是因為其架構的緣故，如果不好好處理的話，那麼就可能會在運行時出現問題

我們來看看這個函式

```kotlin
fun sum(number: Long): Long {
    return when (number) {
        1L -> 1L
        else -> sum(number - 1) + number
    }
}
```

這段程式的邏輯很簡單：如果輸入是 `1` 就回傳 `1`，如果不是的話，就往下一層遞迴，並加上參數內輸入的數字

所以，如果輸入的 `number` 是 `5`，那麼運作就會是

* `5 + sum(4)`
* `5 + 4 + sum(3)`
* `5 + 4 + 3 + sum(2)`
* `5 + 4 + 3 + 2 + sum(1)`
* `5 + 4 + 3 + 2 + 1`
* `15`

在一般的狀況下，這段程式運作不會有太大問題。可是我們可以看出來，運作程式時需要一層一層地將函式的狀態都紀錄下來，直到 `sum(1)` 的時候回傳了 `1` 我們才能開始解析 `sum(2)`、`sum(3)`⋯⋯

這樣的結構，如果輸入很大的話，那麼記憶體不就可能會不夠嗎？

我們來試看看

```kotlin
fun main(){
    println(sum(999_999_999))
}
```

我們可以看到錯誤 `Exception in thread "main" java.lang.StackOverflowError`

這是什麼意思呢？這個錯誤的意思是，我們用來記錄函式呼叫的堆疊（stack）已經滿出來（overflow）了，所以出現了錯誤。

## 什麼是尾遞迴

尾遞迴（tail recursion）的定義是，在遞迴函式的最後面，只有呼叫一個函式。

這樣的話，由於呼叫時所需要的資料不包含現在函式的狀態，所以你可以不需要紀錄現在函式，也可以計算出最後的答案

我們來參考這個函式

```kotlin
fun tailSum(number: Long, answer: Long = 0): Long {
    return when (number) {
        0L -> answer
        else -> tailSum(number - 1, answer + number)
    }
}
```

乍看之下，我們並沒有改變到什麼，`tailSum(5)` 的答案一樣是 `15`，只是現在的堆疊會長成

* `tailSum(4, 5)`
* `tailSum(3, 9)`
* `tailSum(2, 12)`
* `tailSum(1, 14)`
* `tailSum(0, 15)`
* `15`

不過，對編譯器來說，有很多方法可以優化這段程式，比方說將 `tailSum` 的呼叫改成用 `goto` 實現，或者用迴圈的方式實作⋯⋯等等。

這也是一般現代編譯器裡面，尾遞迴的程式效能會比起一般遞迴更好的原因。

## Kotlin 的尾遞迴

如果我們嘗試運作 `tailSum()`

```kotlin
fun main(){
    println(tailSum(999_999_999))
}
```

我們一樣會得到 StackOverflowError。這是因為我們沒有告訴 kotlin 編譯器這是一個尾遞迴的函式，所以並沒有太多的優化。

我們在這個函式前面加上一個關鍵字 `tailrec`

```kotlin
tailrec fun tailSum(number: Long, answer: Long = 0): Long {
    return when (number) {
        0L -> answer
        else -> tailSum(number - 1, answer + number)
    }
}
```

這時候 `println(tailSum(999_999_999))` 就可以跑出我們的答案 `499999999500000000` 了！

如果我們嘗試將一般遞迴的函式前面加上 `tailrec`

```kotlin
tailrec fun sum(number: Long): Long {
    return when (number) {
        1L -> 1L
        else -> sum(number - 1) + number
    }
}
```

這時 IDE 會跳出提示，告訴我們雖然這個函式被宣告為尾遞迴，但是並沒有找到最後面只有呼叫一個函式的宣告。運行這段程式時也依然會有 StackOverflowError 的問題
