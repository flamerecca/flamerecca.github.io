## Kotlin Object 實作

Kotlin 的 Object 關鍵字

可以讓我們很快的建立起一個 singleton 物件

```kotlin
object DoAuth {
	val isAuth = true
    fun takeParams(username: String, password: String) {  
        println("input Auth parameters = $username:$password")  
    }  
}
```

並且能夠用簡潔的語法對該物件進行存取

```kotlin
fun main() {
    DoAuth.isAuth
    DoAuth.takeParams("foo", "qwerty")
}
```

不過，Kotlin 的 object 底層是怎麼實作的呢？

## 查看 object 實作

要知道 object 背後的實作方式是什麼

我們可以將編譯出來的 bytecode 

進行反編譯後查看

將剛剛的程式反編譯後，我們可以看到結果

```java
public final class DoAuth {
   @NotNull
   public static final DoAuth INSTANCE = new DoAuth();
   private static final boolean isAuth = true;

   private DoAuth() {
   }
   public final boolean isAuth() {
      return isAuth;
   }
```

我們可以看到，利用將建構子設置成 `private`

就可以讓 `DoAuth` 實作 singleton pattern 

另外我們也會發現

利用宣告成 static 的 `INSTANCE` 變數和 `isAuth`

可以讓其他程式取用時更加方便

參考 main 反編譯之後的結果

```java
   public static final void main() {
      DoAuth.INSTANCE.isAuth();
      DoAuth.INSTANCE.takeParams("foo", "qwerty");
   }
```

綜合以上兩段程式，我們就能知道

Kotlin 如何在 jvm 並不知道什麼是 object 的狀況下

實作出 jvm 能夠理解的 singleton 物件

並能夠簡易的存取該物件裡面的內容
