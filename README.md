# 郵便番号・デジタルアドレスAPI

郵便番号・デジタルアドレスAPIのサーバーサイドのコードです。

## セットアップ

### 0. システム登録

IPアドレス 127.0.0.1 を設定してください

![image](https://github.com/user-attachments/assets/1582c6f5-db1a-41d8-a202-95fc7258786e)

### 1. index.phpと.htaccessをアップロード

### 2. credentials.jsonの作成

credentials.json
```json
{
    "grant_type": "client_credentials",
    "client_id": "your-client_id",
    "secret_key": "your-secret_key"
}
```

> [!IMPORTANT]
> 公開ディレクトリに置かないように、`credentials.json`や`access_token.json`のパスを変更できます。

### 3. 動作確認

```bash
# .htaccessが有効な場合
curl http://example.com/1000001
# .htaccessが無効な場合
curl http://example.com/index.php?search_code=1000001
```
