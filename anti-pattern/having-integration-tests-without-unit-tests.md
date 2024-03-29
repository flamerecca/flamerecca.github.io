## 僅有整合測試，沒有單元測試

-----
原文摘錄自 [http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-2---having-integration-tests-without-unit-tests](http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-2---having-integration-tests-without-unit-tests)

歡迎到原本部落格閱讀原文，認為翻譯有問題也歡迎討論。

-----

這是 [僅有單元測試，沒有整合測試](having-unit-tests-without-integration-tests.md) 的相反情況。這種反模式通常出現在大公司或者大的企業集團中。幾乎所有情況下，這種反模式的出現都牽涉某些開發者認為單元測試沒有意義，只有整合測試可以發現問題。有相當多的開發者認為單元測試是浪費時間。通常，如果你問一些問題探探口風，你會發現在過去某個時間點內，管理層曾經強迫他們寫一些簡單的單元測試來提高測試覆蓋率（參考 過度關注測試覆蓋率）。

理論上，專案確實可以只依靠整合測試來找出問題。但是不管是從開發測試角度來看，或者是測試運行時間來看，實際上只依靠整合測試會導致測試變得非常困難。我們從前面的表格可以看出，所有單元測試可以找出的錯誤，理論上都可以透過整合測試找出來，所以整合測試在這方面可以「取代」單元測試。但是這個策略可能長久執行嗎？

整合測試很複雜
我們看一個例子，假設我們有個服務，包含以下四個元件：

Cyclomatic complexity for 4 modules

