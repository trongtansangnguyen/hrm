#!/bin/bash
# HRM Database Backup Script
# Usage: bash backup.sh

BACKUP_DIR="${BACKUP_DIR:-/backups}"
DB_USER="${DB_USER:-hrm_user}"
DB_NAME="${DB_NAME:-hrm}"

mkdir -p "$BACKUP_DIR"

BACKUP_FILE="$BACKUP_DIR/hrm_$(date +%F_%H-%M-%S).sql"

echo "Backing up $DB_NAME to $BACKUP_FILE..."
mysqldump -u "$DB_USER" -p "$DB_NAME" > "$BACKUP_FILE"

if [ $? -eq 0 ]; then
  echo "Backup completed: $BACKUP_FILE"
  # Optional: compress
  gzip "$BACKUP_FILE"
  echo "Compressed: ${BACKUP_FILE}.gz"
else
  echo "Backup failed!"
  exit 1
fi
