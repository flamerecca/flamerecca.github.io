## 沒有讀文件就開始測試

-----
原文摘錄自 [http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-12---writing-tests-without-reading-documentation-first](http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-12---writing-tests-without-reading-documentation-first)

歡迎到原本部落格閱讀原文，認為翻譯有問題也歡迎討論。

------

專業的工程師熟知他的職業技能。在開始專案之前，你應該會花時間研究你即將使用的技術。網頁框架時時在更新，知道新的技術能做什麼對寫出有效率而精確的程式碼絕對是很有幫助的。

你應該以一樣的態度對待測試程式碼。有的工程師以一種次等公民的心態對待測試（請參考 [將測試視為次等公民](treating-test-code-as-a-second-class-citizen.md) ，他們不認真研究測試程式碼的框架能做些什麼。剪貼其他專案的測試程式碼可能在第一時間有用，但是這不是專業人士該做的事情。

不幸的是，這樣的狀況太常發生了。在弄清楚測試框架已經內建或者透過其他模組支援某些功能時，工程師常會自己寫一些「helper functions」或者「utilities」用在測試裡面。

這些「utilities」讓測試更難理解，特別是對較資淺的開發者。因為他們有很多公司自己的內部知識，這些知識和其他公司或專案不相通。好幾次我曾經將這些「聰明的內部解法」換成現成的函式庫，用更標準的方法就可以做到一樣的事情。

你應該花時間研究測試框架可以做些什麼。舉例來說，研究你的框架怎麼做：

* 參數化測試
* mocks 和 stubs
* 測試的 setup 和 teardown
* 測試分類
* 測試的條件選擇

如果你是在建立傳統的網頁應用，你應該至少稍微研究一下：

* 測試資料建立
* HTTP client 函式庫
* HTTP mock 伺服器
* mutation/fuzzy testing
* 資料庫 cleanup/rollback
* 效能測試

⋯⋯等等，有沒有比較好的實作方式。

「沒有必要重新發明輪子」這句話對測試程式碼也是成立的。或許有一些特例狀況讓你的產品程式碼獨一無二，需要一些專屬的 utility。但是我敢打賭他們的測試本身一點也不特殊，因此用客製化的 utility 來撰寫測試顯然是有問題的。