上面的CC代表每個元件的[循環複雜](https://zh.wikipedia.org/wiki/%E5%BE%AA%E7%92%B0%E8%A4%87%E9%9B%9C%E5%BA%A6)度，或者説，每個元件分支出路徑的數量。

開發者瑪莉・照規矩小姐，了解單元測試的重要性，認為應該要為這個服務寫單元測試。那麼她需要寫多少測試，才能覆蓋所有的可能情況呢？

要測試所有元件的可能路徑，很顯然她需要寫 2＋5＋3＋2＝12 個獨立的測試，才能覆蓋這個服務的所有商業邏輯。請記得這只是針對單一服務，而瑪莉正處理的應用有多個服務。

另外，開發者喬・壞脾氣先生，不認為單元測試有意義。他認為單元測試是浪費時間，所以他只寫整合測試。那麼，他需要寫多少測試呢？我們來看看下圖：

Examining code paths in a service

依據輸入到輸出的可能性，我們可以算出喬需要 2×5×3×2＝60 個測試才能覆蓋所有路徑的可能性。但是喬可能會寫60個整合測試嗎？當然不會！喬一定會嘗試省略某些測試。他會挑選「比較具有代表性」的幾個情況。這些「比較具有代表性」的測試，可以讓他用最少的力氣取得足夠的測試覆蓋率。

聽起來蠻簡單的，但是很快，問題就出現了。實際上這 60 種路徑沒有被公平對待，有的有進行測試，而有的路徑沒有。有的路徑可能非常不容易出現。比方說，元件 C 有三種可能路徑，其中某個路徑屬於特例，只有在 B 元件的其中一種路徑可能觸發。而恰好 B 元件對應得路徑也很特殊，只有在 A 元件的其中一種路徑下才會出發。這就導致我們在整合測試上，需要非常精確的輸入和設置，才能觸發 C 元件針對該路徑的測試。

對瑪莉來說，這則根本不是問題，他只需要針對 C 元件的對應路徑寫一個測試就好。完全不影響測試複雜度。

Basic unit test

這代表瑪麗只需要寫單元測試嗎？這想法會回到 [僅有單元測試，沒有整合測試](having-unit-tests-without-integration-tests.md) 這個反模式。瑪麗應該要同時撰寫單元測試和整合測試。單元測試裡，他應該要測試所有的商業邏輯，然後，瑪麗只需要再寫一兩個整合測試來確認服務整體沒有問題即可。

以這個服務來說，所有元件的商業邏輯已經在單元測試驗證過，整合測試應該要針對其他元件進行。瑪麗的整合測試應該針對像是和資料庫系統的溝通，和 queue 的溝通，和序列器的溝通⋯⋯等等即可。

correct Integration tests

到最後，整合測試的數量應該比起單元測試的數量少很多，就像是前面所說的測試金字塔所表示的一樣。

## 整合測試很慢
整合測試另一個大問題是速度。一般來說整合測試會比對應的單元測試慢一個數量級。單元測試只需要程式碼就可以進行，速度限制通常只取決於 CPU 速度。整合測試則可能有檔案存取或者外部系統存取，所以速度通常很難提升。

我們看個案例來了解測試花費的時間差距有多大。假設：

* 每個單元測試平均花費 60ms
* 每個整合測試平均花費 800ms
* 整個應用包含40個服務，每個服務結構和前面範例一樣


然後：

* 針對每個服務，瑪麗寫了 10 個單元測試和 2 個整合測試
* 針對每個服務，喬寫了 12 個整合測試

現在我們來計算測試時間，注意這邊我們假設了喬找到了非常少的整合測試，就能覆蓋瑪麗單元測試所覆蓋的程式碼。這在實際情況下很難成立。

| 運作時間 | 只有整合測試（喬） | 包含單位測試和整合測試（瑪麗）
| ---      | ---                | ---
| 單位測試 | 沒有單位測試       | 40×60×10＝24 秒
| 整合測試 | 40×800×12＝384 秒  | 0×800×2＝64 秒
| 總和     | 384 秒             | 8 8秒

我們可以看到，兩種測試架構花費時間差異非常大。每次修改程式碼需要等一分鐘和需要等六分鐘是很不同的。另外，實際上整合測試可能會比假設的 800 ms 要花費更長時間。我見過僅僅單一一項整合測試就花費數分鐘執行的情況。

總的來說，僅用整合測試來檢驗商業邏輯非常浪費時間。即使你使用自動整合（CI）來自動化測試，你的回饋時間（feedback loop，從 commit 程式碼到得到測試結果的時間）仍然會非常長。 

## 整合測試比單元測試難找出錯誤
最後一個只有整合測試是反模式的原因是因為從出錯測試中找出問題的時間。既然整合測試定義上就是同時測試多個元件的整合情況，當某個整合測試出錯，錯誤的地方可能是這些元件的任何一個。根據該整合測試所覆蓋的元件數量，找出是哪些元件錯誤可能是非常麻煩的大工程。

當一個整合測試出錯，你需要了解整個測試哪邊出錯，以及怎麼修理。其複雜度和廣度讓整合測試非常難協助除錯。

我們下面用另一個範例來說明，假設我們正在開發一個電子商城，而這個應用只有整合測試。某個開發者上傳了新的程式碼，導致以下錯誤：

breakage of integration tests

作為處理這個問題的開發者，你看到了「客戶購買單一產品」這個整合測試出錯了。但是這對你的除錯沒什麼幫助，有太多原因可能導致這個錯誤了。

要找出這個錯誤，我們只能從測試環境的紀錄檔和設定中找看看有沒有紀錄（假設該錯誤有被記錄的話）。在某些狀況下，更複雜的應用要透過整合測試找出錯誤，必須先下載程式碼，在本地重建測試環境，然後在本地運行所有整合測試來找出問題點。

假設我們是跟瑪麗合作，所以她幫我們寫了單元測試。在上傳新程式碼過後，我們看到以下錯誤：

breakage of both kinds of tests

現在，我們有兩個測試出錯了：

* 整合測試裡「客戶購買單一產品」出錯
* 單元測試裡「特別折扣測試」出錯

現在問題出在哪邊就很明顯了，我們可以直接找折扣相關的程式碼，然後找到錯誤並修正。99% 的情況下對應的整合測試都會一起被修正。

在找程式碼臭蟲時，有比起整合測試先出錯的單元測試，會讓除錯的過程輕鬆很多。

## 總結：為什麼你需要單元測試
這段是整篇文章最長的段落，但是我認為這非常重要。簡單說，雖然理論上可以只有整合測試，但是實際上：

* 單元測試更好維護
* 單元測試可以簡單的複製出特殊狀況
* 單元測試運行得比整合測試快
* 出現錯誤時，單元測試比起整合測試更容易找出錯誤

如果你只做整合測試，你在浪費開發者的時間和公司的錢。你需要單元測試和整合測試，這兩者不是互相排斥的。有些網路上的文章提倡只需要使用其中一種測試，這些文章全是誤傳。雖然令人難過，但是卻是事實。
