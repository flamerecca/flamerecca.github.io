發現即使有教學，還是有些人沒有做過這件事情，所以再寫一篇文章解釋怎麼做這件事情

### 在本機建立  SSH key

我們可以用以下指令，在本機內建立 SSH key

```shell
ssh-keygen -t ed25519 -C "你的email"
```

接著一路按 enter 就可以 成功建立 `~/.ssh/id_ed25519`  這個檔案

可以把這個檔案想成是你的鑰匙。

接著，我們要提供 GitHub 一個鎖頭，讓 GitHub 能幫你的權限上鎖

如果你之後的鑰匙能打開這個鎖頭，那麼就代表你有權限使用 GitHub 的專案。

### 在 GitHub  帳號內新增 SSH key

接著我們要上傳提供給 GitHub 的鎖頭。

這個檔案是一個純文字檔，檔名是 `~/.ssh/id_ed25519.pub`

可以在指令內用 `cat` 看到裡面的檔案內容

舉我自己操作的範例， `id_ed25519.pub` 如下

```text
ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIHQdXFZDAu++RXV6dWyuZIWM+ITW44xe0kck9lJC+Wra recca-mac
```

這個檔案是可以公開對外的，畢竟其他人拿到你的鎖頭複製品，是不能做什麼的。

但是鑰匙檔案，也就是 `~/.ssh/id_ed25519` 就千萬不能對外了！

接著，我們點選 Setting > SSH and GPG keys，進到 https://github.com/settings/keys 裡面

點選「New SSH Key 」按鈕

在 Key 裡面填入 `id_ed25519.pub` 的內容，接著按「Add SSH Key」

這樣就成功的上傳了 SSH key，之後這台電腦就可以操作 GitHub 帳號裡的內容了！
