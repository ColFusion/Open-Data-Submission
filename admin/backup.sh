#!/usr/bin/env bash
set -o errexit

# Usage: config_val CONFIG_FILE KEY
function config_val()
{
    awk -F "=" "/$2/ "'{print $2}' "$1" | tr -d ' '
}

echo "Running backup.sh script as user: " $(whoami)

ODS_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )"/.. && pwd )"
SERVER_DIR="${ODS_DIR}/server"

BACKUPS="${ODS_DIR}/backups"
WORKINGDIR="$(mktemp -d)"
TIMESTAMP="$(date +%Y-%m-%d_%H-%M-%S)"

CONFIG_INI="${ODS_DIR}/config.ini"
MYSQL_SERVERNAME="$(config_val "${CONFIG_INI}" mysql_servername)"
MYSQL_USERNAME="$(config_val "${CONFIG_INI}" mysql_username)"
MYSQL_PASSWORD="$(config_val "${CONFIG_INI}" mysql_password)"
MYSQL_DATABASE_NAME="$(config_val "${CONFIG_INI}" mysql_database_name)"

mkdir -p "${WORKINGDIR}/${TIMESTAMP}"

cd "${WORKINGDIR}/${TIMESTAMP}"

# TODO: Don't acceopt open data submissions while backing up

cp -r "${SERVER_DIR}/files" .

## MySQL

mysqldump -h "${MYSQL_SERVERNAME}" -u"${MYSQL_USERNAME}" -p"${MYSQL_PASSWORD}" "${MYSQL_DATABASE_NAME}" > mysql.sql

cd "${WORKINGDIR}"
tar cvzf "${BACKUPS}/${TIMESTAMP}.tar.gz" "${TIMESTAMP}"

cd /
rm -r "${WORKINGDIR}"

echo "Done with backup.sh"
