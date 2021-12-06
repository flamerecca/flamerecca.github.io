## Mongodb 的 WriteConcern

最近工作上比較多使用 MongoDB

意外的發現到 Write Concern 這個設置

這個設置會影響到寫入的安全級別

如果使用 Kotlin 的 Kmongo 框架

由於取出的物件是 Driver 原本的 MongoCollection 

因此可以直接使用 `withWriteConcern()` 進行設置

```kotlin
val client = KMongo.createClient(connectionString)
val database = client.getDatabase("recca")
val collection = database.getCollection("log")
collection.withWriteConcern(WriteConcern.ACKNOWLEDGED)
    .insertOne(log)
```

## 參考資料
- <https://docs.mongodb.com/manual/reference/write-concern/>
