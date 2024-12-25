翻譯自 

https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/Cryptographic_Storage_Cheat_Sheet.md

----

# 密碼儲存小抄

## 簡介

本文提供了一個簡單的模型，用於實施保護靜態數據解決方案時的遵循。

不應使用可逆加密來儲存密碼 - 應改用安全的密碼雜湊算法。[密碼儲存小抄](Password_Storage_Cheat_Sheet.md) 包含了有關儲存密碼的進一步指導。

## 內容

- [密碼儲存小抄](#密碼儲存小抄)
  * [簡介](#簡介)
  * [架構設計](#架構設計)
    + [加密應該在哪裡執行](#加密應該在哪裡執行)
    + [減少敏感信息的儲存](#減少敏感信息的儲存)
  * [演算法](#演算法)
    + [自訂演算法](#自訂演算法)
    + [加密模式](#加密模式)
    + [隨機填充](#隨機填充)
    + [安全隨機數生成](#安全隨機數生成)
      - [UUIDs 和 GUIDs](#UUIDs和GUIDs)
    + [防禦深度](#防禦深度)
  * [金鑰管理](#金鑰管理)
    + [流程](#流程)
    + [金鑰生成](#金鑰生成)
    + [金鑰壽命和輪換](#金鑰壽命和輪換)
  * [金鑰存儲](#金鑰存儲)
    + [金鑰和數據的分離](#金鑰和數據的分離)
    + [加密存儲的金鑰](#加密存儲的金鑰)

# 密碼儲存小抄

## 簡介

本文提供了一個簡單的模型，用於在實施解決方案以保護靜態數據時遵循。

密碼不應使用可逆加密進行儲存 - 應改用安全的密碼雜湊算法。[密碼儲存小抄](Password_Storage_Cheat_Sheet.md) 包含了有關儲存密碼的進一步指導。

## 架構設計

設計任何應用程序的第一步是考慮系統的整體架構，因為這將對技術實施產生巨大影響。

這個過程應該始於考慮應用程序的[威脅模型](Threat_Modeling_Cheat_Sheet.md)（即，您正試圖保護數據免受誰的威脅）。

使用專用的秘密或金鑰管理系統可以提供額外的安全保護層，同時使秘密的管理顯著變得更容易 - 但這將增加額外的複雜性和管理開銷 - 因此對於所有應用程序可能不可行。請注意，許多雲環境提供這些服務，因此應盡可能利用這些服務。[秘密管理小抄](Secrets_Management_Cheat_Sheet.md) 包含了有關此主題的進一步指導。

### 加密應該在哪裡執行

加密可以在應用程序堆棧的多個層級上執行，例如：

- 在應用程序層面。
- 在數據庫層面（例如，[SQL Server TDE](https://docs.microsoft.com/en-us/sql/relational-databases/security/encryption/transparent-data-encryption?view=sql-server-ver15)）
- 在文件系統層面（例如，BitLocker 或 LUKS）
- 在硬件層面（例如，加密的 RAID 卡或 SSD）

哪些層級最適合將取決於威脅模型。例如，硬件層面的加密對於保護服務器的物理盜竊非常有效，但如果攻擊者能夠遠程入侵服務器，則不提供任何保護。

### 減少敏感信息的儲存

保護敏感信息的最佳方法是根本不要儲存它。儘管這適用於所有類型的信息，但最常適用於信用卡詳細信息，因為它們對攻擊者非常有吸引力，並且 PCI DSS 對它們的儲存方式有非常嚴格的要求。在可能的情況下，應盡量避免儲存敏感信息。

## 演算法

對於對稱加密 **AES**，應該使用至少 **128 位元**（理想情況下為 **256 位元**）的金鑰和安全的[模式](#cipher-modes)作為首選演算法。

對於非對稱加密，應該使用橢圓曲線加密（ECC），並使用安全曲線如 **Curve25519** 作為首選演算法。如果 ECC 不可用且必須使用 **RSA**，則確保金鑰至少為 **2048 位元**。

還有許多其他對稱和非對稱演算法可供選擇，它們各自有優缺點，在特定用例中可能比 AES 或 Curve25519 更好或更差。在考慮這些演算法時，應考慮多個因素，包括：

- 金鑰大小。
- 演算法的已知攻擊和弱點。
- 演算法的成熟度。
- 第三方機構的批准，如[NIST 的演算法驗證計畫](https://csrc.nist.gov/projects/cryptographic-algorithm-validation-program)。
- 效能（加密和解密）。
- 可用的函式庫品質。
- 演算法的可移植性（即，它有多廣泛的支援）。

在某些情況下，可能會有法規要求限制可使用的演算法，例如[FIPS 140-2](https://csrc.nist.gov/csrc/media/publications/fips/140/2/final/documents/fips1402annexa.pdf)或[PCI DSS](https://www.pcisecuritystandards.org/pci_security/glossary#Strong%20Cryptography)。

### 自訂演算法

不要這樣做。

### 加密模式

有各種[模式](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation)可用於允許區塊加密（如 AES）加密任意量的資料，就像串流加密器一樣。這些模式具有不同的安全性和效能特性，對它們的全面討論超出了本速查表的範圍。一些模式有生成安全初始化向量（IV）和其他屬性的要求，但這些應該由函式庫自動處理。

在可用時，應始終使用驗證模式。這些提供了數據的完整性和真實性保證，以及機密性。最常用的驗證模式是 **[GCM](https://en.wikipedia.org/wiki/Galois/Counter_Mode)** 和 **[CCM](https://en.wikipedia.org/wiki/CCM_mode)**，應該作為首選。 

--- 

**原始連結:** [https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation)

如果GCM或CCM不可用，則應使用[CTR](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_%28CTR%29)模式或[CBC](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Cipher_Block_Chaining_%28CBC%29)模式。由於這些模式並未提供有關數據真實性的任何保證，因此應實施單獨的身份驗證，例如使用[Encrypt-then-MAC](https://en.wikipedia.org/wiki/Authenticated_encryption#Encrypt-then-MAC_%28EtM%29)技術。在使用此方法與[可變長度消息](https://en.wikipedia.org/wiki/CBC-MAC#Security_with_fixed_and_variable-length_messages)時需要注意。

在非常特定的情況下不應使用[ECB](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#ECB)。

### 隨機填充

對於RSA，啟用隨機填充是至關重要的。隨機填充也被稱為OAEP或最佳非對稱加密填充。這種防禦類型通過在有效負載的開頭添加隨機性來防範已知明文攻擊。

在這種情況下通常使用[PKCS#1](https://wikipedia.org/wiki/RSA_(cryptosystem)#Padding_schemes)的填充模式。

### 安全隨機數生成

隨機數（或字符串）在各種安全關鍵功能中都是必需的，例如生成加密金鑰、初始化向量、會話ID、CSRF令牌或重置密碼令牌。因此，重要的是要安全地生成這些數字，並且不可能讓攻擊者猜測和預測它們。

通常，計算機無法生成真正的隨機數（沒有特殊硬件），因此大多數系統和語言提供兩種不同類型的隨機性。

偽隨機數生成器（PRNG）提供低質量的隨機性，速度更快，可用於非安全相關功能（例如在頁面上排序結果或隨機化UI元素）。但是，它們**絕對不應**用於任何安全關鍵功能，因為攻擊者通常可以猜測或預測輸出。

加密安全的偽隨機數生成器（CSPRNG）旨在產生更高質量的隨機性（更嚴格地說，更多的熵量），使其在安全敏感功能中使用時更安全。然而，它們速度較慢且消耗更多 CPU 資源，在某些情況下可能會因為請求大量隨機數據而導致阻塞。因此，如果需要大量非安全相關的隨機性，則可能不適用。

下表顯示了每種語言的推薦算法，以及不應使用的不安全函數。

| 語言        | 不安全函數                                                                                                                         | 加密安全函數                                                                                                                                                                                                                                                                                                                                                               |
|-------------|------------------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| C           | `random()`, `rand()`                                                                                                               | [getrandom(2)](http://man7.org/linux/man-pages/man2/getrandom.2.html) |
| Java        | `Math.random()`, `StrictMath.random()`, `java.util.Random`, `java.util.SplittableRandom`, `java.util.concurrent.ThreadLocalRandom` | [java.security.SecureRandom](https://docs.oracle.com/javase/8/docs/api/java/security/SecureRandom.html), [java.util.UUID.randomUUID()](https://docs.oracle.com/javase/8/docs/api/java/util/UUID.html#randomUUID--) |
| PHP         | `array_rand()`, `lcg_value()`, `mt_rand()`, `rand()`, `uniqid()`                                                                   | [random_bytes()](https://www.php.net/manual/en/function.random-bytes.php), [Random\Engine\Secure](https://www.php.net/manual/en/class.random-engine-secure.php) in PHP 8, [random_int()](https://www.php.net/manual/en/function.random-int.php) in PHP 7, [openssl_random_pseudo_bytes()](https://www.php.net/manual/en/function.openssl-random-pseudo-bytes.php) in PHP 5 |
| .NET/C#     | `Random()`                                                                                                                         | [RandomNumberGenerator](https://learn.microsoft.com/en-us/dotnet/api/system.security.cryptography.randomnumbergenerator?view=net-6.0) |
| Objective-C | `arc4random()`/`arc4random_uniform()`（使用 RC4 Cipher）、`GKRandomSource` 的子類、rand()、random()                           | [SecRandomCopyBytes](https://developer.apple.com/documentation/security/1399291-secrandomcopybytes?language=objc) |
| Python      | `random()`                                                                                                                         | [secrets()](https://docs.python.org/3/library/secrets.html#module-secrets) |
| Ruby        | `rand()`, `Random`                                                                                                                 | [SecureRandom](https://ruby-doc.org/stdlib-2.5.1/libdoc/securerandom/rdoc/SecureRandom.html) |
| Go          | 使用 `math/rand` 套件的 `rand`                                                                                                     | [crypto.rand](https://golang.org/pkg/crypto/rand/) 套件 |
| Rust        | `rand::prng::XorShiftRng`                                                                                                          | [rand::prng::chacha::ChaChaRng](https://docs.rs/rand/0.5.0/rand/prng/chacha/struct.ChaChaRng.html) 和 Rust 函式庫的其他部分 [CSPRNGs.](https://docs.rs/rand/0.5.0/rand/prng/index.html#cryptographically-secure-pseudo-random-number-generators-csprngs) |
| Node.js     | `Math.random()`                                                                                                                    | [crypto.randomBytes()](https://nodejs.org/api/crypto.html#cryptorandombytessize-callback), [crypto.randomInt()](https://nodejs.org/api/crypto.html#cryptorandomintmin-max-callback), [crypto.randomUUID()](https://nodejs.org/api/crypto.html#cryptorandomuuidoptions) |

#### UUIDs和GUIDs

通用唯一識別碼（UUIDs 或 GUIDs）有時被用作快速生成隨機字串的方法。儘管它們可以提供合理的隨機性來源，但這將取決於創建的 UUID 的[類型或版本](https://en.wikipedia.org/wiki/Universally_unique_identifier#Versions)。

具體來說，版本 1 的 UUID 由高精度時間戳和生成它們系統的 MAC 地址組成，因此**不是隨機的**（儘管可能難以猜測，因為時間戳是最接近 100 納秒）。類型 4 的 UUID 是隨機生成的，儘管是否使用 CSPRNG 進行生成取決於實現。除非在特定語言或框架中已知這是安全的，否則不應依賴 UUID 的隨機性。

### 防禦深度

應用程序應設計為即使加密控制失敗仍然安全。以加密形式存儲的任何信息也應受到額外的安全層保護。應用程序還不應依賴於加密 URL 參數的安全性，應強制執行強大的訪問控制以防止未經授權訪問信息。

## 金鑰管理

### 流程

應實施（並測試）正式流程，以涵蓋金鑰管理的所有方面，包括：

- 生成並存儲新金鑰。
- 將金鑰分發給所需方。
- 部署金鑰到應用程序伺服器。
- 輪換和停用舊金鑰

### 金鑰生成

應使用加密安全函數隨機生成金鑰，例如在[安全隨機數生成](#secure-random-number-generation)部分討論的那些。金鑰**不應**基於常見詞語或短語，也不應基於通過亂按鍵盤生成的“隨機”字符。

如果使用多個金鑰（例如數據分離的數據加密和金鑰加密金鑰），它們應完全獨立於彼此。

### 金鑰壽命和輪換

根據多種不同標準，應更改（或輪換）加密金鑰：

- 如果先前的金鑰已知（或懷疑）已被破壞。
    - 這也可能是由於某人擁有金鑰並離開組織所導致的。
- 在特定時間段（稱為密碼週期）過後。
    - 有許多因素可能會影響適當的密碼週期，包括金鑰的大小、數據的敏感性以及系統的威脅模型。有關進一步指引，請參見[NIST SP 800-57](https://nvlpubs.nist.gov/nistpubs/SpecialPublications/NIST.SP.800-57pt1r4.pdf)第5.3節。
- 在金鑰被用於加密特定量的數據後。
    - 對於64位元金鑰，這通常是`2^35`位元組（約34GB），對於128位元區塊大小，這是`2^68`位元組（約295艾字節）。
- 如果演算法提供的安全性發生重大變化（例如宣布了新的攻擊）。

一旦滿足這些標準之一，應生成新金鑰並用於加密任何新數據。有兩種主要方法來處理使用舊金鑰加密的現有數據：

1. 解密並使用新金鑰重新加密。
2. 將每個項目標記為用於加密的金鑰的ID，並存儲多個金鑰以允許解密舊數據。

通常應首選第一個選項，因為它極大地簡化了應用程式代碼和金鑰管理流程；但是，這可能並非總是可行的。請注意，舊金鑰通常應在退役後存儲一段時間，以防需要解密舊備份或數據副本。

重要的是，在需要之前就擁有旋轉金鑰所需的程式碼和流程，以便在金鑰受到破壞時能夠快速旋轉金鑰。此外，還應實施流程，允許更改加密演算法或庫，以防發現演算法或實現中的新漏洞。

## 金鑰存儲

安全地存儲加密金鑰是最難解決的問題之一，因為應用程式始終需要某種程度的訪問權限才能解密數據。儘管無法完全保護金鑰免受完全破壞應用程式的攻擊者，但可以採取一些步驟使其更難獲取金鑰。

在可用的情況下，應使用操作系統、框架或雲服務提供商提供的安全存儲機制。這些包括：

- 物理硬體安全模組（HSM）。
- 虛擬 HSM。
- 金鑰保險庫，如 [Amazon KMS](https://aws.amazon.com/kms/) 或 [Azure Key Vault](https://azure.microsoft.com/en-gb/services/key-vault/)。
- 外部密碼管理服務，如 [Conjur](https://github.com/cyberark/conjur) 或 [HashiCorp Vault](https://github.com/hashicorp/vault)。
- .NET 框架中 [ProtectedData](https://docs.microsoft.com/en-us/dotnet/api/system.security.cryptography.protecteddata?redirectedfrom=MSDN&view=netframework-4.8) 類提供的安全存儲 API。

使用這些安全存儲類型相較於簡單將金鑰放在配置文件中有許多優勢。具體優勢將取決於所使用的解決方案，但它們包括：

- 集中管理金鑰，特別是在容器化環境中。
- 輕鬆進行金鑰輪換和替換。
- 安全金鑰生成。
- 簡化符合 FIPS 140 或 PCI DSS 等監管標準。
- 使攻擊者更難導出或竊取金鑰。

在某些情況下，這些選項可能都不可用，例如在共享主機環境中，這意味著無法為任何加密金鑰獲得高度保護。但是，仍然可以遵循以下基本規則：

- 不要將金鑰硬編碼到應用程式源代碼中。
- 不要將金鑰提交到版本控制系統中。
- 使用限制性權限保護包含金鑰的配置文件。
- 避免將金鑰存儲在環境變數中，因為這些可能會通過 [phpinfo()](https://www.php.net/manual/en/function.phpinfo.php) 等函數或通過 `/proc/self/environ` 文件意外暴露。

[Secrets Management Cheat Sheet](Secrets_Management_Cheat_Sheet.md) 提供了有關安全存儲密碼的更多詳細信息。

### 金鑰和數據的分離

在可能的情況下，應將加密金鑰存儲在與加密數據不同的位置。例如，如果數據存儲在數據庫中，則金鑰應存儲在文件系統中。這意味著如果攻擊者僅能訪問其中一個（例如通過目錄遍歷或 SQL 注入），則無法同時訪問金鑰和數據。

根據環境的架構，可能可以將金鑰和資料存儲在不同系統上，這將提供更高程度的隔離。

### 加密存儲的金鑰

在可能的情況下，加密金鑰本身應該以加密形式存儲。為此至少需要兩個獨立的金鑰：

- 數據加密金鑰（DEK）用於加密數據。
- 金鑰加密金鑰（KEK）用於加密DEK。

為了使其有效，KEK必須與DEK分開存儲。加密的DEK可以與數據一起存儲，但只有在攻擊者能夠獲得也存儲在另一個系統上的KEK時才能使用。

KEK的強度也應至少與DEK一樣強。Google的[信封加密](https://cloud.google.com/kms/docs/envelope-encryption)指南包含有關如何管理DEK和KEK的進一步細節。

在更簡單的應用架構（例如共享主機環境）中，KEK和DEK無法分開存儲，這種方法的價值有限，因為攻擊者可能會同時獲得兩個金鑰。但是，對於技能不足的攻擊者來說，這可以提供額外的障礙。

可以使用金鑰派生函數（KDF）從用戶提供的輸入（例如密碼）生成KEK，然後用於加密隨機生成的DEK。這允許輕鬆更改KEK（當用戶更改其密碼時），而無需重新加密數據（因為DEK保持不變）。
