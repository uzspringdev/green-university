#!/bin/bash

# ==========================================
# Green University - Automated Deployment Script
# ==========================================

REPO_URL="https://github.com/uzspringdev/green-university.git"
PROJECT_DIR="/var/www/green-university"
BRANCH="main"

echo "🚀 Starting Deployment for Green University..."

# --- Interactive Prompts ---
read -p "🌐 Enter Main Domain (e.g., green-university.uz): " DOMAIN
read -p "🔧 Enter Admin Domain (e.g., admin.green-university.uz): " ADMIN_DOMAIN
read -s -p "🔑 Enter Database Password (for 'postgres' user): " DB_PASSWORD
echo ""

if [ -z "$DOMAIN" ] || [ -z "$ADMIN_DOMAIN" ]; then
    echo "❌ Error: Domains cannot be empty."
    exit 1
fi

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

# 5. Configure Database (Update main-local.php)
echo "🗄️ Configuring Database..."
sed -i "s/'password' => ''/'password' => '$DB_PASSWORD'/g" common/config/main-local.php

# 6. Configure Nginx
echo "🌐 Configuring Nginx..."
cp deployment/nginx.conf /etc/nginx/sites-available/green-university.conf

# Replace placeholders in Nginx config
sed -i "s|{{FRONTEND_DOMAIN}}|$DOMAIN|g" /etc/nginx/sites-available/green-university.conf
sed -i "s|{{BACKEND_DOMAIN}}|$ADMIN_DOMAIN|g" /etc/nginx/sites-available/green-university.conf
sed -i "s|{{PROJECT_ROOT}}|$PROJECT_DIR|g" /etc/nginx/sites-available/green-university.conf

# Enable Site
sudo ln -sf /etc/nginx/sites-available/green-university.conf /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl restart nginx

# 7. Fix Permissions
echo "🔒 Fixing file permissions..."
sudo chown -R www-data:www-data $PROJECT_DIR
sudo chmod -R 775 $PROJECT_DIR/backend/runtime
sudo chmod -R 775 $PROJECT_DIR/backend/web/assets
sudo chmod -R 775 $PROJECT_DIR/frontend/runtime
sudo chmod -R 775 $PROJECT_DIR/frontend/web/assets
sudo chmod -R 775 $PROJECT_DIR/frontend/web/uploads
sudo chmod -R 775 $PROJECT_DIR/backend/web/uploads
sudo chmod +x yii

# 8. Database Migration
echo "🔄 Running Migrations..."
# Note: Ensure postgres user exists and DB 'green_university' is created. 
# We can try to create it if it doesn't exist (requires sudo -u postgres)
sudo -u postgres psql -c "CREATE DATABASE green_university;" 2>/dev/null || echo "DB likely exists"
# Set password for postgres user if needed (optional, assuming user knows what they are doing)
# sudo -u postgres psql -c "ALTER USER postgres PASSWORD '$DB_PASSWORD';"

php yii migrate/up --interactive=0

echo "✅ Deployment Finished Successfully!"
echo "🌍 Frontend: http://$DOMAIN"
echo "🔧 Backend:  http://$ADMIN_DOMAIN"
