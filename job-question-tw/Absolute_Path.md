以下問題在 Facebook 的面試出現過：

給定檔案的相對路徑，包含資料夾名稱，'..'（上一層資料夾），和 '.'（現在資料夾），回傳檔案的絕對路徑（去除所有的 '..' 和 '.'）

範例
```
輸入: '/Users/Joma/Documents/../Desktop/./../'
輸出: '/Users/Joma/'
```
```
def shortest_path(file_path):
  # Fill this in.

print shortest_path('/Users/Joma/Documents/../Desktop/./../')
# /Users/Joma/
```
