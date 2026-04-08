#!/bin/bash
# =============================================================================
# Horntech ERP — First Time Server Setup Script
# Run this ONCE via SSH after cloning the repo on Namecheap shared hosting
# Usage: bash scripts/first_time_setup.sh
# =============================================================================

set -e  # Exit on any error

APP_DIR="$(pwd)"
PUBLIC_HTML="/home/$(whoami)/public_html"

echo "============================================"
echo "  Horntech ERP — First Time Setup"
echo "  App Dir   : $APP_DIR"
echo "  Public Dir: $PUBLIC_HTML"
echo "============================================"

# ── 1. Check we're in the right folder ───────────────────────────────────────
if [ ! -f "$APP_DIR/artisan" ]; then
    echo "ERROR: artisan not found. Run this script from the Laravel root folder."
    exit 1
fi

# ── 2. Create .env from example ──────────────────────────────────────────────
if [ ! -f "$APP_DIR/.env" ]; then
    echo "[1/8] Creating .env from .env.example..."
    cp "$APP_DIR/.env.example" "$APP_DIR/.env"
    echo "      !! Edit .env now with your DB credentials before continuing !!"
    echo "      Run: nano $APP_DIR/.env"
    exit 0
else
    echo "[1/8] .env already exists — skipping."
fi

# ── 3. Generate app key ───────────────────────────────────────────────────────
echo "[2/8] Generating application key..."
php8.2 artisan key:generate --force

# ── 4. Run migrations ─────────────────────────────────────────────────────────
echo "[3/8] Running database migrations (fresh install)..."
php8.2 artisan migrate:fresh --seed --force

# ── 5. Set storage permissions ────────────────────────────────────────────────
echo "[4/8] Setting folder permissions..."
chmod -R 775 storage bootstrap/cache
chmod -R 755 public

# ── 6. Link public_html to Laravel public folder ──────────────────────────────
echo "[5/8] Setting up public_html symlink..."
if [ -d "$PUBLIC_HTML" ] && [ ! -L "$PUBLIC_HTML" ]; then
    BACKUP="${PUBLIC_HTML}_backup_$(date +%Y%m%d_%H%M%S)"
    echo "      Backing up existing public_html to $BACKUP"
    mv "$PUBLIC_HTML" "$BACKUP"
fi

if [ ! -L "$PUBLIC_HTML" ]; then
    ln -s "$APP_DIR/public" "$PUBLIC_HTML"
    echo "      Symlink created: $PUBLIC_HTML -> $APP_DIR/public"
else
    echo "      Symlink already exists — skipping."
fi

# ── 7. Cache config, routes, views ───────────────────────────────────────────
echo "[6/8] Caching configuration..."
php8.2 artisan config:cache
php8.2 artisan route:cache
php8.2 artisan view:cache

# ── 8. Create storage symlink for public uploads ──────────────────────────────
echo "[7/8] Creating storage symlink..."
php8.2 artisan storage:link

# ── 9. Done ───────────────────────────────────────────────────────────────────
echo "[8/8] Done!"
echo ""
echo "============================================"
echo "  Setup Complete!"
echo "  Visit your domain to access the app."
echo "============================================"
