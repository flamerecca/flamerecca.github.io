Return the number (count) of vowels in the given string.

We will consider a, e, i, o, and u as vowels for this Kata.

The input string will only consist of lower case letters and/or spaces.

## 解答

<details>
  <summary>點擊展開解答</summary>

第一版答案

```php
function getCount($str) {
  $vowelsCount = 0;
  
  $str2 = preg_replace('/(a|e|i|o|u)/', '', $str);
  $vowelsCount = strlen($str) - strlen($str2);
  return $vowelsCount;
}
```

後來找到更簡潔的解法，利用 `preg_match_all()`

```php
function getCount($str) {
  return preg_match_all('/[aeiou]/i',$str);
}
```

</details>
  
-----
回到 [PHP Kata 列表](index.md)
