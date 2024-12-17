# Laravel バックエンド環境構築手順

## 1. 環境準備

### 1.1 PHPコンテナの設定
`tasty-note-docker/php/Dockerfile`:
```dockerfile
FROM php:8.1.29-fpm

# システムの依存パッケージをインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libssl-dev \
    ca-certificates \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && update-ca-certificates

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリの設定
WORKDIR /var/www/html

# ユーザーを作成
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# パーミッションの設定
RUN chown -R www:www /var/www

# ユーザーの切り替え
USER www

# コンテナ起動時のコマンド
CMD ["php-fpm"]

EXPOSE 9000
```

### 1.2 環境の起動
```bash
docker compose down
docker compose build php
docker compose up -d
```

## 2. Laravelのインストールと初期設定

### 2.1 Laravelのインストール
```bash
docker compose exec php bash
composer create-project laravel/laravel .
```

### 2.2 環境設定
`.env`ファイルを以下の内容で編集：
```env
APP_NAME=TastyNote
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=tasty_note
DB_USERNAME=tasty_note
DB_PASSWORD=password
```

### 2.3 アプリケーションキーの生成
```bash
php artisan key:generate
```

### 2.4 ストレージのパーミッション設定
```bash
chmod -R 775 storage bootstrap/cache
```

### 2.5 キャッシュクリア
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## 3. データベースマイグレーション

### 3.1 マイグレーションファイルの作成
```bash
# 店舗テーブル
docker compose exec php php artisan make:migration create_stores_table

# フォルダテーブル
docker compose exec php php artisan make:migration create_folders_table

# タグ関連テーブル
docker compose exec php php artisan make:migration create_tags_table
docker compose exec php php artisan make:migration create_store_tags_table

# 写真テーブル
docker compose exec php php artisan make:migration create_photos_table
```

### 3.2 マイグレーションファイルの内容

#### stores テーブル
```php
Schema::create('stores', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('no action');
    $table->string('place_id')->unique()->comment('Google Places ID');
    $table->text('memo')->nullable()->comment('ユーザーメモ');
    $table->timestamp('last_checked_at')->nullable()->comment('Places API最終確認日時');
    $table->enum('status', ['active', 'closed', 'unknown'])->default('active')->comment('店舗状態');
    $table->timestamps();

    $table->index('user_id');
    $table->index('status');
});
```

#### folders テーブル
```php
Schema::create('folders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('no action');
    $table->string('name');
    $table->text('description')->nullable();
    $table->string('share_url')->nullable()->unique();
    $table->timestamp('share_expired_at')->nullable();
    $table->timestamps();

    $table->index('user_id');
    $table->index('share_url');
});
```

#### tags テーブル
```php
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->timestamps();
    
    $table->index('name');
});
```

#### store_tags テーブル
```php
Schema::create('store_tags', function (Blueprint $table) {
    $table->id();
    $table->foreignId('store_id')->constrained()->onDelete('no action');
    $table->foreignId('tag_id')->constrained()->onDelete('no action');
    $table->timestamp('created_at');

    $table->unique(['store_id', 'tag_id']);
    $table->index('store_id');
    $table->index('tag_id');
});
```

#### photos テーブル
```php
Schema::create('photos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('no action');
    $table->foreignId('store_id')->constrained()->onDelete('no action');
    $table->string('path');
    $table->string('title')->nullable();
    $table->text('description')->nullable();
    $table->timestamps();

    $table->index('user_id');
    $table->index('store_id');
});
```

### 3.3 マイグレーションの実行
```bash
docker compose exec php php artisan migrate
```

### 3.4 マイグレーションの確認
```bash
docker compose exec php php artisan migrate:status
```

## 4. 開発時の注意点

### 4.1 作業場所の使い分け
- **ホスト側で行うこと**
  - ソースコードの編集（PHP, HTML, CSS, JavaScript など）
  - 設定ファイルの編集
  - Gitによるバージョン管理
  - ドキュメントの作成・編集

- **コンテナ内で行うこと**
  - artisanコマンドの実行
  - データベース操作
  - composerコマンドの実行
  - その他PHPやMySQLに関連する操作

### 4.2 コマンド実行方法
ホスト側から以下のようにコマンドを実行可能：
```bash
docker compose exec php php artisan {command}
docker compose exec php composer {command}
```

