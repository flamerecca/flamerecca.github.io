節錄自 [https://martinfowler.com/bliki/TestDouble.html](https://martinfowler.com/bliki/TestDouble.html)

所有測試裡面所用的替身物件總稱為「test double」，對應替身演員的英文「stunt double」

共分以下五類：

## Dummy
「Dummy objects are passed around but never actually used. Usually they are just used to fill parameter lists.」
所以一個 Dummy 物件只是被當作參數傳入，既沒有任何行為，也不會做紀錄。

實務上如果該參數允許 `null`，也可以直接傳 `null` 進去。

## Fake
「Fake objects actually have working implementations, but usually take some shortcut which makes them not suitable for production (an InMemoryTestDatabase is a good example).」

假物件最大的特點是會包含一些實作的內容。主要的用途是將很耗時的部分，比方說存取資料庫，用其他的方式實作以便於測試。Martin 提供的範例是 `InMemoryTestDatabase`。

Laravel 框架裡面實作的幾個 Fake 有：

* `Bus::fake();`
* `Event::fake();`
* `Mail::fake();`
* `Notification::fake();`
* `Queue::fake();`
* `Storage::fake('');`


## Stubs
「Stubs provide canned answers to calls made during the test, usually not responding at all to anything outside what's programmed in for the test.」

stub 是木樁的意思，因此有的網站翻譯成樁件。stub 被呼叫時，可能會完全不動（像是木樁一樣）或者拋出固定的訊息。

## Spies
「Spies are stubs that also record some information based on how they were called. One form of this might be an email service that records how many messages it was sent.」

像間諜一樣，一個 Spy 物件不僅僅會在被呼叫時回傳罐頭訊息，還會在呼叫之後，紀錄自己被呼叫函式的一些資訊。

比方說測試寄信時，可以使用一個 email service 的 spy 物件，紀錄寄信的事件被觸發了多少次或者內容。

## Mocks
「Mocks are pre-programmed with expectations which form a specification of the calls they are expected to receive. They can throw an exception if they receive a call they don't expect and are checked during verification to ensure they got all the calls they were expecting.」

mock 是模擬的意思。mock 物件被呼叫時，不會回傳罐頭訊息，只會紀錄哪些函式被呼叫過。最後驗證時，可以驗證 mock 物件預期被呼叫的韓式是否都確實被呼叫過。當預期外的函式被呼叫時，mock 物件也可以拋出例外。
