
```
function to_nato($words){
  $array = str_split(strtolower($words), 1);

  $ret = '';
  $wordArray = [
    'a' => 'Alfa',
    'b' => 'Bravo',
    'c' => 'Charlie',
    'd' => 'Delta',
    'e' => 'Echo',
    'f' => 'Foxtrot',
    'g' => 'Golf',
    'h' => 'Hotel',
    'i' => 'India',
    'j' => 'Juliet',
    'k' => 'Kilo',
    'l' => 'Lima',
    'm' => 'Mike',
    'n' => 'November',
    'o' => 'Oscar',
    'p' => 'Papa',
    'q' => 'Quebec',
    'r' => 'Romeo',
    's' => 'Sierra',
    't' => 'Tango',
    'u' => 'Uniform',
    'v' => 'Victor',
    'w' => 'Whiskey',
    'x' => 'Xray',
    'y' => 'Yankee',
    'z' => 'Zulu',
  ];
  
  for($i = 0; $i < count($array) - 1; $i++){
    if($array[$i] === ' '){
      continue;
    }
    if(array_key_exists($array[$i], $wordArray)){
      $ret .= $wordArray[$array[$i]] . ' ';
      continue;
    }
    $ret .= $array[$i] . ' ';
  }
  
  if(array_key_exists($array[$i], $wordArray)){
      $ret .= $wordArray[$array[$i]];
  } else {
      $ret .= $array[$i];
  }

  return $ret;
}
```


答案用 trim() 來清除前後空白比較乾淨

```
function to_nato($words){
  $nato = [
    'a' => 'Alfa ',
    'b' => 'Bravo ',
    'c' => 'Charlie ',
    'd' => 'Delta ',
    'e' => 'Echo ',
    'f' => 'Foxtrot ',
    'g' => 'Golf ',
    'h' => 'Hotel ',
    'i' => 'India ',
    'j' => 'Juliet ',
    'k' => 'Kilo ',
    'l' => 'Lima ',
    'm' => 'Mike ',
    'n' => 'November ',
    'o' => 'Oscar ',
    'p' => 'Papa ',
    'q' => 'Quebec ',
    'r' => 'Romeo ',
    's' => 'Sierra ',
    't' => 'Tango ',
    'u' => 'Uniform ',
    'v' => 'Victor ',
    'w' => 'Whiskey ',
    'x' => 'Xray ',
    'y' => 'Yankee ',
    'z' => 'Zulu ',
    ' ' => '',
    '!' => '! ',
    '.' => '. ',
    ',' => ', ',
    '?' => '? '
  ];
  
  $words = strtolower($words);

  return trim(strtr($words, $nato));
}
```
