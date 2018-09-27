來源為 [https://www.slideshare.net/billkarwin/how-to-design-indexes-really](https://www.slideshare.net/billkarwin/how-to-design-indexes-really)

個人隨手筆記

# 資料庫結構根據資料設計，資料庫索引設計根據存取方式設計

檢測哪一些存取（query）是慢的

```sql
SET GLOBAL slow_query_log = ON;
```

# 三星評定法

First Star: Rows referenced by your query are grouped together in the index.

Second Star: Rows referenced by your query are ordered in the index the way you want them.

Third Star: The index contains all columns referenced by your query.


