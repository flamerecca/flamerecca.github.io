# VIM for PHP 筆記

常常會用到，但是總是忘記一些重點

特別寫一篇來記錄

資料來源：[VIM for (PHP) Programmers](https://www.slideshare.net/ZendCon/vim-for-php-programmers-presentation)

## help

`:help`

在 help 內使用 `Ctrl + ]`（跳到對應標籤） 和 `ctrl + T`（回到前一頁）來閱讀其他指令的教學

## 快速關閉

* `ZZ`： `:wq`
* `ZQ`： `:q!`

## where am i

簡單版：`ctrl + g`

詳細版：`g`，`ctrl + g`

`.vimrc` 裡面 `set ruler`：顯示右下角設定值

## 移動

除了上下左右，還有h（左）/j（下）/k（上）/l（右）

檔案最頭：`gg`

檔案最底：`G`

移動到第 10 行：`10gg` 或 `10G`

移動到檔案 10% 的位置：`10%`

移動到行首：`0`

移動到該行第一個有字的位置：`^`

行尾：`$`

移動到下一行第一個有字的位置：`+`

移動到上一行第一個有字的位置：`-`

## 標記

`:marks`：查看現在標記

`m`，`[按鍵]`：設定標記位置

``` `+[按鍵] ```：跳至標記位置

`' + [按鍵]`：跳至標記所在行首
