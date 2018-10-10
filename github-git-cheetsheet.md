# 安裝Git
GitHub提供了包含圖形界面的桌面客戶端，通過客戶端可以完成大部分常用的倉庫操作，同時可以自動更新Git的命令行版本，以適應新的場景。

GitHub Desktop
https://desktop.github.com/

GitHub的Linux和POSIX版本可以在官方的Git SCM網站上獲取。

Git 全平台版
http://git-scm.com

# 配置工具
設定所有本地倉庫的用戶資料
```
$ git config --global user.name "[name]"
```
對你的commit操作設置關聯的用戶名
```
$ git config --global user.email "[email address]"
```
對你的commit操作設置關聯的郵箱地址

# 創建倉庫（repository）
創建一個新的倉庫或者從一個現有的鏈接獲取倉庫
```
$ git init [project-name]
```
創建一個本地的倉庫，並設置名字
```
$ git clone [url]
```
下載一個項目以及它所有的版本歷史

# 更改
檢查已有的編輯並執行commit操作
```
$ git status
```
列出所有新建或者更改的文件，這些文件需要被commit
```
$ git diff
```
展示那些沒有暫存文件的差異
```
$ git add [file]
```
將文件進行快照處理用於版本控制
```
$ git diff --staged
```
展示暫存文件與最新版本之間的不同
```
$ git reset [file]
```
將文件移除暫存區，但是保留其內容
```
$ git commit -m "[descriptive message]"
```
將文件快照永久地記錄在版本歷史中

# 批量更改
命名一系列commit以及合並已完成的工作
```
$ git branch
```
列出當前倉庫中所有的本地分支
```
$ git branch [branch-name]
```
建立一個新分支
```
$ git checkout [branch-name]
```
切換到一個特定的分支上並更新工作目錄
```
$ git merge [branch-name]
```
合併特定分支的歷史到當前分支
```
$ git branch -d [branch-name]
```
刪除特定的分支

# 重構文件
重定位並移除版本文件
```
$ git rm [file]
```
從工作目錄中刪除文件並暫存此刪除
```
$ git rm --cached [file]
```
從版本控制中移除文件，並在本地保存文件
```
$ git mv [file-original] [file-renamed]
```
改變文件名並準備commit

# 停止追蹤
不包含臨時文件和路徑

- *.log
- build/
- temp-*

文本文件.gitignore可以防止一些特定的文件進入到版本控制中
```
$ git ls-files --others --ignored --exclude-standard
```
列出所有項目中忽略的文件

# 保存臨時更改
暫存一些未完成的更改
```
$ git stash
```
臨時存儲所有修改的已跟蹤文件
```
$ git stash pop
```
重新存儲所有最近被stash的文件
```
$ git stash list
```
列出所有被stash的更改
```
$ git stash drop
```
放棄所有最近stash的更改

# 查閱歷史
瀏覽並檢查項目文件的發展
```
$ git log
```
列出當前分支的版本歷史
```
$ git log --follow [file]
```
列出文件的版本歷史，包括重命名
```
$ git diff [first-branch]...[second-branch]
```
展示兩個不同分支之間的差異
```
$ git show [commit]
```
輸出元數據以及特定commit的內容變化

# 撤銷commit
清除錯誤並更改歷史
```
$ git reset [commit]
```
撤銷所有[commit]後的的commit，在本地保存更改
```
$ git reset --hard [commit]
```
放棄所有更改並回到某個特定的commit

# 同步更改
註冊一個遠程的鏈接，交換倉庫的版本歷史
```
$ git fetch [remote]
```
下載遠程倉庫的所有歷史
```
$ git merge [remote]/[branch]
```
合併遠程分支到當前本地分支
```
$ git push [remote] [branch]
```
上傳所有本地分支 commit 到 GitHub 上
```
$ git pull
```
下載所有歷史並合併更改
