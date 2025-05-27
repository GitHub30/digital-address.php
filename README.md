# 郵便番号・デジタルアドレスAPI

郵便番号・デジタルアドレスAPIのサーバーサイドのコードです。

レンタルサーバーやVPSやe2-microなどのクラウドサーバーで動作します。

[さくらのレンタルサーバー ライト](https://rs.sakura.ad.jp/plan/)なら月額100円台で動作します。

## セットアップ

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

ソースコードの`credentials.json`や`access_token.json`のパスは公開ディレクトリに置かないようにパスを変更してください。

### 3. 動作確認

```bash
# .htaccessが有効な場合
curl http://example.com/1000001
# .htaccessが無効な場合
curl http://example.com/index.php?search_code=1000001
```
