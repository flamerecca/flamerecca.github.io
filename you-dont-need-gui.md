# 你不需要 GUI

<details>
It's for noobs :)
</details>
<br />

對使用者來說，GUI 是很友善的。有 GUI 之後，電腦更好上手，不用再忍受指令列介面（CLI）陡峭的學習曲線。

不過，GUI 一般來說會消耗更多硬體資源，操作自由更少，而且更難透過指令自動化。

作為電腦專家，我們希望更有效率，把事情做得更好。我們知道指令列的一些操作並不好記，所以列舉一些可以不用 GUI 達成的常用操作
。

## 連接

1. [複製檔案](#複製檔案)
1. [備份檔案](#備份檔案)
1. [複製資料夾](#複製資料夾)
1. [備份資料夾](#備份資料夾)
1. [移動檔案](#移動檔案)
1. [重命名檔案](#重命名檔案)
1. [移動資料夾](#移動資料夾)
1. [重命名資料夾](#重命名資料夾)
1. [合併資料夾](#合併資料夾)
1. [建立新檔案](#建立新檔案)
1. [建立新資料夾](#建立新資料夾)
1. [顯示檔案／資料夾大小](#顯示檔案／資料夾大小)
1. [開啟檔案](#open-a-file-with-the-default-program)
1. [壓縮資料夾](#壓縮資料夾)
1. [解壓縮資料夾](#解壓縮資料夾)
1. [刪除檔案](#刪除檔案)
1. [刪除資料夾](#刪除資料夾)
1. [列出資料夾內容](#列出資料夾內容)
1. [tree view a folder and its subfolders](#tree-view-a-folder-and-its-subfolders)
1. [find a stale file](#find-a-stale-file)
1. [顯示日曆](#show-a-calendar)
1. [查看未來日期](#find-a-future-date)
1. [計算機](#計算機)
1. [強制關閉程式](#強制關閉程式)


## 複製檔案

**STOP DRAG AND DROP A FILE, OR CMD/CTRL + C, CMD/CTRL + V A FILE** :-1:

複製`readme.txt` 到 `documents` 資料夾

```shell
cp readme.txt documents/
```

## 備份檔案

**不要按右鍵之後選擇複製檔案** :-1:

```shell
cp readme.txt readme.bak.txt
```

## 複製資料夾

**不要拖拉整個資料夾或者 CTRL + C / CTRL + V 資料夾** :-1:

Copy `myMusic` folder to the `myMedia` folder

```shell
cp -a myMusic myMedia/
# 或者
cp -a myMusic/ myMedia/myMusic/
```

## 複製資料夾

**STOP RIGHT CLICK AND DUPLICATE A FOLDER** :-1:

```shell
cp -a myMusic/ myMedia/
# or if `myMedia` folder doesn't exist
cp -a myMusic myMedia/
```

## 移動檔案

**STOP DRAG AND DROP A FILE, OR CTRL + X, CTRL + V A FILE** :-1:

```shell
mv readme.txt documents/
```

**Always** use a trailing slash when moving files, [for this reason](http://unix.stackexchange.com/a/50533).

## 重新命名檔案

**STOP RIGHT CLICK AND RENAME A FILE** :-1:

```shell
mv readme.txt README.md
```

## 移動資料夾

**STOP DRAG AND DROP A FOLDER, OR CTRL + X, CTRL + V A FOLDER** :-1:

```shell
mv myMedia myMusic/
# or
mv myMedia/ myMusic/myMedia
```

## 重新命名資料夾

**STOP RIGHT CLICK AND RENAME A FOLDER** :-1:

```shell
mv myMedia/ myMusic/
```

## 合併資料夾

**STOP DRAG AND DROP TO MERGE FOLDERS** :-1:

```shell
rsync -a /images/ /images2/
```

## 建立新檔案

**STOP RIGHT CLICK AND CREATE A NEW FILE** :-1:

```shell
touch 'new file'
# or
> 'new file'
```

## 建立新資料夾

**STOP RIGHT CLICK AND CREATE A NEW FOLDER** :-1:

```shell
mkdir 'untitled folder'
# 或者
mkdir -p 'path/may/not/exist/untitled folder'
```

## 顯示檔案/資料夾大小

**STOP RIGHT CLICK AND SHOW FILE/FOLDER INFO** :-1:

```shell
stat -x readme.md
# or
du -sh readme.md
```

## 開啟檔案

** DOUBLE CLICKING A FILE** :-1:

```shell
xdg-open file   # on Linux
open file       # on MacOS
```

## 壓縮資料夾

**STOP RIGHT CLICK AND COMPRESS FOLDER** :-1:

```shell
zip -r archive_name.zip folder_to_compress
```

## 解壓縮資料夾

**STOP RIGHT CLICK AND UNCOMPRESS FOLDER** :-1:

```shell
unzip archive_name.zip
```

## 移除檔案

**STOP RIGHT CLICK AND DELETE A FILE PERMANENTLY** :-1:

```shell
rm my_useless_file
```

IMPORTANT: The rm command deletes my_useless_file permanently, which is equivalent to move my_useless_file to Recycle Bin and hit Empty Recycle Bin.

## 移除資料夾

**STOP RIGHT CLICK AND DELETE A FOLDER PERMANENTLY** :-1:

```shell
rm -r my_useless_folder
```

## 列出資料夾內容

**STOP OPENING YOUR FINDER OR FILE EXPLORER** :-1:

```shell
ls -la my_folder
```

## tree view a folder and its subfolders

**STOP OPENING YOUR FINDER OR FILE EXPLORER** :-1:

```shell
tree                                                       # on Linux
find . -print | sed -e 's;[^/]*/;|____;g;s;____|; |;g'     # on MacOS
```

## find a stale file

**STOP USING YOUR FILE EXPLORER TO FIND A FILE** :-1:

Find all files modified more than 5 days ago

```shell
find my_folder -mtime +5
```

## 看日曆

**STOP LOOKING UP WHAT THIS MONTH LOOKS LIKE BY CALENDAR WIDGETS** :-1:

Display a text calendar

```shell
cal
```

## 看未來的日期

**STOP USING WEBAPPS TO CALCULATE FUTURE DATES** :-1:

 想看今天的日期？

```shell
date +%m/%d/%Y
```

那麼，今天往後一週的日期呢？

```shell
date -d "+7 days"                                          # on Linux
date -j -v+7d                                              # on MacOS
```

## 計算機

**STOP USING CALCULATOR WIDGET** :-1:

Want to use a calculator?

```shell
bc
```

## force quit a program

**STOP FORCE QUIT A PROGRAM USING GUI** :-1:

```shell
killall program_name
```

---
_Remember, you can always google or `man` the commands you are not familiar with._
