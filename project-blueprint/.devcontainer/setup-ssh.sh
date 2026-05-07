#!/bin/bash

# Write the WP Engine SSH key from Codespace secrets to ~/.ssh/
if [ -n "$WPE_SSH_KEY_PRIVATE" ]; then
  mkdir -p ~/.ssh
  echo "$WPE_SSH_KEY_PRIVATE" > ~/.ssh/wpe_key
  chmod 600 ~/.ssh/wpe_key
  echo "Host *.ssh.wpengine.net
    IdentityFile ~/.ssh/wpe_key
    StrictHostKeyChecking accept-new" > ~/.ssh/config
  chmod 600 ~/.ssh/config
  echo "WP Engine SSH key configured."
else
  echo "Warning: WPE_SSH_KEY_PRIVATE secret not set. Run ddev auth ssh manually."
fi
