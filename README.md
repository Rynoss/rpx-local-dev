# RPX Local Dev — DDEV Addon

DDEV addon for local WordPress development with WP Engine. Provides `rpx-*` commands for pulling sites from WP Engine and running them locally.

## What This Addon Provides

| Command | Description |
|---|---|
| `ddev rpx-setup` | First-time setup (download WP, pull files + DB, configure everything) |
| `ddev rpx-pull` | Pull both files and database from WP Engine |
| `ddev rpx-db` | Pull only the database |
| `ddev rpx-files` | Pull only files (themes, plugins, uploads) |

## Per-Project Setup

Each project repo needs 3 things:

### 1. `.ddev/config.yaml`
```yaml
name: clientsite
type: wordpress
php_version: "8.4"
webserver_type: nginx-fpm
performance_mode: mutagen
```

### 2. `.env`
```env
WPENGINE_ENV=clientsite
PRODUCTION_URL=https://www.clientsite.com
CHILD_THEME_NAME=theme-3-child
IS_MULTISITE=no
```

### 3. `.ddev/commands/host/rpx-init` (thin wrapper)
```bash
#!/bin/bash
## Description: Initialize RPX local dev
## Usage: rpx-init
## Example: ddev rpx-init
ddev add-on get Rynoss/rpx-local-dev
ddev rpx-setup
```

## Developer Workflow

**First time:**
```bash
git clone git@github.com:Rynoss/clientsite.git
cd clientsite
ddev start
ddev rpx-init
```

**Daily:**
```bash
cd clientsite
ddev start
```

**Refresh from production:**
```bash
ddev rpx-pull
```

## Supports

- Single WordPress sites
- Multisite networks (subdirectory routing)
- Automatic HTTPS via DDEV
- Automatic DNS (*.ddev.site)
- PHP 8.4 with WP-CLI
- Debug logging (errors logged to file, not shown on page)
