#!/usr/bin/env bash
set -o errexit

echo "Running backup.sh script as user: " $(whoami)

ODS_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )"/.. && pwd )"
SERVER_DIR="${ODS_DIR}/server"

BACKUPS="${ODS_DIR}/backups"
WORKINGDIR="$(mktemp -d)"
TIMESTAMP="$(date +%Y-%m-%d_%H-%M-%S)"

MYSQL_SERVERNAME=TODO
MYSQL_USERNAME=TODO
MYSQL_PASSWORD=TODO
MYSQL_DATABASE_NAME=TODO

cd "${WORKINGDIR}"

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
