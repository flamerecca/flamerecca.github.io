# 基礎問題

重構這本書裡面，提到很多不同的壞味道。常常因為壞味道的狀況實在太多了，讓想改善程式碼的人不知道從哪邊先入手。

這份筆記裡面我整理了五個我認為最常見的問題，並且針對這五點節錄出重構裡面所提到的改善方法。

# 重複的程式碼
這個算是很基礎的問題，不過還是很容易發生。 基本上就是網頁想要新增某個功能，但是因為各種原因，沒有仔細看過之前的元件，所以又重新做了一個。於是這段程式碼就

重複的程式碼會讓修改變得很困難。每次要修改的時候就得四處找不同的地方。

## 解決方案

書裡提到對應的解決方案有：

- [萃取函式（Extract Method）](method/extract_method.md)
- [上移函式（Pull Up Method）](method/pull_up_method.md)
- [建立模板函式（Form Template Method）](method/form_template_method.md)
- [替換演算法（Substitude Algorithm）](method/substitude_algorithm.md)
- [萃取類別（Extract Class）](method/extract_class.md)

# 過長函式
另一個很容易發現的問題，就是很大的函式。因為在撰寫的時候，通常會把功能的實作都寫在一起。隨著開發時間，越寫函式就越來越長。

## 解決方案

書裡提到對應的解決方案有：

- [萃取函式（Extract Method）](method/extract_method.md)
- [以查詢替換暫時變數（Replace Temp with Query）](method/replace_temp_with_query.md)
- [引入參數物件（Introduce Parameter Object）](method/introduce_parameter_object.md)
- [保留完整物件（Preserve Whole Object）](method/preserve_whole_object.md)
- [以函式物件替換函式（Replace Method with Method Object）](method/replace_method_with_method_object.md)
- [分解條件式（Decompose Conditional）](method/decompose_conditional.md)

# 過大類別
另一個常常發生的事情，就是類別太大。

在網頁開發上面，如果有使用 MVC 框架的話，這種狀況比較容易出現在 Controller 身上。因為每次需要功能的時候，直覺會想要在既有的 Controller 裡面加入新的函式，並在裡面實作邏輯。久而久之，類別自然就會越來越大。

## 解決方案

書裡提到對應的解決方案有：

- [萃取類別（Extract Class）](method/extract_class.md)
- [萃取子類別（Extract Subclass）](method/extract_subclass.md)
- [萃取介面（Extract Interface）](method/extract_interface.md)
- [複製「被監視資料」（Duplicate Observed Data）](method/duplicate_observed_data.md)
# 過長參數列

## 解決方案

書裡提到對應的解決方案有：

- [以函式替換參數（Replace Parameter with Method）](method/replace_parameter_with_method.md)
- [保留完整物件（Preserve Whole Object）](method/preserve_whole_object.md)
- [引入參數物件（Introduce Parameter Object）](method/introduce_parameter_object.md)

# 註解太多（Comment）
一般來說，開發遇到的問題其實都是註解太少。不過隨著重構的過程，各種說明性註解也就會越來越多。

註解雖然並不是壞味道，甚至很多時候可以說是一種香味，不過當註解多到一定程度時，就會開始變成問題。

所以雖然這個壞味道被放在書裡的最後一種，但是我將這個壞味道放在「基礎問題」裡面。

## 解決方案

- [萃取函式（Extract Method）](method/extract_method.md)
- [重新命名函式（Rename Method）](method/rename_method.md)
- [引入斷言（Introduce Assertion）](method/introduce_assertion.md)
