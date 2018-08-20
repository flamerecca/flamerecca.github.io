文章來源為 [Software Testing Anti-patterns](http://blog.codepipes.com/testing/software-testing-antipatterns.html) 這篇文章

下面會將文章拆分翻譯，方便更多人閱讀

對這個議題想更深入理解的人，可以去他的部落格 [Codepipes Blog](http://blog.codepipes.com/) 看看，相信會有許多收穫。

# 引言
已經有許多文章討論過軟體開發中測試的反模式（anti-pattern）。不過，這些文章大多數討論的是較為低階的細節，而且經常針對單一的技術或者程式語言進行討論。

這篇文章內，我想要往後退一步，討論並分類出一些高階的測試反模式，這些模式是和單一技術或者語言無關的。

希望不管你喜歡什麼程式語言，都會在這篇文章裡面認出一些對應的模式。

# 術語
很不幸的，測試的術語尚未取得全面的共識。問一百位開發者整合測試（integration test），部件測試（component test）和 E2E 測試（end-to-end test）的差異是什麼，很可能會得到一百種不同的答案。在這篇文章內我們使用測試金字塔的定義，如下圖：

The Testing pyramid

如果你不知道什麼是測試金字塔，我建議你先稍微理解它之後再往下閱讀。一些不錯的文章有：

* [The forgotten layer of the test automation pyramid (Mike Cohn 2009)](https://www.mountaingoatsoftware.com/blog/the-forgotten-layer-of-the-test-automation-pyramid)
* [The Test Pyramid (Martin Fowler 2012)](https://martinfowler.com/bliki/TestPyramid.html)
* [Google Testing blog (Google 2015)](https://testing.googleblog.com/2015/04/just-say-no-to-more-end-to-end-tests.html)
* [The Practical Test Pyramid (Ham Vocke 2018)](https://martinfowler.com/articles/practical-test-pyramid.html)

測試金字塔本身就值得撰文討論，特別是針對每個主題需要多少測試數量這個議題。這篇文章目前只是使用這個金字塔對底下兩種測試的定義。注意這篇文章裡沒有提到 UI 測試（金字塔頂端的測試），因為這樣文章討論的議題太過廣泛，也因為 UI 測試的反模式需要獨立出來討論。

因此我們對兩大主要的測試種類，也就是整合測試和單元測試，定義如下：

**單元測試** 比較不容易有歧義，他們伴隨程式碼出現並直接存取程式碼進行測試。通常這些測試會伴隨 xUnit 框架或類似的 library。這些測試直接對原始碼操作，並能對該元件全盤掌握。單元測試會針對個別的類別/方法/函式進行測試，如果該函式有使用其他的單元，則使用 mock 或者 stub 進行區隔。

**整合測試**
也有人稱呼為服務測試（service test），甚至元件測試（component test） 則是針對整個元件進行測試。一個元件可能是多個類別/方法/函式、一個模組、一個子系統甚至整個應用。整合測試輸入資料並檢查輸出資料是否正確。通常整合測試會需要先進行某種部署/bootstrap/設置。外部系統根據商業邏輯，可能完全是 mock 出來的，替換成假的（比方說，使用純記憶體的資料庫來取代真實的資料庫系統），也可能是連接真實的系統。

和單元測試比較起來，整合測試可能會需要比較特殊的工具來處理測試環境，或者模擬交互作用與驗證測試結果。

整合測試的定義比較模糊，許多對測試的命名爭議均從這邊開始。整合測試的「範圍」也很有爭議性，包括是否能存取應用內程式碼（黑箱測試 v.s. 白箱測試），或者能否使用 mock 都有人討論。

基本來說，如果：

* 測試使用了資料庫
* 測試透過網路存取其他元件/應用
* 測試使用了外部系統，像是 queue 或者郵件伺服器
* 測試讀寫檔案，或者執行其他 I/O
* 測試不針對程式碼，而是根據應用部屬過後的 binary 進行測試

⋯⋯那這個測試應該屬於整合測試，不屬於單元測試。

處理完命名問題之後，我們可以開始看反模式的列表了。反模式列表順序大致根據出現頻率由高至低做排列。

軟體測試反模式列表

* 僅有單元測試，沒有整合測試
* 僅有整合測試，沒有單元測試
* 測試種類錯誤
* 測試錯誤功能
* 測試內部實作
* 過度關注測試覆蓋率
* 離譜或緩慢的測試
* 手動測試
* 將測試視為次等公民
* 沒有將正式錯誤列入測試
* 將測試驅動開發視為信仰
* 沒有讀文件就開始測試
* 因無知而對測試有偏見

