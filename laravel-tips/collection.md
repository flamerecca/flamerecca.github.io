## Laravel Collection 技巧

- [「dot」和「undot」方法](#dot)
- [「containsOneItem」方法](#containsOneItem)
- [「times」方法](#times)
- [「ensure」方法檢查集合項目類型](#ensure)
- [「every」方法](#every)
- [「forget」方法](#forget)
- [「skipUntil」方法跳過集合項目直到滿足條件](#skipUntil)
- [「zip」方法](#zip)
- [「WhenNotEmpty」方法](#WhenNotEmpty)
- [「search」方法搜尋集合項目](#search)
- [「sole」方法](#sole)
- [「filter」方法過濾假值](#filter)
- [「join」方法替代 Implode](#join)
- [高階訊息](#high-order)
- [「modelKeys」方法替代 Pluck](#modelKeys)
- [「pipe」集合方法](#pipe)
- [「duplicates」方法尋找重複項](#duplicates)

### 「dot」和「undot」方法 {#dot}

在使用 Laravel 集合時，您可能想要將多維集合扁平化為單層集合，反之亦然。幸運的是，有兩種方法可以做到這一點，「dot」和「undot」🚀

```php
$collection = collect(['products' => ['desk' => ['price' => 100]]]);

$dotted = $collection->dot();    // ['products.desk.price' => 100]
$undotted = $collection->undot(); // ['products' => ['desk' => ['price' => 100]]]
```

### 「containsOneItem」方法 {#containsOneItem}

有時候我們想確保一個集合只有一個項目。您知道嗎，除了在集合上呼叫 count 方法之外，還有一個優雅的方法叫做「containsOneItem」可以做到同樣的事情？🚀

```php
<?php
// 而不是這樣
collect([1])->count() === 1;

// 您可以這樣做
collect([1])->containsOneItem(); // true
collect([])->containsOneItem(); // false
collect([1, 2])->containsOneItem(); // false
```

### 「times」方法 {#times}

您知道 Laravel 附帶一個很酷的集合方法「times」，它允許您通過調用閉包 N 次來建立集合嗎？這在處理日期或產生隨機字串時可能很有用 🚀

```php
$collection = Collection::times(10, function (int $number) {
    return $number * 9;
});

$collection->all(); 
// [9, 18, 27, 36, 45, 54, 63, 72, 81, 90]
```

### 「ensure」方法檢查集合項目類型 {#ensure}

有時候您可能想確保集合項目都是特定類型。雖然 `map` 搭配 `instanceof` 檢查可以做到這一點，但 Laravel 已經附帶了 `ensure` 方法來做到這一點 🚀

```php
<?php

// 而不是這樣 🥱
return $collection->each(function ($item) {
    if (!$item instanceof User) {
        throw new UnexpectedValueException('😕');
    }
});

// 您可以這樣做 😎
return $collection->ensure(User::class);

// 或允許多種類型，這相當於 OR
return $collection->ensure([User::class, Customer::class]);

// 您也可以確保基本類型
return $collection->ensure('int');
```

### 「every」方法 {#every}

有時候您可能想檢查集合中的每個元素是否都通過一個條件。幸運的是，Laravel 附帶了「every」方法來做到這一點 🚀

```php
<?php

$result = collect([1, 2, 3])->every(fn (int $value, int $key) => $value > 2);
// $result 將為 false

$result = collect([])->every(fn (int $value, int $key) => $value > 2);
// 因為集合是空的，$result 將為 true
```

### 「forget」方法 {#forget}

有時候，在使用集合時，您可能想要根據鍵移除一個元素。幸運的是，集合附帶了「forget」方法來做到這一點 🚀

```php
<?php

$collection = collect(['name' => 'John Doe', 'framework' => 'laravel']);

$collection->forget('name');

$collection->all(); // ['framework' => 'laravel']
```

### 「skipUntil」方法跳過集合項目直到滿足條件 {#skipUntil}

有時候，在使用集合時，您可能想要跳過所有元素直到滿足條件。Laravel 附帶了「skipUntil」方法來做到這一點 🚀

```php
<?php

$collection = collect([1, 2, 3, 4]);

$subset = $collection->skipUntil(function (int $item) {
    return $item >= 3;
});

$subset->all(); // [3, 4]
```

### 「zip」方法 {#zip}

在使用集合時，您可能想要按索引合併兩個集合，將第一個索引的值組合在一起，然後是第二個，依此類推。幸運的是，Laravel 包含了「zip」方法來做到這一點 🚀

```php
<?php

$collection = collect(['Chair', 'Desk']);

// 這將按索引合併值，所以「Chair」與 100，「Desk」與 200
$zipped = $collection->zip([100, 200]);

$zipped->all(); // [['Chair', 100], ['Desk', 200]]
```

### 「WhenNotEmpty」方法 {#WhenNotEmpty}

在使用集合時，您可能想要在集合不為空時執行一些邏輯。Laravel 附帶一個很酷的方法「whenNotEmpty()」，而不是手動檢查，來做到這一點 🚀

```php
<?php

$collection = collect(['michael', 'tom']);

$collection->whenNotEmpty(function (Collection $collection) {
    return $collection->push('adam');
});

$collection->all(); // ['michael', 'tom', 'adam']

$collection = collect(); // 空集合

$collection->whenNotEmpty(function (Collection $collection) {
    return $collection->push('adam');
});

$collection->all(); // []
```

### 「search」方法搜尋集合項目 {#search}

您知道 Laravel 允許您搜尋集合項目嗎？您甚至可以傳遞一個條件來搜尋滿足它的第一個元素 🚀

```php
<?php
$collection = collect([2, 4, 6, 8]);

$collection->search('4'); // 1 (索引)

$collection->search('4', strict: true); // false (未找到)

$collection->search(fn (int $item, int $key) => $item > 5); // 2 (索引)
```

### 「sole」方法 {#sole}

在使用集合時，無論是常規集合還是 Eloquent 集合，如果您想獲取符合條件的第一個項目並確保它是唯一的，請使用「sole」方法 🚀

```php
<?php

// 返回 2
collect([1, 2, 3, 4])->sole(fn (int $value, int $key) => $value === 2);

// 拋出：Illuminate\Support\MultipleItemsFoundException 找到 2 個項目。
collect([1, 2, 2, 4])->sole(fn (int $value, int $key) => $value === 2);
```

### 「filter」方法過濾假值 {#filter}

我們都用過集合上的「filter」方法，但是您知道嗎，如果沒有傳遞回呼函式，它將過濾掉所有假值？🚀

```php
<?php

$collection = collect([1, 2, 3, null, false, '', 0, []]);
$collection->filter()->all(); // [1, 2, 3]
```

### 「join」方法替代 Implode {#join}

我們都用過 PHP 的「implode」函式，但是您知道「join」輔助方法嗎？它做同樣的事情，但還允許您自訂最後一個分隔符 🚀

```php
<?php

// 我們都這樣做過，常規的 implode()
collect(['a', 'b', 'c'])->join(', ', ''); // 'a, b, c'

// 但是您知道您可以指定最後一個分隔符嗎？
collect(['a', 'b', 'c'])->join(', ', ', and '); // 'a, b, and c'

// 而且它足夠聰明，可以處理邊界情況
collect(['a'])->join(', ', ', and '); // 'a'
collect([])->join(', ', ', and '); // ''
```

### 高階訊息 {#high-order}

在使用 Laravel 集合時，請記住它們附帶高階訊息，這是最常見操作的捷徑 🚀

```php
<?php

use App\Models\User;
 
$users = User::where('votes', '>', 500)->get();
 
// 雖然您可以這樣做
$users->each(fn(User $user) => $user->markAsVip());

// 您可以使用高階訊息將其簡化為此 🔥
$users->each->markAsVip();
```

### 「modelKeys」方法替代 Pluck {#modelKeys}

我們經常需要獲取某些模型的 ID。雖然您可以使用「pluck()」方法來做到這一點，但您也可以使用「modelKeys()」，它讀起來更好，而且如果您在任何時候更改主鍵，它都不會中斷 🚀

```php
<?php

use App\Models\User;

// 而不是這樣
$ids = User::all()->pluck('id');

// 您可以這樣做 🔥
$ids = User::all()->modelKeys();
```

### 「pipe」集合方法 {#pipe}

您知道 Laravel 集合附帶「pipe」方法嗎？它將集合傳遞給給定的回呼函式並返回結果。當您想要包裝集合或執行計算時，它可能很有用 🚀

```php
<?php

use Illuminate\Support\Collection;

$collection = collect([1, 2, 3]);
 
$collection->pipe(fn (Collection $collection) => $collection->sum());  // 6

$collection->pipe(fn (Collection $collection) => ['numbers' => $collection->toArray()]);

// ['numbers' => [1, 2, 3]]
```

### 「duplicates」方法尋找重複項 {#duplicates}

有時候您可能需要尋找重複值，例如在清理數據時。雖然您可以手動執行此操作，但 Laravel 已經附帶了「duplicates」方法來做到這一點 🚀

```php
<?php

$collection = collect(['a', 'b', 'a', 'c', 'b', 100, '100']);

// 鬆散比較
$collection->duplicates(); // ['a', 'b', '100']

// 嚴格比較
$collection->duplicatesStrict(); // ['a', 'b']
```
