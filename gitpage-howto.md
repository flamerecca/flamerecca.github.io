# gitpage 設定

這邊紀錄我自己的 gitpage 怎麼設定

## 初始設定

在自己的 github 裡面開啟專案 `[username].github.io`

其中 username 要和自己 github 帳號一模一樣

再來建立 `index.md`

目前（2018.08）的 gitpage 已經支援自動轉換 markdown 檔

所以不需要像某些教學一樣編寫 HTML 檔

## 自定義網址

預設的網址和專案名稱一樣，都會是 `[username].github.io`

但是我喜歡自己的網址，所以就設定了一個

在專案裡面開啟新檔案 `CNAME`

裡面放自定義的網址

並在自己的 DNS 裡面設定 CNAME 轉向到 `[username].github.io` 就好了

## 內部超連接

只要在 markdown 檔內使用 `[首頁](index.md)` 這種方式

就可以在專案裡面做超連接，像這樣 [首頁](index.md)

在網頁裡面會自動轉換成對應的 HTML 檔，超級方便的！

## 設置外觀

到 `setting` 裡面 `Theme Chooser` 選擇即可

或者到 `_config.yml` 手動設置也可

## 設置 https 連線

因為我需要的其實不是怎麼辦理 https 憑證（之前處理過）

看網路教學之後卡了一陣子

結果只是去 setting 設定一下就好了⋯⋯

## Sitemap

透過 `jekyll-seo-tag` 套件建立

預設位於 <https://gitpage.reccachao.net/sitemap.xml>

## robots.txt

對 SEO 非常重要

之前設置錯誤導致 Google 一直無法對網頁建立索引

目前設置很陽春但是堪用

```text
User-agent: Googlebot
Disallow: /*.xls$

User-agent: *
Allow: /

Sitemap: https://gitpage.reccachao.net/sitemap.xml
```
