## Binary Search 的時間複雜度

以下我們嘗試計算 Binary Search 的時間複雜度

## 範例程式碼

Binary Search 用 Kotlin 程式語言的寫法為

```kotlin
fun search(nums: IntArray, target: Int): Int {
    var left = 0
    var right = nums.size - 1
    while (left <= right) {
        val pivot = left + (right - left) / 2
            when {
                nums[pivot] == target -> return pivot
                nums[pivot] > target -> right = pivot - 1
                nums[pivot] < target -> left = pivot + 1
        }
    }
    return -1
}
```

## 假設

這邊我們有幾個基本假設

因為處理的數字均是 `Int` 有固定大小（4 Byte）

我們假設針對這些輸入進行變數設置、比較大小、回傳、或者對輸入進行四則運算等等

所花費的時間均為常數。

## 計算時間複雜度

我們已經假設了設置變數的時間為常數

所以

```kotlin
var left = 0
var right = nums.size - 1
```

還有

```kotlin
return -1
```

這段時間均為常數，我們假設總和為 C_1

由於四則運算的時間複雜度為常數，`while` 迴圈的內容內

```kotlin
val pivot = left + (right - left) / 2
```

這段時間也是常數

接著我們看 `when`

```kotlin
when {
	nums[pivot] == target -> return pivot
	nums[pivot] > target -> right = pivot - 1
	nums[pivot] < target -> left = pivot + 1
}
```

這邊針對固定個數的情境進行比較

這些比較的時間不因輸入陣列的大小有所改變

所以我們可以確定這邊的時間複雜度也會是常數

迴圈內的所有邏輯所需時間總和，我們將這段時間假設為 C_2

所以我們比較需要關注的問題

就會是

```kotlin
while (left <= right) {
}
```

這個迴圈需要運行的次數，究竟是幾次

### while 迴圈次數

我們假設輸入的陣列 size 為 n

```kotlin
val pivot = left + (right - left) / 2
when {
	nums[pivot] == target -> return pivot
	nums[pivot] > target -> right = pivot - 1
	nums[pivot] < target -> left = pivot + 1
}
```

我們發現，在每一次迴圈內，不管是哪種情境

我們至少會將需要檢查的元素個數

減少到 n/2 以下，直到只剩下 1 個元素。

也就是説，迴圈運作的次數

等同於不斷將 n 除以 2，直到 n 等於 1 時的次數

也就是 log<sub>2</sub>n

因此，我們就可以知道

這個演算法的時間複雜度 f(x) 

是 C_1 + log<sub>2</sub>x × C_2


## 計算 Big-O-notation

已知 f(x) ＝ C_1 + log<sub>2</sub>x × C_2

我們令 x_0 = 2^C_1

M = 2 × C_2 + 1

對所有輸入大小 x ＞ x_0，

M × log<sub>2</sub>x = 2 × C_2 × log<sub>2</sub>x + log<sub>2</sub>x

由於 log<sub>2</sub>x ＞ log<sub>2</sub>x_0 = C_1

所以 2 × C_2 × log<sub>2</sub>x + log<sub>2</sub>x ＞ C_1 + 2 × C_2 × log<sub>2</sub>x

由於 C_2 ＞ 0

所以 2 × C_2 × log<sub>2</sub>x ＞ C_2 × log<sub>2</sub>x

綜合以上可以得到

M × log<sub>2</sub>x ＞ C_1 + C_2 × log<sub>2</sub>x

得證 f(x) = O(log x)

## 延伸閱讀

- [什麼是 Big-O-notation](what-is-big-o.md)
