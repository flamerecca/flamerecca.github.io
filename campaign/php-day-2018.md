聽說有很多秘辛ＸＤ

# PHP+ETL+serverless

從 Java 開始

要認真考慮流量

面對一隻老鼠和面對一千隻老鼠是完全不同的兩回事

流量乘以十倍，整個問題都不一樣了。

ETL solution: pentaho kettle(?

[開幕 - 就決定寫Kettle了](https://ithelp.ithome.com.tw/articles/10186258)

拖拖拉拉寫程式的感覺ＸＤ 蠻有趣的

用 PHP 處理資料庫（fat-free mvc structure）並整理，用 shell script(?!)上傳到S3 

之後就是走 S3 trigger lambda > lambda to SNS > SNS to end-user

----

基本上就是 讀取 Excel > 轉置出需要的資料 > 載入至資料庫處理


