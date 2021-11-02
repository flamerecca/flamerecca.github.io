## HTTP Idempotent Methods

常常用到會忘記，所以紀錄一下

## Idempotent

中文翻譯是「冪等」，跟這裡的場景有關的數學定義是針對一元運算的定義

「當由 X -> X 的一元運算 f，對所有在 X 內的元素 x，f(f(x)) = f(x) 為真，則 f 為冪等」

比方說，假設 f 是「對數字取絕對值」，雖然可能 x ≠ f(x)，但是 f(f(x)) = f(x) 一定為真

## HTTP Idempotent Method

與其對應的，HTTP 的 Idempotent Method 要符合的定義是「不論做幾次，所產生的影響跟只做一次是一樣的」

以功能的角度來講，比方說，「新增用戶」就不會是這樣的操作，因為每新增用戶一次，資料庫的內容就會多一筆。

不過「取得用戶資料」則是符合的，不論你取出幾次資料，所產生的影響和結果都會和第一次取出資料的內容一樣。

## RFC 7231

根據 [RFC 7231 section 4.2.2](https://tools.ietf.org/html/rfc7231#section-4.2.2) 所述：

   A request method is considered "idempotent" if the intended effect on
   the server of multiple identical requests with that method is the
   same as the effect for a single such request.  Of the request methods
   defined by this specification, PUT, DELETE, and safe request methods
   are idempotent.
   
裡面提到，「PUT」和「DELETE」這兩個動作是冪等的，亦即無論操作幾次，應該結果都和操作一次是一樣的。

首先我們看看 「DELETE」，根據語意，DELETE 通常用來刪除資料。

一但第一次執行，資料被刪除之後，就無法重複刪除該資料了，所以這個動作確實是冪等的。

再來我們看到「PUT」，一般來說我們會用 PUT 處理「編輯資料」的動作，

## 用 POST 寫入資料

很多時候，POST 可以用來建立新資料

如果建立新資料時

