# 核對表：需求
## 針對功能需求
- [ ] 是否詳細定義了系統的全部輸入，包括其來源，準確度，取值範圍，出現頻率等？
- [ ] 是否詳細定義了系統的全部輸出，包括目的地，準確度，取值範圍，出現頻率，格式等？
- [ ] 是否詳細定義了所有的輸出格式（網頁，報表等等）？
- [ ] 是否詳細定義了所有硬體及軟體的外部介面？
- [ ] 是否詳細定義了全部的外部通訊介面，包括握手協定（hand-shaking），偵錯協定（error-checking），通訊協定等？
- [ ] 是否列出了使用者想要做的全部事情？
- [ ] 是否詳細定義了每項任務所使用的資料，以及每個任務會產出的資料？

## 針對非功能需求（品質需求）
- [ ] 從使用者的視角來看，是否已經替全部必要的操作都詳細描述了期望的回應時間（response-time）？
- [ ] 是否詳細描述了其他與計時有關的考慮，例如處理時間，資料傳輸率，系統產量（system throughput）？
- [ ] 是否詳細定義了安全等級？
- [ ] 是否詳細定義了可靠性（reliability），包括軟體失靈的後果，發生故障時需要保護的貴重資訊，錯誤檢測與恢復的策略等等？
- [ ] 是否詳細定義了機器記憶體的最小值和剩餘硬碟空間的最小值？
- [ ] 是否詳細定義了系統的可維護性（maintainability），包括適應特定功能的變更，操作環境的變更，與其他軟體的介面的變更能力？
- [ ] 是否包含了對「成功」的定義？對「失敗」的定義？

## 需求的品質
- [ ] 需求是用使用者的語言書寫的嗎？使用者也這麼認為嗎？
- [ ] 每條需求都不與其他需求相衝突嗎？
- [ ] 是否詳細定義了相互競爭的特性之間的權衡——例如，健全性（robustness）與正確性（correctness）之間的權衡？
- [ ] 是否避免在需求中規定設計方案
- [ ] 需求是否在詳細程度上保持相當一致的水準？有些需求應該更詳細的去描述嗎？有些需求應該更粗略地去描述嗎？
- [ ] 需求是否足夠清晰，即使轉交給一個獨立的小組去建構，他們也能理解嗎？開發者也這麼想嗎？
- [ ] 每個項目都與待解決的問題及其解決方案相關嗎？能從每個項目上回溯到他在問題領域中對應的根源嗎？
- [ ] 是否每條需求都是可測試的？是否可能進行獨立的測試，以檢驗滿不滿足各項需求？
- [ ] 是否詳細描述了所有可能的對於需求的變更，包括各項變更的可行性？

## 需求的完備性
- [ ] 對於在開始開發之前無法獲得的資訊，是否詳細描述了「資訊不完全」的區域？
- [ ] 需求的完備度是否達到這種程度：如果產品滿足了所有需求，那麼他就是可接受的？
- [ ] 你對全部的需求都感到很合理嗎？你是否已經去掉了那些不可能實現的需求——那些只是為了安撫顧客的東西？
