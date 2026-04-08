#!/bin/bash

# Deployment Setup Script for Namecheap Shared Hosting
# Run this ONCE on the server after the first 'git clone'

APP_NAME="horntech_erp"
APP_DIR="/home/$(whoami)/$APP_NAME"
PUBLIC_HTML="/home/$(whoami)/public_html"

echo "Starting initial deployment setup..."

cd $APP_DIR

# 1. Setup .env if it doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
    echo "Please edit .env manually to update DB credentials."
fi

# 2. Storage Permissions
echo "Setting storage permissions..."
chmod -R 775 storage bootstrap/cache

# 3. Create Symlink for Public Access
if [ -d "$PUBLIC_HTML" ] && [ ! -L "$PUBLIC_HTML" ]; then
    echo "Backing up existing public_html..."
    mv "$PUBLIC_HTML" "${PUBLIC_HTML}_backup_$(date +%Y%m%d)"
fi

if [ ! -L "$PUBLIC_HTML" ]; then
    echo "Creating symlink from $APP_DIR/public to $PUBLIC_HTML..."
    ln -s "$APP_DIR/public" "$PUBLIC_HTML"
fi

echo "Setup complete. Don't forget to:"
echo "1. Update your .env file with production credentials."
echo "2. Run 'php artisan key:generate' and 'php artisan migrate'."
