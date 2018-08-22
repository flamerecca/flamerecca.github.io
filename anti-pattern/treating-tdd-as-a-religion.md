原文摘錄自 [http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-11---treating-tdd-as-a-religion](http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-11---treating-tdd-as-a-religion)

歡迎到原本部落格閱讀原文，認為翻譯有問題也歡迎討論。

# 將測試驅動開發視為信仰

測試驅動開發，常簡稱為 TDD，就像所有的方法論一樣，理論上是個好方法，直到顧問們嘗試說服公司盲目相信 TDD 才是唯一的道路。這篇文章撰寫的時候，這個風潮已經逐漸消失，但是為求完整，我還是在這邊提到這點，特別是業界深深受到這個反模式的荼毒。

概略地說，當撰寫測試時：

* 你可以先寫測試，再撰寫實作的程式碼
* 你可以寫測試時，同時撰寫實作的程式碼
* 你可以後寫測試，先撰寫實作的程式碼
* 你可以不寫任何測試

測試驅動開發的核心信條之一就是永遠先寫測試。先寫測試實作上不錯，但是並不是永遠都是最佳解法。

先寫測試代表你對你的最終產品樣貌很清楚，但是狀況不見得如此。或許你有完整的規格，因此你對該實作什麼東西很清楚。但是其他情況下你可能只是要實驗一下東西，快速嘗試看看，找尋比較好的做法而不是已經知道該怎麼做。

講更實際的例子，對新創公司來講盲目執行 TDD 就很不成熟。如果你在新創公司工作，你的程式需求變動可能快到測試驅動開發沒法幫上什麼忙。你甚至可能為了「做對的事」必須要拋棄一些程式碼。這種情況下，先寫程式碼之後補測試是一個完全合理的策略。

完全不寫任何測試也是可行的策略之一。在 測試錯誤功能 裡面有提到過，有些程式碼是不需要做測試的。只是因為要「符合 TDD」針對這些部分撰寫測試，對你一點好處都沒有。

TDD 崇拜者這種無論怎樣都一定要先寫測試的狂熱，已經對正常開發者的心理健康產生傷害。許多地方已經紀錄這種狂熱信仰的問題所在，希望我不需要在這個主題上面贅述些什麼了，想知道的人可以搜尋「TDD 很垃圾/很蠢/已死」。

現在，我可以承認有不少次自己的開發順序是：
* 先實作主要功能
* 針對該功能補充測試
* 跑測試確定會成功
* 註解掉核心功能
* 跑測試確定會失敗
* 解開核心功能的註解
* 跑測試確定會成功
* 上傳程式碼

簡單說，TDD 是個好想法，但是不用永遠遵守。如果你在前五百大公司工作，身邊圍繞著商業分析師，每個實作項目都有清楚規格的話，那麼 TDD 可能有幫助。

反過來說，如果你只是週末在家裡試試新的框架，看看框架怎麼運作，那麼當然可以不用遵守 TDD。
In summary, TDD is a good idea but you don’t have to follow it all the time. If you work in a fortune 500 company, surrounded by business analysts and getting clear specs on what you need to implement, then TDD might be helpful.

On the other hand if you are just playing with a new framework at your house during the weekend and want to understand how it works, then feel free to not follow TDD.


