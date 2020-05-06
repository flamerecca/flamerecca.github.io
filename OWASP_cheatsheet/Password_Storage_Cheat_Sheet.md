翻譯自 

https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/Password_Storage_Cheat_Sheet.md

----

# 簡介

因為多數使用者都會在不同的服務裡用相同的密碼，用即使服務本身或者資料庫被攻擊者破解，密碼也不會外流的方式儲存密碼，就變得非常重要。如同密碼學裡面的許多領域一樣，要做到這件事情需要考慮非常多的因素。幸運的是，多數現代的程式語言和框架都提供了內建的方式來儲存密碼，將複雜度減少了很多。

這份小抄提供了儲存密碼上，所需要考慮各個不同面向的指引。

簡而言之：

- **除非你有很好的理由，不然就用 [bcrypt](#現代演算法)**
- **設置一個合理的 [work factor](#work-factors)**
- **加 [salt](#salting)（現在演算法預設都會加上了）**
- **要更加安全，可以考慮加上 [pepper](#peppering)**

# 內容

- [背景](#背景)
  - [雜湊 vs 加密](#雜湊-vs-加密)
  - [攻擊者如何破解密碼雜湊](#攻擊者如何破解密碼雜湊)
- [雜湊概念](#雜湊概念)
  - [Salting](#salting)
  - [Peppering](#peppering)
    - [缺點](#缺點)
  - [Work Factors](#work-factors)
    - [升級 Work Factor](#升級-Work-Factor)
  - [最長密碼長度](#最長密碼長度)
    - [預先雜湊密碼](#預先雜湊密碼)
- [密碼雜湊演算法](#密碼雜湊演算法)
  - [現代演算法](#現代演算法)
    - [Argon2id](#argon2id)
    - [PBKDF2](#pbkdf2)
    - [Bcrypt](#bcrypt)
  - [古老的演算法](#古老的演算法)
  - [更新古老的雜湊](#更新古老的雜湊)
  - [自定義演算法](#自定義演算法)

# 背景

## 雜湊 vs 加密

雜湊和加密是常常被混淆或者誤用的兩個詞彙。這兩個詞彙關鍵的不同點是，雜湊是**單向**函數（或者說，不可能從雜湊「解密」出原本的值），而加密則是雙向函數。

幾乎所有的情況下，密碼都不應該被加密，而是應該被雜湊。因為，這樣攻擊者幾近不可能從雜湊後的結果逆推出原本的密碼。

只有在非常罕見的情況下，因為你必須保有原本的密碼，所以才必須使用加密的方式。

必須保有原本密碼的情況可能有：

- 如果該應用程式必須透過密碼，和不支援 SSO（single sign-on）的外部老舊系統進行溝通
- 必須要從密碼取出個別字母時

有可能解密出密碼是一件非常嚴重的資安風險，所以必須要全面評估過風險。如果可能的話，應該盡量選用其他架構，來避免將密碼以加密的形式進行儲存。

這份小抄主要針對密碼雜湊，對加密後的資料儲存可以參考[加密儲存資料的小抄](Cryptographic_Storage_Cheat_Sheet.md)。

## 攻擊者如何破解密碼雜湊

雖然攻擊者不能夠從雜湊之中「解密」出原本的密碼，在某些情況下還是可以「破解」這些雜湊的。基本做法是：

- 選可能的密碼（比方說「password」）
- 計算該密碼的雜湊
- 將計算後的雜湊與原本的雜湊比較看看是否相同

之後可以針對大量可能的密碼重複這幾個步驟，直到找出對應的雜湊。有很多方法可以找出可能的密碼，比方說：

- 暴力破解（嘗試所有的可能）
- 字典或常用密碼列表
- 從其他被破解網站取得的密碼列表
- 比較複雜的演算法，像是 [Markov chains](https://github.com/magnumripper/JohnTheRipper/blob/bleeding-jumbo/doc/MARKOV) 或 [PRINCE](https://github.com/hashcat/princeprocessor)
- 樣式或者遮罩（比方說「一個大寫字母，六個小寫字母，一個數字」）

破解的過程並不保證會成功，成功率取決於以下幾個因素：

- 密碼的強度
- 計算雜湊所需要花費的時間（或者現代演算法所說的 work factor）
- 被視為目標的密碼數量（假設每個密碼都有獨立的 salt）

用現代演算法雜湊過的強密碼，對攻擊者來說應該是實際上不可能破解的。

# 雜湊概念

## Salting

salting（加鹽）是在雜湊過程中，對每個密碼個別再加上一串唯一且隨機的字串。由於每個使用者的 salt 都是不同的，攻擊者破解密碼時，就不能只計算一次雜湊值，直接和所有的密碼雜湊比較，而是必須針對不同的 salt 個別計算出雜湊值並進行比較。這讓破解大量的密碼所要消耗的時間顯著的提升。

salt 也可以在攻擊者嘗試用 rainbow tables 或基於資料庫的內容預先計算出的雜湊列表進行攻擊時，提供多一層的保護。

最後，除非攻擊者破解其雜湊，salt 也可以避免兩個使用者使用相同密碼時被攻擊者發現。因為使用者所帶不同的 salt 可以保證其雜湊結果也不相同。

[現代的雜湊演算法](#現代演算法)像是 Argon2 或者 Bcrypt 會自動在密碼上加 salt，所以不需要再進行額外的處理。不過，如果是使用[古老的演算法](#古老的演算法)那麼就需要手動加上 salt。自己加上 salt 的流程有：

- 使用[密碼學上安全的函數](Cryptographic_Storage_Cheat_Sheet.md#secure-random-number-generation)產生 salt
  - salt 至少要 16 個字
  - 將 salt 轉譯成安全的字母集合，像是十六進位或者 base64
- 合併 salt 與密碼
  - 可以簡單的做字串連接，或者以 HMAC 之類的結構進行合併
- 對合併後結果進行雜湊
- 儲存雜湊後的結果

## Peppering

[pepper](https://en.wikipedia.org/wiki/Pepper_%28cryptography%29)（加胡椒）可以在 salt 以外多加上一層保護。pepper 和 salt 很像，不過有兩個關鍵的不同點：

- pepper 和 salt 不同，同一服務裡面的每個密碼都是一樣的 pepper
- pepper 和 salt 不同，**不會存在資料庫裡**。

pepper 的用意是保證如果攻擊者只拿到了資料庫的內容，那麼該攻擊者不可能破解任何的密碼。舉例來說，攻擊者可能是透過 SQL injection 的攻擊取得了資料庫的備份。

pepper 應該是隨機產生，並至少有 32 個字。pepper 要儲存在應用的設定檔內，以適當的檔案權限保護，使用作業系統提供的安全 API 進行存取或放在硬體安全模組（HSM）裡面。

傳統上 pepper 和 salt 一樣都是用字串連接的方式，在進行雜湊前和密碼組合在一起，像是 `hash($pepper . $password)` 的結構

另一種方法是將密碼用一般的方式算出雜湊值，然後用對稱式加密法加密該雜湊後，再儲存到資料庫內。該加密的金鑰就等同於 pepper 的效果。這種方式避免了傳統 pepper 的一些問題，並且讓汰換原本 pepper 的流程變得比較簡單。

### 缺點

pepper 主要的問題之一是長期維護上的困難。更換使用中的 pepper 會導致所有資料庫中的密碼失效，所以即使 pepper 被攻擊者取得了也很難簡單的更換掉。

其中一個解決方式是將 pepper 的 ID 和加密的密碼儲存在一起。當 pepper 更新時，使用新的 pepper 加密的密碼可以一併更新所儲存的 pepper ID。雖然這代表專案內需要儲存所有正在使用中的 pepper，不過這確實提供了當 pepper 不再安全時可以替換的方法。

## Work Factors

work factor 基本上是針對一個密碼，雜湊加密重複運作的次數（實際上通常會是 `2^work` 次）。work factor 的意義是讓計算雜湊更花時間，進而提高攻擊者破解的難度。work factor 通常會一併儲存在雜湊後的結果裡面。

調整 work factor 時，要在安全性和效能之間達成一個平衡。提高 work factor 會讓攻擊者更難以破解，但是也會讓驗證使用者更花時間。如果將 work factor 設置得太高，那麼可能會降低系統的效能，另外也可能變成被攻擊者利用，以大量的嘗試登入來消耗伺服器的 CPU 計算能力，達成拒絕服務（denial of service，DoS）攻擊。

針對 work factor 沒有絕對的準則，這會取決於使用者的數量以及伺服器的效能。通常需要在應用運作的伺服器上實驗看看才能決定 work factor 的大小。

一般來說，計算雜湊的時間應該要小於一秒。當然流量更高的網站計算的時間應該要比一秒左右更少。

### 升級 Work Factor

有 work factor 一個關鍵的好處，是可以隨著硬體越來越進步和便宜時一起提升運算時間。以摩爾定律（同樣價格下的計算效能每十八個月會翻倍）作為粗略的估計，這代表每十八個月 work factor 應該加一。

升級 work factor 最常見的做法是等到用戶下次登入，並用新的 work factor 計算雜湊。

The most common approach to upgrading the work factor is to wait until the user next authenticates, and then to re-hash their password with the new work factor. This means that different hashes will have different work factors, and may result in hashes never being upgraded if the user doesn't log back in to the application. Depending on the application, it may be appropriate to remove the older password hashes and require users to reset their passwords next time they need to login, in order to avoid storing older and less secure hashes.

有些狀況下，是可以在不取得原始密碼的狀況下直接升級 work factor 的。不過目前多數的雜湊演算法像是 Bcrypt 和 PBKDF2 都不支援這麼做。

## 最長密碼長度

Some hashing algorithms such as Bcrypt have a maximum length for the input, which is 72 characters for most implementations (there are some [reports](https://security.stackexchange.com/questions/39849/does-bcrypt-have-a-maximum-password-length) that other implementations have lower maximum lengths, but none have been identified at the time of writing). Where Bcrypt is used, a maximum length of 64 characters should be enforced on the input, as this provides a sufficiently high limit, while still allowing for string termination issues and not revealing that the application uses Bcrypt.

另外，由於現代演算法的計算比較消耗計算資源，如果允許用戶使用非常長的密碼，可能會有潛在的拒絕服務（denial of service，DoS）問題，比方說 2013 年[Django](https://www.djangoproject.com/weblog/2013/sep/15/security/)公布的弱點。

為了要避免上述的兩個問題，應該要限制密碼的最長長度。如果使用 Bcrypt 應該要設置為 64 個字（因為演算法本身以及其實作的限制），其他的演算法則設置為 64 到 128 個字之內。

### 預先雜湊密碼

An alternative approach is to pre-hash the user-supplied password with a fast algorithm such as SHA-256, and then to hash the resultant hash with a more secure algorithm such as Bcrypt (i.e, `bcrypt(sha256($password))`). While this approach solves the problem of arbitrary length user inputs to slower hashing algorithms, it also introduces some vulnerabilities that could allow attackers to crack hashes more easily.

If an attacker is able to obtain password hashes from two different sources, one of which is storing passwords with `bcrypt(sha256($password))` and the other of which is storing them as plain `sha256($password)`, and attacker can use uncracked SHA-256 hashes from the second site as candidate passwords to try and crack the hashes from the first (more secure) site. If passwords are re-used between the two sites, this can effectively allow the attacker to strip off the Bcrypt layer, and to crack the much easier SHA-256 passwords.

Pre-hashing with SHA-256 also means that the keyspace for an attacker to brute-force the hashes is `2^256`, rather than `2^420` for passwords capped at 64 characters (although both of these are big enough to make no practical difference).

Finally, when using pre-hashing ensure that the output for the first hashing algorithm is safely encoded as hexadecimal or base64, as some hashing algorithms such as Bcrypt can behave in undesirable ways if the [input contains null bytes](https://blog.ircmaxell.com/2015/03/security-issue-combining-bcrypt-with.html).

As such, the preferred option should generally be to limit the maximum password length. Pre-hashing of passwords should only be performed where there is a specific requirement to do so, and appropriate steps have been taking to mitigate the issues discussed above.

# 密碼雜湊演算法

## 現代演算法

現在已經有許多專門設計來安全儲存密碼的雜湊演算法。不像 MD5 和 SHA-1 這些演算法以快為設計目的，這些現代演算法設計上以耗時為設計目的，並且可以透過調整參數（[work factor](#work-factors)）來決定運算有多耗時。

下面列出三個主要應該考慮的演算法。

### Argon2id

[Argon2](https://en.wikipedia.org/wiki/Argon2) is the winner of the 2015 [密碼雜湊競賽](https://password-hashing.net). There are three different versions of the algorithm, and the Argon2**id** variant should be used where available, as it provides a balanced approach to resisting both side channel and GPU-based attacks.

Rather than a simple work factor like other algorithms, Argon2 has three different parameters that can be configured, meaning that it's more complicated to correctly tune for the environment. The specification contains [guidance on choosing appropriate parameters](https://password-hashing.net/argon2-specs.pdf), however, if you're not in a position to properly tune it, then a simpler algorithm such as [Bcrypt](#bcrypt) may be a better choice.

### PBKDF2

[PBKDF2](https://en.wikipedia.org/wiki/PBKDF2) is recommended by [NIST](https://pages.nist.gov/800-63-3/sp800-63b.html#memsecretver) and has FIPS-140 validated implementations. So, it should be the preferred algorithm when these are required. Additionally, it is supported out of the box in the .NET framework, so is commonly used in ASP.NET applications.

PBKDF2 can be used with HMACs based on a number of different hashing algorithms. HMAC-SHA-256 is widely supported and is recommended by NIST.

PBKDF2 的 work factor 代表的是雜湊運算的次數，至少必須設置到 10,000，如果在安全性要求更高的環境上應該設置到 100,000 更為合適。

### Bcrypt

[Bcrypt](https://en.wikipedia.org/wiki/Bcrypt) 是目前支援度最廣的演算法，並且應該是優先的選擇。除非有特殊的需求必須使用 PBKDF2，或者團隊有專門的知識可以調校 Argon2。

Bcrypt 預設的 work factor 是 10，除非系統老舊或者是低耗能系統，不然一般來說應該要提升到至少 12。

## 古老的演算法

In some circumstances it is not possible to use [modern hashing algorithms](#modern-algorithms), usually due to the use of legacy language or environments. Where possible, third party libraries should be used to provide these algorithms. However, if the only algorithms available are legacy ones such as MD5 and SHA-1, then there are a number of steps that can be taken to improve the security of stored passwords.

- Use the strongest algorithm available（SHA-512 > SHA-256 > SHA-1 > MD5）
- 加上 [pepper](#peppering).
- 密碼個別加上獨立的 [salt](#salting)。generated using a [密碼學上安全的亂數產生器 secure random number generator](Cryptographic_Storage_Cheat_Sheet.md#secure-random-number-generation).
- Use a very large number of iterations of the algorithm (at least 10,000, and possibly significantly more depending on the speed of the hardware).

It should be emphasised that these steps **are not as good as using a modern hashing algorithm**, and that this approach should only be taken where no other options are available.

## 更新古老的雜湊

For older applications that were built using less secure hashing algorithms such as MD5 or SHA-1, these hashes should be upgraded to more modern and secure ones. When the user next enters their password (usually by authenticating on the application), it should be re-hashed using the new algorithm. It would also be good practice to expire the users' current password and require them to enter a new one, so that any older (less secure) hashes of their password are no longer useful to an attacker.

However, this approach means that old (less secure) password hashes will be stored in the database until the user next logs in and may be stored indefinitely. There are two main approaches that can be taken to solve this.

One method is to expire and delete the password hashes of users who have been inactive for a long period, and require them to reset their passwords to login again. Although secure, this approach is not particularly user friendly, and expiring the passwords of a large number of users may cause issues for the support staff, or may be interpreted by users as an indication of a breach. However, if there is a reasonable delay between implementing the password hash upgrade code on login and removing old password hashes, most active users should have changed their passwords already.

An alternative approach is to use the existing password hashes as inputs for a more secure algorithm. For example if the application originally stored passwords as `md5($password)`, this could be easily upgraded to `bcrypt(md5($password))`. Layering the hashes in this manner avoids the need to known the original password, however it can make the hashes easier to crack, as discussed in the [Pre-Hashing](#pre-hashing) section. As such, these hashes should be replaced with direct hashes of the users' passwords next time the users login.

## 自定義演算法

撰寫自定義的密碼學相關程式，比方說雜湊演算法，是**非常難的**。因此**絕對不應該**在學術練習之外實際使用。

任何使用未知或者自己撰寫的雜湊演算法能帶來的潛在好處，跟可能帶有的弱點相比，是遠遠不能比較的。

**不要這麼做**
