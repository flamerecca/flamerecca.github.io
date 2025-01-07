翻譯自 

https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/Cryptographic_Storage_Cheat_Sheet.md

----

# 輸入驗證速查表

## 簡介

本文旨在提供清晰、簡單、可操作的指導，以在應用程式中提供輸入驗證安全功能。

## 輸入驗證的目標

輸入驗證是為了確保只有格式正確的資料進入資訊系統的工作流程，防止格式錯誤的資料持續存在於資料庫中並觸發各種下游元件的故障。輸入驗證應該在資料流程中盡早進行，最好是在從外部方接收到資料時就進行。

所有潛在不受信任來源的資料都應該經過輸入驗證，包括不僅僅是面向互聯網的網頁客戶端，還包括來自外部網絡的後端供應源，來自[供應商、合作夥伴、供應商或監管機構](https://badcyber.com/several-polish-banks-hacked-information-stolen-by-unknown-attackers/)的數據，這些數據可能會被單獨入侵並開始發送格式錯誤的數據。

輸入驗證不應該被用作防止[XSS](Cross_Site_Scripting_Prevention_Cheat_Sheet.md)、[SQL Injection](SQL_Injection_Prevention_Cheat_Sheet.md)和其他攻擊的*主要*方法，這些攻擊在各自的[速查表](https://cheatsheetseries.owasp.org/)中有所涵蓋，但如果正確實施，輸入驗證可以顯著有助於減少它們的影響。

## 輸入驗證策略

應在語法和語義層面上應用輸入驗證：

- **語法**驗證應強制執行結構化字段的正確語法（例如 SSN、日期、貨幣符號）。
- **語義**驗證應在特定業務上下文中強制執行其*值*的正確性（例如開始日期在結束日期之前，價格在預期範圍內）。

建議盡早在處理用戶（攻擊者）請求時防止攻擊。輸入驗證可用於在應用程式處理之前檢測未經授權的輸入。

## 實施輸入驗證

可以使用任何有效執行語法和語義正確性的編程技術來實施輸入驗證，例如：

- 網頁應用程式框架中本地可用的資料類型驗證器（例如[Django Validators](https://docs.djangoproject.com/en/1.11/ref/validators/)、[Apache Commons Validators](https://commons.apache.org/proper/commons-validator/apidocs/org/apache/commons/validator/package-summary.html#doc.Usage.validator)等）。
- 對於以[JSON Schema](http://json-schema.org/)和[XML Schema (XSD)](https://www.w3schools.com/xml/schema_intro.asp)格式輸入的驗證。
- 類型轉換（例如在Java中的`Integer.parseInt()`，在Python中的`int()`）具有嚴格的例外處理。
- 數值參數和日期的最小和最大值範圍檢查，字符串的最小和最大長度檢查。
- 小型字符串參數集合的允許值陣列（例如星期幾）。
- 用於覆蓋整個輸入字符串的任何其他結構化數據的正則表達式 `(^...$)`，並且**不**使用"任何字符"通配符（例如`.`或`\S`）。
- 拒絕已知危險模式可以用作額外的防禦層，但應該補充而不是取代允許清單，以幫助捕捉一些常見的觀察到的攻擊或模式，而不依賴於它作為主要驗證方法。

### 允許清單 vs 拒絕清單

使用拒絕清單驗證來嘗試檢測可能危險的字符和模式（例如撇號 `'` 字元、字符串 `1=1` 或 `<script>` 標籤）是一個常見的錯誤，但這是一個嚴重有缺陷的方法，因為攻擊者可以輕易繞過此類過濾器。

此外，這樣的過濾器經常阻止授權的輸入，例如 `O'Brian`，其中 `'` 字元是完全合法的。有關跨站腳本攻擊避免的更多信息，請參見[此維基頁面](https://owasp.org/www-community/xss-filter-evasion-cheatsheet)。

雖然拒絕清單可以作為捕捉一些常見惡意模式的額外防禦層，但不應依賴它作為主要方法。允許清單仍然是預防潛在有害輸入的更堅固和安全的方法。

對於用戶提供的所有輸入字段，允許清單驗證是適當的。允許清單驗證涉及確定什麼是被授權的，並根據定義，其他所有內容都是未經授權的。

如果是結構化的資料，例如日期、社會安全號碼、郵遞區號、電子郵件地址等，開發人員應該能夠定義非常強大的驗證模式，通常基於正則表達式，用於驗證此類輸入。

如果輸入欄位來自一組固定的選項，例如下拉列表或單選按鈕，則輸入需要與用戶一開始提供的值中的一個完全匹配。

### 驗證自由格式的 Unicode 文本

自由格式文本，特別是包含 Unicode 字元的文本，由於需要允許的字符範圍相對較大，被認為難以驗證。

這也是自由格式文本輸入突顯了正確上下文感知輸出編碼的重要性，並清楚地表明輸入驗證**不是**防範跨站腳本攻擊的主要保障。如果您的用戶想在評論欄中輸入撇號 `'` 或小於號 `<`，他們可能有非常合理的理由，應用程序的工作是在整個數據的生命週期中正確處理它。

自由格式文本輸入的主要輸入驗證手段應該是：

- **規範化：** 確保所有文本都使用規範編碼，並且不存在無效字符。
- **字符類別允許列表：** Unicode 允許列出類別，例如“十進制數字”或“字母”，不僅涵蓋拉丁字母，還包括全球使用的各種其他文字（例如阿拉伯文、西里爾文、CJK 表意文字等）。
- **個別字符允許列表：** 如果您允許名稱中使用字母和表意文字，並且還想允許愛爾蘭名稱中的撇號 `'`，但不想允許整個標點符號類別。

參考資料：

- [Python 中自由格式 Unicode 文本的輸入驗證](https://web.archive.org/web/20170717174432/https://ipsec.pl/python/2017/input-validation-free-form-unicode-text-python.html/)
- [UAX 31：Unicode 識別符和模式語法](https://unicode.org/reports/tr31/)
- [UAX 15：Unicode 正規化形式](https://www.unicode.org/reports/tr15/)
- [UAX 24：Unicode 腳本屬性](https://unicode.org/reports/tr24/)

### 正則表達式（Regex）

開發正則表達式可能很複雜，遠超出了這份速查表的範圍。

有很多關於如何編寫正則表達式的資源在網上，包括這個[網站](https://www.regular-expressions.info/)和[OWASP 驗證正則表達式存儲庫](https://owasp.org/www-community/OWASP_Validation_Regex_Repository)。

在設計正則表達式時，要注意[正則表達式拒絕服務（ReDoS）攻擊](https://owasp.org/www-community/attacks/Regular_expression_Denial_of_Service_-_ReDoS)。這些攻擊會導致使用設計不良的正則表達式的程序運行非常緩慢，並長時間使用 CPU 資源。

總結一下，輸入驗證應該：

- 至少應用於所有輸入數據。
- 定義要接受的字符集。
- 為數據定義最小和最大長度（例如 `{1,25}`）。

## 允許列表正則表達式示例

驗證美國郵政編碼（5 位數字加可選的 -4）

```text
^\d{5}(-\d{4})?$
```

驗證從下拉菜單中選擇美國州名

```text
^(AA|AE|AP|AL|AK|AS|AZ|AR|CA|CO|CT|DE|DC|FM|FL|GA|GU|
HI|ID|IL|IN|IA|KS|KY|LA|ME|MH|MD|MA|MI|MN|MS|MO|MT|NE|
NV|NH|NJ|NM|NY|NC|ND|MP|OH|OK|OR|PW|PA|PR|RI|SC|SD|TN|
TX|UT|VT|VI|VA|WA|WV|WI|WY)$
```

**Java 正則表達式使用示例：**

示例使用正則表達式驗證參數 "zip"。

```java
private static final Pattern zipPattern = Pattern.compile("^\d{5}(-\d{4})?$");

public void doPost( HttpServletRequest request, HttpServletResponse response) {
  try {
      String zipCode = request.getParameter( "zip" );
      if ( !zipPattern.matcher( zipCode ).matches() ) {
          throw new YourValidationException( "Improper zipcode format." );
      }
      // do what you want here, after its been validated ..
  } catch(YourValidationException e ) {
      response.sendError( response.SC_BAD_REQUEST, e.getMessage() );
  }
}
```

一些允許列表驗證器也已經在各種開源套件中預定義，您可以利用這些驗證器。例如：

- [Apache Commons Validator](http://commons.apache.org/proper/commons-validator/)

## 客戶端 vs 伺服器端驗證

在應用程序的功能處理任何數據之前，**必須**在伺服器端實施輸入驗證，因為任何在客戶端執行的基於 JavaScript 的輸入驗證都可能被禁用 JavaScript 的攻擊者繞過或使用網絡代理。實施客戶端基於 JavaScript 的驗證以提升用戶體驗和伺服器端驗證以確保安全是推薦的方法，利用各自的優勢。

## 驗證豐富用戶內容

驗證用戶提交的豐富內容非常困難。有關更多信息，請參閱有關使用專為此工作設計的庫對 HTML 標記進行消毒的 XSS 速查表[Cross_Site_Scripting_Prevention_Cheat_Sheet.md](Cross_Site_Scripting_Prevention_Cheat_Sheet.md)。

## 防止跨網站指令碼攻擊（XSS）和內容安全策略

所有受控用戶數據在返回 HTML 頁面時必須進行編碼，以防止惡意數據的執行（例如 XSS）。例如 `<script>` 將被返回為 `&lt;script&gt;`

編碼的類型取決於用戶控制數據插入的頁面上下文。例如，對於放置在 HTML 主體中的數據，HTML 實體編碼是適當的。然而，放置在腳本中的用戶數據需要 JavaScript 特定的輸出編碼。

有關 XSS 預防的詳細信息請參見：[OWASP XSS Prevention Cheat Sheet](Cross_Site_Scripting_Prevention_Cheat_Sheet.md)

## 文件上傳驗證

許多網站允許用戶上傳文件，例如個人資料圖片等。本節有助於安全地提供該功能。

查看 [文件上傳防範小抄](File_Upload_Cheat_Sheet.md)。

### 上傳驗證

- 使用輸入驗證來確保上傳的文件名使用預期的擴展類型。
- 確保上傳的文件不超過定義的最大文件大小。
- 如果網站支持 ZIP 文件上傳，在解壓縮文件之前進行驗證檢查。檢查包括目標路徑、壓縮級別、預估解壓縮大小。

### 上傳存儲

- 使用新文件名將文件存儲在作業系統上。不要使用任何用戶控制的文本作為此文件名或臨時文件名。
- 當文件上傳到網絡時，建議將文件重新命名存儲。例如，上傳的文件名為 *test.JPG*，將其重新命名為 *JAI1287uaisdjhf.JPG*，使用隨機文件名。這樣做的目的是為了防止直接訪問文件的風險和模糊的文件名以逃避過濾器，例如 `test.jpg;.asp 或 /../../../../../test.jpg`。
- 上傳的文件應該進行惡意內容分析（反惡意軟件、靜態分析等）。
- 文件路徑不應該由客戶端指定。這是由服務器端決定的。

### 公開提供上傳內容

- 確保上傳的圖像以正確的內容類型提供服務（例如 image/jpeg、application/x-xpinstall）

### 注意特定檔案類型

上傳功能應該使用允許清單方法，僅允許特定檔案類型和副檔名。然而，重要的是要注意以下檔案類型，如果允許，可能會導致安全漏洞：

- **crossdomain.xml** / **clientaccesspolicy.xml：** 允許在 Flash、Java 和 Silverlight 中跨域數據加載。如果在需要驗證的站點上允許，這可能導致跨域數據竊取和 CSRF 攻擊。請注意，這可能會變得非常複雜，具體取決於問題中特定插件版本，因此最好禁止名為 "crossdomain.xml" 或 "clientaccesspolicy.xml" 的檔案。
- **.htaccess** 和 **.htpasswd：** 提供每個目錄基礎上的伺服器配置選項，不應允許。參見 [HTACCESS 文件](http://en.wikipedia.org/wiki/Htaccess)。
- 建議不允許 Web 可執行腳本檔案，例如 `aspx, asp, css, swf, xhtml, rhtml, shtml, jsp, js, pl, php, cgi`。

### 圖片上傳驗證

- 使用圖片重寫庫來驗證圖片是否有效，並去除多餘內容。
- 將存儲圖片的副檔名設置為基於從圖片處理中檢測到的圖片內容類型的有效圖片副檔名（例如，不要僅信任上傳的標頭）。
- 確保圖片的檢測到的內容類型在定義的圖片類型列表內（jpg, png 等）。

## 電子郵件地址驗證

### 語法驗證

電子郵件地址的格式由 [RFC 5321](https://tools.ietf.org/html/rfc5321#section-4.1.2) 定義，比大多數人意識到的要複雜得多。例如，以下都被認為是有效的電子郵件地址：

- `"><script>alert(1);</script>"@example.org`
- `user+subaddress@example.org`
- `user@[IPv6:2001:db8::1]`
- `" "@example.org`

使用正則表達式正確解析電子郵件地址的有效性非常複雜，儘管有許多有關正則表達式的 [公開文件](https://datatracker.ietf.org/doc/html/draft-seantek-mail-regexen-03#rfc.section.3)。

最大的注意事項是，儘管 RFC 為電子郵件地址定義了一個非常靈活的格式，但大多數現實世界的實作（例如郵件伺服器）使用的是一個更受限制的地址格式，這意味著它們將拒絕*技術上*有效的地址。儘管這些地址在技術上是正確的，但如果您的應用程式無法實際向這些地址發送郵件，則這些地址幾乎沒有用處。

因此，驗證電子郵件地址的最佳方法是進行一些基本的初始驗證，然後將地址傳遞給郵件伺服器，如果郵件伺服器拒絕該地址，則捕獲異常。這意味著應用程式可以確信其郵件伺服器可以向接受的任何地址發送郵件。初始驗證可能如下：

- 電子郵件地址包含兩個部分，用 `@` 符號分隔。
- 電子郵件地址不包含危險字符（例如反引號、單引號或雙引號，或空字節）。
    - 哪些字符是危險的將取決於地址將如何使用（在頁面中回顯，插入到資料庫中等）。
- 域部分僅包含字母、數字、連字符（`-`）和句點（`.`）。
- 電子郵件地址的長度合理：
    - 本地部分（`@` 之前）不應超過 63 個字符。
    - 總長度不應超過 254 個字符。

### 語義驗證

語義驗證是關於確定電子郵件地址是否正確和合法的。最常見的方法是向用戶發送一封電子郵件，要求他們點擊郵件中的鏈接，或輸入已發送給他們的代碼。這提供了一個基本的保證：

- 電子郵件地址是正確的。
- 應用程式可以成功向其發送郵件。
- 用戶可以訪問郵箱。

發送給用戶以證明所有權的鏈接應包含一個標記，該標記：

- 至少長度為 32 個字符。
- 使用[安全的隨機來源](Cryptographic_Storage_Cheat_Sheet.md#secure-random-number-generation)生成。
- 單次使用。
- 有時間限制（例如，在八小時後過期）。

在驗證電子郵件地址的所有權後，用戶應該被要求通過應用程序上的常規機制進行身份驗證。

#### 一次性電子郵件地址

在某些情況下，用戶在應用程序註冊時可能不想提供他們的真實電子郵件地址，而是提供一個一次性電子郵件地址。這些是公開可用的地址，用戶無需進行身份驗證，通常用於減少用戶主要電子郵件地址收到的垃圾郵件量。

阻止一次性電子郵件地址幾乎是不可能的，因為有許多網站提供這些服務，每天都會創建新的域。有一些公開可用的已知一次性域名列表和商業列表，但這些列表總是不完整的。

如果使用這些列表來阻止使用一次性電子郵件地址，則應向用戶顯示一條消息，解釋為什麼他們被阻止（儘管他們可能只是簡單地尋找另一個一次性提供者，而不是提供他們的合法地址）。

如果必須阻止一次性電子郵件地址，則應僅允許從特定允許的電子郵件提供者進行註冊。但是，如果這包括像Google或Yahoo這樣的公共提供者，用戶可以簡單地在這些提供者那裡註冊自己的一次性地址。

#### 子地址

子地址允許用戶在電子郵件地址的本地部分（在 `@` 符號之前）指定一個 *標籤*，這將被郵件服務器忽略。例如，如果該 `example.org` 域支持子地址，則以下電子郵件地址是等效的：

- `user@example.org`
- `user+site1@example.org`
- `user+site2@example.org`

許多郵件提供者（如Microsoft Exchange）不支持子地址。最著名支持子地址的提供者是Gmail，儘管還有許多其他提供者也支持。

一些用戶將為他們在每個註冊的網站使用不同的 *標籤*，這樣如果他們開始收到垃圾郵件到其中一個子地址，他們可以識別哪個網站洩漏或出售了他們的電子郵件地址。

因為這可能允許使用者使用單一電子郵件地址註冊多個帳戶，一些網站可能希望阻止子地址功能，方法是刪除 `+` 與 `@` 之間的所有內容。一般來說，這不被建議，因為這暗示網站擁有者可能不知道子地址功能，或者希望防止使用者在洩漏或出售電子郵件地址時識別他們。此外，這可以輕鬆地被繞過，方法是使用[一次性電子郵件地址](#disposable-email-addresses)，或者簡單地在可信任的提供者處註冊多個電子郵件帳戶。

## 參考資料

- [OWASP Top 10 Proactive Controls 2024: C3: 驗證所有輸入並處理異常](https://top10proactive.owasp.org/the-top-10/c3-validate-input-and-handle-exceptions)
- [CWE-20 不當輸入驗證](https://cwe.mitre.org/data/definitions/20.html)
- [OWASP Top 10 2021: A03:2021-注入](https://owasp.org/Top10/A03_2021-Injection/)
- [Snyk: 不當輸入驗證](https://learn.snyk.io/lesson/improper-input-validation/)
