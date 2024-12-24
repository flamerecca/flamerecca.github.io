翻譯自 

https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/Database_Security_Cheat_Sheet.md

----

# 資料庫安全防護小抄

## 簡介

這份小抄提供了有關安全配置 SQL 和 NoSQL 資料庫的建議。它旨在供應用程式開發人員使用，如果他們負責管理資料庫。有關如何防範 SQL 注入攻擊的詳細資訊，請參閱[SQL 注入防護小抄](SQL_Injection_Prevention_Cheat_Sheet.md)。

## 保護後端資料庫

應用程式的後端資料庫應該與其他伺服器隔離，並且只與盡可能少的主機連接。這項任務將取決於系統和網路架構。請考慮以下建議：

- 禁用網路（TCP）訪問，要求所有訪問都是通過本地套接字文件或命名管道進行。
- 配置資料庫僅綁定在本地主機上。
- 通過防火牆規則將對網路端口的訪問限制為特定主機。
- 將資料庫伺服器放置在與應用程式伺服器隔離的獨立 DMZ 中。

類似的保護措施應該保護與資料庫一起使用的任何基於 Web 的管理工具，例如 phpMyAdmin。

當應用程式在一個不受信任的系統上運行（例如一個厚客戶端），它應始終通過可以強制執行適當訪問控制和限制的 API 連接到後端。從厚客戶端直接連接到後端資料庫**絕對不應該**發生。

### 實施傳輸層保護

大多數資料庫的默認配置都是使用未加密的網路連接，儘管有些會加密初始驗證（例如 Microsoft SQL Server）。即使初始驗證是加密的，其餘的流量將是未加密的，所有類型的敏感信息都將以明文形式在網路上傳送。應採取以下步驟來防止未加密流量：

- 配置資料庫僅允許加密連接。
- 在伺服器上安裝受信任的數位憑證。
- 客戶端應使用 TLSv1.2+ 與現代密碼（例如，AES-GCM 或 ChaCha20）進行連接。
- 客戶端應驗證數位憑證是否正確。 

permalink: https://www.example.com/database-security-cheat-sheet

## 配置安全認證

資料庫應始終要求進行認證，包括來自本地伺服器的連線。資料庫帳戶應該：

