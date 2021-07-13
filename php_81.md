## PHP 8.1 調整了什麼

根據官網的內容，PHP 8.1 新增了：

- Pure intersection types 
- Add IntlDatePatternGenerator
- Deprecate implicit non-integer-compatible float to int conversions
- Enumerations
- Deprecate passing null to non-nullable arguments of internal functions 
- Array unpacking with string keys
- Add array_is_list(array $array): bool 
- Explicit octal integer literal notation
- Restrict $GLOBALS usage
- Change Default mysqli Error Mode
- Add fetch_column method to mysqli
- Mysqli bind in execute 
- fsync() Function
- noreturn type
- Fibers
- Phasing out Serializable
- Static variables in inherited methods
- Add return type declarations for internal methods
- Final class constants
- Make reflection setAccessible() no-op

以下根據作者自己的興趣，逐一介紹：

### Enumerations

### 參考資料

- <https://wiki.php.net/rfc#php_81>
- <https://stitcher.io/blog/new-in-php-81>
