## Kotlin Kata - 遮罩

輸入一個正整數 `target`

得到長度為 `target` 的一串 1 bits

這邊可以利用 binary operation 

```
-1 ^ (-1 << target)
```

得到結果

```kotlin
fun mask(target: Int): Int {
}
```

## 解答

<details>
  <summary>點擊展開解答</summary>


這邊練習的是 Kotlin 上的 binary operation

```kotlin
fun mask(n: Int) = -1 xor (-1 shl target)
```

其中 `xor` 代表 xor operation

`shl` 代表 shift left


</details>

------

回到 [Kotlin Kata 列表](index.md)
