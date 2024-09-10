翻譯自 

https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/PHP_Configuration_Cheat_Sheet.md

----

# PHP 組態速查表

## 簡介

此頁面旨在幫助那些配置 PHP 和運行 PHP 的網頁伺服器以實現高度安全性的人員。

以下將提供有關 `php.ini` 檔案的正確設定資訊，以及有關配置 Apache、Nginx 和 Caddy 網頁伺服器的指示。

有關一般 PHP 代碼庫安全性，請參閱以下兩個優秀指南：

- [Paragonie 的 2018 PHP 安全指南](https://paragonie.com/blog/2017/12/2018-guide-building-secure-php-software)
- [Awesome PHP 安全](https://github.com/guardrailsio/awesome-php-security)

## PHP 組態和部署

### php.ini

以下一些設定需要根據您的系統進行調整，特別是 `session.save_path`、`session.cookie_path`（例如 `/var/www/mysite`）和 `session.cookie_domain`（例如 `ExampleSite.com`）。

您應運行一個[支援的 PHP 版本](https://www.php.net/supported-versions.php)（截至本文撰寫時，8.1 是 PHP 中接收安全支援的最舊版本，儘管發行商通常提供擴展支援）。請查閱 PHP 手冊中有關 [核心 `php.ini` 指令](https://www.php.net/manual/ini.core.php)的完整參考，了解 `php.ini` 組態檔案中每個值的詳細資訊。

您可以在[這裡找到一份現成的 `php.ini` 檔案](https://github.com/danehrlich1/very-secure-php-ini)中的以下值。

#### PHP 錯誤處理

```text
expose_php              = Off
error_reporting         = E_ALL
display_errors          = Off
display_startup_errors  = Off
log_errors              = On
error_log               = /valid_path/PHP-logs/php_error.log
ignore_repeated_errors  = Off
```

請記住，在生產伺服器上，您需要將 `display_errors` 設置為 `Off`，並且經常注意日誌是一個好主意。

#### PHP 一般設定

```text
doc_root                = /path/DocumentRoot/PHP-scripts/
open_basedir            = /path/DocumentRoot/PHP-scripts/
include_path            = /path/PHP-pear/
extension_dir           = /path/PHP-extensions/
mime_magic.magicfile    = /path/PHP-magic.mime
allow_url_fopen         = Off
allow_url_include       = Off
variables_order         = "GPCS"
allow_webdav_methods    = Off
session.gc_maxlifetime  = 600
```

`allow_url_*` 防止 [LFI](https://www.acunetix.com/blog/articles/local-file-inclusion-lfi/) 被輕易升級為 [RFI](https://www.acunetix.com/blog/articles/remote-file-inclusion-rfi/)。

#### PHP 檔案上傳處理

```text
file_uploads            = On
upload_tmp_dir          = /path/PHP-uploads/
upload_max_filesize     = 2M
max_file_uploads        = 2
```

如果您的應用程式不使用檔案上傳，並且假設用戶將輸入/上傳的唯一資料是不需要任何文件附件的表單，則應將 `file_uploads` 設置為 `Off`。

#### PHP 可執行檔處理

```text
enable_dl               = Off
disable_functions       = system, exec, shell_exec, passthru, phpinfo, show_source, highlight_file, popen, proc_open, fopen_with_path, dbmopen, dbase_open, putenv, move_uploaded_file, chdir, mkdir, rmdir, chmod, rename, filepro, filepro_rowcount, filepro_retrieve, posix_mkfifo
disable_classes         =
```

這些是危險的 PHP 函數。您應該停用所有您不使用的函數。

#### PHP 會話處理

在配置中，會話設置是要專注的最重要值之一。將 `session.name` 更改為新值是一個良好的實踐。

```text
 session.save_path                = /path/PHP-session/
 session.name                     = myPHPSESSID
 session.auto_start               = Off
 session.use_trans_sid            = 0
 session.cookie_domain            = full.qualified.domain.name
 #session.cookie_path             = /application/path/
 session.use_strict_mode          = 1
 session.use_cookies              = 1
 session.use_only_cookies         = 1
 session.cookie_lifetime          = 14400 # 4 hours
 session.cookie_secure            = 1
 session.cookie_httponly          = 1
 session.cookie_samesite          = Strict
 session.cache_expire             = 30
 session.sid_length               = 256
 session.sid_bits_per_character   = 6
```

#### 一些更多的安全檢查

```text
session.referer_check   = /application/path
memory_limit            = 50M
post_max_size           = 20M
max_execution_time      = 60
report_memleaks         = On
html_errors             = Off
zend.exception_ignore_args = On
```

### Snuffleupagus

[Snuffleupagus](https://snuffleupagus.readthedocs.io) 是 PHP 7 及更高版本的 Suhosin 的精神後裔，具有[現代功能](https://snuffleupagus.readthedocs.io/features.html)。它被認為是穩定的，可用於生產環境。
