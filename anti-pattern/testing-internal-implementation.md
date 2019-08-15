
# 測試內部實作

測試總是越多越好，對嗎？

錯！你需要確定測試的結構是正確的。測試結構錯誤有兩個壞處：

浪費開發時間

* They waste precious development time the first time they are written
* They waste even more time when they need to be refactored (when a new feature is added)

嚴格來說，測試程式碼和其他的程式碼一樣。為了逐步改善它你總會在某個時間點進行重構。但是，如果你發現自己總是
Strictly speaking, test code is like any other type of code. You will need to refactor it at some point in order to improve it in a gradual way. But if you find yourself routinely changing existing tests just to make them pass when a new feature is added then your tests are not testing what they should be testing.

I have seen several companies that started new projects and thinking that they will get it right this time, they started writing a big number of tests to cover the functionality of the application. After a while, a new feature got added and several existing tests needed to change in order to make them pass again. Then another new feature was added and more tests needed to be updated. Soon the amount of effort spent refactoring/fixing the existing tests was actually larger than the time needed to implement the feature itself.

In such situations, several developers just accept defeat. They declare software tests a waste of time and abandon completely the existing test suite in order to focus fully on new features. In some extreme scenarios some changes might even be held back because of the amount of tests that break.

The problem here is of course the bad quality of tests. Tests that need to be refactored all the time suffer from tight coupling with the main code. Unfortunately, you need some basic testing experience to understand which tests are written in this “wrong” way.

Having to change a big number of existing tests when a new feature is introduced shows the symptom. The actual problem is that tests were instructed to verify internal implementation which is always a recipe for disaster. There are several software testing resources online that attempt to explain this concept, but very few of them show some solid examples.

I promised in the beginning of this article that I will not speak about a particular programming language and I intend to keep that promise. In this section the illustrations show the data structure of your favorite programming language. Think of them as structs/objects/classes that contain fields/values.

Let’s say that the customer object in an e-shop application is the following:

Tight coupling of tests

The customer type has only two values where 0 means “guest user” and 1 means “registered user”. Developers look at the object and write 10 unit tests that verify various cases of guests users and 10 cases of registered user. And when I say “verify” I mean that tests are looking at this particular field in this particular object.

Time passes by and business decides that a new customer type with value 2 is needed for affiliates. Developers add 10 more tests that deal with affiliates. Finally another type of user called “premium customer” is added and developers add 10 more tests.

At this point, we have 40 tests in 4 categories that all look at this particular field. (These numbers are imaginary. This contrived example exists only for demonstration purposes. In a real project you might have 10 interconnected fields within 6 nested objects and 200 tests).

Tight coupling of tests example

If you are a seasoned developer you can always imagine what happens next. New requirements come that say:

For registered users, their email should also be stored
For affiliate users, their company should also be stored
Premium users can now gather reward points.
The customer object now changes as below:

Tight coupling of tests broken

You now have 4 objects connected with foreign keys and all 40 tests are instantly broken because the field they were checking no longer exists.

Of course in this trivial example one could simply keep the existing field to not break backwards compatibility with tests. In a real application this is not always possible. Sometimes backwards compatibility might essentially mean that you need to keep both old and new code (before/after the new feature) resulting in a huge bloat. Also notice that having to keep old code around just to make unit tests pass is a huge anti-pattern on its own.

In a real application when this happens, developers ask from management some extra time to fix the tests. Project managers then declare that unit testing is a waste of time because they seem to hinder new features. The whole team then abandons the test suite by quickly disabling the failing tests.

The big problem here is not testing, but instead the way the tests were constructed. Instead of testing internal implementation they should instead expected behavior. In our simple example instead of testing directly the internal structure of the customer they should instead check the exact business requirement of each case. Here is how these same tests should be handled instead.

Tests that test behavior

The tests do not really care about the internal structure of the customer object. They only care about its interactions with other objects/methods/functions. The other objects/method/functions should be mocked when needed on a case to case basis. Notice that each type of tests directly maps to a business need rather than a technical implementation (which is always a good practice.)

If the internal implementation of the Customer object changes, the verification code of the tests remains the same. The only thing that might change is the setup code for each test, which should be centralized in a single helper function called createSampleCustomer() or something similar (more on this in AntiPattern 9)

Of course in theory it is possible for the verified objects themselves to change. In practice it is not realistic for changes to happen at loginAsGuest() and register() and showAffiliateSales() and getPremiumDiscount() at the same time. In a realistic scenario you would have to refactor 10 tests instead of 40.

In summary, if you find yourself continuously fixing existing tests as you add new features, it means that your tests are tightly coupled to internal implementation.
