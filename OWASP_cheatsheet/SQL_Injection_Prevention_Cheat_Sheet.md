翻譯自 

https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.md

----

# 防止 SQL 注入的防護小抄

## 簡介

這份小抄將幫助您在應用程式中防止 SQL 注入漏洞。它將定義什麼是 SQL 注入，解釋這些漏洞發生的地方，並提供四種防禦 SQL 注入攻擊的選項。[SQL Injection](https://owasp.org/www-community/attacks/SQL_Injection) 攻擊很常見，因為：

1. SQL 注入漏洞非常普遍，以及
2. 應用程式的資料庫通常是攻擊者的頻繁目標，因為它通常包含有趣/關鍵的資料。

## 什麼是 SQL 注入攻擊？

如果應用程式使用動態資料庫查詢並使用字串串接和使用者提供的輸入，攻擊者可以對應用程式進行 SQL 注入。為了避免 SQL 注入漏洞，開發人員需要：

1. 停止使用字串串接撰寫動態查詢，或
2. 防止惡意的 SQL 輸入被包含在執行的查詢中。

有簡單的技術可以防止 SQL 注入漏洞，它們可以用於幾乎任何種類的程式語言和任何類型的資料庫。雖然 XML 資料庫可能存在類似的問題（例如 XPath 和 XQuery 注入），但這些技術也可以用來保護它們。

## 典型 SQL 注入漏洞的解剖

Java 中常見的 SQL 注入漏洞如下。由於其未經驗證的 "customerName" 參數僅附加到查詢中，攻擊者可以將 SQL 代碼輸入該查詢，並且應用程式將接受攻擊者的代碼並在資料庫上執行。

```java
String query = "SELECT account_balance FROM user_data WHERE user_name = "
             + request.getParameter("customerName");
try {
    Statement statement = connection.createStatement( ... );
    ResultSet results = statement.executeQuery( query );
}

...
```

## 主要防禦措施

- **選項 1：使用預先準備的陳述（帶有參數化查詢）**
- **選項 2：使用正確構建的儲存程序**
- **選項 3：允許清單輸入驗證**
- **選項 4：強烈不建議：對所有使用者提供的輸入進行轉義**

### 防禦選項 1：預先準備的陳述（帶有參數化查詢）

當開發人員學習如何撰寫資料庫查詢時，他們應該被告知使用帶有變數綁定（又稱參數化查詢）的預先準備的陳述。預先準備的陳述簡單易寫，比動態查詢更容易理解，而參數化查詢則強制開發人員首先定義所有 SQL 代碼，然後稍後將每個參數傳遞給查詢。

如果資料庫查詢使用這種編碼風格，無論提供了什麼用戶輸入，資料庫都會始終區分代碼和數據。此外，預處理語句確保攻擊者無法改變查詢的意圖，即使攻擊者插入了 SQL 命令。

#### 安全的 Java 預處理語句示例

在下面的安全 Java 示例中，如果攻擊者將 userID 輸入為 `tom' or '1'='1`，參數化查詢將尋找一個完全匹配整個字符串 `tom' or '1'='1` 的用戶名。因此，資料庫將受到對惡意 SQL 代碼的注入的保護。

以下代碼示例使用了 `PreparedStatement`，Java 的參數化查詢實現，來執行相同的資料庫查詢。

```java
// This should REALLY be validated too
String custname = request.getParameter("customerName");
// Perform input validation to detect attacks
String query = "SELECT account_balance FROM user_data WHERE user_name = ? ";
PreparedStatement pstmt = connection.prepareStatement( query );
pstmt.setString( 1, custname);
ResultSet results = pstmt.executeQuery( );
```

#### 安全的 C# .NET 預處理語句示例

在 .NET 中，查詢的創建和執行並未改變。只需使用 `Parameters.Add()` 調用將參數傳遞給查詢，如下所示。

```csharp
String query = "SELECT account_balance FROM user_data WHERE user_name = ?";
try {
  OleDbCommand command = new OleDbCommand(query, connection);
  command.Parameters.Add(new OleDbParameter("customerName", CustomerName Name.Text));
  OleDbDataReader reader = command.ExecuteReader();
  // …
} catch (OleDbException se) {
  // error handling
}
```

雖然我們展示了 Java 和 .NET 的示例，實際上所有其他語言（包括 Cold Fusion 和 Classic ASP）都支持參數化查詢接口。甚至 SQL 抽象層，如 [Hibernate Query Language](http://hibernate.org/)（HQL）具有相同類型的注入問題（稱為 [HQL Injection](http://cwe.mitre.org/data/definitions/564.html)） 也支持參數化查詢：

#### Hibernate Query Language (HQL) 預處理語句（命名參數）示例

```java
// This is an unsafe HQL statement
Query unsafeHQLQuery = session.createQuery("from Inventory where productID='"+userSuppliedParameter+"'");
// Here is a safe version of the same query using named parameters
Query safeHQLQuery = session.createQuery("from Inventory where productID=:productid");
safeHQLQuery.setParameter("productid", userSuppliedParameter);
```

#### 其他安全預處理語句示例

如果您需要預處理查詢/參數化語言的示例，包括 Ruby、PHP、Cold Fusion、Perl 和 Rust，請參閱 [Query Parameterization Cheat Sheet](Query_Parameterization_Cheat_Sheet.md) 或此 [網站](http://bobby-tables.com/)。

通常，開發人員喜歡預處理語句，因為所有的 SQL 代碼都留在應用程序中，這使應用程序相對獨立於資料庫。

### 防禦選項 2：存儲過程

雖然儲存程序並非總是免於 SQL 注入的安全，開發人員可以使用某些標準的儲存程序編程結構。只要儲存程序被安全實施（這對大多數儲存程序語言來說是正常的），這種方法就具有與使用帶有參數的查詢相同的效果。

#### 儲存程序的安全方法

如果需要儲存程序，最安全的使用方法要求開發人員使用自動參數化的參數來構建 SQL 陳述，除非開發人員做了某些大多數情況下不會做的事情。預備陳述和安全的儲存程序之間的區別在於，儲存程序的 SQL 代碼是在數據庫中定義並存儲的，然後從應用程序中調用。由於預備陳述和安全的儲存程序在防止 SQL 注入方面同樣有效，您的組織應該選擇對您最有意義的方法。

#### 儲存程序可能增加風險的情況

偶爾，當系統受到攻擊時，儲存程序可能會增加風險。例如，在 MS SQL Server 上，您有三個主要的默認角色：`db_datareader`、`db_datawriter` 和 `db_owner`。在使用儲存程序之前，數據庫管理員會根據需求將 `db_datareader` 或 `db_datawriter` 權限授予 Web 服務的使用者。

然而，儲存程序需要執行權限，這是默認情況下不可用的角色。在某些設置中，用戶管理已經被集中化，但僅限於這 3 個角色的情況下，Web 應用程序必須運行為 `db_owner`，以便儲存程序能夠運作。當然，這意味著如果伺服器被入侵，攻擊者將擁有對數據庫的完全權限，而以前他們可能只有讀取訪問權限。

#### 安全的 Java 儲存程序範例

以下代碼範例使用 Java 的儲存程序接口實現（`CallableStatement`）來執行相同的數據庫查詢。`sp_getAccountBalance` 儲存程序必須在數據庫中預先定義並使用與上述查詢相同的功能。

```java
// This should REALLY be validated
String custname = request.getParameter("customerName");
try {
  CallableStatement cs = connection.prepareCall("{call sp_getAccountBalance(?)}");
  cs.setString(1, custname);
  ResultSet results = cs.executeQuery();
  // … result set handling
} catch (SQLException se) {
  // … logging and error handling
}
```

#### 安全的 VB .NET 儲存程序範例

以下程式碼範例使用 `SqlCommand`，.NET 實作的儲存程序介面，來執行相同的資料庫查詢。`sp_getAccountBalance` 儲存程序必須在資料庫中預先定義，並且使用與上面定義的查詢相同的功能。

```vbnet
 Try
   Dim command As SqlCommand = new SqlCommand("sp_getAccountBalance", connection)
   command.CommandType = CommandType.StoredProcedure
   command.Parameters.Add(new SqlParameter("@CustomerName", CustomerName.Text))
   Dim reader As SqlDataReader = command.ExecuteReader()
   '...
 Catch se As SqlException
   'error handling
 End Try
```

### 防禦選項 3: 允許清單輸入驗證

如果面臨無法使用綁定變數的 SQL 查詢部分，例如表名、列名或排序順序指示符（ASC 或 DESC），則輸入驗證或查詢重新設計是最適當的防禦措施。當需要表名或列名時，理想情況下這些值來自程式碼而不是使用者參數。

#### 安全表名驗證範例

警告：使用使用者參數值來定位表名或列名是設計不良的症狀，如果時間允許，應考慮進行完整重寫。如果不可能，開發人員應將參數值映射到合法/預期的表名或列名，以確保未經驗證的使用者輸入不會出現在查詢中。

在下面的範例中，由於 `tableName` 被識別為此查詢中表名的合法且預期的值之一，因此可以直接附加到 SQL 查詢中。請記住，通用表驗證函數可能導致數據丟失，如果表名用於不希望出現的查詢中。

```text
String tableName;
switch(PARAM):
  case "Value1": tableName = "fooTable";
                 break;
  case "Value2": tableName = "barTable";
                 break;
  ...
  default      : throw new InputValidationException("unexpected value provided"
                                                  + " for table name");
```

#### 最安全的動態 SQL 生成使用（不鼓勵）

當我們說一個儲存程序是「安全實作」時，這意味著它不包含任何不安全的動態 SQL 生成。開發人員通常不會在儲存程序內部生成動態 SQL。但是，這是可以做到的，但應該避免。

如果無法避免，則儲存程序必須使用輸入驗證或適當的轉義，如本文所述，以確保所有用戶提供的輸入不能用於將 SQL 代碼注入到動態生成的查詢中。審計員應始終尋找 SQL Server 儲存程序中的 `sp_execute`、`execute` 或 `exec` 的使用情況。其他供應商的類似功能也需要類似的審計指南。

#### 較安全的動態查詢生成示例（不鼓勵使用）

對於像排序順序這樣簡單的事情，最好將用戶提供的輸入轉換為布林值，然後使用該布林值來選擇要附加到查詢中的安全值。這在動態查詢創建中是非常標準的需求。

例如：

```java
public String someMethod(boolean sortOrder) {
 String SQLquery = "some SQL ... order by Salary " + (sortOrder ? "ASC" : "DESC");`
 ...
```

任何時候用戶輸入可以轉換為非字符串（如日期、數字、布林值、列舉類型等）之一時，再將其附加到查詢中或用於選擇要附加到查詢中的值，這樣可以確保安全性。

在所有情況下，即使在本文中討論過使用綁定變數時，也建議進行輸入驗證作為第二道防線。有關如何實施強大的輸入驗證的更多技術，請參閱[輸入驗證小抄](Input_Validation_Cheat_Sheet.md)。

### 防禦選項 4：強烈不建議：對所有用戶提供的輸入進行轉義

在這種方法中，開發人員將在將用戶輸入放入查詢之前對其進行轉義。這在其實施中非常依賴於特定於數據庫。與其他防禦措施相比，這種方法脆弱，我們無法保證此選項將在所有情況下防止所有SQL注入。

如果應用程序是從頭開始構建或需要低風險容忍度，則應使用參數化查詢、存儲過程或某種為您構建查詢的對象關係映射器（ORM）來構建或重新編寫。

## 附加防禦措施

除了採用四種主要防禦措施之一外，我們還建議採用所有這些附加防禦措施以提供深度防禦。這些附加防禦措施包括：

- **最低權限**
- **允許列表輸入驗證**

### 最低權限

為了最大程度減少成功的SQL注入攻擊可能造成的損害，您應該將分配給環境中每個數據庫帳戶的權限最小化。從頭開始確定應用程序帳戶需要哪些訪問權限，而不是試圖弄清楚需要收回哪些訪問權限。

確保僅授予僅需要讀取權限的帳戶對其需要訪問的表進行讀取訪問。不要將 DBA 或 ADMIN 類型的訪問權限分配給應用程式帳戶。我們明白這樣做很容易，當您以這種方式操作時一切都“運作”正常，但這樣做非常危險。

#### 減少應用程式和作業系統權限

SQL 注入並不是對您的資料庫數據唯一的威脅。攻擊者可以簡單地將參數值從他們所呈現的合法值之一更改為對他們未經授權的值，但應用程式本身可能被授權訪問。因此，將授予應用程式的權限最小化將減少此類未經授權訪問嘗試的可能性，即使攻擊者並未嘗試使用 SQL 注入作為其攻擊的一部分。

同時，您應該將 DBMS 運行的作業系統帳戶的權限最小化。不要將您的 DBMS 作為 root 或 system 運行！大多數 DBMS 預設以非常強大的系統帳戶運行。例如，MySQL 在 Windows 上默認以 system 帳戶運行！將 DBMS 的作業系統帳戶更改為更適當的帳戶，並限制其權限。

#### 開發時的最小權限細節

如果一個帳戶僅需要訪問表的部分，請考慮創建一個限制對該部分數據訪問的視圖，並將帳戶訪問權限分配給該視圖而不是底層表。幾乎從不將創建或刪除訪問權限授予數據庫帳戶。

如果您採用一種政策，即在任何地方都使用存儲過程，並且不允許應用程式帳戶直接執行其自己的查詢，那麼將這些帳戶限制為僅能執行它們需要的存儲過程。不要直接向它們授予對數據庫中的表的任何權限。

#### 多個資料庫的最小管理權限

Web 應用程式的設計者應該避免在 Web 應用程式中使用相同的擁有者/管理員帳戶連接到數據庫。不同的 DB 使用者應該用於不同的 Web 應用程式。

一般來說，每個需要存取資料庫的獨立網頁應用程式應該擁有一個指定的資料庫使用者帳戶，該應用程式將用來連接到資料庫。這樣，應用程式的設計者可以在存取控制上有很好的細微度，從而將權限降低到最低限度。然後，每個資料庫使用者將只有所需的查詢權限，以及必要的寫入權限。

舉例來說，登入頁面需要讀取資料表中的使用者名稱和密碼欄位，但不需要任何形式的寫入權限（不得插入、更新或刪除）。然而，註冊頁面確實需要對該資料表具有插入權限；只有當這些網頁應用程式使用不同的資料庫使用者連接到資料庫時，才能強制執行此限制。

#### 使用 SQL 檢視增強最小權限原則

您可以使用 SQL 檢視進一步增加存取的細微度，限制對資料表特定欄位或資料表連接的讀取權限。這可能會帶來額外的好處。

例如，如果系統需要（可能是由於某些特定的法律要求）存儲使用者的密碼，而不是經過鹽值雜湊的密碼，設計者可以使用檢視來彌補這個限制。他們可以撤銷對該資料表的所有存取權限（除了擁有者/管理員之外的所有資料庫使用者），並建立一個檢視，輸出密碼欄位的雜湊值而非欄位本身。

任何成功竊取資料庫資訊的 SQL 注入攻擊將被限制在竊取密碼的雜湊值（甚至可能是帶鍵的雜湊值），因為任何網頁應用程式的資料庫使用者都無法存取該資料表本身。

### 白名單輸入驗證

除了在沒有其他可能時（例如，當綁定變數不合法時）作為主要防禦措施外，輸入驗證也可以作為二次防禦措施，用於在傳遞到 SQL 查詢之前檢測未授權的輸入。有關更多資訊，請參閱[輸入驗證速查表](Input_Validation_Cheat_Sheet.md)。在這裡謹慎行事。經過驗證的資料未必安全可供透過字串構建插入到 SQL 查詢中。

## 相關文章

**SQL 注入攻擊秘笈**:

以下文章描述如何利用不同類型的 SQL 注入漏洞在各種平台上進行攻擊（本文旨在幫助您避免這些漏洞）：

- [SQL 注入秘笈](https://www.netsparker.com/blog/web-security/sql-injection-cheat-sheet/)
- 通過 SQLi 繞過 WAF - [SQL 注入繞過 WAF](https://owasp.org/www-community/attacks/SQL_Injection_Bypassing_WAF)

**SQL 注入漏洞描述**:

- OWASP 關於 [SQL 注入](https://owasp.org/www-community/attacks/SQL_Injection) 漏洞的文章
- OWASP 關於 [Blind_SQL_Injection](https://owasp.org/www-community/attacks/Blind_SQL_Injection) 漏洞的文章

**如何避免 SQL 注入漏洞**:

- [OWASP 開發人員指南](https://github.com/OWASP/DevGuide) 上關於如何避免 SQL 注入漏洞的文章
- OWASP 秘笈提供了[多種特定語言的範例，使用參數化查詢，包括預備語句和存儲過程](Query_Parameterization_Cheat_Sheet.md)
- [Bobby Tables 網站（受 XKCD 網絡漫畫啟發）提供了不同語言的參數化預備語句和存儲過程的許多範例](http://bobby-tables.com/)

**如何檢查代碼中的 SQL 注入漏洞**:

- [OWASP 代碼審查指南](https://wiki.owasp.org/index.php/Category:OWASP_Code_Review_Project) 上關於如何[檢查代碼中的 SQL 注入](https://wiki.owasp.org/index.php/Reviewing_Code_for_SQL_Injection) 漏洞的文章

**如何測試 SQL 注入漏洞**:

- [OWASP 測試指南](https://owasp.org/www-project-web-security-testing-guide) 上關於如何[測試 SQL 注入](https://owasp.org/www-project-web-security-testing-guide/stable/4-Web_Application_Security_Testing/07-Input_Validation_Testing/05-Testing_for_SQL_Injection.html) 漏洞的文章
