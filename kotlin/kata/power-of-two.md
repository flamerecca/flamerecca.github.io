Given an integer n, return true if it is a power of two. Otherwise, return false.

An integer n is a power of two, if there exists an integer x such that n == 2x.


```kotlin
class Solution {

    function isPowerOfTwo($n) {
        TODO()
    }
}
```

## 解答

由於題目剛好是 2 為底

我們可以利用位元運算的方式簡化題目

直接計算輸入的位元是不是符合 `1[0*]` 這樣的型態

```kotlin
class Solution {

    function isPowerOfTwo($n) {
        if($n == 0 ){
            return false;
        }
        if(($n & ($n -1)) == 0){
            return true;
        }
        return false;
    }
}
```

------

回到 [Kotlin Kata 列表](index.md)
