## Effective Java 3e 讀書心得 - Item 10：Obey the general contract when overriding equals

## 覆載 `equals()` 的場景

非常多的情境下，並不值得覆載（override） `equals()`

重新定義物件間「相等」的邏輯

比方說：

- 該類別個別物件本質上是不同的
- 沒有提供「相等」比較的必要，比方說 java.util.regex.Pattern
- 父類別已經覆載 `equals()`，並且其邏輯用在這個類別是合理的
- 該類別僅在這個專案內使用，並且你很確定專案內沒有用到 `equals()`

如果遇到以上情境，不要覆載 `equals()` 就可以避免掉很多問題。

不過，還是有一些狀況，我們會需要 覆載 `equals()`

根據書中提到，當一個類別邏輯上的「相等」已經和物件的相同有所差距，這時就很值得為其定義一個客製化的 `equals()`

>It is when a class has a notion of logical equality that differs from mere object identity and a superclass has not already overridden equals.(p. 38)

## 覆載 `equals()` 的慣例

即便如此，「相等」這件事情必須要遵守一些慣例：

- 自反性（Reflexive）：對任意非空值 x，x.equals(x) 應為 true
- 對稱性（Symmetric）：對任意非空值 x、y，x.equals(y) 應等於 y.equals(x)
- 遞移性（Transitive）：對任意非空值 x、y、z，如果 x.equals(y) 為 true 且 y.equals(z) 為 true，則 x.equals(z) 應為 true
- 一致性（Consistent）：對任意非空值 x、y，只要不更動這裡面的值，無論呼叫幾次，x.equals(y) 的回傳要一樣
- 對任意非空值 x 來說，x.equals(null) 要等於 false

違反這些慣例，會導致其他行為變得難以預測

### 違反慣例的問題

書中相關篇幅不少

以下舉其中一個違反慣例可能導致的問題

#### 違反對稱性

這個狀況書中提到了一個可能的案例

比方說，你可能覺得每次比對大小寫無關的字串時

還要全部轉成小寫再進行比對很不方便

所以寫了一個類別 `CaseInsensitiveString`

並覆載 `equals` 如下

```java
// Broken - violates symmetry!
    @Override public boolean equals(Object o) {
        if (o instanceof CaseInsensitiveString)
            return s.equalsIgnoreCase(
                ((CaseInsensitiveString) o).s);
        if (o instanceof String)  // One-way interoperability!
            return s.equalsIgnoreCase((String) o);
        return false;
    }
```

這樣的設計乍看之下很方便

```java
CaseInsensitiveString cis = new CaseInsensitiveString("Polish");
String s = "polish";

cis.equals(s) // true
```

但是卻違背了對稱性

```java
cis.equals(s) // true
s.equals(cis) // false
```

違反這個特性，會導致其他使用 `equals` 的其他函數

比方說 Collection 的 `contains` 函數

無法正確判斷該物件是否存在於集合內

要修正這個問題

要改變我們一開始 `CaseInsensitiveString` 和 `String` 相同的想法

讓 `CaseInsensitiveString` 只能和 `CaseInsensitiveString` 相同

改寫 `equals` 如下

```java
@Override public boolean equals(Object o) {
    return o instanceof CaseInsensitiveString &&
        ((CaseInsensitiveString) o).s.equalsIgnoreCase(s);
}
```

## 如何撰寫有效率的 `equals()`

針對怎麼撰寫一個有效率的 `equals()`

書中提出了以下建議

- Use the == operator to check if the argument is a reference to this object.
- Use the instanceof operator to check if the argument has the correct type.
- Cast the argument to the correct type.
- For each "significant" field in the class, check if that field of the argument matches the corresponding field of this object.


### 實作案例

Kotlin 官方已經提供我們一個很好的案例：data class！

#### data class 的 `equals()`

假設我們有一個 data class 如下

```kotlin
data class Customer(
    val name: String,
    val email: String
)
```

如果我們反組譯這個 data class 編譯出的 bytecode

可以看到裡面定義了客製版本的 `equals()`，實作如下

```java
public boolean equals(@Nullable Object other) {
    if (this == other) {
        return true;
    } else if (!(other instanceof Customer)) {
        return false;
    } else {
        Customer var2 = (Customer)other;
        if (!Intrinsics.areEqual(this.name, var2.name)) {
           return false;
        } else {
            return Intrinsics.areEqual(this.email, var2.email);
        }
    }
}
```

首先，利用 `==` 快速檢查物件是否是同一個參照（reference）

再來，快速檢查型態，如果型態不同則回傳 false

接著就是客製化的定義：即便兩個 `Customer` 物件可能是不同參照

不過如果他們有相同的名字和 email，我們就視為相等的 `Customer`

這件事情也可以看出 Kotlin 在實作上

確實很多地方參考了 Effective Java 這本書的觀念

作為其程式設計的架構

----

回到[首頁](index.md)
