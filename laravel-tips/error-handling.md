## 錯誤處理技巧

- [略過例外回報](#ShouldntReport)
- [更好的自訂例外](#static)

### 略過例外回報 {#ShouldntReport}

有些例外您可能不想回報給您的監控工具。雖然您可以手動在「app.php」中註冊它們，但您只需使用「ShouldntReport」介面標記例外即可

```php
<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Debug\ShouldntReport;

class PodcastProcessingException extends Exception implements ShouldntReport
{
    //
}
```

### 更好的自訂例外 {#static}

您是否在程式碼庫中使用自訂例外，結果卻產生了多個空類別？您可以將所有相關的例外分組到一個類別中，並使用靜態方法建立類似英文的程式碼，讓您立即知道出了什麼問題

```php
<?php

namespace App\Exceptions;

use Exception;

final class CouldNotStartAbTest extends Exception
{
    public static function testDoesNotHaveEnoughVariants(string $abTestName): static
    {
        return new static(
            "無法啟動測試 '{$abTestName}'。至少需要 2 個變體。"
        );
    }

    // 在這裡將所有相關的例外分組
}

// 而不是硬式編碼訊息
throw new Exception('無法啟動測試 new-navbar。至少需要 2 個變體。');

// 或為每個錯誤建立一個單獨的自訂例外，這只是一個空類別
throw new NotEnoughAbTestVariantsException();

// 您可以將所有相關的例外分組到一個類別中，
// 這使得程式碼更具可讀性和可維護性
throw CouldNotStartAbTest::testDoesNotHaveEnoughVariants('new-navbar');
```
