翻譯自

https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/File_Upload_Cheat_Sheet.md

----

# 上傳檔案的小抄

## 簡介

檔案上傳已經是各種應用裡越來越重要的功能，比方說讓用戶可以上傳他們的照片，履歷，或者是展示自己最近工作內容的影片。要保護應用本身以及使用者的安全，檔案上傳功能要可以防範假檔案或者惡意檔案的攻擊。

簡而言之，要實作安全的檔案上傳功能，應該遵守以下原則：

- **以副檔名白名單允許檔案上傳格式。只允許商業邏輯上安全且重要的檔案格式**
  - **驗證副檔名之前要做[輸入驗證](https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/Input_Validation_Cheat_Sheet.md#validating-free-form-unicode-text)**
- **[Content-Type header](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Type) 是可以偽造的，所以不可信，要針對檔案類別進行驗證**
- **將檔名改成應用本身產生的名字**
- **設置檔名長度限制，如果可以的話，限制檔名可以使用的符號**
- **設置檔案大小限制**
- **只允許有權限的用戶上傳檔案**
- **將檔案儲存在不同的伺服器上。如果不可能做到，那麼將檔案儲存在運作網頁程式的資料夾以外**
  - **如果檔案有公開存取權限，透過處理程序將應用程式和檔案名稱進行綁定（someid -> file.ext）**
- **如果可以的話，用防毒軟體或者沙盒環境來運作檔案，確定裡面沒有包含惡意資料**
- **確認所使用的函式庫是最新且正確設置的**
- **防範檔案上傳的功能受到 [CSRF](Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.md) 攻擊**

## 內容

- [上傳檔案的威脅](#上傳檔案的危險)
  - [惡意檔案](#惡意檔案)
  - [Public File Retrieval](#public-file-retrieval)
- [File Upload Protection](#file-upload-protection)
  - [副檔名驗證](#副檔名驗證)
     - [副檔名白名單](#副檔名白名單)
     - [副檔名黑名單](#副檔名黑名單)
  - [Content-Type Validation](#content-type-validation)
  - [Magic Number Validation](#magic-number-validation)
  - [檔名過濾](#檔名過濾)
  - [檔案內容驗證](#檔案內容驗證)
  - [檔案儲存位置](#file-storage-location)
  - [使用者權限](#使用者權限)
  - [檔案系統權限](#檔案系統權限)
  - [上傳下載限制](#上傳下載限制)
- [Java 程式碼節錄](#Java 程式碼節錄)

## 上傳檔案的危險

要保護好系統，知道自己面對什麼樣的問題是非常重要的。這樣才知道具體上要做什麼保護措施。

以下章節展示上傳檔案時隨之而來的風險。

### 惡意檔案

攻擊者可能會上傳惡意檔案，比方說：

1. 針對檔案分析器或處理模組的弱點攻擊（比方說 [ImageTrick Exploit](https://imagetragick.com/) 和 [XXE](https://owasp.org/www-community/vulnerabilities/XML_External_Entity_%28XXE%29_Processing)）
2. 上傳釣魚檔案（比方說企業簡歷）
3. 上傳 ZIP bombs 或 XML bombs（也被稱為 billion laughs attack）。或者上傳一個超大的檔案，讓系統容量爆滿，破壞主機的可用性。
4. 嘗試覆寫系統內已存的檔案
5. 攻擊客戶端的檔案（XSS、CSRF⋯⋯等）。當其他用戶存取到這些檔案時，會對用戶產生危害。

### 公開取得檔案的風險

如果上傳的檔案之後會公開，那麼會有其他的風險：

1. 導致其他文件公開泄露
2. Initiate a DoS attack by requesting lots of files. Requests are small, yet responses are much larger
3. File content that could be deemed as illegal, offensive, or dangerous (_e.g._ personal data, copyrighted data, etc.) which will make you a host for such malicious files.

## File Upload Protection

There is no silver bullet in validating user content. Implementing a defense in depth approach is key to make the upload process harder and more locked down to the needs and requirements for the service. Implementing multiple techniques is key and recommended, as no one technique is enough to secure the service.

### 副檔名驗證

Ensure that the validation occurs after decoding the file name, and that a proper filter is set in place in order to avoid certain known bypasses, such as the following:

- Double extensions, _e.g._ `.jpg.php`, where it circumvents easily the regex `\.jpg`
- Null bytes, _e.g._ `.php%00.jpg`, where `.jpg` gets truncated and `.php` becomes the new extension
- Generic bad regex that isn't properly tested and well reviewed. Refrain from building your own logic unless you have enough knowledge on this topic.

Refer to the [Input Validation CS](Input_Validation_Cheat_Sheet.md) to properly parse and process the extension.

#### 副檔名白名單

只允許使用*商業邏輯上極重要的*檔案格式，不允許 without allowing any type of *non-required* extensions. For example if the system requires:

- 上傳圖片，允許商務需求上一致認同的一種型態
- 上傳履歷，允許 `docx` 和 `pdf` 格式

根據應用本身的需求，確保使用**傷害最小**和**風險最低**的檔案型態。

#### 副檔名黑名單

只使用副檔名黑名單是非常危險的，除非沒有其他辦法，不然別這樣做。

In order to perform this validation, specifying and identifying which patterns that could should be rejected are used in order to protect the service.

### Content-Type Validation

_The Content-Type for uploaded files is provided by the user, and as such cannot be trusted, as it is trivial to spoof. Although it should not be relied upon for security, it provides a quick check to prevent users from unintentionally uploading files with the incorrect type._

Other than defining the extension of the uploaded file, its MIME-type can be checked for a quick protection against simple file upload attacks.

This can be done preferrably in a whitelist approach; otherwise, this can be done in a blacklist approach.

### File Signature Validation

In conjunction with [content-type validation](#content-type-validation), validating the file's signature can be checked and verified against the expected file that should be received.

> This should not be used on its own, as bypassing it is pretty common and easy.

### 檔名過濾

惡意檔名有不少種危害系統的可能，比方說使用系統內不合法的字符，或者使用特殊或者限制的檔名。

For Windows, refer to the following [MSDN guide](https://docs.microsoft.com/en-us/windows/win32/fileio/naming-a-file?redirectedfrom=MSDN#naming-conventions). For a wider overview on different filesystems and how they treat files, refer to [Wikipedia's Filename page](https://en.wikipedia.org/wiki/Filename).

In order to avoid the above mentioned threat, creating a **random string** as a file-name, such as generating a UUID/GUID, is essential. If the file-name is required by the business needs, proper input validation should be done for client-side (_e.g._ active content that results in XSS and CSRF attacks) and back-end side (_e.g._ special files overwrite or creation) attack vectors. File-name length limits should be taken into consideration based on the system storing the files, as each system has its own file name length limit. If user file-names are required, consider implementing the following:

- 設置檔名最長長度
- Restrict characters to an allowed subset specifically, such as alphanumeric characters, hyphen, spaces, and periods
  - If this is not possible, blacklist dangerous characters that could endanger the framework and system that is storing and using the files.

### 檔案內容驗證

As mentioned in the [Public File Retrieval](#public-file-retrieval) section, file content can contain malicious, inappropriate, or illegal data.

Based on the expected type, special file content validation can be applied:

- For **images**, applying image rewriting techniques destroys any kind of malicious content injected in an image; this could be done through [randomization](https://security.stackexchange.com/a/8625/118367).
- For **Microsoft documents**, the usage of [Apache POI](https://poi.apache.org/) helps validating the uploaded documents.
- **ZIP files** are not recommended since they can contain all types of files, and the attack vectors pertaining to them are numerous.

The File Upload service should allow users to report illegal content, and copyright owners to report abuse.

If there are enough resources, manual file review should be conducted in a sandboxed environment before releasing the files to the public.

Adding some automation to the review could be helpful, which is a harsh process and should be well studied before its usage. Some services (_e.g._ Virus Total) provide APIs to scan files against well known malicious file hashes. Some frameworks can check and validate the raw content type and validating it against predefined file types, such as in [ASP.NET Drawing Library](https://docs.microsoft.com/en-us/dotnet/api/system.drawing.imaging.imageformat). Beware of data leakage threats and information gathering by public services.

### 檔案儲存位置

The location where the files should be stored must be chosen based on security and business requirements. The following points are set by security priority, and are inclusive:

1. Store the files on a **different host**, which allows for complete segragation of duties between the application serving the user, and the host handling file uploads and their storage.
2. Store the files **outside the webroot**, where only administrative access is allowed.
3. Store the files **inside the webroot**, and set them in write permissions only.
   - If read access is required, setting proper controls is a must (_e.g._ internal IP, authorized user, etc.)

Storing files in a studied manner in databases is one additional technique. This is sometimes used for automatic backup processes, non file-system attacks, and permissions issues. In return, this opens up the door to performance issues (in some cases), storage considerations for the database and its backups, and this opens up the door to SQLi attack. This is advised only when a DBA is on the team and that this process shows to be an improvement on storing them on the file-system.

> Some files are emailed or processed once they are uploaded, and are not stored on the server. It is essential to conduct the security measures discussed in this sheet before doing any actions on them.

### 使用者權限

Before any file upload service is accessed, proper validation should occur on two levels for the user uploading a file:

- Authentication level
  - The user should be a registered user, or an identifiable user, in order to set restrictions and limitations for their upload capabilities
- Authorization level
  - The user should have appropriate permissions to access or modify the files

### 檔案系統權限

> Set the files permissions on the principle of least privilege.

Files should be stored in a way that ensures:

- Allowed system users are the only ones capable of reading the files
- Required modes only are set for the file
  - If execution is required, scanning the file before running it is required as a security best practice, to ensure that no macros or hidden scripts are available.

### 上傳下載限制

為了保護上傳容量，應用應該要為上傳功能設置一個合適的檔案大小上限。

If the system is going to extract the files or process them, the file size limit should be considered after file decompression is conducted and by using secure methods to calculate zip files size. For more on this, see how to [Safely extract files from ZipInputStream](https://wiki.sei.cmu.edu/confluence/display/java/IDS04-J.+Safely+extract+files+from+ZipInputStream), Java's input stream to handle ZIP files.

The application should set proper request limits as well for the download service if available to protect the server from DoS attacks.

## Java 程式碼節錄

Dominique 所撰寫的 [Document Upload Protection](https://github.com/righettod/document-upload-protection) 

[Document Upload Protection](https://github.com/righettod/document-upload-protection) repository written by Dominique for certain document types in Java.
