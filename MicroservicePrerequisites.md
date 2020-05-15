翻譯自

https://martinfowler.com/bliki/MicroservicePrerequisites.html

----

當我和其他人談到微服務架構時，我聽到很多樂觀的想法。開發者很享受以較小的單位進行開發，並對新架構會帶來比起巨大系統更好的模組化充滿期待。不過和所有架構的選擇一樣，這是有取捨的。對微服務來說，取捨錯誤特別會帶來嚴重的後果，因為一但選用微服務，你就不再是管理一個單一完整的巨大系統，而是要處理一堆小服務所組成的生態系。因此，如果你不具備某些基本條件，那就不應該考慮使用微服務架構。

快速配置：你應該要可以在幾個小時之內開一個新的伺服器。如果使用雲端系統的話，這是很自然的。不過即使不全部使用雲端服務這也是可以達成的。要做到這麼快速的配置，你需要很多的自動化——一開始可能不需要完全自動化，但是要認真的做微服務最終還是需要做到。

基本監控：在正式環境內有這麼多鬆耦合的服務同時運作，一定會有測試環境內不好察覺的問題出現，所以設立一個能快速偵測嚴重問題的監控機制是很重要的。底線是你要能偵測出技術上的問題，像是計算錯誤，服務是否還可用等等。另外有許多商務問題也很值得偵測，比方說訂單遺漏等等的情況。

如果突然出現問題，你要能夠馬上退回到沒問題的版本，所以你需要⋯⋯

快速應用部署：要處理這麼多服務，你必須要能夠在測試環境或者正式環境下都能夠快速部署服務。通常這會牽涉到使用自動部署，並且部署時間不會超過幾個小時。早期需要部分手動操作是可以接受的，但是要能很快的做到全自動部署。

這些能力又需要一個很重要的組織架構轉移，要求開發者和部署者必須有密切的合作關係：也就是 DevOps 文化。 This collaboration is needed to ensure that provisioning and deployment can be done rapidly, it's also important to ensure you can react quickly when your monitoring indicates a problem. In particular any incident management needs to involve the development team and operations, both in fixing the immediate problem and the root-cause analysis to ensure the underlying problems are fixed.

With this kind of setup in place, you're ready for a first system using a handful of microservices. Deploy this system and use it in production, expect to learn a lot about keeping it healthy and ensuring the devops collaboration is working well. Give yourself time to do this, learn from it, and grow more capability before you ramp up your number of services.

If you don't have these capabilities now, you should ensure you develop them so they are ready by the time you put a microservice system into production. Indeed these are capabilities that you really ought to have for monolithic systems too. While they aren't universally present across software organizations, there are very few places where they shouldn't be a high priority.

Going beyond a handful of services requires more. You'll need to trace business transactions through multiple services and automate your provisioning and deployment by fully embracing ContinuousDelivery. There's also the shift to product centered teams that needs to be started. You'll need to organize your development environment so developers can easily swap between multiple repositories, libraries, and languages. Some of my contacts are sensing that there could be a useful MaturityModel here that can help organizations as they take on more microservice implementations - we should see more conversation on that in the next few years.
