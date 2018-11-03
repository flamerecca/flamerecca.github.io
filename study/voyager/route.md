voyager 作為一個有大量後台頁面的套件，自然需要一個處理套件的方式，這是怎麼做到的呢？

# 外層結構設計

首先，針對使用者看得到的部分，是這樣的：

```
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
```

這對 laravel 使用者來說很直觀，只要是 prefix 是 `admin` 的路徑，通通會被導入 Voyager 自己定義的路徑裡面。如果我有需要其他 Voyager 沒有定義的路徑，那我就在下面加入新的路徑，像是這樣：

```
Route::group(['prefix' => 'admin'], function () {
   Voyager::routes();

   // Your overwrites here
   Route::post('login', ['uses' => 'MyAuthController@postLogin', 'as' => 'postlogin']);
});
```

# 內部實作

## 在 routes/web.php 裡面寫入路徑宣告

上面所說的段落是在呼叫指令 `php artisan voyager:install` 時產生的，這是怎麼實現的呢？

我們來看看 `voyager:install` 時做了哪些事情

在 `vendor/tcg/voyager/src/Commands/InstallCommand.php` 裡面

可以看到這一段：

```php
$this->info('Adding Voyager routes to routes/web.php');
$routes_contents = $filesystem->get(base_path('routes/web.php'));
if (false === strpos($routes_contents, 'Voyager::routes()')) {
    $filesystem->append(
        base_path('routes/web.php'),
        "\n\nRoute::group(['prefix' => 'admin'], function () {\n    Voyager::routes();\n});\n"
    );
}
```

這邊的 `$filesystem` 是一個 `Illuminate\Filesystem\Filesystem` 物件

所以這一段的邏輯就是，如果執行 `voyager:install` 時，`routes/web.php`裡面沒有看到 `Voyager::routes()` 這段文字，那麼就會在下面加上

```php
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
```
這麼一段。

## 連接物件

不過這邊有個奇怪的地方是，laravel 怎麼會認得什麼是 `Voyager` 物件，知道呼叫 `Voyager::routes()` 時要去哪邊找程式呢？

這一段的處理，在 `vendor/tcg/voyager/VoyagerServiceProvider.php` 裡面

```
        $loader = AliasLoader::getInstance();
        $loader->alias('Voyager', VoyagerFacade::class);

        $this->app->singleton('voyager', function () {
            return new Voyager();
        });
```

VoyagerFacade 裡面則是

```
<?php

namespace TCG\Voyager\Facades;

use Illuminate\Support\Facades\Facade;

class Voyager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'voyager';
    }
}

```

這邊透過了 `Illuminate\Foundation\AliasLoader` 註冊了 `Voyager` 這個別名，所以在 `routes/web.php` 裡面，不需要宣告整個 `TCG\Voyager\Voyager` 物件（看起來很醜），只需要宣告 `Voyager::routes()`，laravel 就知道是要找 `TCG\Voyager\Voyager` 裡面的 `routes()` 了

## 連接 routes 檔案

那麼，routes() 裡面又是怎麼實作，才能讓 laravel 知道所有 voyager 套件所需要的路徑呢？

`TCG\Voyager\Voyager`是這樣實作：

```php
    public function routes()
    {
        require __DIR__.'/../routes/voyager.php';
    }
```

`routes/voyager.php` 這個檔案裡面，可以看到包含所有 voyager 所需要的路徑，都會在這個時候被引入 routes 裡面。

所以整個流程就清楚了。先透過 `VoyagerServiceProvider` 引入 `Voyager` 別名，讓這個別名綁定 `TCG\Voyager\Voyager` 物件。然後在裡面宣告 `routes()`，require `/routes/voyager.php` 這個檔案之後，就可以透過 `(new Illuminate\Filesystem\Filesystem())->append()` 的方式，在原本的 `routes/web.php` 裡面寫入 `Voyager::routes()`，這樣就能完整的引入套件所需要的路徑了！


