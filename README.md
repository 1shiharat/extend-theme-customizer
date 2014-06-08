# Extend Theme Customizer

WordPressのテーマカスタマイザーを拡張し、
json ファイルからテーマカスタマイザーの設定を行います。

## Installation

1. Githubから zip をダウンロードし、管理画面からインストール・有効化
2. コマンドラインにてプラグインディレクトリに移動後、 git clone

```
git clone https://github.com/1shiharaT/extend-theme-customizer.git extend-theme-customizer
```

## Usage

1. 別途設定ファイル( json )を作成します。

```

{
  "setting": {
    "capability": "edit_theme_options" // テーマカスタマイザーを利用できる管理権限
  },
  "sections": {
    "gg_general_settings": { // セクションID
      "title": "テキスト系", // セクションのタイトル
      "priority": 10, // セクションの順番
      "setting": {
        "general_keywords": { // セッティングID
          "transport": "postMessage", // javascriptでリアルタイム反映させる場合は "postMessage", リロードする場合は "refresh"
          "default": "", // 初期値
          "label": "通常のテキスト", // セッティングのラベル
          "type": "option" // セッティングのタイプ
        }
      }
    }
  }
}

```

2. セッティングファイルを FTP などでサイト内にアップロード。
  又は、Gist や Drop Box などに設置。

3. 管理画面設定画面にて、上記設定ファイルの URL を 入力


## Option Type

* text : テキストボックス
* textarea : テキストエリア
* text-editor : テキストエディター
* color : カラーピッカー
* image : メディアアップロード
* layout-picker : レイアウトピッカー
* date-picker : 日付ピッカー
* category-dropdown : カテゴリードロップダウン
* google-font : Google Font
* menu-dropdown : メニュードロップダウン
* post-dropdown : 投稿ドロップダウン
* post-type-dropdown : 投稿タイプドロップダウン
* taxonomy-dropdown : タクソノミードロップダウン
* user-dropdown : ユーザードロップダウン

## TODO

* 管理画面からGUIでオプションの設定を可能に
* カスタマイザープレビュー用の javascript を自動出力
* 設定に応じて動的にCSSを出力
* ページ毎に設定項目の変更
