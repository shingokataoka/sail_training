## ダミー用の画像データを移動
public/storage内にshopsとproductsという画像データ入りフォルダがあります。
のshopsとproductsをstorage/app/public直下に移動かコピペなどしてください。

## storage内のデータにアクセスできるようにする
そして、storage内のデータが使えるように下記コマンドを実行してください。
sail artisan storage/link

localhost/stoage/products/product1.jpgをブラウザでアクセス・表示できれば成功です。

## メール送信テストの用意
ご自身のメール送信テスト環境に合わせて.envの環境変数を設定してください。
