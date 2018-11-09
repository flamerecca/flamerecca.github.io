`php artisan inspire` 會隨機顯示一些激勵人的對話，私心覺得不夠ＸＤ

來個中文版（？

```php
return Collection::make([
    'When there is no desire, all things are at peace. - 老子',
    'Simplicity is the ultimate sophistication. - Leonardo da Vinci',
    'Simplicity is the essence of happiness. - Cedric Bledsoe',
    'Smile, breathe, and go slowly. - 釋一行',
    'Simplicity is an acquired taste. - Katharine Gerould',
    '好的開始是成功的一半 - 亞里斯多德',
    '知足者富 - 老子',
    '只需要很少的東西就能創造幸福生活 - 馬可·奧里略',
    '重質不重量 - 盧修斯·阿奈烏斯·塞內卡',
    '天才是百分之一的靈感，百分之九十九的汗水 - 湯瑪斯·愛迪生',
    '電腦之於資訊科學，不過就像望遠鏡之於天文學一樣 - 艾茲赫爾·戴克斯特拉',
    'It always seems impossible until it is done. - 納爾遜·曼德拉',
    'Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - 伊曼努爾·康德',
])->random();
```
