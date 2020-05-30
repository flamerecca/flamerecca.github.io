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
  - **In the case of public access to the files, use a handler that gets mapped to file names inside the application (someid -> file.ext)**
- **Run the file through an antivirus or a sandbox if available to validate that it doesn't contain malicious data**
- **確認所使用的函式庫是最新且正確設置的**
- **防範檔案上傳的功能受到 [CSRF](Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.md) 攻擊**

## 內容

- [File Upload Threats](#file-upload-threats)
  - [Malicious Files](#malicious-files)
  - [Public File Retrieval](#public-file-retrieval)
- [File Upload Protection](#file-upload-protection)
  - [Extension Validation](#extension-validation)
     - [Whitelist Extensions](#whitelist-extensions)
     - [Blacklist Extensions](#blacklist-extensions)
  - [Content-Type Validation](#content-type-validation)
  - [Magic Number Validation](#magic-number-validation)
  - [File Name Sanitization](#file-name-sanitization)
  - [File Content Validation](#file-content-validation)
  - [File Storage Location](#file-storage-location)
  - [User Permissions](#user-permissions)
  - [System Permissions](#system-permissions)
  - [Upload and Download Limits](#upload-and-download-limits)
- [Java Code Snippets](#java-code-snippets)

## File Upload Threats

In order to assess and know exactly what controls to implement, knowing what you're facing is essential to protect your assets. The following sections will hopefully showcase the risks accompanying the file upload functionality.

### Malicious Files

The attacker delivers a file for malicious intent, such as:

1. Exploit vulnerabilities in the file parser or processing module (_e.g._ [ImageTrick Exploit](https://imagetragick.com/), [XXE](https://owasp.org/www-community/vulnerabilities/XML_External_Entity_%28XXE%29_Processing))
2. Use the file for phishing (_e.g._ careers form)
3. Send ZIP bombs, XML bombs (otherwise known as billion laughs attack), or simply huge files in a way to fill the server storage which hinders and damages the server's availability
4. Overwrite an existing file on the system
5. Client-side active content (XSS, CSRF, etc.) that could endanger other users if the files are publicly retrievable.

### Public File Retrieval

If the file uploaded is publicly retrievable, additional threats can be addressed:

1. Public disclosure of other files
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

- 上傳圖片, allow one type that is agreed upon to fit the business requirement;
- 上傳履歷，允許 `docx` 和 `pdf` 格式

Based on the needs of the application, ensure the **傷害最小** and the **風險最低** file types to be used.

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

File-names can endager the system in multiple ways, either by using non acceptable characters, or by using special and restricted filenames. For Windows, refer to the following [MSDN guide](https://docs.microsoft.com/en-us/windows/win32/fileio/naming-a-file?redirectedfrom=MSDN#naming-conventions). For a wider overview on different filesystems and how they treat files, refer to [Wikipedia's Filename page](https://en.wikipedia.org/wiki/Filename).

In order to avoid the above mentioned threat, creating a **random string** as a file-name, such as generating a UUID/GUID, is essential. If the file-name is required by the business needs, proper input validation should be done for client-side (_e.g._ active content that results in XSS and CSRF attacks) and back-end side (_e.g._ special files overwrite or creation) attack vectors. File-name length limits should be taken into consideration based on the system storing the files, as each system has its own file name length limit. If user file-names are required, consider implementing the following:

- Implement a maximum length
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

The application should set proper size limits for the upload service in order to protect the file storage capacity. If the system is going to extract the files or process them, the file size limit should be considered after file decompression is conducted and by using secure methods to calculate zip files size. For more on this, see how to [Safely extract files from ZipInputStream](https://wiki.sei.cmu.edu/confluence/display/java/IDS04-J.+Safely+extract+files+from+ZipInputStream), Java's input stream to handle ZIP files.

The application should set proper request limits as well for the download service if available to protect the server from DoS attacks.

## Java 程式碼節錄

[Document Upload Protection](https://github.com/righettod/document-upload-protection) repository written by Dominique for certain document types in Java.
