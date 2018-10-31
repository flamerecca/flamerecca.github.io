Create a function isAlt() that accepts a string as an argument and validates whether the vowels (a, e, i, o, u) and consonants are in alternate order.

```
isAlt("amazon")
// true
isAlt("apple")
// false
isAlt("banana")
// true
```
Arguments consist of only lowercase letters.

----

用很複雜的手法弄出來，結果答案很簡單

```php
function isAlt($s){
  return !preg_match('/[aeiou]{2}|[^aeiou]{2}/', $s);
}
```
