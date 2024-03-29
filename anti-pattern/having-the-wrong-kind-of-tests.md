## 測試種類錯誤

-----
原文摘錄自 [http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-3---having-the-wrong-kind-of-tests](http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-3---having-the-wrong-kind-of-tests)

歡迎到原本部落格閱讀原文，認為翻譯有問題也歡迎討論。

-----

根據前面兩篇反模式討論（[僅有單元測試，沒有整合測試](having-unit-tests-without-integration-tests.md) 和 [僅有整合測試，沒有單元測試](having-integration-tests-without-unit-tests.md)）我們知道應該兩種測試要同時存在了。現在我們要決定每一種分別需要多少測試。

這件事沒有絕對的鐵則，需要依照你的應用狀況而定。重點是你需要花時間弄清楚哪種測試對你的應用最有價值。測試金字塔只是在假設場景為商業網頁應用開發下的建議比例，但是不是所有場景都適用。我們看看以下例子：

## 範例：Linux 指令列工具

你要開發一個指令列工具應用，這個指令讀入某種檔案格式（比方說 csv 檔），經過一些轉換之後，輸出成另一種檔案格式（比方說 json 檔）。這個應用不和其他系統溝通，不需要網路，轉換過程是非常複雜的數學分析運算，花費很多運算時間以保證轉換的正確性。

上面這個情況，你需要：

* 非常非常多的單元測試，保證數學分析運算正確。
* 一些整合測試，保證檔案輸入輸出的格式正確。
* 不需要 UI 測試，指令列工具沒有 UI。
下面是針對這個專案的測試比例分析：

Test pyramid example

基本上全部都是單元測試。測試比例**不是一個金字塔**。

## 範例：付費管理系統

你要在一個企業系統裡面加入新的應用。這個應用處理付費功能，負責將付費資訊傳輸到其他系統。該應用必須將所有交易紀錄儲存到其他資料庫內，與其他付款功能溝通（比方說 aypal，Stripe，WorldPay⋯⋯等），並將交易資料傳輸到其他團隊開發的發票系統，處理開支發票的功能。

上面這個情況，你需要：

* 極少的單元測試，因為幾乎沒有包含商業邏輯。
* 非常非常多的整合測試，包含測試外部連接，資料庫存取，發票系統⋯⋯等。
* 不需要 UI 測試，這個應用沒有 UI。
下面是針對這個專案的測試比例分析：

Test pyramid example

基本上全部都是整合測試，只有一點單元測試。測試比例也**不是一個金字塔**。

## 範例：建立網站系統

你建立了一個全新的新創公司，希望改變人們建立網站的方式。你提供透過瀏覽器就可以建立網頁，獨一無二的方式。

這個應用提供像是繪圖軟體一樣的工具箱，可以操作所有的 HTML 元件，將他們加入網頁內搭配預設的樣板。你也可以從商城裡購買其他的樣板。

這個系統提供非常簡單的操作，透過滑鼠拖拉就能修改元件位置、大小的功能，也可以編輯元件的屬性，顏色，外觀。

上面這個情況，你需要：

* 極少的單元測試，因為幾乎沒有商業邏輯。
* 一些整合測試，確定商城系統連線正常。
* 非常非常多的使用者介面測試，來保證用戶的操作感覺和廣告所宣稱的一樣。

下面是針對這個專案的測試比例分析：

Test pyramid example

這邊有大量的使用者介面測試，測試比例也**不是一個金字塔**。

這邊用這些極端的例子，來解釋為什麼你必須要理解應用的情況，並撰寫真正有價值的測試種類。我曾經見過沒有整合測試的付費管理系統，也見過沒有使用者介面測試的建立網站系統。

網路上有一些文章（這邊不提供連接）討論到你需要的整合/單元/畫面測試比例。這些文章均會假設一些可能跟你的情況不符的前提上面。
