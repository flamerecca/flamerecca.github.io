## 手動測試

----
原文摘錄自 http://blog.codepipes.com/testing/software-testing-antipatterns.html#anti-pattern-8---running-tests-manually

歡迎到原本部落格閱讀原文，認為翻譯有問題也歡迎討論。

----

Depending on your organization you might actually have several types of tests in place. Unit tests, Load tests, User acceptance tests are common categories of test suites that might be executed before the code goes into production.

Ideally all your tests should run automatically without any human intervention. If that is not possible at the very least all tests that deal with correctness of code （例如單元和整合測試）must run in an automatic manner. This way developers get feedback on the code in the most timely manner. It is very easy to fix a feature when the code is fresh in your mind and you haven’t switched context yet to an unrelated feature.

Test feedback loop tests

In the past the most lengthy step of the software lifecycle was the deployment of the application. With the move into cloud infrastructure where machines can be created on demand (either in the form of VMs or containers) the time to provision a new machine has been reduced to minutes or seconds. This paradigm shift has caught a lot of companies by surprise as they were not ready to handle daily or even hourly deployments. Most of the existing practices were centered around lengthy release cycles. Waiting for a specific time in the release to “pass QA” with manual approval is one of those obsolete practices that is no longer applicable if a company wants to deploy as fast as possible.

Deploying as fast as possible implies that you trust each deployment. Trusting an automatic deployment requires a high degree of confidence in the code that gets deployed. While there are several ways of getting this confidence, the first line of defense should be your software tests. However, having a test suite that can catch regressions quickly is only half part of the equation. The other half is running the tests automatically (possibly after every commit).

A lot of companies think that they practice continuous delivery and/or deployment. In reality they don’t. Practicing true CI/CD means that at any given point in time there is a version of the code that is ready to be deployed. This means that the candidate release for deployment is already tested. Therefore having a package version of an application “ready” which has not really “passed QA” is not true CI/CD.

Unfortunately, while most companies have correctly realized that deployments should be automated, because using humans for them is error prone and slow, I still see companies where launching the tests is a semi-manual process. And when I say semi-manual I mean that even though the test suite itself might be automated, there are human tasks for house-keeping such as preparing the test environment or cleaning up the test data after the tests have finished. That is an anti-pattern because it is not true automation. All aspects of testing should be automated.

Automated tests

Having access to VMs or containers means that it is very easy to create various test environments on demand. Creating a test environment on the fly for an individual pull request should be a standard practice within your organization. This means that each new feature is tested individually on its own. A problematic feature (i.e. that causes tests to fail) should not block the release of the rest of the features that need to be deployed at the same time.

An easy way to understand the level of test automation within a company is to watch the QA/Test people in their daily job. In the ideal case, testers are just creating new tests that are added to an existing test suite. Testers themselves do not run tests manually. The test suite is run by the build server.

In summary, testing should be something that happens all the time behind the scenes by the build server. Developers should learn the result of the test for their individual feature after 5-15 minutes of committing code. Testers should create new tests and refactor existing ones, instead of actually running tests.
