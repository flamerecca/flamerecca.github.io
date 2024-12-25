翻譯自 

https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/Forgot_Password_Cheat_Sheet.md

----

# 忘記密碼小抄

## 簡介

為了實現正確的使用者管理系統，系統會整合一個**忘記密碼**服務，允許使用者請求重設密碼。

儘管這個功能看起來簡單且易於實現，但卻是一個常見的漏洞來源，例如著名的[使用者列舉攻擊](https://owasp.org/www-project-web-security-testing-guide/stable/4-Web_Application_Security_Testing/03-Identity_Management_Testing/04-Testing_for_Account_Enumeration_and_Guessable_User_Account.html)。

以下簡短指南可作為快速參考，以保護忘記密碼服務：

- **對於現有和不存在的帳戶返回一致的訊息。**
- **確保使用者回應訊息所花費的時間是一致的。**
- **使用側通道來傳達重設密碼的方法。**
- **使用[URL 標記](#url-tokens)進行最簡單和最快速的實現。**
- **確保生成的標記或代碼：**
    - **使用具有密碼安全算法的隨機生成。**
    - **足夠長以防範暴力攻擊。**
    - **安全地存儲。**
    - **單次使用並在適當期限後過期。**
- **在提交有效標記之前不要對帳戶進行更改，例如鎖定帳戶**

這份小抄專注於重設使用者密碼。有關重設多因素認證（MFA）的指導，請參見[多因素認證小抄](Multifactor_Authentication_Cheat_Sheet.md#resetting-mfa)中的相關部分。

## 忘記密碼服務

密碼重設流程可分為兩個主要步驟，詳細說明如下。

### 忘記密碼請求

當使用者使用忘記密碼服務並輸入其使用者名稱或電子郵件時，應遵循以下步驟來實現安全流程：

- 對於現有和不存在的帳戶返回一致的訊息。
- 確保回應以一致的時間返回，以防止攻擊者列舉存在的帳戶。這可以通過使用非同步呼叫或確保遵循相同邏輯來實現，而不是使用快速退出方法來實現。
- 實施保護措施，例如對每個帳戶進行速率限制、要求 CAPTCHA 或其他控制來防止過多的自動提交。否則，攻擊者可能會為特定帳戶每小時進行數千次密碼重設請求，將無用的請求洪水般地發送到使用者的接收系統（例如電子郵件收件匣或簡訊）。
- 採用正常的安全措施，例如[SQL 注入防範方法](SQL_Injection_Prevention_Cheat_Sheet.md)和[輸入驗證](Input_Validation_Cheat_Sheet.md)。 

permalink: https://cheatsheetseries.owasp.org/cheatsheets/Forgot_Password_Cheat_Sheet.html

### 用戶重設密碼

用戶通過提供通過電子郵件發送的令牌或通過短信或其他機制發送的代碼證明其身份後，應該將其密碼重設為一個新的安全密碼。為了確保這一步驟的安全性，應採取以下措施：

- 用戶應確認他們設置的密碼，通過兩次輸入來確認。
- 確保有一個安全的密碼策略，並與應用程序的其餘部分保持一致。
- 根據[安全實踐](Password_Storage_Cheat_Sheet.md)更新和存儲密碼。
- 發送一封電子郵件通知用戶他們的密碼已被重置（不要在電子郵件中發送密碼！）。
- 一旦他們設置了新密碼，用戶應通過通常的機制登錄。不要自動登錄用戶，因為這會給身份驗證和會話處理代碼引入額外的複雜性，並增加引入漏洞的可能性。
- 詢問用戶是否要使所有現有會話失效，或自動使會話失效。

## 方法

為了允許用戶請求重設密碼，您將需要某種方式來識別用戶，或通過側通道與他們聯繫的方法。

可以通過以下任何方法來完成：

- [URL 令牌](#url-tokens)。
- [PIN碼](#pins)
- [離線方法](#offline-methods)
- [安全問題](#security-questions)。

這些方法可以結合使用，以提供更高程度的保證，確保用戶是其所聲稱的人。無論如何，您必須確保用戶始終有一種方法來恢復其帳戶，即使這涉及聯繫支援團隊並向工作人員證明其身份。

### 一般安全實踐

對於重置標識符（令牌、代碼、PIN等），採用良好的安全實踐至關重要。一些要點不適用於[離線方法](#offline-methods)，例如生存期限制。所有令牌和代碼應該：

- 生成[具有密碼學安全的隨機數生成器](Cryptographic_Storage_Cheat_Sheet.md#secure-random-number-generation)。
    - 也可以使用 JSON Web Tokens（JWT）代替隨機令牌，儘管這可能會引入額外的漏洞，例如在[JSON Web Token Cheat Sheet](JSON_Web_Token_for_Java_Cheat_Sheet.md)中討論的那些。
- 足夠長，以防止暴力攻擊。
- 與數據庫中的個別用戶相關聯。
- 在使用後使其失效。
- 以安全的方式存儲，如[Password Storage Cheat Sheet](Password_Storage_Cheat_Sheet.md)中討論的那樣。

### URL 標記

URL 標記是通過 URL 的查詢字串傳遞的，通常通過電子郵件發送給用戶。該過程的基本概述如下：

1. 為用戶生成一個標記，並將其附加在 URL 的查詢字串中。
2. 通過電子郵件將此標記發送給用戶。
   - 在創建重置 URL 時，不要依賴 [Host](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Host) 標頭，以避免 [Host 標頭注入](https://owasp.org/www-project-web-security-testing-guide/stable/4-Web_Application_Security_Testing/07-Input_Validation_Testing/17-Testing_for_Host_Header_Injection) 攻擊。URL 應該是硬編碼的，或者應該根據一組受信任的域名列表進行驗證。
   - 確保 URL 使用 HTTPS。
3. 用戶收到電子郵件，並瀏覽帶有附加標記的 URL。
   - 確保重置密碼頁面添加 [Referrer Policy](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy) 標籤，值為 `noreferrer`，以避免 [引薦來源泄漏](https://portswigger.net/kb/issues/00500400_cross-domain-referer-leakage)。
   - 實施適當的保護措施，以防止用戶對 URL 中的標記進行暴力破解，例如限制速率。
4. 如有必要，執行任何額外的驗證步驟，例如要求用戶回答 [安全問題](#security-questions)。
5. 讓用戶創建新密碼並確認。確保應用程序中其他地方使用的相同密碼策略也應用於此處。

*備註：* URL 標記可以遵循 [PINs](#pins) 的相同行為，通過從標記創建受限制的會話。應根據開發人員的需求和專業知識做出決定。

### PINs

PINs 是通過短信等側通道發送給用戶的數字（介於 6 到 12 位數之間）。

1. 生成一個 PIN。
2. 通過短信或其他機制將其發送給用戶。
   - 使用空格分隔 PIN 使用戶更容易閱讀和輸入。
3. 用戶然後在重置密碼頁面上輸入 PIN 和他們的用戶名。
4. 從該 PIN 創建一個有限的會話，僅允許用戶重置他們的密碼。
5. 讓用戶創建新密碼並確認。確保應用程序中其他地方使用的相同密碼策略也應用於此處。

### 離線方法

離線方法與其他方法不同之處在於允許使用者在不從後端請求特殊識別符（如令牌或 PIN）的情況下重設密碼。然而，仍然需要後端進行認證，以確保請求是合法的。離線方法在註冊時或使用者希望配置時提供某種識別符。

這些識別符應該以離線方式並安全地存儲（*例如* 密碼管理器），並且後端應該遵循[一般安全實踐](#general-security-practices)。一些實現是建立在[硬體 OTP 令牌](Multifactor_Authentication_Cheat_Sheet.md#hardware-otp-tokens)、[憑證](Multifactor_Authentication_Cheat_Sheet.md#certificates)或任何其他可在企業內部使用的實現上。這些不在本速查表的範圍之內。

如果帳戶啟用了 MFA，並且您正在尋找 MFA 恢復，可以在相應的[多因素認證速查表](Multifactor_Authentication_Cheat_Sheet.md#resetting-mfa)中找到不同的方法。

### 安全問題

安全問題不應作為重設密碼的唯一機制，因為攻擊者通常可以輕易猜測或獲取答案。然而，當與本速查表中討論的其他方法結合使用時，它們可以提供額外的安全層。如果使用了安全問題，則確保選擇安全問題如[安全問題速查表](Choosing_and_Using_Security_Questions_Cheat_Sheet.md)中所討論的那樣。

## 帳戶鎖定

不應該因為忘記密碼攻擊而導致帳戶被鎖定，因為這可能會用於拒絕已知用戶名的用戶訪問。有關帳戶鎖定的更多詳細信息，請參見[認證速查表](Authentication_Cheat_Sheet.md)。
