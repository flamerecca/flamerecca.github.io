

最好解答

```php
function find_uniq($a) {
  sort($a);
  
  return ($a[0] === $a[1]) ? end($a) : current($a);
}
```

用 `sort()` 來快速解決這個問題，雖然時間多一點（nlog(n)），好聰明ＸＤ
