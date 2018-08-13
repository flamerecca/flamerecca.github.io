# flamerecca-vim 

詳細均在 [https://github.com/flamerecca/flamerecca-vim](https://github.com/flamerecca/flamerecca-vim) 可以找到

## 緣起

原本對 vim 環境設置並沒有這麼高的興趣

不過看到朋友做的專案之後，覺得是值得花點時間透過版本控制處理的事情

所以也開了一個專案進行處理

## circleci 自動測試
這真的是因為有趣才做的XD，本身意義並不高

在 circleci 下找不包含其他語言的環境

結果建議使用最乾淨的 `debian:stretch`

乾淨到連 `sudo` 和 `curl` 都沒有，得安裝

稍微處理了一下，可以下載 .sh 檔並執行，算是大功告成吧。
