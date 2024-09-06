# Laravel 快速參考手冊

## 簡介

這份 *快速參考手冊* 旨在為開發 Laravel 應用程式的開發人員提供安全提示。它旨在涵蓋所有常見的弱點，以及如何確保您的 Laravel 應用程式是安全的。

Laravel 框架提供內建的安全功能，並且預設情況下應該是安全的。然而，它也提供額外的彈性以應對複雜的使用情境。這意味著對 Laravel 內部運作不熟悉的開發人員可能會陷入使用複雜功能但不安全的陷阱。這份指南旨在教育開發人員避免常見的陷阱，並以安全的方式開發 Laravel 應用程式。

您也可以參考 [Enlightn 安全文件](https://www.laravel-enlightn.com/docs/security/)，該文件突顯了保護 Laravel 應用程式的常見弱點和良好實踐。

## 基本原則

- 確保您的應用程式在正式環境中不處於偵錯模式。要關閉偵錯模式，將您的 `APP_DEBUG` 環境變數設置為 `false`：

```ini
APP_DEBUG=false
```

- 確保您的應用程式金鑰已生成。Laravel 應用程式使用應用程式金鑰進行對稱加密和 SHA256 雜湊，例如 cookie 加密、簽名 URL、密碼重設令牌和會話資料加密。要生成應用程式金鑰，您可以執行 `key:generate` Artisan 指令：

```bash
php artisan key:generate
```

- 確保您的 PHP 組態是安全的。您可以參考 [PHP 組態快速參考手冊](PHP_Configuration_Cheat_Sheet.md) 以獲取有關安全 PHP 組態設定的更多資訊。

- 在您的 Laravel 應用程式上設置安全的檔案和目錄權限。一般來說，所有 Laravel 目錄應設置為最大權限級別 `775`，非可執行檔的檔案應設置為最大權限級別 `664`。可執行檔，如 Artisan 或部署腳本，應提供最大權限級別 `775`。

- 確保您的應用程式沒有弱點依賴。您可以使用 [Enlightn 安全檢查器](https://github.com/enlightn/security-checker) 來檢查這一點。 

## Cookie安全性和會話管理

預設情況下，Laravel已經以安全方式配置。但是，如果您更改了cookie或會話配置，請確保以下事項：

- 如果您使用`cookie`會話存儲或存儲任何不應由客戶端讀取或篡改的數據，請啟用cookie加密中間件。一般情況下，除非您的應用程序有一個非常特定的用例需要禁用此功能，否則應該啟用此中間件。要啟用此中間件，只需將`EncryptCookies`中間件添加到`App\Http\Kernel`類中的`web`中間件組：

```php
/**
 * The application's route middleware groups.
 *
 * @var array
 */
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        ...
    ],
    ...
];
```

- 通過您的`config/session.php`文件，在會話cookie上啟用`HttpOnly`屬性，以便您的會話cookie無法從Javascript訪問：

```php
'http_only' => true,
```

- 除非您在Laravel應用程序中使用子域路由註冊，建議將cookie的`domain`屬性設置為null，以便僅同源（不包括子域）可以設置cookie。這可以在您的`config/session.php`文件中配置：

```php
'domain' => null,
```

- 在您的`config/session.php`文件中將`SameSite` cookie屬性設置為`lax`或`strict`，以將您的cookie限制在第一方或同站點上下文中：

```php
'same_site' => 'lax',
```

- 如果您的應用程序僅支持HTTPS，建議在您的`config/session.php`文件中將`secure`配置選項設置為`true`，以防止中間人攻擊。如果您的應用程序同時使用HTTP和HTTPS的組合，則建議將此值設置為`null`，以便在提供HTTPS請求時自動設置安全屬性：

```php
'secure' => null,
```

- 確保您設置了較低的會話閒置超時值。[OWASP建議](Session_Management_Cheat_Sheet.md)對於價值較高的應用程序，閒置超時為2-5分鐘，對於風險較低的應用程序，閒置超時為15-30分鐘。這可以在您的`config/session.php`文件中配置：

```php
'lifetime' => 15,
```

您也可以參考[Cookie安全性指南](https://owasp.org/www-chapter-london/assets/slides/OWASPLondon20171130_Cookie_Security_Myths_Misconceptions_David_Johansson.pdf)以了解更多關於cookie安全性和上述提到的cookie屬性的信息。 { /*examples*/ }

## 認證

### Guards 和 Providers

在 Laravel 的核心中，認證設施由 "guards" 和 "providers" 組成。Guards 定義了如何對每個請求進行用戶身份驗證。Providers 定義了如何從持久性存儲中檢索用戶。

Laravel 預設提供了一個 `session` guard，它使用會話存儲和 cookies 來維護狀態，還有一個 `token` guard 用於 API token。

對於 providers，Laravel 預設提供了一個 `eloquent` provider 用於使用 Eloquent ORM 檢索用戶，以及一個 `database` provider 用於使用資料庫查詢構建器檢索用戶。

Guards 和 providers 可以在 `config/auth.php` 文件中進行配置。Laravel 還提供了建立自定義 guards 和 providers 的能力。

### 起始套件

Laravel 提供了各種第一方應用程式起始套件，其中包括內置的認證功能：

1. [Laravel Breeze](https://laravel.com/docs/8.x/starter-kits#laravel-breeze): 一個簡單、最小化的實現，包括登錄、註冊、密碼重置、電子郵件驗證和密碼確認等所有 Laravel 的認證功能。
2. [Laravel Fortify](https://laravel.com/docs/fortify): 一個無界面的認證後端，包括上述認證功能以及雙因素認證。
3. [Laravel Jetstream](https://jetstream.laravel.com/): 一個應用程式起始套件，提供了一個 UI，用於 Laravel Fortify 的認證功能之上。

建議使用這些起始套件之一，以確保您的 Laravel 應用程式具有強大且安全的認證功能。

### API 認證套件

Laravel 還提供了以下 API 認證套件：

1. [Passport](https://laravel.com/docs/passport): 一個 OAuth2 認證提供者。
2. [Sanctum](https://laravel.com/docs/sanctum): 一個 API token 認證提供者。

像 Fortify 和 Jetstream 這樣的起始套件內置支持 Sanctum。

## 大量賦值

[大量賦值](Mass_Assignment_Cheat_Sheet.md) 是現代 Web 應用程序中常見的漏洞，這些應用程序使用像 Laravel 的 Eloquent ORM 這樣的 ORM。

質量分配是一種弱點，其中一個 ORM 模式被濫用以修改使用者通常不應該修改的資料項目。

考慮以下程式碼：

```php
Route::any('/profile', function (Request $request) {
    $request->user()->forceFill($request->all())->save();

    $user = $request->user()->fresh();

    return response()->json(compact('user'));
})->middleware('auth');
```

上述個人資料路由允許已登入的使用者更改其個人資訊。

然而，假設在使用者表格中有一個 `is_admin` 欄位。您可能不希望使用者被允許更改此欄位的值。然而，上述程式碼允許使用者更改使用者表格中其行的任何欄位值。這是一種質量分配弱點。

Laravel 具有內建功能來預防此弱點。請確保以下內容以保持安全：

- 使用 `$request->only` 或 `$request->validated` 來限定您希望更新的允許參數，而不是使用 `$request->all`。
- 不要取消保護模型或將 `$guarded` 變數設置為空陣列。這樣做實際上是禁用 Laravel 的內建質量分配保護。
- 避免使用繞過保護機制的方法，如 `forceFill` 或 `forceCreate`。但如果您傳入經過驗證的值陣列，則可以使用這些方法。

## SQL 注入

SQL 注入攻擊在現代 Web 應用程式中很常見，攻擊者提供惡意的請求輸入資料以干擾 SQL 查詢。本指引涵蓋了針對 Laravel 應用程式特別預防 SQL 注入的方法。您也可以參考 [SQL 注入預防小抄](SQL_Injection_Prevention_Cheat_Sheet.md) 以獲取更多與 Laravel 無關的資訊。

### Eloquent ORM 防止 SQL 注入

預設情況下，Laravel 的 Eloquent ORM 通過對查詢進行參數化和使用 SQL 綁定來防止 SQL 注入。例如，考慮以下查詢：

```php
use App\Models\User;

User::where('email', $email)->get();
```

上述程式碼觸發以下查詢：

```sql
select * from `users` where `email` = ?
```

因此，即使 `$email` 是不受信任的使用者輸入資料，您也受到保護，不會受到 SQL 注入攻擊的影響。

### 原始查詢 SQL 注入 {/examples/}

Laravel 也提供原始查詢表達式和原始查詢，用於構建複雜查詢或不受支援的特定資料庫查詢。

雖然這對於靈活性來說很好，但您必須小心，始終要為這些查詢使用 SQL 資料綁定。考慮以下查詢：

```php
use Illuminate\Support\Facades\DB;
use App\Models\User;

User::whereRaw('email = "'.$request->input('email').'"')->get();
DB::table('users')->whereRaw('email = "'.$request->input('email').'"')->get();
```

這兩行程式碼實際上執行相同的查詢，這個查詢容易受到 SQL 注入攻擊，因為該查詢未使用 SQL 綁定來處理不受信任的使用者輸入資料。

上面的程式碼觸發以下查詢：

```sql
select * from `users` where `email` = "email 查詢參數的值"
```

請記得為請求資料使用 SQL 綁定。我們可以透過以下修改修復上述程式碼：

```php
use App\Models\User;

User::whereRaw('email = ?', [$request->input('email')])->get();
```

我們甚至可以使用命名的 SQL 綁定，如下所示：

```php
use App\Models\User;

User::whereRaw('email = :email', ['email' => $request->input('email')])->get();
```

### 欄位名稱 SQL 注入 {/examples/}

絕不能讓使用者輸入資料決定查詢中引用的欄位名稱。

以下查詢可能容易受到 SQL 注入攻擊：

```php
use App\Models\User;

User::where($request->input('colname'), 'somedata')->get();
User::query()->orderBy($request->input('sortBy'))->get();
```

值得注意的是，即使 Laravel 具有一些內建功能，例如將欄位名稱包裹起來以防止上述 SQL 注入漏洞，某些資料庫引擎（取決於版本和配置）仍然可能容易受到攻擊，因為資料庫不支援綁定欄位名稱。

至少，這可能導致大量分配漏洞，而不是 SQL 注入，因為您可能期望某組特定的欄位值，但由於這裡未經驗證，使用者可以自由使用其他欄位。

請始終針對此類情況驗證使用者輸入，如下所示：

```php
use App\Models\User;

$request->validate(['sortBy' => 'in:price,updated_at']);
User::query()->orderBy($request->validated()['sortBy'])->get();
```

### 驗證規則 SQL 注入 {/examples/}

某些驗證規則可以提供資料庫欄位名稱的選項。這些規則容易受到 SQL 注入攻擊，方式與欄位名稱 SQL 注入相同，因為它們以類似的方式構建查詢。

例如，以下程式碼可能存在漏洞：

```php
use Illuminate\Validation\Rule;

$request->validate([
    'id' => Rule::unique('users')->ignore($id, $request->input('colname'))
]);
```

在幕後，上述程式碼觸發以下查詢：

```php
use App\Models\User;

$colname = $request->input('colname');
User::where($colname, $request->input('id'))->where($colname, '<>', $id)->count();
```

由於欄位名稱由使用者輸入決定，這類似於欄位名稱SQL注入。

## 跨站腳本攻擊（XSS）

[XSS 攻擊](https://owasp.org/www-community/attacks/xss/) 是注入攻擊，惡意腳本（例如 JavaScript 代碼片段）被注入到受信任的網站中。

Laravel 的 [Blade 模板引擎](https://laravel.com/docs/blade) 具有回映語句 `{{ }}`，使用 `htmlspecialchars` PHP 函數自動轉義變數，以防範 XSS 攻擊。

Laravel 還提供使用未轉義語法 `{!! !!}` 顯示未轉義資料。這不應該用於任何不受信任的資料，否則您的應用程式將容易受到 XSS 攻擊。

例如，如果您在任何 Blade 模板中有類似以下內容，將導致漏洞：

```blade
{!! request()->input('somedata') !!}
```

然而，以下操作是安全的：

```blade
{{ request()->input('somedata') }}
```

有關不特定於 Laravel 的 XSS 預防其他資訊，您可以參考 [跨站腳本攻擊預防清單](Cross_Site_Scripting_Prevention_Cheat_Sheet.md)。

## 不受限制的檔案上傳

不受限制的檔案上傳攻擊包括攻擊者上傳惡意檔案以破壞網路應用程式。本節描述了在建構 Laravel 應用程式時如何保護免受此類攻擊。您也可以參考 [檔案上傳清單](File_Upload_Cheat_Sheet.md) 以瞭解更多資訊。

### 總是驗證檔案類型和大小

總是驗證檔案類型（副檔名或 MIME 類型）和檔案大小，以避免存儲 DOS 攻擊和遠端代碼執行：

```php
$request->validate([
    'photo' => 'file|size:100|mimes:jpg,bmp,png'
]);
```

存儲 DOS 攻擊利用缺少檔案大小驗證並上傳大型檔案，通過耗盡磁碟空間來導致拒絕服務（DOS）。

遠端程式碼執行攻擊首先需要上傳惡意可執行檔案（例如 PHP 檔案），然後透過訪問檔案 URL（如果是公開的）來觸發其惡意程式碼。

這兩種攻擊都可以通過簡單的檔案驗證來避免，如上所述。

### 不要依賴使用者輸入來指定檔案名稱或路徑 {/examples/}

如果您的應用程式允許使用者控制的資料來構建檔案上傳的路徑，這可能導致覆寫重要檔案或將檔案存儲在不良位置。

考慮以下程式碼：

```php
Route::post('/upload', function (Request $request) {
    $request->file('file')->storeAs(auth()->id(), $request->input('filename'));

    return back();
});
```

此路徑將檔案保存到特定於使用者 ID 的目錄。在這裡，我們依賴於 `filename` 使用者輸入資料，這可能導致漏洞，因為檔案名稱可能類似於 `../2/filename.pdf`。這將會將檔案上傳到使用者 ID 2 的目錄，而不是當前已登入使用者的目錄。

為了修復這個問題，我們應該使用 `basename` PHP 函數來從 `filename` 輸入資料中剝除任何目錄資訊：

```php
Route::post('/upload', function (Request $request) {
    $request->file('file')->storeAs(auth()->id(), basename($request->input('filename')));

    return back();
});
```

### 盡量避免處理 ZIP 或 XML 檔案 {/examples/}

XML 檔案可能會使您的應用程式受到各種攻擊的影響，例如 XXE 攻擊、十億笑攻擊等。如果處理 ZIP 檔案，您可能會受到 zip bomb DOS 攻擊的影響。

請參考 [XML 安全秘訣表](XML_Security_Cheat_Sheet.md) 和 [檔案上傳秘訣表](File_Upload_Cheat_Sheet.md) 以瞭解更多資訊。

## 路徑遍歷

路徑遍歷攻擊旨在通過操縱請求輸入資料中的 `../` 序列和變化或使用絕對檔案路徑來訪問檔案。

如果您允許使用者按檔案名稱下載檔案，則如果輸入資料未剝除目錄資訊，則可能會受到此漏洞的影響。

考慮以下程式碼：

```php
Route::get('/download', function(Request $request) {
    return response()->download(storage_path('content/').$request->input('filename'));
});
```

在這裡，檔案名稱未剝除目錄資訊，因此像 `../../.env` 這樣的格式錯誤的檔案名稱可能會將您的應用程式憑證暴露給潛在的攻擊者。

與不受限制的檔案上傳相似，您應該使用 `basename` PHP 函式來剝離目錄資訊，如下所示：

```php
Route::get('/download', function(Request $request) {
    return response()->download(storage_path('content/').basename($request->input('filename')));
});
```

## 開放式重新導向

開放式重新導向攻擊本身並不那麼危險，但它們會啟用釣魚攻擊。

考慮以下程式碼：

```php
Route::get('/redirect', function (Request $request) {
   return redirect($request->input('url'));
});
```

此程式碼將使用者重新導向至由使用者輸入提供的任何外部 URL。這可能使攻擊者能夠建立看似安全的 URL，例如 `https://example.com/redirect?url=http://evil.com`。例如，攻擊者可能使用此類型的 URL 來偽裝密碼重設郵件，並引導受害者在攻擊者的網站上洩露其憑證。

## 跨站請求偽造（CSRF）

[跨站請求偽造（CSRF）](https://owasp.org/www-community/attacks/csrf) 是一種攻擊類型，當惡意網站、電子郵件、部落格、即時消息或程式導致使用者的網頁瀏覽器在使用者已驗證時對受信任網站執行不需要的操作時發生。

Laravel 提供了 `VerifyCSRFToken` 中介軟體，以提供開箱即用的 CSRF 保護。通常，如果您在 `App\Http\Kernel` 類的 `web` 中介軟體組中有此中介軟體，您應該受到良好的保護：

```php
/**
 * The application's route middleware groups.
 *
 * @var array
 */
protected $middlewareGroups = [
    'web' => [
        ...
         \App\Http\Middleware\VerifyCsrfToken::class,
         ...
    ],
];
```

接下來，對於所有您的 `POST` 請求表單，您可以使用 `@csrf` Blade 指示詞來生成隱藏的 CSRF 輸入欄位：

```html
<form method="POST" action="/profile">
    @csrf

    <!-- Equivalent to... -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form>
```

對於 AJAX 請求，您可以設定 [X-CSRF-Token 標頭](https://laravel.com/docs/csrf#csrf-x-csrf-token)。

Laravel 還提供了排除某些路由不受 CSRF 保護的能力，使用 CSRF 中介軟體類中的 `$except` 變數。通常，您應該只排除無狀態路由（例如 API 或 Webhook）免受 CSRF 保護。如果排除任何其他路由，這可能導致 CSRF 漏洞。

## 指令注入

指令注入漏洞涉及使用未經轉義的使用者輸入資料構建的 shell 指令。

例如，以下程式碼對使用者提供的網域名稱執行 `whois`：

```php
public function verifyDomain(Request $request)
{
    exec('whois '.$request->input('domain'));
}
```

上述程式碼存在漏洞，因為使用者資料未正確轉義。為了解決這個問題，您可以使用 `escapeshellcmd` 和/或 `escapeshellarg` PHP 函式。

## 其他注入

物件注入、評估碼注入和提取變數劫持攻擊涉及對不受信任的使用者輸入資料進行反序列化、評估或使用 `extract` 函式。

一些範例：

```php
unserialize($request->input('data'));
eval($request->input('data'));
extract($request->all());
```

一般來說，應避免將任何不受信任的輸入資料傳遞給這些危險的函式。

## 安全標頭

您應考慮將以下安全標頭添加到您的網頁伺服器或 Laravel 應用程式中介軟體：

- X-Frame-Options
- X-Content-Type-Options
- Strict-Transport-Security（僅適用於 HTTPS 應用程式）
- Content-Security-Policy

欲瞭解更多資訊，請參考 [OWASP 安全標頭專案](https://owasp.org/www-project-secure-headers/)。

## 工具

您應考慮使用 [Enlightn](https://www.laravel-enlightn.com/)，這是一個針對 Laravel 應用程式的靜態和動態分析工具，具有超過 45 個自動化安全檢查，可識別潛在的安全問題。Enlightn 提供開源版本和商業版本。Enlightn 包含一份廣泛的 45 頁安全漏洞文件，瞭解更多 Laravel 安全資訊的好方法就是查閱其 [文件](https://www.laravel-enlightn.com/docs/security/)。

您也應使用 [Enlightn Security Checker](https://github.com/enlightn/security-checker) 或 [Local PHP Security Checker](https://github.com/fabpot/local-php-security-checker)。這兩個都是開源套件，分別根據 MIT 和 AGPL 授權許可，使用 [Security Advisories Database](https://github.com/FriendsOfPHP/security-advisories) 掃描您的 PHP 依賴項，以查找已知的安全漏洞。

## 參考資料

- [Laravel 認證文件](https://laravel.com/docs/authentication)
- [Laravel 授權文件](https://laravel.com/docs/authorization)
- [Laravel CSRF 文件](https://laravel.com/docs/csrf)
- [Laravel 驗證文件](https://laravel.com/docs/validation)
- [Enlightn SAST 和 DAST 工具](https://www.laravel-enlightn.com/)
- [Laravel Enlightn 安全性文件](https://www.laravel-enlightn.com/docs/security/){/*examples*/}
