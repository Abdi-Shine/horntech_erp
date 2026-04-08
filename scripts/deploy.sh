#!/bin/bash
# =============================================================================
# Horntech ERP — Manual Deploy Script
# Run this on the server after every git pull (if not using GitHub Actions)
# Usage: bash scripts/deploy.sh
# =============================================================================

set -e

APP_DIR="$(pwd)"
echo "============================================"
echo "  Horntech ERP — Manual Deploy"
echo "  Dir: $APP_DIR"
echo "============================================"

# ── 1. Pull latest code ───────────────────────────────────────────────────────
echo "[1/6] Pulling latest code from GitHub..."
git pull origin main

# ── 2. Install/update Composer packages ──────────────────────────────────────
echo "[2/6] Installing Composer dependencies..."
php8.2 composer.phar install --no-dev --optimize-autoloader --no-interaction

# ── 3. Run migrations ─────────────────────────────────────────────────────────
echo "[3/6] Running migrations..."
php8.2 artisan migrate --force

# ── 4. Clear & rebuild caches ────────────────────────────────────────────────
echo "[4/6] Rebuilding caches..."
php8.2 artisan config:clear && php8.2 artisan config:cache
php8.2 artisan route:clear  && php8.2 artisan route:cache
php8.2 artisan view:clear   && php8.2 artisan view:cache

# ── 5. Set permissions ────────────────────────────────────────────────────────
echo "[5/6] Setting permissions..."
chmod -R 775 storage bootstrap/cache

# ── 6. Done ───────────────────────────────────────────────────────────────────
echo "[6/6] Done!"
echo "============================================"
echo "  Deployment complete!"
echo "============================================"
