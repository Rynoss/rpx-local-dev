# RPX Local Dev — DDEV Addon

DDEV addon for local WordPress development with WP Engine. Pulls a site from WP Engine and runs it locally via DDEV.

## Architecture

The project repo IS the active theme. WordPress is installed into `.ddev/wp/` on the host (gitignored), and the active theme directory inside that install is symlinked back to the repo root. Local PHP constants live in `.ddev/wp-config-local.php` — editable, survives restarts, gitignored.

| Path on host | Purpose |
|---|---|
| Repo root | Active theme files (style.css, functions.php, etc.) |
| `.ddev/wp/` | Full WordPress install (gitignored) |
| `.ddev/wp/wp-content/themes/<active>/` | Symlink back to repo root |
| `.ddev/wp-config-local.php` | Editable local constants (gitignored) |

## Commands

| Command | Description |
|---|---|
| `ddev rpx-setup` | First-time setup (download WP, symlink theme, pull files + DB, configure) |
| `ddev rpx-pull` | Pull both files and database from WP Engine |
| `ddev rpx-db` | Pull only the database |
| `ddev rpx-files` | Pull only files (themes, plugins, uploads) |

## Per-Project Setup

The blueprint of files each project repo needs lives in [`_project_dev_blueprint/`](./_project_dev_blueprint/) — devops pipelines pull from there. Below is what ends up in each repo:

### `.ddev/config.yaml`
```yaml
name: clientsite
type: wordpress
php_version: "8.4"
webserver_type: nginx-fpm
performance_mode: mutagen
```

`docroot: .ddev/wp` is added by `rpx-setup` automatically.

### `.env`
```env
WPENGINE_ENV=clientsite
PRODUCTION_URL=https://www.clientsite.com
ACTIVE_THEME_NAME=theme-3-child
IS_MULTISITE=no
```

### `.ddev/commands/host/rpx-init`
```bash
#!/bin/bash
## Description: Initialize RPX local dev
## Usage: rpx-init
## Example: ddev rpx-init
ddev add-on get Rynoss/rpx-local-dev
ddev rpx-setup
```

## Developer Workflow

```bash
git clone git@github.com:Rynoss/clientsite.git
cd clientsite
ddev start
ddev rpx-init
```

Daily:
```bash
cd clientsite
ddev start
```

Refresh from production:
```bash
ddev rpx-pull
```

## Supports

- Single WordPress sites
- Multisite networks (subdirectory routing)
- Automatic HTTPS via DDEV
- PHP 8.4 with WP-CLI
- GitHub Codespaces
