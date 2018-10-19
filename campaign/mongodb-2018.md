# Mongo DB 4.0 介紹

## multi-documents ACID transaction

laravel-mongodb 目前還不支援這個功能

## compass 支援 aggregation GUI

目前沒有用過 aggregation 這個功能，回去研究一下

## mongoDB charts

分析用軟體

## elastic shard balacing

用 shards 時會用到，等資料量大到一定程度之後會使用

## non-blocking secondary reads

## security

SHA1 升級到 SHA2 基本上等同沒有改變（炸）

## 線上 atlas

### global sharding

### free monitor cloud

### K8s 整合

### mongodb stitch

mongodb 的 serverless solution

可以從前端就存取資料庫

後端要失業了ＸＤ（？）

# 春秋集團

## 應用現狀

### 訂單

* 會員資訊
* 春秋航空訂單
* vip 會員
* 金融會員

### 查詢

多維度（100+）查詢的處理

也就是用了，沒有太深的技術分享

### 誤區

架構規劃失誤：集中針對單一資料庫，容易造成數據流失

硬體架構規劃失誤：共用硬體而沒有限制記憶體和硬碟使用

版本問題：觸發整個資料庫鎖住，無法寫入訂單

# 17 media

架構快速，不需要設計資料庫結構，部屬快速。

## 誤區 

寫錯時不會馬上出錯，要等到一陣子之後出錯

資料庫不是用 transaction 但是處理的是禮物，會有很多客訴

## 好處

scalable DB

# 明門實業

主要是分析大數據的狀況，因為物聯網有很多數據

生產節拍，機台溫度，汽缸氣壓，重量⋯⋯什麼的

比起人工紀錄，用機器偵測自動記錄還是比較合理一點

好處還是針對不斷變動的需求可以處理

## 壓低學習曲線

把 SQL 寫出來之後，翻譯成 aggregate


per event or time series

如果是 time series 的狀況，可能要用 unwind 的方式展開

