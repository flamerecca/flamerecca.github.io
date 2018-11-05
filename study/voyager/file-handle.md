
voyager 用一個文字欄位就可以處理多個檔案上傳，處理的邏輯在 `Http/Controllers/ContentTypes/File.php`：

```php
foreach ($files as $file) {
    $filename = $this->generateFileName($file, $path);
    $file->storeAs(
        $path,
        $filename.'.'.$file->getClientOriginalExtension(),
        config('voyager.storage.disk', 'public')
    );

    array_push($filesPath, [
        'download_link' => $path.$filename.'.'.$file->getClientOriginalExtension(),
        'original_name' => $file->getClientOriginalName(),
    ]);
}
```

使用這個套件的話，要自己實作這個方法以合乎資料庫格式。

不知道有沒有什麼更好的做法ＸＤ
