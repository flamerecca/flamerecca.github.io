## 因無知而對測試有偏見

-----
原文摘錄自 [http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-13---giving-testing-a-bad-reputation-out-of-ignorance](http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-13---giving-testing-a-bad-reputation-out-of-ignorance)

歡迎到原本部落格閱讀原文，認為翻譯有問題也歡迎討論。

-----

雖然這是最後提到的反模式，但是這個模式是這篇文章出現的真正原因。當我看到有人在研討會或聚會上驕傲的宣稱測試是浪費時間，他們的專案不需要測試也運作得很好時，總是覺得很失望。另一個更常見的情況是遇到反對某種測試（通常是單元測試或者整合測試其中一種）的人，就像我們在反模式 [僅有單元測試，沒有整合測試](having-unit-tests-without-integration-tests.md) 和反模式  [僅有整合測試，沒有單元測試](having-unit-tests-without-integration-tests.md) 看到的一樣。

當我遇到這些人，我會問他們一些問題，看看為什麼會這麼討厭測試。原因通常都跟某種反模式有關。可能之前的公司測試非常慢（反模式 7），或者常常需要重構（反模式 5）。有些人被無理的要求測試率要達到百分之百（反模式 離譜或緩慢的測試）或者遇到測試驅動狂熱者（反模式 11）嘗試讓整個團隊遵守他對測試驅動開發的扭曲認知。

如果你是這些人其中之一，我理解。因為我知道要在一個有壞習慣的公司裡工作有多辛苦。

過去因經驗所導致的不好經驗，不應該影響你判斷自己的專案是否需要測試。嘗試客觀的檢視你的團隊和專案，看看裡面是否存在任何測試的反模式。如果有，那麼你就是單純地往錯誤的方向測試，不管增加多少測試對你的專案都不會更好。這雖然很讓人難過，但是是事實。

你的團隊受到不好的測試習慣受苦是一回事，指導新的開發者「測試是浪費時間」是另一回事，請不要這樣指導新的開發者。許多公司並不受這篇文章所說反模式的影響，去找這些公司吧！