- 使用強大且唯一的密碼進行保護。
- 只供單一應用程式或服務使用。
- 根據下面[權限部分中討論的最低權限要求進行配置](#creating-secure-permissions)。

與任何具有自己用戶帳戶的系統一樣，應遵循通常的帳戶管理流程，包括：

- 定期審查帳戶，以確保它們仍然需要。
- 定期審查權限。
- 在應用程式停用時刪除用戶帳戶。
- 當員工離職或有理由相信其可能已被破壞時更改密碼。

對於 Microsoft SQL Server，考慮使用[Windows 或整合式驗證](https://docs.microsoft.com/en-us/dotnet/framework/data/adonet/sql/authentication-in-sql-server)，該驗證使用現有的 Windows 帳戶而不是 SQL Server 帳戶。這也消除了在應用程式中存儲憑證的要求，因為它將使用運行下的 Windows 使用者的憑證進行連接。[Windows Native Authentication Plugins](https://dev.mysql.com/doc/connector-net/en/connector-net-programming-authentication-windows-native.html) 為 MySQL 提供了類似的功能。

### 安全地存儲資料庫憑證

資料庫憑證絕不能存儲在應用程式原始碼中，尤其是如果它們未加密。相反，它們應存儲在一個配置文件中，該配置文件：

- 位於網頁根目錄之外。
- 具有適當的權限，以便只能被所需的使用者讀取。
- 不應提交到原始碼存儲庫中。

在可能的情況下，這些憑證還應該使用內建功能進行加密或以其他方式進行保護，例如 [ASP.NET 中提供的 `web.config` 加密](https://docs.microsoft.com/en-us/dotnet/framework/data/adonet/connection-strings-and-configuration-files#encrypting-configuration-file-sections-using-protected-configuration)。

## 建立安全權限

當開發人員為資料庫使用者帳戶分配權限時，他們應該採用最小權限原則（即，帳戶應僅具有應用程式正常運作所需的最小權限）。這個原則可以應用在資料庫中的多個越來越細緻的層級，取決於資料庫中可用的功能。您可以在所有環境中執行以下操作：

- 不要使用內建的 `root`、`sa` 或 `SYS` 帳戶。
- 不要授予帳戶對資料庫實例的管理權限。
- 確保帳戶只能從允許的主機連線。這通常會是 `localhost` 或應用程式伺服器的位址。
- 帳戶應僅存取其所需的特定資料庫。開發、UAT 和正式環境應該使用不同的資料庫和帳戶。
- 只授予資料庫上所需的權限。大多數應用程式只需要 `SELECT`、`UPDATE` 和 `DELETE` 權限。帳戶不應該是資料庫的擁有者，因為這可能導致權限升級漏洞。
- 避免使用資料庫連結或連結伺服器。在需要時，使用僅已授予對最小資料庫、表格和系統權限的帳戶。

對於大多數安全關鍵應用程式，應在更細緻的層級上應用權限，包括：

- 表格層級權限。
- 欄位層級權限。
- 列層級權限。
- 阻止對底層表格的存取，並要求所有存取透過受限制的[檢視](<https://en.wikipedia.org/wiki/View_(SQL)>)。

## 資料庫組態和硬化

資料庫伺服器的底層作業系統應該進行硬化，基於安全基準，如[CIS Benchmarks](https://www.cisecurity.org/cis-benchmarks/)或[Microsoft Security Baselines](https://docs.microsoft.com/en-us/windows/security/threat-protection/windows-security-baselines)。

資料庫應用程式也應該被正確組態和硬化。以下原則應適用於任何資料庫應用程式和平台：

- 安裝任何必要的安全更新和補丁。
- 配置資料庫服務以在低特權使用者帳戶下運行。
- 移除任何預設帳戶和資料庫。
- 將[交易日誌](https://en.wikipedia.org/wiki/Transaction_log)存儲在與主要資料庫文件不同的磁碟上。
- 配置定期備份資料庫。確保備份受到適當權限保護，最好是加密保護。

以下各節提供了有關特定資料庫軟體的進一步建議，除了上述更一般的建議。

### 強化 Microsoft SQL Server

- 禁用 `xp_cmdshell`、`xp_dirtree` 和其他不需要的儲存程序。
- 禁用公用語言執行環境 (CLR) 執行。
- 禁用 SQL 瀏覽器服務。
- 禁用[混合模式驗證](https://docs.microsoft.com/en-us/sql/relational-databases/security/choose-an-authentication-mode?view=sql-server-ver15)，除非需要。
- 確保已刪除範例[Northwind 和 AdventureWorks 資料庫](https://docs.microsoft.com/en-us/dotnet/framework/data/adonet/sql/linq/downloading-sample-databases)。
- 參閱 Microsoft 有關[保護 SQL Server](https://docs.microsoft.com/en-us/sql/relational-databases/security/securing-sql-server)的文章。

### 強化 MySQL 或 MariaDB 伺服器

- 執行 `mysql_secure_installation` 腳本以刪除預設資料庫和帳戶。
- 禁用[FILE](https://dev.mysql.com/doc/refman/8.0/en/privileges-provided.html#priv_file)權限，以防止用戶讀取或寫入文件。
- 參閱[Oracle MySQL](https://dev.mysql.com/doc/refman/8.0/en/security-guidelines.html)和[MariaDB](https://mariadb.com/kb/en/library/securing-mariadb/)的強化指南。

### 強化 PostgreSQL 伺服器

- 參閱[PostgreSQL 伺服器設置和操作文件](https://www.postgresql.org/docs/current/runtime.html)以及較舊的[安全文件](https://www.postgresql.org/docs/7.0/security.htm)。

### MongoDB

- 參閱[MongoDB 安全檢查清單](https://docs.mongodb.com/manual/administration/security-checklist/)。

### Redis

- 請參閱[Redis安全指南](https://redis.io/topics/security)。
