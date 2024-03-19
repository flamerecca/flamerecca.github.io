## 手動測試

----
原文摘錄自 http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-8---running-tests-manually

歡迎到原本部落格閱讀原文，認為翻譯有問題也歡迎討論。

----

根據您的組織，您實際上可能會有幾種不同類型的測試。單元測試、負載測試、使用者接受測試是常見的測試套件類別，在程式碼投入生產之前可能會執行。

理想情況下，所有的測試都應該在沒有任何人工干預的情況下自動運行。如果這不可行，至少所有涉及程式碼正確性的測試（例如單元測試和集成測試）必須以自動方式運行。這樣開發人員可以及時獲得代碼的反饋。當程式碼還新鮮在您的腦海中，且尚未轉換到不相關的功能時，修復功能是非常容易的。

Test feedback loop tests

過去，軟體生命週期中最耗時的步驟是應用程式的部署。隨著轉向雲基礎架構，可以根據需求創建機器（以虛擬機器或容器的形式），新機器的配置時間已經被縮短到了幾分鐘或幾秒鐘。這種範式轉移使許多公司措手不及，因為他們還沒有準備好處理每天甚至每小時的部署。大多數現有的做法都圍繞著冗長的發布周期。等待特定時間在發布過程中進行「QA過關」並經過手動批准是一種已經過時的做法，如果一家公司想要盡快部署，這種做法就不再適用了。

盡快部署意味著您信任每次部署。信任自動部署需要對所部署的程式碼具有高度的信心。雖然有幾種方法可以獲得這種信心，但第一道防線應該是您的軟體測試。然而，擁有能夠快速捕捉回歸問題的測試套件僅僅是方程式的一半。另一半是自動運行測試（可能在每次提交後）。

許多公司認為他們正在實踐持續交付和/或部署。但實際上並非如此。真正實踐持續集成/持續交付意味著在任何給定的時間點，都存在一個準備好部署的程式碼版本。這意味著部署的候選版本已經經過了測試。因此，擁有一個應用程式的「就緒」套件版本，但實際上並未真正「通過QA」測試，這並不是真正的持續集成/持續交付。

不幸的是，雖然大多數公司已經正確地意識到部署應該是自動化的，因為使用人類進行部署容易出錯且速度較慢，但我仍然看到一些公司在啟動測試方面存在半手動的情況。當我說半手動時，我的意思是即使測試套件本身可能是自動化的，但仍然存在一些人類任務，如準備測試環境或在測試完成後清理測試數據。這是一種反模式，因為它並不是真正的自動化。測試的所有方面都應該是自動化的。

Automated tests

Having access to VMs or containers means that it is very easy to create various test environments on demand. Creating a test environment on the fly for an individual pull request should be a standard practice within your organization. This means that each new feature is tested individually on its own. A problematic feature (i.e. that causes tests to fail) should not block the release of the rest of the features that need to be deployed at the same time.

An easy way to understand the level of test automation within a company is to watch the QA/Test people in their daily job. In the ideal case, testers are just creating new tests that are added to an existing test suite. Testers themselves do not run tests manually. The test suite is run by the build server.

In summary, testing should be something that happens all the time behind the scenes by the build server. Developers should learn the result of the test for their individual feature after 5-15 minutes of committing code. Testers should create new tests and refactor existing ones, instead of actually running tests.
