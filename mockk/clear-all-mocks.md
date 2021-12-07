## Mockk 框架記得測試結束後要 clearAllMocks()

撰寫測試時意外發現某個測試單獨運作時沒有問題

但是在 `gradle test` 時會出現 NullPointerException

由於這段測試會存取 Mongo DB 連線

所以一開始以為是連線所導致的問題

嘗試從連線方式上修正錯誤，但是一直沒法修正

後來發現真正的原因，是因為在其他的測試中

會建立一個 `MongoRepository` 這個 Object 的 mock

導致之後所執行的測試，如果使用 `MongoRepository` 這個 Object

實際存取到的都是 mock，不是真實的物件

解決方法也很簡單，在 `tearDown()` 環節將 Mock 清除掉就好

```kotlin
@After
fun tearDown() {
	clearAllMocks()
}
```
