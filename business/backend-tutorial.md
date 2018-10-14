# 程式規範

## coding style

遵守 PSR2 規範，使用 phpcs 和 phpcbf 協助檢查

團隊成員應該學會怎樣使用這兩個工具

[PHP_CodeSniffer 檢查程式碼標準 phpcs phpcbf](https://clouding.city/php-phpcs-phpcbf/)

## 程式碼結構

使用 laravel + l5-repository

實現 MVC + repository 結構

手動維護 Service 層

減少參數數量時可以使用 Data Transfer Object

[https://github.com/andersao/l5-repository](https://github.com/andersao/l5-repository)

[Data Transfer Object](https://martinfowler.com/eaaCatalog/dataTransferObject.html)

[php-the-right-way](http://laravel-taiwan.github.io/php-the-right-way/)

## 其他規範

參考 cleancode 

[無瑕的程式碼 Clean Code 心得分享](https://www.slideshare.net/kylinfish/clean-code-72688451)

[PHP 良好實踐 (Best Practice)](https://www.slideshare.net/kylinfish/php-best-practice-81744253)

# 資料庫

## 資料庫結構

資料庫正規化，研究到第三正規化

[SQL anti pattern](https://www.slideshare.net/gleicon/nosql-and-sql-anti-patterns/)

## 索引

[How to Design Indexes, Really](https://www.slideshare.net/billkarwin/how-to-design-indexes-really)

# API

使用 jwt-auth 實現 jwt 認證機制

[https://github.com/tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)

# 主機架構

使用 docker 維護

[http://laradock.io/](http://laradock.io/)

# 版本維護

使用 git flow

[Git Flow 是什麼？為什麼需要這種東西？](https://gitbook.tw/chapters/gitflow/why-need-git-flow.html)

[Git怎麼這麼難用？Git Flow + 好習慣 = 不再苦惱](https://medium.com/kuma%E8%80%81%E5%B8%AB%E7%9A%84%E8%BB%9F%E9%AB%94%E5%B7%A5%E7%A8%8B%E6%95%99%E5%AE%A4/%E5%9F%BA%E7%A4%8E-git-flow-%E5%B7%A5%E4%BD%9C%E6%B3%95-fa50b1dddc4f)

[GitHub Flow 及 Git Flow 流程使用時機](https://blog.wu-boy.com/2017/12/github-flow-vs-git-flow/comment-page-1/)
