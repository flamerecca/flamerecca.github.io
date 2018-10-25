
There is an array with some numbers. All numbers are equal except for one. Try to find it!

```
findUniq([ 1, 1, 1, 2, 1, 1 ]) === 2
findUniq([ 0, 0, 0.55, 0, 0 ]) === 0.55
```

It’s guaranteed that array contains more than 3 numbers.

The tests contain some very huge arrays, so think about performance.

This is the first kata in series:

* Find the unique number (this kata)
* Find the unique string
* Find The Unique

最好解答

```php
function find_uniq($a) {
  sort($a);
  
  return ($a[0] === $a[1]) ? end($a) : current($a);
}
```

用 `sort()` 來快速解決這個問題，雖然時間多一點（nlog(n)），好聰明ＸＤ
