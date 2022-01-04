## Effective Java 3e 讀書心得 - Item 12：Always override toString

為什麼要覆載 toString 呢？

如果我們不特別覆載 toString 的話

我們通常會印出類別名稱加上 hashcode 

```kotlin
val test = Object()  
println(test) // java.lang.Object@6d311334
```

書中提到

>providing a good toString implementation makes your class much more pleasant to use and makes systems using the class easier to debug.

如果我們讓 toString 提供更清晰的資訊，

在找錯誤的時候可以更加的方便。

```kotlin
class PhoneNumber(var number: String) {  
    override fun toString() = number  
}
  
fun main() {  
    val test = PhoneNumber("123-456")  
    println(test) // 123-456
}
```

這在集合內也會產生效果

```kotlin
class PhoneNumber(var number: String) {  
    override fun toString() = number  
}  
  
fun main() {  
    val test = mapOf("Alice" to PhoneNumber(number = "123-456"))  
    println(test) // {Alice=123-456}
}
```


## Kotlin 的範例

這裡同樣可以參考一下 Kotlin 的 data class

如何實作 toString

```kotlin
data class Customer(
    val name: String,
    val email: String
)
```

以上面這個 data class 為例

反編譯出來的 `toString()` 如下

```java
@NotNull  
public String toString() {  
   return "Customer(name=" + this.name + ", email=" + this.email + ')';  
}
```

利用 data class 的特性

Kotlin 的編譯器認定所有的資料欄位

都是值得放進 `toString()` 裡面的

-----

回到[首頁](index.md)
