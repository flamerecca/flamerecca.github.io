## HTTP Idempotent Methods

常常用到，但是有時還是會忘記的觀念，所以紀錄一下

## Idempotent

這個數學名詞的中文翻譯是「冪等」

跟這裡的場景有關的數學定義是針對一元運算的定義

「當由 X -> X 的一元運算 f，對所有在 X 內的元素 x，f(f(x)) = f(x) 為真，則 f 為冪等」

比方說，假設 f 是「對數字取絕對值」，雖然可能 x ≠ f(x)，但是 f(f(x)) = f(x) 一定為真

這時我們說 f(x) 為冪等

## HTTP Idempotent Method

與其對應的，HTTP 的 Idempotent Method 要符合的定義是「不論做幾次，所產生的影響跟只做一次是一樣的」

以功能的角度來講，比方說，「新增用戶」就不會是這樣的操作，因為每新增用戶一次，資料庫的內容就會多一筆。

不過「取得用戶資料」則是符合的，不論你取出幾次資料，所產生的影響和結果都會和第一次取出資料的內容一樣。

## RFC 7231

根據 [RFC 7231 section 4.2.2](https://tools.ietf.org/html/rfc7231#section-4.2.2) ：

>A request method is considered "idempotent" if the intended effect on the server of multiple identical requests with that method is the same as the effect for a single such request.  Of the request methods defined by this specification, PUT, DELETE, and safe request methods are idempotent.
   
裡面提到，「PUT」和「DELETE」這兩個動作是冪等的，亦即無論操作幾次，應該結果都和操作一次是一樣的。

### DELETE

首先我們看看 「DELETE」，根據語意，DELETE 通常用來刪除資料。

一但第一次執行，資料被刪除之後，就無法重複刪除該資料了，所以這個動作確實是冪等的。

### PUT

再來我們看到「PUT」，一般來說我們會用 PUT 處理「編輯資料」的動作

PUT 編輯資料的方式，根據 MDN Web Docs

>The HTTP PUT request method creates a new resource or replaces a representation of the target resource with the request payload.

也就是說，PUT 會帶著所有需要的資料欄位，建立新的資料後，取代掉舊的資料。

這個動作無論執行幾次，只要攜帶的資料相同，那就會產生相同的結果

所以 PUT 動作是冪等的

## 用 POST 建立資料

很多時候，POST 可以用來建立新資料，建立新資料時不會帶入資料 id。

這時候，如果我們操作 POST 不只一次，那麼就會建立多筆資料。

所以 POST 並不一定是冪等的。

## 用 PATCH 編輯資料

根據 MDN Web Docs

PUT 和 PATCH 都可以用來編輯資料

那麼為什麼 PUT 是冪等，但是 PATCH 則不是呢？

這是因為 PATCH 的副作用範圍要比起 PUT 來的廣

假設我們有一個資源（resource），裡面記錄了資料更動的時間

這個資源在接受 PUT 的資料修改時，由於 PUT 會將全部的資料更新

所以必定會在請求（request）內包含資料更動時間的內容。

這也就保證了，只要 PUT 的請求內容相同

執行幾次 PUT 得到的結果都會是一致的。

但是 PATCH，依據「修補」的語意，允許我們只更新部分的資料。

所以我們可能在 PATCH 請求裡面，並沒有寫入資料更動時間

而是期待更動資料時，由系統自動幫我們更新資料更動時間的內容

這個副作用（side-effect）導致了 PATCH 不能保證是冪等的。
