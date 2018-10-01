來源：[https://www.slideshare.net/gleicon/nosql-and-sql-anti-patterns](https://www.slideshare.net/gleicon/nosql-and-sql-anti-patterns)

# 列表
* The eternal tree
* Dynamic table creation
* Table as Cache
* Table as Queue
* Table as logfile
* Stoned Procedure
* Row alignment
* Extreme JOIN

## The eternal tree

需求為需要樹狀結構，所以資料結構變成

| `id` | `parent_id` | `content`
| --   | --          | --
| `1`  | `0`         | `aaa`
| `2`  | `0`         | `bbb`
| `3`  | `1`         | `ccc`


### 問題

資料結構和 Query 都極難維護。當需求改變時更加困難。

### 解法

使用 json 檔案紀錄

```json
[
    {
        "id": 1,
        "content": "aaa",
        "children": [
            {
                "id": 3,
                "content": "ccc",
                "children": []
            }
        ]
    },
    {
        "id": 2,
        "content": "bbb",
        "children": []
    }
]
```
## Dynamic table creation

隨著資料量變多，開發者可能會想到將資料分成多張子表，並用一張關係表紀錄資料在哪個子表裡面：

比方說，如果你在一家文件管理公司工作，

|`item_id`|`row_id`|`column_id`|`content`
|--|--|--|--
|1|10|20|apple
|2|12|32|bird

### 問題

很明顯的，當你資料越來越多，散在各個不同的資料表時，你就得想出一個很複雜的存取方式取出你要的資料。

要是需求突然加入搜尋功能，那只有神能保佑你了。

### 解法

database SET 或者 用檔案存取

## Table as Cache

隨著存取跨表越來越多，可能會開一張新的資料表，將存取的內容放在裡面當作快取。

### 問題

首先，這顯然有問題ＸＤ，畢竟已經有這麼多快取服務可以用了。

實際操作上，這有很高機會導致難除錯的問題（資料錯誤）。

### 解法

* Redis
* 去標準化，讓某些存取變快

## Table as Queue

用資料庫作為 message Queue 的服務

### 問題

概念來看，有這麼多專門做 queue 的服務，用資料庫很奇怪。

實際上來看，針對該 queue 的服務會大量消耗資料庫的效能。處理順序也非常麻煩。

### 解法

* 專門服務，像是Resque，RestMQ
* 各種 message Broker
* Redis

## Table as logfile

用資料表當作 log

### 問題

logfile 之所以叫 logfile 是有理由的。

剛開始這個做法可以解決當下需求，但是之後大量的資料會使得該表變得難以處理。因應這種狀況，又會加入備份機制和清空機制。提升維護難度。

### 解法

* MongoDB
* Redis
* RIAK

## Stoned Procedure

資料庫的 Stored Procedure 在某些場景下很好用。資料庫的 trigger 也是。在某些需求下會誘惑開發者大量使用這兩者來處理商業邏輯。

### 問題

因為不在程式碼內，Stored Procedure 和 trigger 非常容易在修改需求的時候遺忘。

另外因為相同原因，這兩個東西通常也不在版本控制之內。

### 解法

商業邏輯透過像是 php 之類的語言處理。事件處理則使用專業的 pub/sub 服務或者 message queue 服務。

## Row alignment

某個人預先在資料庫裡面多加入欄位，通常命名成 `a1`，`a2` 之類的。

雖然看起來很笨，但是通常有當初設置的好意。比方說過去每次新增欄位時，都需要花上一兩天之類的。

### 問題

問題點很明顯，光只是在資料庫裡面加入多餘的欄位，就提升維護的困難度了。

### 解法
## Extreme JOIN

商業邏輯設置上關聯性很多。每次要弄清某個商業邏輯，需要用大量的 JOIN 才行。

### 問題

大量的 JOIN 不僅僅效率很差，也導致維護變得困難。

### 解法

使用 MongoDB 等非 RDS 資料庫。

去標準化

序列化物件

# 其他問題

## 資料表結構非常複雜

需要用一張 A3 紙，或者好幾張紙，才可以描述你的資料表結構

### 問題

顯而易見，資料表結構越複雜，維護成本就會越高。

### 解法

去標準化

修改規格（？）

部分資料用檔案儲存

key/Value 資料庫

# 產品常見生命週期

投影片寫的不是很明確，用我自己的理解改寫。

## 產品一

一般的網頁服務

* 先使用 MySQL 進行開發
* 隨著用戶變多效能變差，加上 cache 因應
* 逐漸轉換成 Key/Value database，不再使用 relational database

## 產品二

資料分析產品，使用爬蟲

* 用 relational database 進行開發
* 加入計數需求
* 隨著爬蟲數量越多，資料庫開始出現 lock
* 加入讀取的 cache 提升一點效能
* 嘗試用 MongoDB，解決了 lock 的問題
* 修改設計格式，不再使用 relational database

# 反模式總結考量點

你的產品是否很需要 cache 服務？

如果不使用資料庫或者使用 NoSQL 是否可以改善產品狀況？
