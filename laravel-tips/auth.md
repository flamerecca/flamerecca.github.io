## 身份驗證和授權技巧

- [檢查使用者是否為訪客](#guest)
- [以「404 NotFound」拒絕](#denyAsNotFound)
- [一次性驗證使用者](#once)
- [登出其他裝置](#logoutOtherDevices)
- [僅登出目前裝置](#logoutCurrentDevice)
- [掛鉤到身份驗證事件](#listen)

### 檢查使用者是否為訪客 {#guest}

我們經常需要檢查使用者是否經過身份驗證，為此我們使用「check」方法。但是您知道當您需要檢查使用者是否為訪客時，可以使用「guest」方法嗎？🚀

```php
<?php

// 這很好
if (! Auth::check()) {
    // 使用者是訪客
}

// 這更具可讀性
if (Auth::guest()) {
    // 使用者是訪客
}
```

### 以「404 NotFound」拒絕 {#denyAsNotFound}

在定義閘道或策略時，出於安全原因，我們通常選擇返回 404 而不是 403。Laravel 為此提供了「denyAsNotFound()」方法 🚀

```php
<?php

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

Gate::define('edit-settings', fn (User $user) =>
    $user->isAdmin
        ? Response::allow()
        : Response::denyAsNotFound()
);
```

### 一次性驗證使用者 {#once}

您知道 Laravel 附帶「once」方法，僅對當前請求進行使用者身份驗證嗎？這在各種情況下都很有用，例如建立一次性連結或 RESTful API 🚀

```php
<?php

if (Auth::once($credentials)) {
    // ...
}

```

### 登出其他裝置 {#logoutOtherDevices}

當使用者登出時，您可能想詢問他們是否要從其他裝置登出，同時保留目前的裝置。幸運的是，Laravel 附帶了「logoutOtherDevices」方法，可以做到這一點 🚀

```php
<?php

use Illuminate\Support\Facades\Auth;
 
Auth::logoutOtherDevices($currentPassword);
```

### 僅登出目前裝置 {#logoutCurrentDevice}

您知道 Laravel 附帶「logoutCurrentDevice」方法，它允許您僅登出目前經過身份驗證的裝置嗎？🚀

```php
<?php

use Illuminate\Support\Facades\Auth;
 
Auth::logoutCurrentDevice();
```

### 掛鉤到身份驗證事件 {#listen}

您知道 Laravel 身份驗證組件附帶多個您可以監聽的事件嗎？無論使用者嘗試登入還是失敗，您都可以隨心所欲地處理這些事件 🚀

```php
<?php

protected $listen = [
    Illuminate\Auth\Events\Registered::class => [],
    Illuminate\Auth\Events\Attempting::class => [],
    Illuminate\Auth\Events\Authenticated::class => [],
    Illuminate\Auth\Events\Login::class => [],
    Illuminate\Auth\Events\Failed::class => [],
    Illuminate\Auth\Events\Validated::class => [],
    Illuminate\Auth\Events\Verified::class => [],
    Illuminate\Auth\Events\Logout::class => [],
    Illuminate\Auth\Events\CurrentDeviceLogout::class => [],
    Illuminate\Auth\Events\OtherDeviceLogout::class => [],
    Illuminate\Auth\Events\Lockout::class => [],
    Illuminate\Auth\Events\PasswordReset::class => [],
];
```
