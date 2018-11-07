# repository-service-presenter pattern

## 傳統的網頁 MVC

在網頁開發裡，MVC 框架一班將程式碼區分為三塊：

* model
* view
* controller

理想情況是，model 處理資料庫邏輯，view 處理前端邏輯，controller 處理兩者之間的溝通。

實際上，隨著網頁需求的發展，

## repository

repository 協助 model 處理資料庫邏輯。讓 model 專注於資料之間的關聯。

### criteria

l5-repository 這個套件提供了更進一步的分層，對常用的 query 條件建立了 criteria 層。

## service

有了 service 之後，商業邏輯終於有了一個好地方落腳了。可以讓 service 層專心處理商業邏輯。

因為是在 service 層處理，保證了最外層一定會有一個 controller，因此 service 可以安心的在各種異常狀況下，拋出 exception 中斷程式運行。所有的 exception 由 controller 內，根據不同類型的例外進行不同的處理。

### 有了 service 之後的 controller

商業邏輯放進 service 裡面之後，controller 基本上只剩下一件事情：資料回傳和例外處理

所以，我的 controller 建構子通常長這樣：

```php
public function __construct(XXXService $service)
{
    $this->service  = $service;
}
```
然後，功能的函式裡面的實作通常長這樣：

```php
try {
    $returnValue = $this->service->xxxhandle($id);
    
    //沒有例外，回傳成功資料
} catch (XXXException $e) {
    // 例外處理
}
```

因為我的專案多實行前後端分離，因此我回傳資料的格式通常是 json。laravel 內寫法如下：

```php
return response()->json([
    'error'   => false,
    'message'   => $message,
    'data' => $data
], Response::HTTP_OK);
```

最後就是例外處理了。我自己的習慣是寫成固定的 json 格式，透過 `getMessage()` 取得異常內容，並透過設置回傳的 HTTP response code 溝通狀況。laravel 內寫法如下：

```php
return response()->json([
    'error'   => true,
    'message' => $exception->getMessage()
], $code);
```

因為上面這兩個寫法太固定，所以可以寫在一個 PHP trait 裡面，方便在每個 controller 內使用。

## presenter

presenter 可以用來分擔 view 的責任，處理前端資料的部分

不過因為我自己的專案多走前後端分離，所以這一塊並不常使用。
