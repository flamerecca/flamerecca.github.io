# flamerecca-vim 

詳細均在 [https://github.com/flamerecca/flamerecca-vim](https://github.com/flamerecca/flamerecca-vim) 可以找到

## 緣起

原本對 vim 環境設置並沒有這麼高的興趣

不過看到朋友做的專案之後，覺得是值得花點時間透過版本控制處理的事情

所以也開了一個專案進行處理

## bash 檔案撰寫
真的是全新的領域，所以只是很單純的看著別人怎麼寫自己就怎麼寫

但是還是硬著頭皮做了 自己都很心虛

不過做出了一定的成績之後，還是蠻開心的

### 流程
參考其他人的專案，設置 bash 處理流程

* 檢查是否設置 $HOME 參數
* 檢查 git vim 是否安裝
* 備份原本設置
* 安裝 vim plugin
* 安裝 vundle
* 透過 git 下載檔案
* 建立相對路徑
* 安裝 plugin


## circleci 自動測試
這真的是因為有趣才做的XD，本身意義並不高

在 circleci 下找不包含其他語言的環境

結果建議使用最乾淨的 `debian:stretch` (後來我改用 `debian:8-slim`)

乾淨到連 `sudo` 和 `curl` 都沒有，得自行安裝

稍微處理了一下，可以下載 .sh 檔並執行，算是大功告成吧。
