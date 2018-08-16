# circleci
## 環境變數
因為測試 vim 的自動整合時需要設置環境變數 `$TERM`

花費很長時間研究設置方法，但是總是不生效

結果，因為circleci裡面每個指令是獨立的，所以不能在指令裡面處理

```yml
    steps:
      - run: export TERM=xterm
      - run: echo $TERM # 不會顯示xterm
```

必須使用環境變數的方式處理：

```yml
version: 2
jobs:
  build:
    docker:
      - image: debian:8-slim
    environment:
      TERM: xterm
    steps:
      - checkout
      - run: apt-get update && apt-get install -y sudo curl git vim
      - run: sudo su -c 'bash <(curl https://bit.ly/flamerecca-vim -L)'
```

這樣才能保證該次測試下，所有的指令均能取用到一樣的環境變數 `$TERM`
