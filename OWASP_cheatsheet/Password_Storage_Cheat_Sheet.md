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

salt（加鹽）是在雜湊過程中，對每個密碼個別再加上一串唯一且隨機的字串。由於每個使用者的 salt 都是不同的，攻擊者破解密碼時，就不能只計算一次雜湊值，直接和所有的密碼雜湊比較，而是必須針對不同的 salt 個別計算出雜湊值並進行比較。這讓破解大量的密碼所要消耗的時間顯著的提升。



Salting also provides protection against an attacker pre-computing hashes using rainbow tables or database-based lookups. 

最後，salt 也可以避免兩個使用者使用相同密碼時被攻擊者發現，除非攻擊者破解其雜湊。因為使用者所帶不同的 salt 可以保證其雜湊結果也不相同。

[現代的雜湊演算法](#現代演算法)像是 Argon2 或者 Bcrypt 會自動在密碼上加 salt，所以不需要再進行額外的處理。However, if you are using a [legacy password hashing algorithm](#legacy-algorithms) then salting needs to be implemented manually. The basic steps to perform this are:

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

pepper 應該是隨機產生，並至少有 32 個字。

The pepper should be at least 32 characters long and should be randomly generated. It should be stored in an application configuration file (protected with appropriate permissions) using the secure storage APIs provided by the operating system, or in a Hardware Security Module (HSM).

The pepper is traditionally used in a similar way to a salt by concatenating it with the password prior to hashing, using a construct such as `hash($pepper . $password)`.

另一種方法是將密碼用一般的方式算出雜湊值，然後用對稱式加密法加密該雜湊後，再儲存到資料庫內。該加密的金鑰就等同於 pepper 的效果。這種方式避免了傳統 pepper 的一些問題，並且讓汰換原本 pepper 的流程變得比較簡單。

### 缺點

pepper 主要的問題之一是長期維護上的困難。更換使用中的 pepper 會導致所有資料庫中的密碼失效，所以即使 pepper 被攻擊者取得了也很難簡單的更換掉。

One solution to this is to store the ID of the pepper in the database alongside the associated password hashes. When the pepper needs to be updated, this ID can updated for hashes using the new pepper. Although the application will need to store all of the peppers that are currently in use, this does provide a way to replace a compromised pepper.

## Work Factors

The work factor is essentially the number of iterations of the hashing algorithm that are performed for each password (usually it's actually `2^work` iterations). The purpose of the work factor is to make calculating the hash more computationally expensive, which in turn reduces the speed at which an attacker can attempt to crack the password hash. The work factor is typically stored in the hash output.

When choosing a work factor, a balance needs to be struck between security and performance. Higher work factors will make the hashes more difficult for an attacker to crack, but will also make the process of verifying a login attempt slower. If the work factor is too high, this may degrade the performance of the application, and could also be used by an attacker to carry out a denial of service attack by making a large number of login attempts to exhaust the server's CPU.

There is no golden rule for the ideal work factor - it will depend on the performance of the server and the number of users on the application. Determining the optimal work factor will require experimentation on the specific server(s) used by the application. As a general rule, calculating a hash should take less than one second, although on higher traffic sites it should be significantly less than this.

### 升級 Work Factor

One key advantage of having a work factor is that it can be increased over time as hardware becomes more powerful and cheaper. Taking Moore's Law (i.e, that computational power at a given price point doubles every eighteen months) as a rough approximation, this means that the work factor should be increased by 1 every eighteen months.

The most common approach to upgrading the work factor is to wait until the user next authenticates, and then to re-hash their password with the new work factor. This means that different hashes will have different work factors, and may result in hashes never being upgraded if the user doesn't log back in to the application. Depending on the application, it may be appropriate to remove the older password hashes and require users to reset their passwords next time they need to login, in order to avoid storing older and less secure hashes.

有些狀況下，是可以在不取得原始密碼的狀況下直接升級 work factor 的。不過目前多數的雜湊演算法像是 Bcrypt 和 PBKDF2 都不支援這麼做。

## 最長密碼長度

Some hashing algorithms such as Bcrypt have a maximum length for the input, which is 72 characters for most implementations (there are some [reports](https://security.stackexchange.com/questions/39849/does-bcrypt-have-a-maximum-password-length) that other implementations have lower maximum lengths, but none have been identified at the time of writing). Where Bcrypt is used, a maximum length of 64 characters should be enforced on the input, as this provides a sufficiently high limit, while still allowing for string termination issues and not revealing that the application uses Bcrypt.

Additionally, due to how computationally expensive modern hashing functions are, if a user can supply very long passwords then there is a potential denial of service vulnerability, such as the one published in [Django](https://www.djangoproject.com/weblog/2013/sep/15/security/) in 2013.

In order to protect against both of these issues, a maximum password length should be enforced. This should be 64 characters for Bcrypt (due to limitations in the algorithm and implementations), and between 64 and 128 characters for other algorithms.

### 預先雜湊密碼

An alternative approach is to pre-hash the user-supplied password with a fast algorithm such as SHA-256, and then to hash the resultant hash with a more secure algorithm such as Bcrypt (i.e, `bcrypt(sha256($password))`). While this approach solves the problem of arbitrary length user inputs to slower hashing algorithms, it also introduces some vulnerabilities that could allow attackers to crack hashes more easily.

If an attacker is able to obtain password hashes from two different sources, one of which is storing passwords with `bcrypt(sha256($password))` and the other of which is storing them as plain `sha256($password)`, and attacker can use uncracked SHA-256 hashes from the second site as candidate passwords to try and crack the hashes from the first (more secure) site. If passwords are re-used between the two sites, this can effectively allow the attacker to strip off the Bcrypt layer, and to crack the much easier SHA-256 passwords.

Pre-hashing with SHA-256 also means that the keyspace for an attacker to brute-force the hashes is `2^256`, rather than `2^420` for passwords capped at 64 characters (although both of these are big enough to make no practical difference).

Finally, when using pre-hashing ensure that the output for the first hashing algorithm is safely encoded as hexadecimal or base64, as some hashing algorithms such as Bcrypt can behave in undesirable ways if the [input contains null bytes](https://blog.ircmaxell.com/2015/03/security-issue-combining-bcrypt-with.html).

As such, the preferred option should generally be to limit the maximum password length. Pre-hashing of passwords should only be performed where there is a specific requirement to do so, and appropriate steps have been taking to mitigate the issues discussed above.

# 密碼雜湊演算法

## 現代演算法

There are a number of modern hashing algorithms that have been specifically designed for securely storing passwords. This means that they should be slow (unlike algorithms such as MD5 and SHA-1 which were designed to be fast), and how slow they are can be configured by changing the [work factor](#work-factors).

The main three algorithms that should be considered as listed below.

### Argon2id

[Argon2](https://en.wikipedia.org/wiki/Argon2) is the winner of the 2015 [Password Hashing Competition](https://password-hashing.net). There are three different versions of the algorithm, and the Argon2**id** variant should be used where available, as it provides a balanced approach to resisting both side channel and GPU-based attacks.

Rather than a simple work factor like other algorithms, Argon2 has three different parameters that can be configured, meaning that it's more complicated to correctly tune for the environment. The specification contains [guidance on choosing appropriate parameters](https://password-hashing.net/argon2-specs.pdf), however, if you're not in a position to properly tune it, then a simpler algorithm such as [Bcrypt](#bcrypt) may be a better choice.

### PBKDF2

[PBKDF2](https://en.wikipedia.org/wiki/PBKDF2) is recommended by [NIST](https://pages.nist.gov/800-63-3/sp800-63b.html#memsecretver) and has FIPS-140 validated implementations. So, it should be the preferred algorithm when these are required. Additionally, it is supported out of the box in the .NET framework, so is commonly used in ASP.NET applications.

PBKDF2 can be used with HMACs based on a number of different hashing algorithms. HMAC-SHA-256 is widely supported and is recommended by NIST.

The work factor for PBKDF2 is implemented through the iteration count, which should be at least 10,000 (although values of up to 100,000 may be appropriate in higher security environments).

### Bcrypt

[Bcrypt](https://en.wikipedia.org/wiki/Bcrypt) 是目前支援度最廣的演算法，並且應該是優先的選擇。除非有特殊的需求必須使用 PBKDF2，或者團隊有專門的知識可以調校 Argon2。

Bcrypt 預設的 work factor 是 10，除非系統老舊或者是低耗能系統，不然一般來說應該要提升到至少 12。

## 古老的演算法

In some circumstances it is not possible to use [modern hashing algorithms](#modern-algorithms), usually due to the use of legacy language or environments. Where possible, third party libraries should be used to provide these algorithms. However, if the only algorithms available are legacy ones such as MD5 and SHA-1, then there are a number of steps that can be taken to improve the security of stored passwords.

- Use the strongest algorithm available (SHA-512 > SHA-256 > SHA-1 > MD5).
- Use a [pepper](#peppering).
- Use a unique [salt](#salting) for each password, generated using a [cryptographically secure random number generator](Cryptographic_Storage_Cheat_Sheet.md#secure-random-number-generation).
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
