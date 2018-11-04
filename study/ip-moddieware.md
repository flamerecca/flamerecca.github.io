在很少見的狀況下，有時候我們會需要過濾特定 IP。

# 建立 middleware



# 取得 IP

因為我慣用的網路環境，通常會有一個 docker container 進行 反向代理

如果用 laravel 提供的 `$request->ip()` 通常會取得反向代理的 IP

這時候可以用 `$_SERVER['HTTP_HOST']` 就可以取得真實的 IP
