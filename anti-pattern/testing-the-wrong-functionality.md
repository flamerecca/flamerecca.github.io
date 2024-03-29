## 測試錯誤功能

-----
原文摘錄自 [http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-4---testing-the-wrong-functionality](http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-4---testing-the-wrong-functionality)

歡迎到原本部落格閱讀原文，認為翻譯有問題也歡迎討論。

-----

前面的部分，我們討論到了測試的幾個種類，以及每種測試應該有的數量。接著，我們解釋哪些功能需要測試。

理論上，測試的終極目標是取得 100% 的覆蓋率。實際上這個目標不僅困難，而且也並不保證你的產品沒有任何問題。

有些情況下，可能可以測試所有的功能。如果我們開始的是全新的專案，團隊是小型團隊，並且每個人都知道測試的重要性。那麼當然可以對每個新增加的功能都做完整的的測試（假設舊的功能都已經有完整測試了）。

但是不是所有開發者都這麼幸運。多數情況下，開發者可能面對之前開發者所撰寫只有一點點測試（甚至完全沒有！）的程式。如果你是在較大且較有規模的公司進行開發，開發中遇到遺留程式碼（legacy code）的情況與其說是特例，不如說是常態。

理想情況下，我們在這時會有足夠時間測試新功能和之前遺留下來的功能。這浪漫的想法很可能會被一般的專案管理（PM）拒絕。對他們來說，比起測試和重構程式，他們更關心加入新功能。你必須要做出選擇，找出加入符合商業需求的新功能，和加強既有測試的一個平衡點。

那麼，要測試哪些東西？我看見幾次開發者浪費寶貴的時間，撰寫對系統穩定度幾乎沒有意義的「單元測試」。無用測試一個經典的例子，是單純檢驗應用資料模型的測試。

測試覆蓋率會在自己的反模式（過度關注測試覆蓋率）裡面進行討論。這邊我們會討論程式的「重要性」以及這跟你的測試如何相關。

如果你詢問開發者他應用的程式碼在哪，他通常會打開自己的編輯器或者資料夾，讓你看每個資料夾分別是什麼：

Source code physical model

這些是程式碼的實體結構，每個資料夾負責各個部分的程式碼。不過，雖然程式碼的資料夾結構對分類程式碼本身的功能很有意義，卻不能清楚定義出每段程式碼的重要性。如果單就資料夾結構看，似乎代表同一個資料夾內的程式碼，會有相近的重要程度，但是這是不對的。即使是同一個資料夾的程式碼，也很可能具有不同的重要性。

舉例來說，假設現在我們在處理商城系統，這時出現了下面兩個錯誤：

* 客人購物完成之後，無法完成結帳。
* 客人瀏覽商品時，推薦的商品是錯誤的。
雖然這兩個錯誤都應該要修復，但是顯然第一個錯誤遠比第二個重要程度要高。所以，如果我們接收的商城系統之前完全沒有測試，首先我們要寫的應該是針對購物功能的測試，推薦功能的測試可以晚一點再寫。即使這兩個功能可能在相鄰甚至同一個資料夾裡面，對測試來說，他們的重要性仍舊是不同的。

更概略地說，如果我們正在處理一個中型或者大型的專案應用。與其使用程式碼的資料夾結構思考，應該使用另一種架構思考程式：心智模型（mental model）

Source code mental model 

這邊顯示三種不同的層面，但是根據應用大小，可能會有其他的層面。

上面的層面有：

* 極重要（critical）：這邊的程式碼經常出問題，有許多功能，而且每次出錯都會嚴重影響使用者。
* 核心（core）：有時候會出錯，功能稍少，出錯時對使用者會有一些影響。
* 其他（other）：這邊的程式碼很少更改，新功能很少與其相關，即使出錯了對使用者影響也不大。

如果你正在處理新的軟體專案測試，這個模型可以當作你的指導原則。問問自己寫的測試是不是針對極重要或者核心功能的。如果是，那麼就繼續。如果不是，或許可以將時間花在更有意義的地方上，像是處理其他的錯誤。

這種將程式碼區分出重要性的概念，也可以用來回答一個老問題：對專案來說多少測試覆蓋率才夠。要回答這個問題，我們可以先區分出應用每個功能的重要性或者問某個知道的人。得到這個資訊之後，覆蓋率的答案就很明顯了：

針對極重要的部分，覆蓋率應該提升到接近 100%，如果已經做到這點，可以嘗試將所有核心部分的覆蓋率提升到 100%。但是不建議嘗試將其他部分的覆蓋率也提升到 100%。

一個重點是，極重要的部分一定是所有程式碼的一個小子集。所以根據 80/20 法則，如果一個應用的極重要功能大約佔 20%，那麼先針對這 20% 的部分撰寫測試，對減少產品的錯誤是一個很好的開始。

總之，優先針對： 

* 常常出錯
* 常常修改
* 對商業邏輯非常重要

的程式碼撰寫單元和整合測試。

如果你有充裕的時間可以補充你的測試，確定你在花費時間撰寫幾乎沒有價值的測試之前，已經理解收益遞減的概念。
