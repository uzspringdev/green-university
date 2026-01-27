#!/bin/bash

# ==========================================
# Green University - Production Deployment Script v2.0
# ==========================================

# Configuration
REPO_URL="https://github.com/uzspringdev/green-university.git"
PROJECT_DIR="/var/www/green-university"
BRANCH="main"
NGINX_CONF="/etc/nginx/sites-available/green-university.conf"
NGINX_LINK="/etc/nginx/sites-enabled/green-university.conf"

echo "🚀 Starting Deployment for Green University..."

# --- 1. Interactive Configuration ---
read -p "🌐 Enter Main Domain (e.g., admission.rirm.uz): " DOMAIN
read -p "🔧 Enter Admin Domain (e.g., adminadmission.rirm.uz): " ADMIN_DOMAIN
read -s -p "🔑 Enter Database Password (for 'postgres' user): " DB_PASSWORD
echo ""
read -p "👤 Do you want to create a default Admin user? (y/n): " CREATE_ADMIN

if [ -z "$DOMAIN" ] || [ -z "$ADMIN_DOMAIN" ]; then
    echo "❌ Error: Domains cannot be empty."
    exit 1
fi

# --- 2. System Dependencies ---
echo "📦 Checking system dependencies..."
# Only install if missing to save time/avoid conflicts
function install_if_missing {
    if ! dpkg -s $1 >/dev/null 2>&1; then
        echo "Installing $1..."
        sudo apt install -y $1
    fi
}

sudo apt update
install_if_missing git
install_if_missing zip
install_if_missing unzip
install_if_missing nginx
install_if_missing postgresql
install_if_missing composer

# PHP needs version handling, checking generically for cli/fpm
if ! command -v php &> /dev/null; then
    sudo apt install -y php php-cli php-fpm php-pgsql php-mbstring php-xml php-curl
fi

# --- 3. Repository Setup ---
if [ -d "$PROJECT_DIR" ]; then
    echo "🔄 Directory exists. Resetting and pulling latest changes..."
    cd $PROJECT_DIR
    # Fix 'dubious ownership' issues
    git config --global --add safe.directory $PROJECT_DIR
    git reset --hard origin/$BRANCH
    git pull origin $BRANCH
else
    echo "⬇️ Cloning repository..."
    sudo git clone $REPO_URL $PROJECT_DIR
    cd $PROJECT_DIR
    git config --global --add safe.directory $PROJECT_DIR
fi

# --- 4. Dependencies & Environment ---
echo "📚 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "⚙️ Initializing Yii2 Environment..."
php init --env=Production --overwrite=All

# --- 5. Database Configuration ---
echo "🗄️ Configuring Database Connection..."
sed -i "s/'password' => ''/'password' => '$DB_PASSWORD'/g" common/config/main-local.php

# Create DB if not exists
sudo -u postgres psql -lqt | cut -d \| -f 1 | grep -qw green_university
if [ $? -ne 0 ]; then
    echo "Creating database 'green_university'..."
    sudo -u postgres psql -c "CREATE DATABASE green_university;"
else
    echo "Database 'green_university' already exists."
fi

# --- 6. Nginx Configuration ---
echo "🌐 Configuring Nginx..."
cp deployment/nginx.conf $NGINX_CONF

# Detect PHP Version dynamically
PHP_VERSION=$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')
echo "🐘 Detected PHP Version: $PHP_VERSION"

# Update Config with Real Values
sed -i "s|{{FRONTEND_DOMAIN}}|$DOMAIN|g" $NGINX_CONF
sed -i "s|{{BACKEND_DOMAIN}}|$ADMIN_DOMAIN|g" $NGINX_CONF
sed -i "s|{{PROJECT_ROOT}}|$PROJECT_DIR|g" $NGINX_CONF
sed -i "s|php8.1-fpm.sock|php$PHP_VERSION-fpm.sock|g" $NGINX_CONF

# Enable Site (Symlink)
if [ ! -f "$NGINX_LINK" ]; then
    sudo ln -sf $NGINX_CONF $NGINX_LINK
fi

# Disable default site ONLY if user wants (safety check)
# sudo rm -f /etc/nginx/sites-enabled/default 

# --- 7. Permissions & Logs ---
echo "🔒 Setting Permissions..."
mkdir -p frontend/runtime/logs backend/runtime/logs frontend/web/assets backend/web/assets frontend/web/uploads backend/web/uploads
sudo chown -R www-data:www-data $PROJECT_DIR
sudo chmod -R 775 frontend/runtime backend/runtime frontend/web/assets backend/web/assets frontend/web/uploads backend/web/uploads
sudo chmod +x yii

# --- 8. Migrations ---
echo "🔄 Running Database Migrations..."
php yii migrate/up --interactive=0

# --- 9. Cache Flushing (Aggressive) ---
echo "🧹 Flushing Caches..."
php yii cache/flush-schema db
php yii cache/flush-all
# Manually clear file cache just in case
sudo rm -rf frontend/runtime/cache/* backend/runtime/cache/*

# --- 10. Admin User Creation ---
if [ "$CREATE_ADMIN" == "y" ]; then
    read -p "Enter Admin Email: " ADMIN_EMAIL
    read -s -p "Enter Admin Password: " ADMIN_PASS
    echo ""
    echo "Creating Admin User..."
    php yii user/create admin $ADMIN_EMAIL $ADMIN_PASS
fi

# --- 11. Final Service Restart ---
echo "🔄 Restarting Services..."
# Restart PHP-FPM to clear OpCache
sudo systemctl restart php$PHP_VERSION-fpm
sudo systemctl reload nginx

echo "=========================================="
echo "✅ DEPLOYMENT COMPLETE!"
echo "🌍 Frontend: http://$DOMAIN"
echo "🔧 Backend:  http://$ADMIN_DOMAIN"
echo "=========================================="
