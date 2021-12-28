## Effective Java 3e 讀書心得 - Item 3：Enforce the singleton property with a private constructor or an enum type

單體（singleton）是在各個專案內很常見的一種設計模式，書中提到兩種實作的方式

首先是建立 public final field

```java
public class Elvis {
    public static final Elvis INSTANCE = new Elvis();
    private Elvis() { ... }
}
```

第二是建立 static factory method

```java
public class Elvis {
    private static final Elvis INSTANCE = new Elvis();
    private Elvis() { ... }
    public static Elvis getInstance() { return INSTANCE; }
}
```

上面提到兩種方法的重點，都是讓建構子（constructor）維持 private

透過其他方式來存取建立好的單體物件

還有第三種方式，是利用 `enum` 關鍵字

```java
public enum Elvis {
    INSTANCE;
}
```

雖然看起來語意比較模糊，不過這個做法和上述兩種相比，有一些好處

- 語法比較簡潔
- 內建序列化（serialization）
- 面對複雜的序列化攻擊或反射（reflection）攻擊比較安全

## Kotlin 實作範例

在 Kotlin 裡面宣告單體的做法是使用 `object` 關鍵字

```kotlin
object DoAuth {
	val isAuth = true
    fun takeParams(username: String, password: String) {  
        println("input Auth parameters = $username:$password")  
    }  
}
```

反組譯後我們看到裡面的實作

```java
public final class DoAuth {
   @NotNull
   public static final DoAuth INSTANCE = new DoAuth();
   private DoAuth() {
   }
}
```

可以看出，Kotlin 選用的做法是書中提到的 public final field 的做法

-----

回到[首頁](index.md)
