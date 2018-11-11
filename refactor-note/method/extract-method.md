# 萃取函式

重構這本書裡面，提到最常使用的一個重構方式就是萃取函式（Extract method）。

過長的函式，通常代表這個函式所做的事情過度複雜，讓人必須要花費很長的時間才能看懂。如果函式的某塊段落與其他地方互動不多，並且邏輯清楚，這時萃取函式就相當簡單。我們只需要移動這段區塊到獨立的函式裡面，並且取個好名字就可以了。

比方說

```php

public function recordStudentScore($request) {
    // 取得學生 ID
    $studentName = $request->route('studentName');
    $student = Student::where('name', $studentName)->first();
    
    if (!$student) {
        throw new InvalidException('學生姓名錯誤');
    }
    // 計算學生成績
    // 寫入學生成績紀錄
    
}

```

這三段的重構相對容易，只要將各自功能的段落移出 `recordStudentScore()`

```php
```

不過，如果要移動的段落與其他地方有互動，那就比較麻煩了。

# 段落內有取用其他變數

第一種狀況，是這個段落有取用其他的變數。

比方說上面的例子裡面

```php
```

# 段落內有更動其他變數

第二種比較棘手的狀況，是這個段落不僅有讀取其他的變數，還會變更該變數的值。這樣的話，我們就必須使這個段落回傳被更動過的變數，

比方說

```php
```

這引出了一個問題：會不會我們需要搬移的段落，同時更改了多個以上的變數，所以不能使用以上的重構方式呢？

如果是這樣，可能代表這一個段落的邏輯仍舊是太過複雜了，最簡單的方法是不要去更動這一段的邏輯。或者是將整個段落的邏輯先用其他的方式重構，理清邏輯之後，再用其他的方式進行重構

如果是我的話，我會先將太大的函式分段看懂，並加上對應的註解。之後根據註解命名新的函式。

# 拆分心結

另外一個心結，是有時候我們在拆分函式的時候，會覺得「這一段真的有需要拆分出來嗎？會不會拆分得太細了？」

針對這個部分，我自己的答案是：如果函式內部有一個段落，需要用單行註解去說明這段的行為時，那麼就代表這一段的邏輯值得用一個函式包起來，並以函式的名稱來說明這段落的行為是什麼。有時候這種段落會非常短，只有兩三行，甚至只有一行。即使如此，只要這一個段落值得用註解來說明，那麼就應該值得改用函式名稱來說明。

比方說 laravel 框架裡面

Illuminate\Http\JsonResponse

```php
/**
* Determine if a JSON encoding option is set.
*
* @param  int  $option
* @return bool
*/
public function hasEncodingOption($option)
{
    return (bool) ($this->encodingOptions & $option);
}
```

能不能不萃取出這函式？其實可以，只要每個地方判斷時都用 `(bool) ($this->encodingOptions & $option)` 的方式實作就好

不過用 `hasEncodingOption($option)` 萃取出來之後，看起來就更簡潔了，不是嗎？
