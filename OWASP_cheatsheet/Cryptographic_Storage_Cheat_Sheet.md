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
  * [內容](#內容)
  * [架構設計](#架構設計)
    + [加密應該在哪裡執行](#加密應該在哪裡執行)
    + [減少敏感信息的儲存](#減少敏感信息的儲存)
  * [演算法](#演算法)
    + [自定義演算法](#自定義演算法)
    + [加密模式](#加密模式)
    + [隨機填充](#隨機填充)
    + [安全隨機數生成](#安全隨機數生成)
      - [UUIDs 和 GUIDs](#UUIDs 和 GUIDs)
    + [防禦深度](#防禦深度)
  * [金鑰管理](#金鑰管理)
    + [流程](#流程)
    + [金鑰生成](#金鑰生成)
    + [金鑰壽命和輪換](#金鑰壽命和輪換)
  * [金鑰存儲](#金鑰存儲)
    + [金鑰和數據的分離](#金鑰和數據的分離)
    + [加密存儲的金鑰](#加密存儲的金鑰)

## 架構設計

設計任何應用程序的第一步是考慮系統的整體架構，因為這將對技術實施產生巨大影響。

這個過程應該從考慮應用程序的[威脅模型](Threat_Modeling_Cheat_Sheet.md) 開始（即，您正在試圖保護哪些數據）。

使用專用的秘密或金鑰管理系統可以提供額外的安全保護層，同時使秘密管理顯著變得更容易 - 但這將增加額外的複雜性和管理開銷 - 因此可能對所有應用程序都不可行。請注意，許多雲環境提供這些服務，因此應該在可能的情況下加以利用。[秘密管理小抄](Secrets_Management_Cheat_Sheet.md) 包含了有關此主題的進一步指導。

### 執行加密的位置

Encryption can be performed on a number of levels in the application stack, such as:

- 在應用層進行加密
- 在資料庫層進行加密（比方說 [SQL Server TDE](https://docs.microsoft.com/en-us/sql/relational-databases/security/encryption/transparent-data-encryption?view=sql-server-ver15)）
- 在資料系統層進行加密（比方說 BitLocker 或 LUKS）
- 在硬體層進行加密（比方說加密後的 RAID cards 或 SSD）

Which layer(s) are most appropriate will depend on the threat model. For example, hardware level encryption is effective at protecting against the physical theft of the server, but will provide no protection if an attacker is able to compromise the server remotely.

### 減少敏感信息的儲存

保護敏感資料的最好方法，是一開始就不儲存任何敏感資料。這個說法適用任何的敏感資料，不過一般來說，最適用的狀況是針對信用卡詳細資料，因為攻擊者非常想要這類資料，並且支付卡產業資料安全標準（PCI DSS）針對這類資料的儲存規範非常嚴格。如果可能的話，一開始就避免儲存任何的敏感資料。

## 演算法

對於對稱加密 **AES**，應使用至少 **128 位元**（理想情況下為 **256 位元**）的金鑰和安全的[模式](#cipher-modes)作為首選演算法。

對於非對稱加密，應使用橢圓曲線加密（ECC），並使用安全曲線，如 **Curve25519** 作為首選演算法。如果 ECC 不可用且必須使用 **RSA**，則確保金鑰至少為 **2048 位元**。

還有許多其他對稱和非對稱演算法可供選擇，它們各自有優缺點，可能在特定用例中比 AES 或 Curve25519 更好或更差。在考慮這些時，應考慮多個因素，包括：

- 金鑰大小。
- 演算法的已知攻擊和弱點。
- 演算法的成熟度。
- 第三方的批准，如[NIST 的演算法驗證計畫](https://csrc.nist.gov/projects/cryptographic-algorithm-validation-program)。
- 效能（加密和解密）。
- 可用的函式庫品質。
- 演算法的可移植性（即，它有多廣泛的支援）。

在某些情況下，可能會有法規要求限制可使用的演算法，例如[FIPS 140-2](https://csrc.nist.gov/csrc/media/publications/fips/140/2/final/documents/fips1402annexa.pdf)或[PCI DSS](https://www.pcisecuritystandards.org/pci_security/glossary#Strong%20Cryptography)。

### 自定義演算法

不要這麼做

### 加密模式

有各種[模式](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation)可用於允許區塊加密（如 AES）加密任意量的資料，就像串流加密器一樣。這些模式具有不同的安全性和效能特性，對它們的全面討論超出了此速查表的範圍。一些模式有生成安全初始化向量（IV）和其他屬性的要求，但這些應由函式庫自動處理。

在可用時，應始終使用驗證模式。這些提供了數據的完整性和真實性的保證，以及機密性。最常用的驗證模式是 **[GCM](https://en.wikipedia.org/wiki/Galois/Counter_Mode)** 和 **[CCM](https://en.wikipedia.org/wiki/CCM_mode)**，應作為首選。 

如果 GCM 或 CCM 不可用，則應使用 [CTR](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_%28CTR%29) 模式或 [CBC](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Cipher_Block_Chaining_%28CBC%29) 模式。由於這些模式不提供有關數據真實性的任何保證，因此應實施獨立的認證，例如使用 [Encrypt-then-MAC](https://en.wikipedia.org/wiki/Authenticated_encryption#Encrypt-then-MAC_%28EtM%29) 技術。在使用此方法與 [可變長度訊息](https://en.wikipedia.org/wiki/CBC-MAC#Security_with_fixed_and_variable-length_messages) 時需要小心。

除了非常特定的情況下，不應使用 [ECB](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#ECB)。

### 隨機填充

對於 RSA，啟用隨機填充是至關重要的。隨機填充也被稱為 OAEP 或最佳非對稱加密填充。這種防禦類型通過在有效負載的開頭添加隨機性來防範已知明文攻擊。

在這種情況下通常使用 [PKCS#1](https://wikipedia.org/wiki/RSA_(cryptosystem)#Padding_schemes) 的填充模式。

### 安全的亂數生成器

隨機數（或字串）在各種安全關鍵功能中都是必需的，例如生成加密金鑰、初始化向量、會話 ID、CSRF 標記或重設密碼標記。因此，重要的是這些數據是安全生成的，並且攻擊者無法猜測和預測它們。

通常，計算機無法生成真正的隨機數（沒有特殊硬體），因此大多數系統和語言提供兩種不同類型的隨機性。

偽隨機數生成器（PRNG）提供低質量的隨機性，速度更快，可用於非安全相關功能（例如在頁面上排序結果或隨機化 UI 元素）。但是，**絕對不應**將其用於任何安全關鍵功能，因為攻擊者通常可以猜測或預測輸出。

加密安全偽隨機數生成器（CSPRNG）旨在產生更高質量的隨機性（更嚴格地說，更多的熵量），使其可以安全用於安全敏感功能。然而，它們速度較慢且消耗 CPU 較多，在某些情況下可能會因請求大量隨機數據而導致阻塞。因此，如果需要大量與安全性無關的隨機性，則可能不適用。

下表顯示了每種語言的推薦算法，以及不應使用的不安全函數。

| 程式語言 | 不安全的函式 | 密碼學上安全的函式 |
|----------|------------------|------------------------------------|
| C        | `random()`, `rand()` | [getrandom(2)](http://man7.org/linux/man-pages/man2/getrandom.2.html) |
| Java     | `java.util.Random()` | [java.security.SecureRandom](https://docs.oracle.com/javase/8/docs/api/java/security/SecureRandom.html) |
| PHP      | `rand()`, `mt_rand()`, `array_rand()`, `uniqid()` | [random_bytes()](https://www.php.net/manual/en/function.random-bytes.php), [random_int()](https://www.php.net/manual/en/function.random-int.php) in PHP 7 or [openssl_random_pseudo_bytes()](https://www.php.net/manual/en/function.openssl-random-pseudo-bytes.php) in PHP 5 |
| .NET/C#  | `Random()`, | [RNGCryptoServiceProvider](https://docs.microsoft.com/en-us/dotnet/api/system.security.cryptography.rngcryptoserviceprovider?view=netframework-4.8) |
| Objective-C | `arc4random()` (Uses RC4 Cipher), | [SecRandomCopyBytes](https://developer.apple.com/documentation/security/1399291-secrandomcopybytes?language=objc) |
| Python   | `random()`, | [secrets()](https://docs.python.org/3/library/secrets.html#module-secrets) |
| Ruby     | `Random`, | [SecureRandom](https://ruby-doc.org/stdlib-2.5.1/libdoc/securerandom/rdoc/SecureRandom.html) |
| Go       | `rand` using `math/rand` package, | [crypto.rand](https://golang.org/pkg/crypto/rand/) package |
| Rust     | `rand::prng::XorShiftRng`, | [rand::prng::chacha::ChaChaRng](https://docs.rs/rand/0.5.0/rand/prng/chacha/struct.ChaChaRng.html) and the rest of the Rust library [CSPRNGs.](https://docs.rs/rand/0.5.0/rand/prng/index.html#cryptographically-secure-pseudo-random-number-generators-csprngs) |

#### UUIDs 和 GUIDs

通用唯一識別碼（UUIDs 或 GUIDs）有時被用作快速生成隨機字串的方法。儘管它們可以提供合理的隨機性來源，但這將取決於創建的 UUID 的[類型或版本](https://en.wikipedia.org/wiki/Universally_unique_identifier#Versions)。

具體來說，版本 1 的 UUID 由高精度時間戳和生成它們的系統的 MAC 地址組成，因此**不是隨機的**（儘管可能很難猜測，因為時間戳是到最接近 100 納秒）。類型 4 的 UUID 是隨機生成的，儘管是否使用 CSPRNG 進行生成取決於實現。除非在特定語言或框架中已知這是安全的，否則不應依賴 UUID 的隨機性。

### 防禦深度

應設計應用程序，即使加密控制失敗，仍然保持安全。以加密形式存儲的任何信息也應受到額外安全層的保護。應用程序還不應依賴於加密 URL 參數的安全性，應強制執行強大的存取控制，以防止未經授權訪問信息。

## 金鑰管理

### 流程

應實施（並測試）正式流程，以涵蓋金鑰管理的所有方面，包括：

- 生成和存儲新金鑰。
- 將金鑰分發給所需方。
- 部署金鑰到應用伺服器。
- 輪換和停用舊金鑰。

### 金鑰生成

金鑰應使用加密安全函數隨機生成，例如在[安全隨機數生成](#secure-random-number-generation)部分討論的那些。金鑰**不應**基於常見詞語或短語，也不應基於通過亂按鍵盤生成的“隨機”字符。

如果使用多個金鑰（例如數據分離的數據加密和金鑰加密金鑰），它們應完全獨立於彼此。

### 金鑰壽命和輪換

Encryption keys should be changed (or rotated) based on a number of different criteria:

- If the previous key is known (or suspected) to have been compromised.
  * This could also be caused by a someone who had access to the key leaving the organisation.
- After a specified period of time has elapsed (known as the cryptoperiod).
  * There are many factors that could affect what an appropriate cryptoperiod is, including the size of the key, the sensitivity of the data, and the threat model of the system. See section 5.3 of [NIST SP 800-57](https://nvlpubs.nist.gov/nistpubs/SpecialPublications/NIST.SP.800-57pt1r4.pdf) for further guidance.
- After the key has been used to encrypt a specific amount of data.
  * This would typically be `2^35` bytes (~34GB) for 64-bit keys and `2^68` bytes (~295 exabytes) for 128 bit keys.
- If there is a significant change to the security provided by the algorithm (such as a new attack being announced).

Once one of these criteria have been met, a new key should be generated and used for encrypting any new data. There are two main approaches for how existing data that was encrypted with the old key(s) should be handled:

1. Decrypting it and re-encrypting it with the new key.
2. Marking each item with the ID of the key that was used to encrypt it, and storing multiple keys to allow the old data to be decrypted.

The first option should generally be preferred, as it greatly simplifies both the application code and key management processes; however, it may not always be feasible. Note that old keys should generally be stored for a certain period after they have been retired, in case old backups of copies of the data need to be decrypted.

It is important that the code and processes required to rotate a key are in place **before** they are required, so that keys can be quickly rotated in the event of a compromise. Additionally, processes should also be implemented to allow the encryption algorithm or library to be changed, in case a new vulnerability is found in the algorithm or implementation.

## 金鑰存儲

Securely storing cryptographic keys is one of the hardest problems to solve, as the application always needs to have some level of access to the keys in order to decrypt the data. While it may not be possible to fully protect the keys from an attacker who has fully compromised the application, a number of steps can be taken to make it harder for them to obtain the keys.

Where available, the secure storage mechanisms provided by the operating system, framework or cloud service provider should be used. These include:

- A physical Hardware Security Module (HSM).
- A virtual HSM.
- Key vaults such as [Amazon KMS](https://aws.amazon.com/kms/) or [Azure Key Vault](https://azure.microsoft.com/en-gb/services/key-vault/).
- Secure storage APIs provided by the [ProtectedData](https://docs.microsoft.com/en-us/dotnet/api/system.security.cryptography.protecteddata?redirectedfrom=MSDN&view=netframework-4.8) class in the .NET framework.

There are many advantages to using these types of secure storage over simply putting keys in configuration files. The specifics of these will vary depending on the solution used, but they include:

- Central management of keys, especially in containerised environments.
- Easy key rotation and replacement.
- Secure key generation.
- Simplifying compliance with regulatory standards such as FIPS 140 or PCI DSS.
- Making it harder for an attacker to export or steal keys.

In some cases none of these will be available, such as in a shared hosting environment, meaning that it is not possible to obtain a high degree of protection for any encryption keys. However, the following basic rules can still be followed:

- Do not hard-code keys into the application source code.
- Do not check keys into version control systems.
- Protect the configuration files containing the keys with restrictive permissions.
- Avoid storing keys in environment variables, as these can be accidentally exposed through functions such as [phpinfo()](https://www.php.net/manual/en/function.phpinfo.php) or through the `/proc/self/environ` file.

### 金鑰和數據的分離

在可能的情況下，應將加密金鑰存儲在與加密數據不同的位置。例如，如果數據存儲在數據庫中，則金鑰應存儲在文件系統中。這意味著如果攻擊者只能訪問其中一個（例如通過目錄遍歷或 SQL 注入），則無法同時訪問金鑰和數據。

根據環境的架構，可能可以將金鑰和資料存儲在不同的系統上，這將提供更高程度的隔離。

### 加密存儲的金鑰

Where possible, encryption keys should themselves be stored in an encrypted form. At least two separate keys are required for this:

- The Data Encryption Key (DEK) is used to encrypt the data.
- The Key Encryption Key (KEK) is used to encrypt the DEK.

For this to be effective, the KEK must be stored separately from the DEK. The encrypted DEK can be stored with the data, but will only be usable if an attacker is able to also obtain the KEK, which is stored on another system.

The KEK should also be at least as strong as the DEK. The [envelope encryption](https://cloud.google.com/kms/docs/envelope-encryption) guidance from Google contains further details on how to manage DEKs and KEKs.

In simpler application architectures (such as shared hosting environments) where the KEK and DEK cannot be stored separately, there is limited value to this approach, as an attacker is likely to be able to obtain both of the keys at the same time. However, it can provide an additional barrier to unskilled attackers.

A key derivation function (KDF) could be used to generate a KEK from user-supplied input (such a passphrase), which would then be used to encrypt a randomly generated DEK. This allows the KEK to be easily changed (when the user changes their passphrase), without needing to re-encrypt the data (as the DEK remains the same).
