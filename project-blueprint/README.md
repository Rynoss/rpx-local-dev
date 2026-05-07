# Project Blueprint

This folder is the **blueprint** for what each new RPX project repo should contain. The devops pipeline (or any provisioning tool) pulls these files into a fresh repo and substitutes placeholders.

## How the pipeline uses this folder

1. Pull `Rynoss/rpx-local-dev` (this repo).
2. Copy the contents of `project-blueprint/` (NOT this README) into the target repo.
3. Substitute placeholders (see table below).
4. Rename `.env.template` to `.env`.
5. **Append** `.gitignore-additions` to the repo's existing `.gitignore` (do not overwrite). Then delete `.gitignore-additions`.
6. **Append** `.deployignore-additions` to the repo's existing `.deployignore` (do not overwrite). Then delete `.deployignore-additions`.
7. Commit and push the result.

## Files in this blueprint

```
.ddev/config.yaml                     # has {{REPO_NAME}}
.ddev/commands/host/rpx-init          # identical across repos
.devcontainer/devcontainer.json       # identical across repos
.devcontainer/setup-ssh.sh            # identical across repos
.env.template                         # rename to .env, fill placeholders
.gitignore-additions                  # append to existing .gitignore
.deployignore-additions               # append to existing .deployignore
```

## Placeholders

| Placeholder | Example value | Where it appears |
|---|---|---|
| `{{REPO_NAME}}` | `clientname-theme` | `.ddev/config.yaml` |
| `{{WPENGINE_ENV}}` | `clientnameprd` | `.env.template` |
| `{{PRODUCTION_URL}}` | `https://www.clientname.com` | `.env.template` |
| `{{ACTIVE_THEME_NAME}}` | `theme-3-child` | `.env.template` |
| `{{IS_MULTISITE}}` | `yes` or `no` | `.env.template` |

`ACTIVE_THEME_NAME` is whatever WordPress treats as the active theme — the directory name under `wp-content/themes/` on WP Engine. Use the child theme directory name if there is one, otherwise the parent theme directory name.

## Example pipeline (bash)

```bash
# 1. Pull blueprint
git clone --depth 1 https://github.com/Rynoss/rpx-local-dev /tmp/rpx-local-dev
cp -r /tmp/rpx-local-dev/project-blueprint/. ./

# 2. Substitute placeholders
sed -i "s|{{REPO_NAME}}|${REPO_NAME}|g" .ddev/config.yaml
sed -i "s|{{WPENGINE_ENV}}|${WPENGINE_ENV}|g" .env.template
sed -i "s|{{PRODUCTION_URL}}|${PRODUCTION_URL}|g" .env.template
sed -i "s|{{ACTIVE_THEME_NAME}}|${ACTIVE_THEME_NAME}|g" .env.template
sed -i "s|{{IS_MULTISITE}}|${IS_MULTISITE}|g" .env.template

# 3. Rename .env.template -> .env
mv .env.template .env

# 4. Append .gitignore-additions and .deployignore-additions
touch .gitignore .deployignore
cat .gitignore-additions >> .gitignore && rm .gitignore-additions
cat .deployignore-additions >> .deployignore && rm .deployignore-additions

# 5. Remove the blueprint README (this file isn't copied — it stays in the addon repo)
```

## Codespaces setup (one-time per GitHub org)

In **GitHub org settings → Codespaces → Secrets**, add:

- `WPE_SSH_KEY_PRIVATE` — WP Engine SSH private key, granted access to all theme repos that need it.

## Developer experience after the pipeline runs

```bash
git clone <repo>
cd <repo>
ddev start
ddev rpx-init
```

`rpx-init` installs this addon and runs `rpx-setup`, which downloads WordPress into `.ddev/wp/`, symlinks the active theme to the repo root, and pulls files + DB from WP Engine.
