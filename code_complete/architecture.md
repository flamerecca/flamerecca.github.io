# 核對表：架構
## 針對各架構主題
- [ ] 程式的整體組織結構是否清晰？是否包含一個良好的架構全域觀（及其理由）？
- [ ] 是否明確定義了主要的構造塊（包括每個構造塊的職責範圍及與其他構造塊的介面）？
- [ ] 是否明顯涵蓋了「需求」中列出的所有功能？
- [ ] 是否描述並論證了那些最關鍵的類別？
- [ ] 是否描述並論證了資料設計？
- [ ] 是否詳細定義了資料庫的組織結構和內容？
- [ ] 是否指出了所用關鍵的業務規則，並描述其對系統的影響？
- [ ] 是否描述了使用者介面設計的策略？
- [ ] 是否將使用者介面模組化，使介面的變更不會影響程式的其餘部分？
- [ ] 是否描述並論證了處理 I/O 的策略？
- [ ] 是否估算了數量有限的資源（如執行緒，資料庫連接，控制代碼，網路頻寬等）的使用量，是否描述並論證了資源管理的策略？
- [ ] 是否描述架構的安全需求？
- [ ] 架構是否為每個類別，每個子系統，或每個功能域（functionality area）提出空間與時間預算？
- [ ] 架構是否描述了如何達到可伸縮性（Scalability）？
- [ ] 架構是否關注互動操作性？
- [ ] 是否描述了國際化／本地化的策略？
- [ ] 是否提供了一整套的錯誤處理策略？
- [ ] 是否規定了容錯的辦法（如果有需要的話）？
- [ ] 是否證實了系統各個部分技術的可行性？
- [ ] 是否詳細描述了過度工程（overengineering）的方法？
- [ ] 是否包含了必要的「買 v.s. 造」的決策？
- [ ] 架構是否描述了如何加工被複用的程式碼，使之符合其他架構目標？
- [ ] 是否將架構設計得能後適應很可能出現的變更？

## 架構的總體品質
- [ ] 有沒有哪個部分是「過度架構（overarchitected）」或「欠缺架構（underarchitected）」？是否明確宣布了在這方面的預期指標？
- [ ] 整個架構是否在概念上協調一致？
- [ ] 頂層設計是否獨立於實現它的機器和語言？
- [ ] 是否說明了所有主要決策的動機？
- [ ] 你作為一名實現該系統的程式設計師，是否對這個架構感覺良好？