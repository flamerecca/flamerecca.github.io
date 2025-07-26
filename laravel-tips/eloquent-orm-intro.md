## Eloquent ORM 入門 {#eloquent-ORM}

- [防止 N+1 問題](#prevent-n+1)
- [「doesntExist」方法](#doesntExist)

### 防止 N+1 問題 {#prevent-n+1} ([⬆️](#eloquent-ORM))

預先載入可以顯著提升效能。使用「preventLazyLoading」方法可確保在開發期間所有關聯都已預先載入，並自訂其對違規行為的行為 🚀

```php
<?php

use Illuminate\Database\Eloquent\Model;

// 在您的 AppServiceProvider 中
public function boot(): void
{
    // 這可確保在您的開發環境中防止延遲載入
    Model::preventLazyLoading(! $this->app->isProduction());

    // 您可以自訂延遲載入違規的行為
    Model::handleLazyLoadingViolationUsing(function (Model $model, string $relation) {
        $class = $model::class;

        info("嘗試在模型 [{$class}] 上延遲載入 [{$relation}]。");
    });
}
```

### 「doesntExist」方法 {#doesntExist} ([⬆️](#eloquent-ORM))

有時候您可能想要檢查資料庫中是否不存在某些記錄。雖然檢查計數或使用 exists() 方法可以做到這一點，但 Laravel 附帶「doesntExist」方法可以優雅地做到這一點 🚀

```php
<?php

// 這可以 😊
if (User::count() === 0) {
}

// 這很好 😊
if (! User::exists()) {
}

// 這更好 😎
if (User::doesntExist()) {
}
```

### 尋找多個物件 ([⬆️](#eloquent--database-tips-cd-))

您知道您可以將多個 ID 傳遞給 `find()` 方法嗎？Laravel 還附帶一個稍微更具可讀性的方法 `findMany()`，它做同樣的事情！🚀

```php
<?php

// 而不是這樣
$users = User::query()->whereIn('id', [1, 2, 3])->get();

// 這樣做
$users = User::find([1, 2, 3]);

// 更好的是，find() 在內部呼叫 findMany()，所以這樣寫更明確
$users = User::findMany([1, 2, 3]);
```

### 建立新記錄或更新現有記錄 ([⬆️](#eloquent--database-tips-cd-))

我們都遇過這樣的情況：我們想檢查記錄是否存在，以便更新它，或者如果不存在則建立它。Laravel 附帶 `updateOrCreate` 方法來完全做到這一點 🚀

```php
<?php

$flight = Flight::updateOrCreate(
    // 如果我們找不到具有下列條件的航班，
    ['departure' => 'Oakland', 'destination' => 'San Diego'],
    // 我們將使用下列資料建立它
    ['price' => 99, 'discounted' => 1]
);
```

### 刪除 (Destroy) 記錄 ([⬆️](#eloquent--database-tips-cd-))

您知道 Laravel 附帶 `destroy` 方法，可讓您按其主鍵刪除記錄嗎？🚀

```php
<?php

// 而不是這樣 😢
Flight::find(1)->delete()

// 這樣做 😎
Flight::destroy(1);

Flight::destroy(1, 2, 3); // 適用於可變引數

Flight::destroy([1, 2, 3]); // 陣列

Flight::destroy(collect([1, 2, 3])); // 也適用於集合！
```
