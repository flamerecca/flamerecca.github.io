來源為[https://github.com/Droogans/unmaintainable-code/](https://github.com/Droogans/unmaintainable-code/)

# 如何寫出無法維護的程式碼

## 保障終身工作 ;-)

**Roedy Green**
 [**Canadian Mind Products**](http://mindprod.com/jgloss/unmain.html)

* * *

## 引言

> _可以用無能解釋的事，永遠不要歸咎於惡意。_ - 拿破崙

為了讓 Java 領域有更多工作機會，我在這邊傳授一些大師的教誨。指導後進如何寫出極難維護的程式碼，讓後面的接班人即使做最小的修改都要花上數以年計的時間。並且，如果你嚴格遵守這些規則，你會保障**你自己**終身的工作穩定。因為你寫的程式碼除了你自己之外沒人能維護。不過，如果你遵守**全部**的規則，那麼連你自己也沒法維護這些程式！

你不希望做得太過火，你不希望你的程式碼**看起來**很難維護，只需要讓他**真的**很難維護就好。不然可能會引起夠多的注意，導致後人重寫或者重構你的程式。

## 大原則

> _Quidquid latine dictum sit, altum sonatur._
> _- 無論什麼話用拉丁語說，聽起來都很深奧_

要阻礙之後維護的工程師，你需要知己知彼，理解他的想法。他收到你的程式碼，他沒有時間全部讀過一遍，更別提理解了。他想要趕快找到需要修改的部分，然後改完，期間不影響其他的功能。

他彷彿以管窺天一般，只能看到你程式碼的一小部分。你要確保他這樣做時永遠搞不清楚你的程式碼全貌。你要讓他非常難找到應該修改的部分，更重要得是，你要確保他**忽視**任何東西時，事情就會變得越奇怪越好。

工程師會被慣例所蒙蔽而自滿。不過，當你偶爾違背一下慣例，你就會強迫他放下自信，認真地檢視每一行你所寫的程式碼。

你可能會認為每種語言的特色都讓程式碼難以維護 -- 其實不儘然，只有在正確的誤用時能生效。

## 命名

> _「當我用這個字時，」 Humpty Dumpty 説，語帶輕蔑：「那個字就是我當時想的意思，不多也不少」_
> - Lewis Carroll -- Through the Looking Glass, Chapter 6

要寫難以維護的程式碼，命名上面有許多的技巧可用。命名對編譯器來說沒有影響，因此給予我們極大的空間，可以寫出能運作，但是對之後的工程師難以看懂的程式碼。

#### <cite>Names For Baby</cite> 新用途

買本幫小孩命名的書，你再也不會不知道怎麼幫變數命名了。比方說，Fred 就是個很好的名字，又很好輸入。

如果你想找其他很好輸入的名稱，可以試試 `adsf`，如果你使用 Dvorak 鍵盤，也可以用 `aoeu`。

#### 單字母命名法

如果你用 `a`, `b`, `c` 幫變數命名，你可以保證之後的工程師無法用文字搜尋找到這些變數。另外，也沒有人能猜到他們的用途。如果有人希望打破從 FØRTRAN 以來，用 `i`, `j`, `k` 來當作 index 的傳統，就將他們改成 `ii`, `jj`, `kk`，並警告他們以前對異教徒都是怎麼處置的。

#### 有創意的拼字錯誤

如果你一定要使用有意義的變數和函式名稱，那就拼錯字。藉由在某些地方拼錯字，其他類似的函式又拼對字來命名（像是`SetPintleOpening` 和 `SetPintalClosing`），我們保證其他工程師無法用搜尋或 grep 來找到應該處理的程式碼。這種方法效果十分顯著。另外，我們也可以透過在不同的 theatres/theaters（美式拼法） 裡面，使用_tory_ 或 _tori_拼法來加入一點國際觀。

#### 抽象

在命名變數時，使用抽象的字，像是 _it_, _everything_, _data_, _handle_, _stuff_, _do_, _routine_, _perform_，可以搭配數字編號。比方說 `routineX48`，`PerformDataFunction`，`DoIt`，`HandleStuff`，`do_args_method`⋯⋯等等。

#### A.C.R.O.N.Y.M.S.（縮寫）

使用縮寫讓程式碼緊湊。男子漢從不定義縮寫，他們天生就知道縮寫的意思了。

#### 同義字替換法

為了不無聊，用同義字典來為同一行為找出盡可能多的單字。比方說 _display_ 也可以寫成 _show_， _present_。當兩個函式行為一模一樣時，用不同的字暗示他們有些微不同。但是，當兩個函式有重要的不同點時，用相同的單字隱藏其不同處（比方說，一個是印東西在紙上，一個是印東西在螢幕上，都使用 _print_ 來命名）。任何情況下，絕不建立單字表文件說明每個單字明確的用法。這種不專業的文件違背了 _資訊隱藏_ 的設計原則。

#### 使用其他語言的複數形式

一個 VMS 系統可以用來監測不同「Vaxen」（如果用中世紀英文規則下「Vax」的複數）回傳的「statii」（如果用拉丁文規則的話「status」的複數）。世界語，[克林貢語](https://www.kli.org/) 和哈比語的文法均適用。對類世界語單字的複數型態，使用世界語文法，在字尾加上-oj。這樣做是在幫世界和平盡一份力。

#### 大寫

在單字的每個音節隨意地插入大寫，比方說 `ComputeRasterHistoGram()`

#### 重複使用名稱

只要文法允許，給類別、建構子、方法、成員變數、參數和區域變數一樣的名稱。要更進一步，在`{}`區塊內重複使用相同的區域變數名稱。這樣的目標是強迫之後的維護者要詳細確認每個變數的可視範圍到底在哪邊。在 Java 裡面，可以讓一般的方法假裝自己是建構子。

#### 重音字母

使用重音字母當變數名稱，像是

```c
typedef struct { int i; } ínt;
```

第二個 ínt 上面的 í 其實是**重音 i**。如果只用一般的文字編輯器，幾乎不可能看出 i 上面的一點變斜了這點不同。

#### 利用編譯器長度限制

如果假設編譯器只能分辨命名的前八個字，那麼就多多利用後方的空間。

比方說程式裡混雜使用 `var_unit_update()` 和 `var_unit_setup()`，對編譯器來說，這兩個都是 `var_unit`。

#### 底線，大家的好朋友

使用 `_` 和 `__` 當作名稱。

#### 混雜各種語言

任意混用人類和電腦的語言。如果你的老闆堅持使用他的語言，告訴他你使用自己的語言時比較好整理思緒。如果這樣沒有用，提出這是語言歧視，並要脅你的老闆要付罰款。

#### 延伸 ASCII

延伸 ASCII 符號非常適合用來命名，像是 ß、Ð 和 ñ。用一般的文字編輯器，除了剪貼之外幾乎不可能輸入這些符號。

#### 來自其他語言的命名

使用各種語言來命名變數，比方說用德語的 _punkt_ 來命名 _point_ 。之後的維護者，不像你這麼精通德文，必然會在解讀這些變數命名時享受其文化體驗。

#### 來自數學術語的命名

使用看起來像是數學運算符號的變數命名，像是：

```js
openParen = (slash + asterix) / equals;
```

#### 眼花撩亂的命名

隨心情選擇富有感情，但是和程式意義完全無關的名稱，像是：

```js
marypoppins = (superman + starship) / god;
```
這會讓讀者閱讀時非常困擾，必須一邊理解你的想法，一邊嘗試忽視這些單字的意義。

#### 重新命名和重複利用

對 Ada，一個許多技巧都無法使用的語言來說，這個技巧特別有效。一開始宣告物件和套件的人都是笨蛋，所以與其說服他們改變命名。不如在自己修改的部分裡面改變名稱就好。記得留下一些地方保留舊名稱，讓不注意的人中計。

#### 使用 i 的時機

絕不在傳統使用 `i` 的地方，也就是最裡面 for 迴圈的 index 時，使用 `i` 命名變數。特別是在非整數的變數下使用 `i` 效果更好。

使用 `n` 當作迴圈的 index 變數命名。

#### 慣例

忽略 [Sun Java 程式慣例](http://web.archive.org/web/20091003224540/http://java.sun.com/docs/codeconv/)，反正，連 Sun 自己也不遵守。幸好編譯器不會因為不遵守這些規範就報錯。目標是要想出微妙地違反這些慣例的命名方式。如果你被強迫使用駝峰式命名，你還是可以在一些模糊地帶做變化，比方說同時使用 _input**F**ile**n**ame_ 和 _input**f**ile**N**ame_。自己發明一個無比複雜的命名慣例，並且在別人不遵守時指責他們。

#### 小寫 l 看起來像是數字 1

用小寫 l 代表長的常數。比方說，比起 `10L`，`10l`更容易被誤認為是 `101`。不使用任何可以輕易辨認出`uvw`, `wW`, `gq9`, `2z`, `5s`, `il17|!j`, `oO08`, `` `'" ``, `;,.`, `m nn rn`, 和 `{[()]}`的字體。發揮創意。

#### 重複利用全域變數，變成私有變數

在模組 A 裡面宣告一個全域變數，在模組 B 裡面也宣告一個同名的私有變數，讓人誤以為模組 B 是使用模組 A 裡面宣告的變數。在任何文件和註解裡面絕不說明這重複利用的情況。

#### 再看重複利用

用違背直覺的方式重複使用變數。比方說，你有全域變數 `A` 和 `B`，函式 `foo` 和 `bar`。然後你知道 `A` 常常傳給 `foo`，`B` 常常傳給 `bar`，那麼就宣告`function foo(B)` 和 `function bar(A)`，這樣在函式裡面 `A` 和 `B` 就常常會被搞混。隨著函式和全域變數變多，你可以編織出巨大的混亂網，裡面充斥著各種同名的函式和變數。

#### 重複使用你的變數

只要能運作，盡可能重複使用不相關的變數名稱。

使用相同的暫時變數來處理不同的用途。更進一步，在程式裡面修改這個變數。舉例來說，在一個很長的函式裡，開頭宣告一個變數，中間進行很小的修改，比方說從零開始改成從一開始。確保所有的文件裡都不會提到這個修改。

#### Cd wrttn wtht vwls s mch trsr（沒有母音的程式更珍貴）

對變數和函式使用縮寫時，同一個字使用各種縮寫法法以免無聊。甚至可以時不時不用縮寫，把全名拼出來。這樣可以免得之後的懶惰鬼用搜尋的方式，只需要了解你的部分程式就知道怎麼處理問題。針對同一個字，可以考慮使用不同拼法，比方說對顏色，混用國際的拼法 _colour_，美式的拼法 _color_ 以及俗俚拼法 _kulerz_。如果你總是固定用全名，那麼每個名稱就只有一種可能拼法，這對之後維護的工程師來說太好記了。因為一個字有許多縮寫的方式，使用縮寫的話，我們可以對一個目標有數個不同的變數。另外，之後維護的工程師可能根本沒注意到他們是不同的變數。

#### 誤導的名稱

確保每個函式都比名稱顯示的多做（或少做）一點事情。舉個簡單的例子，`isValid(x)` 除了檢查 `x` 是不是合法的之外，可以順便將 `x` 轉成二進位，並存進資料庫裡面。

#### m_

C++ 曾經有個命名慣例是使用`m_`開頭的字代表成員（member）變數。這可以幫助你區分儲存方法的變數，直到你想起方法（method）這個字也是 m 開頭。

#### o_apple obj_apple

使用 `o` 或 `obj` 前綴代表所有物件（object），代表你有看到多型結構的大局。


#### 匈牙利命名法

匈牙利命名法是混淆程式碼的戰術核子武器，用！光只是這個技法可以污染的程式碼範圍，沒有什麼比起良好設計的匈牙利命名法，能更快地殺害之後維護的工程師。以下技巧可以保證你毀掉原本匈牙利命名法的初衷：

 - 即使你使用 C++ 等能直接宣告常數的語言，堅持使用 `c` 前綴代表常數，

 - 使用和你現在用的語言無關的匈牙利命名法綴詞。比方說，堅持 PowerBuilder 的 `l_` 和 `a_`（本地（local）和參數（argument））前綴。寫 C++ 時，堅持使用 VB 類語言會使用的 control type 前綴，忽略連微軟的 MFC 類別庫程式碼都沒有 control type 前綴這個事實。

 - 違背匈牙利命名法內常用的變數應該要攜帶較少其他資訊的原則。要達到這點，可以堅持每個類別都應該有自己的前綴，不讓別人提醒你針對什麼**是**類別這件事情，根本**不存在**匈牙利命名法前綴。這個原則非常重要，如果沒有遵守，那程式碼可能會充斥許多簡短的，母音/子音比例變高的變數名稱。最差的狀況甚至可能導致整個混淆的努力失效，程式碼裡面出現用英文就可以看懂的段落！

 - 違背匈牙利命名原則內要求所有符號都要以有意義的方式命名這個原則。單單匈牙利綴詞的組合就足以作為一個很充份的變數名稱了。

 - 堅持在匈牙利命名法綴詞裡面包含所有獨立的資訊。參考這個真實世界的變數名稱 `a_crszkvc30LastNameCol`。花費一整個團隊的維護工程師大概三天的時間，才搞清楚這個變數是一個常數（`c`），參考（`reference`），函式的引數（`a_`），null 結尾字串（`sz`），某個資料庫欄位（`Col`）裡面名為 `LastName` 的資料，資料長度是 Varchar[30]（`vc30`），而且是某個表的 primary key 裡面的一部分（`k`）。 搭配「所有變數都是公開的」原則，這個技巧可以讓數千行程式碼直接廢掉！

 - 善加利用人腦一次只能同時處理七件事情的原則。舉例來說，良好運用上面原則，可以寫出具有以下特點的程式碼：

    * 一行帶有 14 個型態和意義資訊的宣告。
    * 呼叫一個函式，傳入三個參數，回傳帶有 29 個型態和名稱資訊的值。
    * 繼續改善這個優秀但是稍嫌簡潔的標準，建議使用五個字母標注程式碼撰寫的時間點，像是 `Monam` 和`FriPM`，讓你的同事驚訝一下。
    * 即使只使用有一點複雜的巢狀結構，也可以輕易擊垮其他人的短期記憶。**特別是** 當這段程式碼無法在螢幕上同時看到開頭和結尾時。

#### 再看匈牙利命名法

匈牙利命名法的一個技巧是「改變變數型態，但是不改變變數名稱」。這種技巧常見於將程式碼從 Win16：

```c
WndProc(HWND hW, WORD wMsg, WORD wParam, LONG lParam)
```

更新到 Win32：

```c
WndProc(HWND hW, UINT wMsg, WPARAM wParam, LPARAM lParam)
```

`w` 代表這些變數是 WORD，但是他們其實都是 LONG。這在搬移到 Win64 時會更看出其價值。全部的參數都是 64 bits，但是 `w` 和 `l` 的前綴會永遠留下。

#### Reduce, Reuse, Recycle

If you have to define a structure to hold data for callbacks, always call the structure `PRIVDATA`. Every module can define its own `PRIVDATA`. In VC++, this has the advantage of confusing the debugger so that if you have a `PRIVDATA` variable and try to expand it in the watch window, it doesn't know which `PRIVDATA` you mean, so it just picks one.

#### 隱晦的電影引用

使用 `LancelotsFavouriteColour` 這種變數名稱儲存 `#0204FB` 的 RGB 色碼，不要用 `blue`。這個顏色和正藍色看起來幾乎一樣，但是你之後的維護者必須要想辦法弄清楚 `0204FB` 到底是什麼，可能還會用上繪圖工具。只有特別喜歡 "Monty Python and the Holy Grail" 這部電影的人才會知道 Lancelot 最喜歡的顏色是藍色。畢竟，如果一個工程師沒法直接回想這部電影的細節，那麼他根本就不適合當工程師。

## 偽裝

> _當錯誤浮現的時間越長，那錯誤就越難找_ - Roedy Green

撰寫難以維護的程式碼上面，許多技巧來自於偽裝的藝術。將東西隱藏起來，或者讓東西看起來的樣子不是真實情況。許多技巧依賴編譯器比起人類或者文字編輯器更能詳細區分細節這件事情。以下是一些偽裝的技巧：

#### 偽裝成註解的程式碼（反之亦然）

包含看起來像是程式碼，但是其實是註解的段落：

```js
for(j=0; j<array_len; j+ =8)
{
total += array[j+0 ];
total += array[j+1 ];
total += array[j+2 ]; /* Main body of
total += array[j+3 ]; * loop is unrolled
total += array[j+4 ]; * for greater speed.
total += array[j+5 ]; */
total += array[j+6 ];
total += array[j+7 ];
}
```

沒有上色的話，你會知道中間三行被註解掉了嗎？

#### namespaces

在 C 裡面，struct/union 和 typedef struct/union 是不同的東西。你可以先定義一個 struct/union，然後定義同名的 typedef struct/union。如果可以的話，讓這兩個 struct/union 結構幾乎一樣。

```c
typedef struct {
char* pTr;
size_t lEn;
} snafu;

struct snafu {
unsigned cNt
char* pTr;
size_t lEn;
} A;
```
> 譯註：個人認為這個範例相當優秀，光看著就覺得自己得了不治之症

#### 隱藏巨集定義

在一堆沒用的註解裡面隱藏聚集的定義。之後維護的工程師閱讀註解到一半就會無聊而放棄，永遠找不到你所定義的巨集。確保你的巨集將原本合理的行為替換成某種奇怪的操作，比方說：

```c
#define a=b a=0-b
```

#### 裝忙

用 `define` 定義將全部輸入以註解處理的函式。像是：

```c
#define fastcopy(x,y,z) /*xyz*/
// ...
fastcopy(array1, array2, size); /* 什麼都不會做 */
```

#### 使用換行來隱藏變數

如果你想寫

```c
#define local_var xy_z
```

將 `xy_z` 分成兩行，改成：

```c
#define local_var xy\
_z // local_var OK
```

這樣一來，搜尋 `xy_z` 完全找不到這個變數，但是對 C 前置處理器來說，末端的 `\` 代表將兩行合併，所以可以編譯出 `xy_z` 這個變數。

#### 偽裝成保留字的任意命名

在文件撰寫時，如果你需要一個名稱，比方說代表某個可能的輸入檔案時，絕不使用好理解的任意命名，比方說  _"Charlie.dat"_ 或 _"Frodo.txt"_。基本上，在文件的範例裡，名稱越像保留關鍵字越好。比方說，你可以將變數或者參數命名為 `bank`，`blank`，`class`，`const`，`constant`，`input`，`key`，`keyword`，`kind`，`output`，`parameter`，`parm`，`system`，`type`，`value`，`var` 和 `variable`。

如果你使用該語言真正的保留關鍵字，也就是該段範例碼如果嘗試編譯或運作會出錯的話，那就更好了。做得好的話，可以讓之後的用戶完全搞不懂哪段是程式需要的保留字，哪些又是你設定的名稱。如果有人問起，你可以無辜的看著他，宣稱這是為了幫助大家更好地理解這些變數的意義。

#### 程式碼內名稱絕不和畫面名稱相同

選擇和程式畫面上對應的資料一點關係都沒有的名稱來命名你的變數。比方說，畫面顯示「郵遞區號（Postal Code）」的資料，程式碼內對應的變數是 `zip`。

#### 絕不改名

與其要到處找名稱不同的地方修改讓兩個功能合併，不如用多個 TYPEDEF 來同步程式。

#### 如何隱藏被禁止的全域變數

因為全域變數是「邪惡的」，所以我們改用一個
Since global variables are "evil", define a structure to hold all the things you'd put in globals. Call it something clever like `EverythingYoullEverNeed`. Make all functions take a pointer to this structure (call it `handle` to confuse things more). This gives the impression that you're not using global variables, you're accessing everything through a "handle". Then declare one statically so that all the code is using the same copy anyway.

#### Hide Instances With Synonyms

Maintenance programmers, in order to see if they'll be any cascading effects to a change they make, do a global search for the variables named. This can be defeated by this simple expedient of having synonyms, such as

```c
#define xxx global_var // in file std.h
#define xy_z xxx // in file ..\other\substd.h
#define local_var xy_z // in file ..\codestd\inst.h
```

These defs should be scattered through different include-files. They are especially effective if the include-files are located in different directories. The other technique is to reuse a name in every scope. The compiler can tell them apart, but a simple minded text searcher cannot. Unfortunately SCIDs in the coming decade will make this simple technique impossible. since the editor understands the scope rules just as well as the compiler.

#### 長又相似的變數名稱

Use very long variable names or class names that differ from each other by only one character, or only in upper/lower case. An ideal variable name pair is `swimmer` and `swimner`. Exploit the failure of most fonts to clearly discriminate between `ilI1|` or `oO08` with identifier pairs like `parselnt` and `parseInt` or `D0Calc` and `DOCalc`. `l` is an exceptionally fine choice for a variable name since it will, to the casual glance, masquerade as the constant `1`. In many fonts rn looks like an m. So how about a variable `swirnrner`. Create variable names that differ from each other only in case e.g. `HashTable` and `Hashtable`.

#### 唸起來相似或看起來相似的變數名稱

Variables that resemble others except for capitalization and underlines have the advantage of confounding those who like remembering names by sound or letter-spelling, rather than by exact representations.

#### Overload and Bewilder

In C++, overload library functions by using `#define`. That way it looks like you are using a familiar library function where in actuality you are using something totally different.

#### Choosing The Best Overload Operator

In C++, overload `+`, `-`, `*`, and `/` to do things totally unrelated to addition, subtraction etc. After all, if the Stroustroup can use the shift operator to do I/O, why should you not be equally creative? If you overload `+`, make sure you do it in a way that `i = i + 5;` has a totally different meaning from `i += 5;`. Here is an example of elevating overloading operator obfuscation to a high art. Overload the `!` operator for a class, but have the overload have nothing to do with inverting or negating. Make it return an integer. Then, in order to get a logical value for it, you must use `! !`. However, this inverts the logic, so [drum roll] you must use `! ! !`. Don't confuse the `!` operator, which returns a boolean 0 or 1, with the `~` bitwise logical negation operator.

#### Overload new

Overload the `new` operator - much more dangerous than overloading the `+-/*`. This can cause total havoc if overloaded to do something different from its original function (but vital to the object's function so it's very difficult to change). This should ensure users trying to create a dynamic instance get really stumped. You can combine this with the case sensitivity trick also have a member function, and variable called "New".

#### #define

`#define` in C++ deserves an entire essay on its own to explore its rich possibilities for obfuscation. Use lower case `#define` variables so they masquerade as ordinary variables. Never use parameters to your preprocessor functions. Do everything with global `#defines`. One of the most imaginative uses of the preprocessor I have heard of was requiring five passes through CPP before the code was ready to compile. Through clever use of `defines` and `ifdefs`, a master of obfuscation can make header files declare different things depending on how many times they are included. This becomes especially interesting when one header is included in another header. Here is a particularly devious example:

```cpp
#ifndef DONE

#ifdef TWICE

// put stuff here to declare 3rd time around
void g(char* str);
#define DONE

#else // TWICE
#ifdef ONCE

// put stuff here to declare 2nd time around
void g(void* str);
#define TWICE

#else // ONCE

// put stuff here to declare 1st time around
void g(std::string str);
#define ONCE

#endif // ONCE
#endif // TWICE
#endif // DONE
```

This one gets fun when passing `g()` a `char*`, because a different version of `g()` will be called depending on how many times the header was included.

#### Compiler Directives

Compiler directives were designed with the express purpose of making the same code behave completely differently. Turn the boolean short-circuiting directive on and off repeatedly and vigourously, as well as the long strings directive.

## 文件

> _Any fool can tell the truth, but it requires a man of some sense to know how to lie well._ - Samuel Butler (1835 - 1902)

> _Incorrect documentation is often worse than no documentation._ - Bertrand Meyer

Since the computer ignores comments and documentation, you can lie outrageously and do everything in your power to befuddle the poor maintenance programmer.

#### 在註解裡說謊

你不需要特別做什麼，只要不維護註解，隨著程式碼改變，註解自然而然就會說謊了。

#### 為顯而易見的東西寫文件

在程式碼裡散佈像是 `/* i 加上 1*/` 這樣的註解。不過絕對不對這段程式碼實際在做什麼這種模糊的事加上註解。

#### 紀錄怎麼做的，而不是為什麼這麼做

只紀錄程式碼做了什麼事情的細節，但是不描述這段程式碼的功能。這樣一來，如果出錯，負責改的人完全不知道這段程式應該要做什麼事情。

#### 避免為了「顯而易見」的東西寫文件

假如你在為一個飛機定位系統撰寫文件。確保假設加入一條新的航線，程式碼至少要改 25 個地方以上。確定沒有文件如果加入航線到底要注意哪些地方。後面的維護者沒有看過你的每一行程式之前，完全沒有辦法更新任何商業流程。

#### On the Proper Use Of Documentation Templates

Consider function documentation prototypes used to allow automated documentation of the code. These prototypes should be copied from one function (or method or class) to another, but never fill in the fields. If for some reason you are forced to fill in the fields make sure that all parameters are named the same for all functions, and all cautions are the same but of course not related to the current function at all.

####  設計文件的正確用法

實作一個非常複雜的演算法時，參照傳統軟體開發的原則，先想出完整設計過後，再開始寫程式。針對該演算法的每一步驟寫出非常詳細的文件，文件詳細程度越高越好。

文件要將整個演算法拆解成詳細的結構化步驟，每個段落解釋一個步驟內的實作方式。拆分的詳細程度至少要達到五層標題。
In fact, the design doc should break the algorithm down into a hierarchy of structured steps, described in a hierarchy of auto-numbered individual paragraphs in the document. Use headings at least 5 deep. Make sure that when you are done, you have broken the structure down so completely that there are over 500 such auto-numbered paragraphs. For example, one paragraph might be(this is a real example)

1.2.4.6.3.13 - 選擇的緩解方式

Display all impacts for activity where selected mitigations can apply (short pseudocode omitted).

**然後**⋯⋯ （精彩的部分來了）當你寫程式碼時，針對每個段落，你對應的函式名稱為：

```c
Act1_2_4_6_3_13()
```

函式本身不用再註解了，畢竟設計文件已經寫過了！

Since the design doc is auto-numbered, it will be extremely difficult to keep it up to date with changes in the code (because the function names, of course, are static, not auto-numbered.) This isn't a problem for you because you will not try to keep the document up to date. In fact, do everything you can to destroy all traces of the document.

Those who come after you should only be able to find one or two contradictory, early drafts of the design document hidden on some dusty shelving in the back room near the dead 286 computers.

#### Units of Measure

Never document the units of measure of any variable, input, output or parameter. e.g. feet, metres, cartons. This is not so important in bean counting, but it is very important in engineering work. As a corollary, never document the units of measure of any conversion constants, or how the values were derived. It is mild cheating, but very effective, to salt the code with some incorrect units of measure in the comments. If you are feeling particularly malicious, make up your **own** unit of measure; name it after yourself or some obscure person and never define it. If somebody challenges you, tell them you did so that you could use integer rather than floating point arithmetic.

#### 抓到了

Never document gotchas in the code. If you suspect there may be a bug in a class, keep it to yourself. If you have ideas about how the code should be reorganised or rewritten, for heaven's sake, do not write them down. Remember the words of Thumper in the movie Bambi, _"If you can't say anything nice, don't say anything at all"_? What if the programmer who wrote that code saw your comments? What if the owner of the company saw them? What if a customer did? You could get yourself fired. An anonymous comment that says "This needs to be fixed!" can do wonders, especially if it's not clear what the comment refers to. Keep it vague, and nobody will feel personally criticised.

#### 用文件紀錄變數

**Never** put a comment on a variable declaration. Facts about how the variable is used, its bounds, its legal values, its implied/displayed number of decimal points, its units of measure, its display format, its data entry rules (e.g. total fill, must enter), when its value can be trusted etc. should be gleaned from the procedural code. If your boss forces you to write comments, lard method bodies with them, but never comment a variable declaration, not even a temporary!

#### Disparage In the Comments

Discourage any attempt to use external maintenance contractors by peppering your code with insulting references to other leading software companies, especial anyone who might be contracted to do the work. e.g.:

```c
/* The optimised inner loop.
This stuff is too clever for the dullard at Software Services Inc., who would
probably use 50 times as memory & time using the dumb routines in <math.h>.
*/
class clever_SSInc
    {
    .. .
    }
```

If possible, put insulting stuff in syntactically significant parts of the code, as well as just the comments so that management will probably break the code if they try to sanitise it before sending it out for maintenance.

#### COMMENT AS IF IT WERE CØBØL ON PUNCH CARDS

Always refuse to accept advances in the development environment arena, especially SCIDs. Disbelieve rumors that all function and variable declarations are never more than one click away and always assume that code developed in Visual Studio 6.0 will be maintained by someone using edlin or vi. Insist on Draconian commenting rules to bury the source code proper.

#### Monty Python 式註解

在 makeSnafucated() 函式前面，加上註解 `/* 做 snafucated */`。**絕不**定義 _snafucated_ 到底是什麼意思。Only a fool does not already know, with complete certainty, what _snafucated_ means. For classic examples of this technique, consult the Sun AWT JavaDOC.

## 程式設計

> _The cardinal rule of writing unmaintainable code is to specify each fact in as many places as possible and in as many ways as possible._ - Roedy Green

The key to writing maintainable code is to specify each fact about the application in only one place. To change your mind, you need change it in only one place, and you are guaranteed the entire program will still work. Therefore, the key to writing unmaintainable code is to specify a fact over and over, in as many places as possible, in as many variant ways as possible. Happily, languages like Java go out of their way to make writing this sort of unmaintainable code easy. For example, it is almost impossible to change the type of a widely used variable because all the casts and conversion functions will no longer work, and the types of the associated temporary variables will no longer be appropriate. Further, if the variable is displayed on the screen, all the associated display and data entry code has to be tracked down and manually modified. The Algol family of languages which include C and Java treat storing data in an array, Hashtable, flat file and database with **totally** different syntax. In languages like Abundance, and to some extent Smalltalk, the syntax is identical; just the declaration changes. Take advantage of Java's ineptitude. Put data you know will grow too large for RAM, for now into an array. That way the maintenance programmer will have a horrendous task converting from array to file access later. Similarly place tiny files in databases so the maintenance programmer can have the fun of converting them to array access when it comes time to performance tune.

#### Java Casts

Java's casting scheme is a gift from the Gods. You can use it without guilt since the language requires it. Every time you retrieve an object from a Collection you must cast it back to its original type. Thus the type of the variable may be specified in dozens of places. If the type later changes, all the casts must be changed to match. The compiler may or may not detect if the hapless maintenance programmer fails to catch them all (or changes one too many). In a similar way, all matching casts to `(short)` need to be changed to `(int)` if the type of a variable changes from `short` to `int`. There is a movement afoot in invent a generic cast operator `(cast)` and a generic conversion operator `(convert)` that would require no maintenance when the type of variable changes. Make sure this heresy never makes it into the language specification. Vote no on RFE 114691 and on genericity which would eliminate the need for many casts.

#### Exploit Java's Redundancy

Java insists you specify the type of every variable twice. Java programmers are so used to this redundancy they won't notice if you make the two types slightly different, as in this example:

```java
Bubblegum b = new Bubblegom();
```

Unfortunately the popularity of the ++ operator makes it harder to get away with pseudo-redundant code like this:

```java
swimmer = swimner + 1;
```

#### 從不驗證

絕不檢查輸入的格式是否正確或者有差異。這表示了你絕對相信公司，也代表你是團隊的好成員，絕對相信團隊的所有夥伴和用戶。即使輸入的資料看起來很奇怪或有錯，總是輸出看起來有道理的回傳值。

#### 有禮貌，從不斷言

避免使用 `assert()`  功能。他可能使本來需要三天的除錯工作變成十分鐘搞定。

#### 避免封裝

In the interests of efficiency, avoid encapsulation. Callers of a method need all the external clues they can get to remind them how the method works inside.

#### Clone & Modify

以效率的名義，剪貼別人的程式碼然後修改。這樣比起寫很多小的，可重複使用的模組要快很多。這個技巧在以程式碼行數判斷工程師效率的公司裡面特別有效。

#### 使用靜態陣列

If a module in a library needs an array to hold an image, just define a static array. Nobody will ever have an image bigger than 512 x 512, so a fixed-size array is OK. For best precision, make it an array of doubles. Bonus effect for hiding a 2 Meg static array which causes the program to exceed the memory of the client's machine and thrash like crazy even if they never use your routine.

#### Dummy Interfaces

Write an empty interface called something like `WrittenByMe`, and make all of your classes implement it. Then, write wrapper classes for any of Java's built-in classes that you use. The idea is to make sure that every single object in your program implements this interface. Finally, write all methods so that both their arguments and return types are `WrittenByMe`. This makes it nearly impossible to figure out what some methods do, and introduces all sorts of entertaining casting requirements. For a further extension, have each team member have his/her own personal interface (e.g., `WrittenByJoe`); any class worked on by a programmer gets to implement his/her interface. You can then arbitrarily refer to objects by any one of a large number of meaningless interfaces!

#### 肥大的 Listener

Never create separate Listeners for each Component. Always have one listener for every button in your project and simply use massive if...else statements to test for which button was pressed.

#### Too Much Of A Good Thing<sup>TM</sup>

Go wild with encapsulation and oo. For example:

```java
myPanel.add( getMyButton() );
private JButton getMyButton()
    {
    return myButton;
    }
```

That one probably did not even seem funny. Don't worry. It will some day.

#### Friendly Friend

Use as often as possible the friend-declaration in C++. Combine this with handing the pointer of the creating class to a created class. Now you don't need to fritter away your time in thinking about interfaces. Additionally you should use the keywords _private_ and _protected_ to prove that your classes are well encapsulated.

#### 使用三維陣列 

Lots of them. Move data between the arrays in convoluted ways, say, filling the columns in `arrayB` with the rows from `arrayA`. Doing it with an offset of 1, for no apparent reason, is a nice touch. Makes the maintenance programmer nervous.

#### Mix and Match

Use both accessor methods and public variables. That way, you can change an object's variable without the overhead of calling the accessor, but still claim that the class is a "Java Bean". This has the additional advantage of frustrating the maintenence programmer who adds a logging function to try to figure out who is changing the value.

#### 包裝，包裝，再包裝

Whenever you have to use methods in code you did not write, insulate your code from that other _dirty_ code by at least one layer of wrapper. After all, the other author **might** some time in the future recklessly rename every method. Then where would you be? You could of course, if he did such a thing, insulate your code from the changes by writing a wrapper or you could let VAJ handle the global rename. However, this is the perfect excuse to preemptively cut him off at the pass with a wrapper layer of indirection, **before** he does anything idiotic. One of Java's main faults is that there is no way to solve many simple problems without dummy wrapper methods that do nothing but call another method of the same name, or a closely related name. This means it is possible to write wrappers four-levels deep that do absolutely nothing, and almost no one will notice. To maximise the obscuration, at each level, rename the methods, selecting random synonyms from a thesaurus. This gives the illusion something of note is happening. Further, the renaming helps ensure the lack of consistent project terminology. To ensure no one attempts to prune your levels back to a reasonable number, invoke some of your code bypassing the wrappers at each of the levels.

#### 繼續包裝包裝再包裝

Make sure all API functions are wrapped at least 6-8 times, with function definitions in separate source files. Using `#defines` to make handy shortcuts to these functions also helps.

#### 沒有秘密！

Declare every method and variable `public`. After all, somebody, sometime might want to use it. Once a method has been declared public, it can't very well be retracted, now can it? This makes it very difficult to later change the way anything works under the covers. It also has the delightful side effect of obscuring what a class is for. If the boss asks if you are out of your mind, tell him you are following the classic principles of transparent interfaces.

#### The Kama Sutra

This technique has the added advantage of driving any users or documenters of the package to distraction as well as the maintenance programmers. Create a dozen overloaded variants of the same method that differ in only the most minute detail. I think it was Oscar Wilde who observed that positions 47 and 115 of the Kama Sutra were the same except in 115 the woman had her fingers crossed. Users of the package then have to carefully peruse the long list of methods to figure out just which variant to use. The technique also balloons the documentation and thus ensures it will more likely be out of date. If the boss asks why you are doing this, explain it is solely for the convenience of the users. Again for the full effect, clone any common logic and sit back and wait for the copies to gradually get out of sync.

#### Permute and Baffle

Reverse the parameters on a method called `drawRectangle(height, width)` to `drawRectangle(width, height)` without making any change whatsoever to the name of the method. Then a few releases later, reverse it back again. The maintenance programmers can't tell by quickly looking at any call if it has been adjusted yet. Generalisations are left as an exercise for the reader.

#### Theme and Variations

Instead of using a parameter to a single method, create as many separate methods as you can. For example instead of `setAlignment(int alignment)` where `alignment` is an enumerated constant, for left, right, center, create three methods `setLeftAlignment`, `setRightAlignment`, and `setCenterAlignment`. Of course, for the full effect, you must clone the common logic to make it hard to keep in sync.

#### 靜態就是好

Make as many of your variables as possible static. If _you_ don't need more than one instance of the class in this program, no one else ever will either. Again, if other coders in the project complain, tell them about the execution speed improvement you're getting.

#### Cargill's Quandry

Take advantage of Cargill's quandary (I think this was his) "any design problem can be solved by adding an additional level of indirection, except for too many levels of indirection." Decompose OO programs until it becomes nearly impossible to find a method which actually updates program state. Better yet, arrange all such occurrences to be activated as callbacks from by traversing pointer forests which are known to contain every function pointer used within the entire system. Arrange for the forest traversals to be activated as side-effects from releasing reference counted objects previously created via deep copies which aren't really all that deep.

#### Packratting

Keep all of your unused and outdated methods and variables around in your code. After all - if you needed to use it once in 1976, who knows if you will want to use it again sometime? Sure the program's changed since then, but it might just as easily change back, you "don't want to have to reinvent the wheel" (supervisors love talk like that). If you have left the comments on those methods and variables untouched, and sufficiently cryptic, anyone maintaining the code will be too scared to touch them.

#### And That's Final

Make all of your leaf classes final. After all, _you're_ done with the project - certainly no one else could possibly improve on your work by extending your classes. And it might even be a security flaw - after all, isn't java.lang.String final for just this reason? If other coders in your project complain, tell them about the execution speed improvement you're getting.

#### Eschew The Interface

In Java, disdain the interface. If your supervisors complain, tell them that Java interfaces force you to "cut-and-paste" code between different classes that implement the same interface the same way, and they know how hard that would be to maintain. Instead, do as the Java AWT designers did - put lots of functionality in your classes that can only be used by classes that inherit from them, and use lots of "instanceof" checks in your methods. This way, if someone wants to reuse your code, they have to extend your classes. If they want to reuse your code from two different classes - tough luck, they can't extend both of them at once! If an interface is unavoidable, make an all-purpose one and name it something like `ImplementableIface`. Another gem from academia is to append "Impl" to the names of classes that implement interfaces. This can be used to great advantage, e.g. with classes that implement `Runnable`.

#### Avoid Layouts

Never use layouts. That way when the maintenance programmer adds one more field he will have to manually adjust the absolute co-ordinates of every other thing displayed on the screen. If your boss forces you to use a layout, use a single giant `GridBagLayout`, and hard code in absolute grid co-ordinates.

#### 環境變數

If you have to write classes for some other programmer to use, put environment-checking code (`getenv()` in C++ / `System.getProperty()` in Java) in your classes' nameless static initializers, and pass all your arguments to the classes this way, rather than in the constructor methods. The advantage is that the initializer methods get called as soon as the class program binaries get loaded, even before any of the classes get instantiated, so they will usually get executed before the program `main()`. In other words, there will be no way for the rest of the program to modify these parameters before they get read into your classes - the users better have set up all their environment variables just the way you had them!

#### Table Driven Logic

Eschew any form of table-driven logic. It starts out innocently enough, but soon leads to end users proofreading and then _shudder_, even modifying the tables for themselves.

#### Modify Mom's Fields

In Java, all primitives passed as parameters are effectively read-only because they are passed by value. The callee can modify the parameters, but that has no effect on the caller's variables. In contrast all objects passed are read-write. The reference is passed by value, which means the object itself is effectively passed by reference. The callee can do whatever it wants to the fields in your object. Never document whether a method actually modifies the fields in each of the passed parameters. Name your methods to suggest they only look at the fields when they actually change them.

#### 全域變數的魔法

Instead of using exceptions to handle error processing, have your error message routine set a global variable. Then make sure that every long-running loop in the system checks this global flag and terminates if an error occurs. Add another global variable to signal when a user presses the 'reset' button. Of course all the major loops in the system also have to check this second flag. Hide a few loops that **don't** terminate on demand.

#### 全域變數，再來一次！

If God didn't want us to use global variables, he wouldn't have invented them. Rather than disappoint God, use and set as many global variables as possible. Each function should use and set at least two of them, even if there's no reason to do this. After all, any good maintenance programmer will soon figure out this is an exercise in detective work, and she'll be happy for the exercise that separates real maintenance programmers from the dabblers.

#### 全域變數，最後一次！

Global variables save you from having to specify arguments in functions. Take full advantage of this. Elect one or more of these global variables to specify what kinds of processes to do on the others. Maintenance programmers foolishly assume that C functions will not have side effects. Make sure they squirrel results and internal state information away in global variables.

#### 副作用

在 C 裡面，所有的函式都應該是 idempotent（沒有任何副作用）。我希望這邊的提示已經夠了。

#### Backing Out

Within the body of a loop, assume that the loop action is successful and immediately update all pointer variables. If an exception is later detected on that loop action, back out the pointer advancements as side effects of a conditional expression following the loop body.

#### Local Variables

Never use local variables. Whenever you feel the temptation to use one, make it into an instance or static variable instead to unselfishly share it with all the other methods of the class. This will save you work later when other methods need similar declarations. C++ programmers can go a step further by making all variables global.

#### Configuration Files

These usually have the form keyword=value. The values are loaded into Java variables at load time. The most obvious obfuscation technique is to use slightly different names for the keywords and the Java variables. Use configuration files even for constants that never change at run time. Parameter file variables require at least five times as much code to maintain as a simple variable would.

#### Bloated classes

To ensure your classes are bounded in the most obtuse way possible, make sure you include peripheral, obscure methods and attributes in every class. For example, a class that defines astrophysical orbit geometry really should have a method that computes ocean tide schedules and attributes that comprise a Crane weather model. Not only does this over-define the class, it makes finding these methods in the general system code like looking for a guitar pick in a landfill.

#### 沈溺在 Subclass 中

Object oriented programming is a godsend for writing unmaintainable code. If you have a class with 10 properties (member/method) in it, consider a base class with only one property and subclassing it 9 levels deep so that each descendant adds one property. By the time you get to the last descendant class, you'll have all 10 properties. If possible, put each class declaration in a separate file. This has the added effect of bloating your `INCLUDE` or `USES` statements, and forces the maintainer to open that many more files in his or her editor. Make sure you create at least one instance of each subclass.

## 混淆程式碼

> _Sedulously eschew obfuscatory hyperverbosity and prolixity._

#### Obfuscated C

Follow the obfuscated C contests on the Internet and sit at the lotus feet of the masters.

#### Find a Forth or APL Guru

In those worlds, the terser your code and the more bizarre the way it works, the more you are revered.

#### I'll Take a Dozen

Never use one housekeeping variable when you could just as easily use two or three.

#### Jude the Obscure

Always look for the most obscure way to do common tasks. For example, instead of using arrays to convert an integer to the corresponding string, use code like this:

```c
char *p;
switch (n)
{
case 1:
    p = "one";
    if (0)
case 2:
    p = "two";
    if (0)
case 3:
    p = "three";
    printf("%s", p);
    break;
}
```

#### Foolish Consistency Is the Hobgoblin of Little Minds

When you need a character constant, use many different formats `' '`, `32`, `0x20`, `040`. Make liberal use of the fact that `10` and `010` are not the same number in C or Java.

#### 型態轉換

Pass all data as a `void *` and then typecast to the appropriate structure. Using byte offsets into the data instead of structure casting is fun too.

#### 巢狀 Switch 結構

(a switch within a switch) is the most difficult type of nesting for the human mind to unravel.

#### Exploit Implicit Conversion

Memorize all of the subtle implicit conversion rules in the programming language. Take full advantage of them. Never use a picture variable (in COBOL or PL/I) or a general conversion routine (such as `sprintf` in C). Be sure to use floating-point variables as indexes into arrays, characters as loop counters, and perform string functions on numbers. After all, all of these operations are well-defined and will only add to the terseness of your source code. Any maintainer who tries to understand them will be very grateful to you because they will have to read and learn the entire chapter on implicit data type conversion; a chapter that they probably had completely overlooked before working on your programs.

#### Raw ints

When using ComboBoxes, use a switch statement with integer cases rather than named constants for the possible values.

#### 分號！

Always use semicolons whenever they are syntactically allowed. For example:

```java
if(a);
else;
{
int d;
d = c;
}
;
```

#### 使用八進位

Smuggle octal literals into a list of decimal numbers like this:

```java
array = new int []
{
111,
120,
013,
121,
};
```

#### Convert Indirectly

Java offers great opportunity for obfuscation whenever you have to convert. As a simple example, if you have to convert a double to a String, go circuitously, via Double with `new Double(d).toString()` rather than the more direct `Double.toString(d)`. You can, of course, be far more circuitous than that! Avoid any conversion techniques recommended by the Conversion Amanuensis. You get bonus points for every extra temporary object you leave littering the heap after your conversion.

#### 巢狀結構

Nest as deeply as you can. Good coders can get up to 10 levels of `( )` on a single line and 20 `{ }` in a single method. C++ coders have the additional powerful option of preprocessor nesting totally independent of the nest structure of the underlying code. You earn extra Brownie points whenever the beginning and end of a block appear on separate pages in a printed listing. Wherever possible, convert nested ifs into nested [?:] ternaries. If they span several lines, so much the better.

#### Numeric Literals

If you have an array with 100 elements in it, hard code the literal 100 in as many places in the program as possible. Never use a static final named constant for the 100, or refer to it as `myArray.length`. To make changing this constant even more difficult, use the literal 50 instead of 100/2, or 99 instead of 100-1. You can futher disguise the 100 by checking for `a == 101` instead of `a > 100`, or `a > 99` instead of `a >= 100`.
Consider things like page sizes, where the lines consisting of x header, y body, and z footer lines, you can apply the obfuscations independently to each of these and to their partial or total sums.

These time-honoured techniques are especially effective in a program with two unrelated arrays that just accidentally happen to both have 100 elements. If the maintenance programmer has to change the length of one of them, he will have to decipher every use of the literal 100 in the program to determine which array it applies to. He is almost sure to make at least one error, hopefully one that won't show up for years later.

There are even more fiendish variants. To lull the maintenance programmer into a false sense of security, dutifully create the named constant, but very occasionally "accidentally" use the literal 100 value instead of the named constant. Most fiendish of all, in place of the literal 100 or the correct named constant, sporadically use some other unrelated named constant that just accidentally happens to have the value 100, for now. It almost goes without saying that you should avoid any consistent naming scheme that would associate an array name with its size constant.

#### C's Eccentric View Of Arrays

C compilers transform `myArray[i]` into `*(myArray + i)`, which is equivalent to `*(i + myArray)` which is equivalent to `i[myArray]`. Experts know to put this to good use. To really disguise things, generate the index with a function:

```c
int myfunc(int q, int p) { return p%q; }
// ...
myfunc(6291, 8)[Array];
```

Unfortunately, these techniques can only be used in native C classes, not Java.

#### 超 長 一 行

Try to pack as much as possible into a single line. This saves the overhead of temporary variables, and makes source files shorter by eliminating new line characters and white space. Tip: remove all white space around operators. Good programmers can often hit the 255 character line length limit imposed by some editors. The bonus of long lines is that programmers who cannot read 6 point type must scroll to view them.

#### 例外

I am going to let you in on a little-known coding secret. Exceptions are a pain in the behind. Properly-written code never fails, so exceptions are actually unnecessary. Don't waste time on them. Subclassing exceptions is for incompetents who know their code will fail. You can greatly simplify your program by having only a single try/catch in the entire application (in main) that calls System.exit(). Just stick a perfectly standard set of throws on every method header whether they could actually throw any exceptions or not.

#### 何時使用例外

Use exceptions for non-exceptional conditions. Routinely terminate loops with an `ArrayIndexOutOfBoundsException`. Pass return standard results from a method in an exception.

#### 沈溺在使用線程（thread）內

標題說明一切。

#### 律師程式碼

Follow the language lawyer discussions in the newsgroups about what various bits of tricky code should do e.g. `a=a++;` or `f(a++,a++);` then sprinkle your code liberally with the examples. In C, the effects of pre/post decrement code such as

```c
*++b ? (*++b + *(b-1)) : 0
```

are not defined by the language spec. Every compiler is free to evaluate in a different order. This makes them doubly deadly. Similarly, take advantage of the complex tokenising rules of C and Java by removing all spaces.

#### 提早回傳

Rigidly follow the guidelines about no goto, no early returns, and no labelled breaks especially when you can increase the if/else nesting depth by at least 5 levels.

#### 避免大括號

Never put in any `{ }` surrounding your if/else blocks unless they are syntactically obligatory. If you have a deeply nested mixture of if/else statements and blocks, especially with misleading indentation, you can trip up even an expert maintenance programmer. For best results with this technique, use Perl. You can pepper the code with additional ifs _after_ the statements, to amazing effect.

#### 來自地獄的 Tabs

Never underestimate how much havoc you can create by indenting with tabs instead of spaces, especially when there is no corporate standard on how much indenting a tab represents. Embed tabs inside string literals, or use a tool to convert spaces to tabs that will do that for you.

#### Magic Matrix Locations

Use special values in certain matrix locations as flags. A good choice is the `[3][0]` element in a transformation matrix used with a homogeneous coordinate system.

#### Magic Array Slots revisited

If you need several variables of a given type, just define an array of them, then access them by number. Pick a numbering convention that only you know and don't document it. And don't bother to define `#define` constants for the indexes. Everybody should just know that the global variable `widget[15]` is the cancel button. This is just an up-to-date variant on using absolute numerical addresses in assembler code.

#### Never Beautify

Never use an automated source code tidier (beautifier) to keep your code aligned. Lobby to have them banned them from your company on the grounds they create false deltas in PVCS/CVS (version control tracking) or that every programmer should have his own indenting style held forever sacrosanct for any module he wrote. Insist that other programmers observe those idiosyncratic conventions in "his " modules. Banning beautifiers is quite easy, even though they save the millions of keystrokes doing manual alignment and days wasted misinterpreting poorly aligned code. Just insist that everyone use the **same** tidied format, not just for storing in the common repository, but also while they are editing. This starts an RWAR and the boss, to keep the peace, will ban automated tidying. Without automated tidying, you are now free to _accidentally_ misalign the code to give the optical illusion that bodies of loops and ifs are longer or shorter than they really are, or that else clauses match a different if than they really do. e.g.

```c
if(a)
  if(b) x=y;
else x=z;
```

#### The Macro Preprocessor

It offers great opportunities for obfuscation. The key technique is to nest macro expansions several layers deep so that you have to discover all the various parts in many different *.hpp files. Placing executable code into macros then including those macros in every *.cpp file (even those that never use those macros) will maximize the amount of recompilation necessary if ever that code changes.

#### Exploit Schizophrenia

Java is schizophrenic about array declarations. You can do them the old C, way `String x[]`, (which uses mixed pre-postfix notation) or the new way `String[] x`, which uses pure prefix notation. If you want to really confuse people, mix the notationse.g.

```java
byte[ ] rowvector, colvector , matrix[ ];
```

which is equivalent to:

```java
byte[ ] rowvector;
byte[ ] colvector;
byte[ ][] matrix;
```

#### Hide Error Recovery Code

Use nesting to put the error recovery for a function call as far as possible away from the call. This simple example can be elaborated to 10 or 12 levels of nest:

```javascript
if ( function_A() == OK )
    {
    if ( function_B() == OK )
        {
        /* Normal completion stuff */
        }
    else
        {
        /* some error recovery for Function_B */
        }
    }
    else
        {
        /* some error recovery for Function_A */
        }
```

#### Pseudo C

The real reason for `#define` was to help programmers who are familiar with another programming language to switch to C. Maybe you will find declarations like `#define begin {` or `#define end }` useful to write more interesting code.

#### Confounding Imports

Keep the maintenance programmer guessing about what packages the methods you are using are in. Instead of:

```java
import MyPackage.Read;
import MyPackage.Write;
```

use:

```java
import Mypackage.*;
```

Never fully qualify any method or class no matter how obscure. Let the maintenance programmer guess which of the packages/classes it belongs to. Of course, inconsistency in when you fully qualify and how you do your imports helps most.

#### 通馬桶

Never under any circumstances allow the code from more than one function or procedure to appear on the screen at once. To achieve this with short routines, use the following handy tricks:
Blank lines are generally used to separate logical blocks of code. Each line is a logical block in and of itself. Put blank lines between each line.
Never comment your code at the end of a line. Put it on the line above. If you're forced to comment at the end of the line, pick the longest line of code in the entire file, add 10 spaces, and left-align all end-of-line comments to that column.

Comments at the top of procedures should use templates that are at least 15 lines long and make liberal use of blank lines. Here's a handy template:

```java
/*
/* Procedure Name:
/*
/* Original procedure name:
/*
/* Author:
/*
/* Date of creation:
/*
/* Dates of modification:
/*
/* Modification authors:
/*
/* Original file name:
/*
/* Purpose:
/*
/* Intent:
/*
/* Designation:
/*
/* Classes used:
/*
/* Constants:
/*
/* Local variables:
/*
/* Parameters:
/*
/* Date of creation:
/*
/* Purpose:
*/
```

The technique of putting so much redundant information in documentation almost guarantees it will soon go out of date, and will help befuddle maintenance programmers foolish enough to trust it.

## 測試

> _I don't need to test my programs. I have an error-correcting modem._
> - Om I. Baud

Leaving bugs in your programs gives the maintenance programmer who comes along later something interesting to do. A well done bug should leave absolutely no clue as to when it was introduced or where. The laziest way to accomplish this is simply never to test your code.

#### 絕不測試

Never test any code that handles the error cases, machine crashes, or OS glitches. Never check return codes from the OS. That code never gets executed anyway and slows down your test times. Besides, how can you possibly test your code to handle disk errors, file read errors, OS crashes, and all those sorts of events? Why, you would have to have either an incredibly unreliable computer or a test scaffold that mimicked such a thing. Modern hardware never fails, and who wants to write code just for testing purposes? It isn't any fun. If users complain, just blame the OS or hardware. They'll never know.

#### 絕對絕對不做效能測試

Hey, if it isn't fast enough, just tell the customer to buy a faster machine. If you did do performance testing, you might find a bottleneck, which might lead to algorithm changes, which might lead to a complete redesign of your product. Who wants that? Besides, performance problems that crop up at the customer site mean a free trip for you to some exotic location. Just keep your shots up-to-date and your passport handy.

#### 不寫測試條件

Never perform code coverage or path coverage testing. Automated testing is for wimps. Figure out which features account for 90% of the uses of your routines, and allocate 90% of the tests to those paths. After all, this technique probably tests only about 60% of your source code, and you have just saved yourself 40% of the test effort. This can help you make up the schedule on the back-end of the project. You'll be long gone by the time anyone notices that all those nice "marketing features" don't work. The big, famous software companies test code this way; so should you. And if for some reason, you are still around, see the next item.

#### 測試是懦夫的行為

A brave coder will bypass that step. Too many programmers are afraid of their boss, afraid of losing their job, afraid of customer hate mail and afraid of being sued. This fear paralyzes action, and reduces productivity. Studies have shown that eliminating the test phase means that managers can set ship dates well in advance, an obvious aid in the planning process. With fear gone, innovation and experimentation can blossom. The role of the programmer is to produce code, and debugging can be done by a cooperative effort on the part of the help desk and the legacy maintenance group.
If we have full confidence in our coding ability, then testing will be unnecessary. If we look at this logically, then any fool can recognise that testing does not even attempt to solve a technical problem, rather, this is a problem of emotional confidence. A more efficient solution to this lack of confidence issue is to eliminate testing completely and send our programmers to self-esteem courses. After all, if we choose to do testing, then we have to test every program change, but we only need to send the programmers to one course on building self-esteem. The cost benefit is as amazing as it is obvious.

#### 保證程式只在 debug mode 下才會正確

If you've defined TESTING as 1

```c
#define TESTING 1
```

this gives you the wonderful opportunity to have separate code sections, such as

```c
#if TESTING==1
#endif
```

which can contain such indispensable tidbits as

```c
x = rt_val;
```

so that if anyone resets TESTING to 0, the program won't work. And with the tiniest bit of imaginative work, it will not only befuddle the logic, but confound the compiler as well.

## 語言選擇

> _Philosophy is a battle against the bewitchment of our intelligence by means of language._
> - Ludwig Wittgenstein

Computer languages are gradually evolving to become more fool proof. Using state of the art languages is unmanly. Insist on using the oldest language you can get away with, octal machine language if you can (Like Hans und Frans, I am no girlie man; I am so virile I used to code by plugging gold tipped wires into a plugboard of IBM unit record equipment (punch cards), or by poking holes in paper tape with a hand punch), failing that assembler, failing that FORTRAN or COBOL, failing that C, and BASIC, failing that C++.

#### FØRTRAN

Write all your code in FORTRAN. If your boss ask why, you can reply that there are lots of very useful libraries that you can use thus saving time. However the chances of writing maintainable code in FORTRAN are zero, and therefore following the unmaintainable coding guidelines is a lot easier.

#### 避免 Ada

About 20% of these techniques can't be used in Ada. Refuse to use Ada. If your manager presses you, insist that no-one else uses it, and point out that it doesn't work with your large suite of tools like lint and plummer that work around C's failings.

#### 使用 ASM

Convert all common utility functions into asm.

#### 使用 QBASIC

Leave all important library functions written in QBASIC, then just write an asm wrapper to handle the large->medium memory model mapping.

#### 行內組語

Sprinkle your code with bits of inline assembler just for fun. Almost no one understands assembler anymore. Even a few lines of it can stop a maintenance programmer cold.

#### MASM call C

If you have assembler modules which are called from C, try to call C back from the assembler as often as possible, even if it's only for a trivial purpose and make sure you make full use of the goto, bcc and other charming obfuscations of assembler.

#### Avoid Maintainability Tools

Avoid coding in Abundance, or using any of its principles kludged into other languages. It was **designed** from the ground up with the primary goal of making the maintenance programmer's job easier. Similarly avoid Eiffel or Ada since they were designed to catch bugs before a program goes into production.

## 和其他人合作

> _他人即地獄_
> - Jean-Paul Sartre, No Exit, 1934

There are many hints sprinkled throughout the tips above on how to rattle maintenance programmers though frustration, and how to foil your boss's attempts to stop you from writing unmaintainable code, or even how to foment an RWAR that involves everyone on the topic of how code should be formatted in the repository.

#### 你的老闆永遠知道所有事

If your boss thinks that his or her 20 year old FORTRAN experience is an excellent guide to contemporary programming, rigidly follow all his or her recommendations. As a result, the boss will trust you. That may help you in your career. You will learn many new methods to obfuscate program code.

#### Subvert The Help Desk

One way to help ensure the code is full of bugs is to ensure the maintenance programmers never hear about them. This requires subverting the help desk. Never answer the phone. Use an automated voice that says "thank you for calling the helpline. To reach a real person press "1" or leave a voice mail wait for the tone". Email help requests should be ignored other than to assign them a tracking number. The standard response to any problem is " I think your account is locked out. The person able to authorise reinstatement is not available just now."

#### 閉嘴

Be never vigilant of the next Y2K. If you ever spot something that could sneak up on a fixed deadline and destroy all life in the western hemisphere then **do not** openly discuss it until we are under the critical 4 year event window of panic and opportunity. Do not tell friends, coworkers, or other competent people of your discovery. Under no circumstances attempt to publish anything that might hint at this new and tremendously profitable threat. Do send one normal priority, jargon encrypted, memo to upper management to cover-your-a$$. If at all possible attach the jargon encrypted information as a rider on an otherwise unrelated plain-text memo pertaining to a more immediately pressing business concern. Rest assured that we all see the threat too. Sleep sound at night knowing that long after you've been forced into early retirement you will be begged to come back at a logarithmically increased hourly rate!

#### Baffle 'Em With Bullshit

Subtlety is a wonderful thing, although sometimes a sledge-hammer is more subtle than other tools. So, a refinement on misleading comments create classes with names like `FooFactory` containing comments with references to the GoF creational patterns (ideally with http links to bogus UML design documents) that have nothing to do with object creation. Play off the maintainer's delusions of competence. More subtly, create Java classes with protected constructors and methods like `Foo f = Foo.newInstance()` that return actual **new instances**, rather than the expected singleton. The opportunities for side-effects are endless.

#### Book Of The Month Club

Join a computer book of the month club. Select authors who appear to be too busy writing books to have had any time to actually write any code themselves. Browse the local bookstore for titles with lots of cloud diagrams in them and no coding examples. Skim these books to learn obscure pedantic words you can use to intimidate the whippersnappers that come after you. Your code should impress. If people can't understand your vocabulary, they must assume that you are very intelligent and that your algorithms are very deep. Avoid any sort of homely analogies in your algorithm explanations.

## 自己來吧

You've always wanted to write system level code. Now is your chance. Ignore the standard libraries and [write your own](http://www.roll-your-own.com). It will look great on your resumé.

#### 自己來 BNF

Always document your command syntax with your own, unique, undocumented brand of BNF notation. Never explain the syntax by providing a suite of annotated sample valid and invalid commands. That would demonstrate a complete lack of academic rigour. Railway diagrams are almost as gauche. Make sure there is no obvious way of telling a terminal symbol (something you would actually type) from an intermediate one -- something that represents a phrase in the syntax. Never use typeface, colour, caps, or any other visual clues to help the reader distinguish the two. Use the exact same punctuation glyphs in your BNF notation that you use in the command language itself, so the reader can never tell if a `(...)`, `[...]`, `{...}` or `"..."` is something you actually type as part of the command, or is intended to give clues about which syntax elements are obligatory, repeatable or optional in your BNF notation. After all, if they are too stupid to figure out your variant of BNF, they have no business using your program.

#### Roll Your Own Allocator

Everyone knows that debugging your dynamic storage is complicated and time consuming. Instead of making sure each class has no storage leaks, reinvent your own storage allocator. It just mallocs space out of a big arena. Instead of freeing storage, force your users to periodically perform a system reset that clears the heap. There's only a few things the system needs to keep track of across resets -- lots easier than plugging all the storage leaks; and so long as the users remember to periodically reset the system, they'll never run out of heap space. Imagine them trying to change this strategy once deployed!

## 特異語言的各種技巧

> _用 Basic 寫程式會造成大腦損傷_
> - Edsger Wybe Dijkstra

#### SQL Aliasing

將資料表名稱 `AS` 成一個到兩個字母的單字。更好的做法是將名稱 `AS`  成其他完全無關的資料表名稱。

#### SQL Outer Join

Mix the various flavours of outer join syntax just to keep everyone on their toes.

#### JavaScript Scope

"Optimise" JavaScript code taking advantage of the fact a function can access all local variables in the scope of the caller.

#### Visual Basic 宣告

如果原本是：

```vbnet
dim Count_num as string
dim Color_var as string
dim counter as integer
```

改成：

```vbnet
Dim Count_num$, Color_var$, counter%
```

#### Visual Basic 的瘋狂

If reading from a text file, read 15 characters more than you need to then embed the actual text string like so:

```vbnet
ReadChars = .ReadChars (29,0)
ReadChar = trim(left(mid(ReadChar,len(ReadChar)-15,len(ReadChar)-5),7))
If ReadChars = "alongsentancewithoutanyspaces"
Mid,14,24 = "withoutanys"
and left,5 = "without"
```

#### Delphi/Pascal 專屬技巧

Don't use functions and procedures. Use the label/goto statements then jump around a lot inside your code using this. It'll drive 'em mad trying to trace through this. Another idea, is just to use this for the hang of it and scramble your code up jumping to and fro in some haphazard fashion.

#### Perl

特別是在很長的一行裡面，使用末端 if 或者末端 unless 宣告方式。

#### Lisp

LISP is a dream language for the writer of unmaintainable code. Consider these baffling fragments:

```lisp
(lambda (*<8-]= *<8-[= ) (or *<8-]= *<8-[= ))
(defun :-] (<) (= < 2))

(defun !(!)(if(and(funcall(lambda(!)(if(and '(< 0)(< ! 2))1 nil))(1+ !))
(not(null '(lambda(!)(if(< 1 !)t nil)))))1(* !(!(1- !)))))
```

#### Visual Foxpro

This one is specific to Visual Foxpro. A variable is undefined and can't be used unless you assign a value to it. This is what happens when you check a variable's type:

```foxpro
lcx = TYPE('somevariable')
```

The value of `lcx` will be `'U'` or `undefined`. BUT if you assign scope to the variable it sort of defines it and makes it a logical `FALSE`. Neat, huh!?

```foxpro
LOCAL lcx
lcx = TYPE('somevariable')
```

The value of lcx is now `'L'` or logical. It is further defined the value of `FALSE`. Just imagine the power of this in writing unmaintainable code.

```foxpro
LOCAL lc_one, lc_two, lc_three... , lc_n
IF lc_one
DO some_incredibly_complex_operation_that_will_neverbe_executed WITH
make_sure_to_pass_parameters
ENDIF

IF lc_two
DO some_incredibly_complex_operation_that_will_neverbe_executed WITH
make_sure_to_pass_parameters
ENDIF

PROCEDURE some_incredibly_complex_oper....
* put tons of code here that will never be executed
* why not cut and paste your main procedure!
ENDIF
```

## 其他技巧

> _如果你給人一個程式，他會挫折一天；如果你教他怎麼寫程式，他會挫折一生。_
> - 匿名

#### 不重新編譯

我們從設計最好，最有敵意的技巧開始講起。寫完程式，編譯成執行檔，如果成功了之後，我們做一些小修改⋯⋯對每個模組都做，**但是不重新編譯**。畢竟只是小修改，編譯可以晚一點我們有空除錯時再處理。這時候，當下一個倒霉鬼接手你的程式，修改之後編譯出的執行檔有問題，他一定會誤以為是他剛剛改的東西出錯了。這可以花他好幾週的時間除錯才能找到問題。

#### Foiling Debuggers

A very simple way to confound people trying to understand your code by tracing it with a line debugger, is to make the lines long. In particular, put the then clause on the same line as the if. They can't place breakpoints. They can't tell which branch of an if was taken.

#### 標準度量衡 v.s. 美式度量衡

In engineering work there are two ways to code. One is to convert all inputs to S.I. (metric) units of measure, then do your calculations then convert back to various civil units of measure for output. The other is to maintain the various mixed measure systems throughout. Always choose the second. It's the American way!

#### CANI

經常且不斷改進（**C**onstant **A**nd **N**ever-ending **I**mprovement）。 Make "improvements" to your code often, and force users to upgrade often - after all, no one wants to be running an outdated version. Just because they think they're happy with the program as it is, just think how much happier they will be after you've "fixed" it! Don't tell anyone what the differences between versions are unless you are forced to - after all, why tell someone about bugs in the old version they might never have noticed otherwise?

#### About Box

The About Box should contain only the name of the program, the names of the coders and a copyright notice written in legalese. Ideally it should link to several megs of code that produce an entertaining animated display. However, it should **never** contain a description of what the program is for, its minor version number, or the date of the most recent code revision, or the website where to get the updates, or the author's email address. This way all the users will soon all be running on different versions, and will attempt to install version N+2 before installing version N+1.

#### 改變改變改變

The more changes you can make between versions the better, you don't want users to become bored with the same old API or user interface year after year. Finally, if you can make this change without the users noticing, this is better still - it will keep them on their toes, and keep them from becoming complacent.

#### Put C Prototypes In Individual Files

Instead of common headers. This has the dual advantage of requiring a change in parameter data type to be maintained in every file, **and** avoids any chance that the compiler or linker will detect type mismatches. This will be especially helpful when porting from 32 -> 64 bit platforms.

#### 不需技巧

You don't need great skill to write unmaintainable code. Just leap in and start coding. Keep in mind that management still measures productivity in lines of code even if you have to delete most of it later.

#### 你只需要一把錘子

堅持你知道的，輕裝上陣。當你只帶一把錘子時，所有的問題看起來都是釘子，用敲的就對了。

#### 標準是用來打破的

Whenever possible ignore the coding standards currently in use by thousands of developers in your project's target language and environment. For example insist on STL style coding standards when writing an MFC based application.

#### 反轉常見的 True/False 習慣

Reverse the usual definitions of true and false. Sounds very obvious but it works great. You can hide:

```c
#define TRUE 0
#define FALSE 1
```

somewhere deep in the code so that it is dredged up from the bowels of the program from some file that no-one ever looks at anymore. Then force the program to do comparisons like:

```c
if ( var == TRUE )
if ( var != FALSE )
```

someone is bound to "correct" the apparent redundancy, and use var elsewhere in the usual way:

```c
if ( var )
```

Another technique is to make `TRUE` and `FALSE` have the same value, though most would consider that out and out cheating. Using values 1 and 2 or -1 and 0 is a more subtle way to trip people up and still look respectable. You can use this same technique in Java by defining a static constant called `TRUE`. Programmers might be more suspicious you are up to no good since there is a built-in literal true in Java.

#### 第三方資料庫

Include powerful third party libraries in your project and then don't use them. With practice you can remain completely ignorant of good tools and add the unused tools to your resumé in your "Other Tools" section.

#### 避免第三方資料庫

Feign ignorance of libraries that are directly included with your development tool. If coding in Visual C++ ignore the presence of MFC or the STL and code all character strings and arrays by hand; this helps keep your pointer skills sharp and it automatically foils any attempts to extend the code.

#### Create a Build Order

Make it so elaborate that no maintainer could ever get any of his or her fixes to compile. Keep secret SmartJ which renders `make` scripts almost obsolete. Similarly, keep secret that the `javac` compiler is also available as a class. On pain of death, never reveal how easy it is to write and maintain a speedy little custom java program to find the files and do the make that directly invokes the `sun.tools.javac.Main` compile class.

#### More Fun With Make

Have the makefile-generated-batch-file copy source files from multiple directories with undocumented overrwrite rules. This permits code branching without the need for any fancy source code control system, and stops your successors ever finding out which version of `DoUsefulWork()` is the one they should edit.

#### Collect Coding Standards

Find all the tips you can on writing maintainable code such as the [Square Box Suggestions](http://www.squarebox.co.uk/javatips.html) and flagrantly violate them.

#### IDE，我不要！

Put all the code in the makefile. Your successors will be really impressed how you managed to write a makefile which generates a batch file that generates some header files and then builds the app, such that they can never tell what effects a change will have, or be able to migrate to a modern IDE. For maximum effect use an obsolete make tool, such as an early brain dead version of NMAKE without the notion of dependencies.

#### 繞過公司的程式碼撰寫標準

有些公司嚴格規範不能出現數字作為常值，你一定得用命名之後的常數。這個規範非常好繞過，舉例來說，一個聰明的 C++ 工程師寫過：

```cpp
#define K_ONE 1
#define K_TWO 2
#define K_THOUSAND 999
```

#### 編譯器警告

Be sure to leave in some compiler warnings. Use the handy "-" prefix in make to suppress the failure of the make due to any and all compiler errors. This way, if a maintenance programmer carelessly inserts an error into your source code, the make tool will nonetheless try to rebuild the entire package; it might even succeed! And any programmer who compiles your code by hand will think that they have broken some existing code or header when all that has really happened is that they have stumbled across your harmless warnings. They will again be grateful to you for the enjoyment of the process that they will have to follow to find out that the error was there all along. Extra bonus points make sure that your program cannot possibly compile with any of the compiler error checking diagnostics enabled. Sure, the compiler may be able to do subscripts bounds checking, but real programmers don't use this feature, and neither should you. Why let the compiler check for errors when you can use your own lucrative and rewarding time to find these subtle bugs?

#### 將升級和除錯合併

Never put out a "bug fix only" release. Be sure to combine bug fixes with database format changes, complex user interface changes, and complete rewrites of the administration interfaces. That way, it will be so hard to upgrade that people will get used to the bugs and start calling them features. And the people that really want these "features" to work differently will have an incentive to upgrade to the new versions. This will save you maintenance work in the long run, and get you more revenue from your customers.

#### Change File Formats With Each Release Of Your Product

Yeah, your customers will demand upwards compatibility, so go ahead and do that. But make sure that there is no backwards compatibility. That will prevent customers from backing out the newer release, and coupled with a sensible bug fix policy (see above), will guarantee that once on a newer release, they will stay there. For extra bonus points figure out how to get the old version to not even recognise files created by the newer versions. That way, they not only can't read them, they will deny that they are even created by the same application! _Hint_: PC word processors provide a useful example of this sophisticated behaviour.

#### 和錯誤妥協

Don't worry about finding the root cause of bugs in the code. Simply put in compensating code in the higher-level routines. This is a great intellectual exercise, akin to 3D chess, and will keep future code maintainers entertained for hours as they try to figure out whether the problem is in the low-level routines that generate the data or in the high-level routines that change various cases all around. This technique is great for compilers, which are inherently multi-pass programs. You can completely avoid fixing problems in the early passes by simply making the later passes more complicated. With luck, you will never have to speak to the little snot who supposedly maintains the front-end of the compiler. Extra bonus points make sure the back-end breaks if the front-end ever generates the correct data.

#### 使用旋轉門機制

Avoid actual synchronization primitives in favor of a variety of spin locks -- repeatedly sleep then test a (non-volatile) global variable until it meets your criterion. Spin locks are much easier to use and more "general" and "flexible " than the system objects.

#### Sprinkle sync code liberally

Sprinkle some system synchronization primitives in places where they are **not** needed. I came across one critical section in a section of code where there was no possibility of a second thread. I challenged the original developer and he indicated that it helped document that the code was, well, "critical!"

#### Graceful Degradation

If your system includes an NT device driver, require the application to malloc I/O buffers and lock them in memory for the duration of any transactions, and free/unlock them after. This will result in an application that crashes NT if prematurely terminated with that buffer locked. But nobody at the client site likely will be able to change the device driver, so they won't have a choice.

#### Custom Script Language

Incorporate a scripting command language into your client/server apps that is byte compiled at runtime.

#### Compiler Dependent Code

If you discover a bug in your compiler or interpreter, be sure to make that behaviour essential for your code to work properly. After all you don't use another compiler, and neither should anyone else!

#### 真實案例

這是某位大師所撰寫的真實範例。我們來看看他如何在一個 C 的函式裡合併使用各種技巧：

```c
void* Realocate(void*buf, int os, int ns)
{
    void*temp;
    temp = malloc(os);
    memcpy((void*)temp, (void*)buf, os);
    free(buf);
    buf = malloc(ns);
    memset(buf, 0, ns);
    memcpy((void*)buf, (void*)temp, ns);
    return buf;
}
```

*   重新發明標準函式庫裡面已經有的簡單函式。
*   _Realocate_ 拼錯。千萬別小看創意拼字的力量。
*   毫無理由的建立 `temp` 來儲存輸入。
*   Cast things for no reason. `memcpy()` takes `(void*)`, so cast our pointers even though they're already `(void*)`. Bonus for the fact that you could pass anything anyway.
*   Never bothered to free temp. This will cause a slow memory leak, that may not show up until the program has been running for days.
*   Copy more than necessary from the buffer just in case. This will only cause a core dump on Unix, not Windows.
*   It should be obvious that `os` and `ns` stand for "old size" and "new size".
*   After allocating `buf`, `memset` it to `0\`. Don't use `calloc()` because somebody might rewrite the ANSI spec so that `calloc()` fills the buffer with something other than `0\`. (Never mind the fact that we're about to copy exactly the same amount of data into `buf`.)

#### 如何修正未使用變數的錯誤

如果你的編譯器會警告「未使用的本地變數」，不要直接刪掉這個變數。找個聰明的方法使用變數就好。我最喜歡的方法是：

```java
i = i;
```

#### 數大便是美

顯然，函式是越大越好。然後，越多 GOTO 越好。這樣一來，任何修改都必須仔細檢查所有可能狀況。It snarls the maintenance programmer in the spaghettiness of it all. And if the function is truly gargantuan, it becomes the Godzilla of the maintenance programmers, stomping them mercilessly to the ground before they have an idea of what's happened.

#### 一張圖片包含千言萬語; 一個函式也包含千言萬語

每個函式都越長越好，最好不要低於一千行。當然，要寫成很深的巢狀。

#### 少一個檔案

確保一個或者多個重要檔案不見了。要達成這件事最好使用多重 include。比方說，在你的模組裡，有：

```c
#include <stdcode.h>
```

`stdcode.h` 是存在的，但是在 stdcode.h 裡面，又有：

```c
#include "a:\\refcode.h"
```

然後 `refcode.h` 不見了，到處都找不到。

#### 到處寫，不讀取

至少有一個變數到處都會設值，但是程式裡面幾乎不會使用該變數。不幸的是，目前的編譯器通常會阻止你使用相反的技巧：某個到處都讀取的變數卻沒有設值。不過 C  和 C++ 裡面還是可以用這個方式。

## 哲學

The people who design languages are the people who write the compilers and system classes. Quite naturally they design to make their work easy and mathematically elegant. However, there are 10,000 maintenance programmers to every compiler writer. The grunt maintenance programmers have absolutely no say in the design of languages. Yet the total amount of code they write dwarfs the code in the compilers.

An example of the result of this sort of elitist thinking is the JDBC interface. It makes life easy for the JDBC implementor, but a nightmare for the maintenance programmer. It is far **clumsier** than the FORTRAN interface that came out with SQL three decades ago.

Maintenance programmers, if somebody ever consulted them, would demand ways to hide the housekeeping details so they could see the forest for the trees. They would demand all sorts of shortcuts so they would not have to type so much and so they could see more of the program at once on the screen. They would complain loudly about the myriad petty time-wasting tasks the compilers demand of them.

There are some efforts in this direction [NetRexx](http://www2.hursley.ibm.com/netrexx/), Bali, and visual editors (e.g. IBM's Visual Age is a start) that can collapse detail irrelevant to the current purpose.

## 鞋匠沒鞋穿

Imagine having an accountant as a client who insisted on maintaining his general ledgers using a word processor. You would do your best to persuade him that his data should be structured. He needs validation with cross field checks. You would persuade him he could do so much more with that data when stored in a database, including controlled simultaneous update.

Imagine taking on a software developer as a client. He insists on maintaining all his data (source code) with a text editor. He is not yet even exploiting the word processor's colour, type size or fonts.

Think of what might happen if we started storing source code as structured data. We could view the **same** source code in many alternate ways, e.g. as Java, as NextRex, as a decision table, as a flow chart, as a loop structure skeleton (with the detail stripped off), as Java with various levels of detail or comments removed, as Java with highlights on the variables and method invocations of current interest, or as Java with generated comments about argument names and/or types. We could display complex arithmetic expressions in 2D, the way TeX and mathematicians do. You could see code with additional or fewer parentheses, (depending on how comfortable you feel with the precedence rules). Parenthesis nests could use varying size and colour to help matching by eye. With changes as transparent overlay sets that you can optionally remove or apply, you could watch in real time as other programmers on your team, working in a different country, modified code in classes that you were working on too.

You could use the full colour abilities of the modern screen to give subliminal clues, e.g. by automatically assigning a portion of the spectrum to each package/class using a pastel shades as the backgrounds to any references to methods or variables of that class. You could bold face the definition of any identifier to make it stand out.

You could ask what methods/constructors will produce an object of type X? What methods will accept an object of type X as a parameter? What variables are accessible in this point in the code? By clicking on a method invocation or variable reference, you could see its definition, helping sort out which version of a given method will actually be invoked. You could ask to globally visit all references to a given method or variable, and tick them off once each was dealt with. You could do quite a bit of code writing by point and click.

Some of these ideas would not pan out. But the best way to find out which would be valuable in practice is to try them. Once we had the basic tool, we could experiment with hundreds of similar ideas to make life easier for the maintenance programmer.

I discuss this further in the SCID student project.

An early version of this article appeared in Java Developers' Journal (volume 2 issue 6). I also spoke on this topic in 1997 November at the [Colorado Summit Conference](http://www.SoftwareSummit.com). It has been gradually growing ever since.

This essay is a **joke**! I apologise if anyone took this literally. Canadians think it gauche to label jokes with a :-). People paid no attention when I harped about how to write __maintainable code. I found people were more receptive hearing all the goofy things people often do to muck it up. Checking for **un**maintainable design patterns is a rapid way to defend against malicious or inadvertent sloppiness.

_**<small>The original was published on [Roedy Green's Mindproducts](http://mindprod.com/jgloss/unmain.html) site.</small>**_
