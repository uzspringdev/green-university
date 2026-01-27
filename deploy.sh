#!/bin/bash

# Configuration
REPO_URL="https://github.com/uzspringdev/green-university.git"
PROJECT_DIR="/var/www/green-university"
BRANCH="main"

echo "🚀 Starting Deployment..."

# 1. Update System & Install Dependencies
echo "📦 Installing system dependencies..."
sudo apt update
sudo apt install -y git zip unzip php php-cli php-fpm php-pgsql php-mbstring php-xml php-curl composer nginx postgresql

# 2. Clone or Pull Repository
if [ -d "$PROJECT_DIR" ]; then
    echo "🔄 Directory exists. Pulling latest changes..."
    cd $PROJECT_DIR
    git pull origin $BRANCH
else
    echo "⬇️ Cloning repository..."
    sudo git clone $REPO_URL $PROJECT_DIR
    cd $PROJECT_DIR
fi

# 3. Install Composer Dependencies
echo "📚 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# 4. Init Yii2 Environment (Production)
echo "⚙️ Initializing Yii2 Environment..."
php init --env=Production --overwrite=All

# 5. Fix Permissions
echo "🔒 Fixing file permissions..."
sudo chown -R www-data:www-data $PROJECT_DIR
sudo chmod -R 775 $PROJECT_DIR/backend/runtime
sudo chmod -R 775 $PROJECT_DIR/backend/web/assets
sudo chmod -R 775 $PROJECT_DIR/frontend/runtime
sudo chmod -R 775 $PROJECT_DIR/frontend/web/assets
sudo chmod -R 775 $PROJECT_DIR/frontend/web/uploads
sudo chmod -R 775 $PROJECT_DIR/backend/web/uploads

# 6. Database Migration (Optional - Unomment if DB is configured)
# echo "🗄️ Running Migrations..."
# php yii migrate/up --interactive=0

echo "✅ Deployment Finished! Check Nginx config manually."
