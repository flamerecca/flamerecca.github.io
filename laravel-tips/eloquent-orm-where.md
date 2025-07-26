## Eloquent ORM Where 

- [更短的「whereHas」](#whereHas)
- [動態 Wheres](#dynamic-wheres)
- [「whereBelongsTo」方法](#whereBelongsTo)
- [「whereAll」和「whereAny」方法](#whereAll)
- [「whereKey」方法](#whereKey)
- [使用高階「orWhere」方法](#high-order-orWhere)
- [使用「whereIntegerInRaw」加快查詢速度](#whereIntegerInRaw)
- [「firstWhere」方法](#firstWhere)
- [「whereLike」方法](#whereLike)
- [「withWhereHas」方法](#withWhereHas)

### 更短的「whereHas」 {whereHas}

雖然 Laravel 的 `whereHas` 非常適合根據指定的關聯以及其他查詢限制來擷取記錄，但有一個名為「whereRelation」的捷徑可以完成相同的任務 🚀

```php
<?php

// 之前
User::whereHas('comments', function ($query) {
    $query->where('created_at', '>', now()->subDay());
})->get();

// 之後
User::whereRelation('comments', 'created_at', '>', now()->subDay())->get();
```

### 動態 Wheres {dynamic-wheres}

您知道 Laravel 允許您定義動態「where」條件嗎？例如，您可以執行 `whereNameAndAge(name_value, age_value)` 🤯

請務必將方法名稱新增至模型的 PHPDoc 中，這樣您的 IDE 就不會抱怨，這對它來說有點太神奇了，無法理解。

想知道它是如何完成的嗎？請查看 `Illuminate\Database\Query\Builder::dynamicWhere()`

```php
<?php

// select * from `users` where `name` = 'oussama' and `last_name` = 'mater"
User::whereNameAndLastName('oussama', 'mater')->first();
```

### 「whereBelongsTo」方法 {whereBelongsTo}

您知道 Laravel 附帶「whereBelongsTo」來取得父模型嗎？這將使程式碼更具可讀性 🚀

```php
<?php

// 這個
$posts = Post::where('user_id', $user->id)->get();
// 或這個可以
$posts = Post::whereUserId($user->id)->get();

// 但這個更具可讀性
$posts = Post::whereBelongsTo($user)->get();
```

### 「whereAll」和「whereAny」方法 {whereAll}

Laravel v10.47.0 包含四個新方法：「whereAll」、「whereAny」、「orWhereAll」和「orWhereAny」。這些方法可讓您將一個值與多個欄位進行比較 🚀

```php
<?php

$search = 'ous%';

// 而不是這樣
User::query()
    ->where(function($query) use ($search) {
        $query
            ->where('first_name', 'LIKE', $search)
            ->where('last_name', 'LIKE', 'ous%');
    })
    ->get();

// 您現在可以這樣做
User::query()
    ->whereAll(['first_name', 'last_name'], 'LIKE', $search)
    ->get();

User::query()
    ->whereAny(['first_name', 'last_name'], 'LIKE', $search)
    ->get();

// 這會產生下列查詢

// select * from `users` where (`first_name` LIKE 'ous%' and `last_name` LIKE 'ous%')
// select * from `users` where (`first_name` LIKE 'ous%' or `last_name` LIKE 'ous%')

// 您也可以使用「orWhereAll」和「orWhereAny」。
```

### 「whereKey」方法 {whereKey}

您知道 Laravel 附帶「whereKey」方法嗎？它讓您的「where in」陳述式更具可讀性，而且，您不必記住主鍵的名稱 🚀

```php
<?php

// 😕 而不是這樣做
Post::whereIn('id', [1,2,3])->get();
Post::whereNotIn('id', [1,2,3])->get();

// 😎 您可以這樣做
Post::whereKey([1,2,3])->get();
Post::whereKeyNot([1,2,3])->get();
```

### 使用高階「orWhere」方法 {high-order-orWhere}

Laravel 支援集合的「高階訊息」，這是我們使用的很酷的捷徑。但是您知道您可以在撰寫 eloquent 查詢時使用它們嗎？🚀

```php
<?php

// 而不是這樣 😫
User::popular()->orWhere(function (Builder $query) {
    $query->active();
})->get()

// 您可以這樣做 😎
User::popular()->orWhere->active()->get();
```


### 使用「whereIntegerInRaw」加快查詢速度 {whereIntegerInRaw}

在使用非使用者輸入的 whereIn 查詢時，可以選擇 whereIntegerInRaw。這會透過跳過 PDO 綁定和 Laravel 的 SQL 注入防護措施，來加快您的查詢速度 🚀

```php
<?php

// 而不是使用 whereIn()
Product::whereIn('id', range(1, 10000))->get();

// 使用 WhereIntegerInRaw()
Product::whereIntegerInRaw('id', range(1, 10000))->get();
```

### 「firstWhere」方法 {firstWhere}

我們經常需要取得符合 where 陳述式的第一筆記錄。雖然「where()」結合「first()」可以完成工作，但 Laravel 附帶一個捷徑「firstWhere()」來完全做到這一點 🚀

```php
<?php

// 而不是這樣 😞
$user = User::query()->where('name', 'john')->first();

// 這樣做 😎
$user = User::query()->firstWhere('name', 'john');
```

### 「whereLike」方法 {whereLike}

我們經常在應用程式中使用「where like」陳述式。您知道 Laravel 附帶一個「whereLike」方法，它更進一步，允許 like 陳述式不區分大小寫嗎？🚀

```php
<?php
// 而不是這樣
User::query()->where('name', 'like', 'Jo%')->get();

// 您可以這樣做
User::query()->whereLike('name', 'Jo%')->get();

// 您甚至可以指定是否應區分大小寫
User::query()->whereLike('name', 'Jo%', caseSensitive: true)->get();
// 查詢：select * from `users` where `name` like binary 'Jo%'
```

### 「withWhereHas」方法 {withWhereHas}

您是否曾經需要預先載入一個關聯，但同時又要用關聯存在性來限制它？雖然您可以使用 2 個方法手動執行此操作，但 Laravel 附帶「withWhereHas」方法來完全做到這一點 🚀

```php
// 而不是這樣
User::query()
    ->whereHas('posts', fn (Builder $query) => $query->where('featured', true))
    ->with(['posts' => fn (Builder $query) => $query->where('featured', true)])
    ->get();

// 您可以簡單地使用 withWhereHas 🔥
User::query()
    ->withWhereHas('posts', fn (Builder $query) => $query->where('featured', true))
    ->get();

// 這將擷取所有符合條件的使用者，以及僅其精選貼文。
```
