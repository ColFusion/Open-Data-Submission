To restore a backup:

# Set path to backup folder
BACKUP_DIR=/path/to/backup

# Set path to open-data-submission
ODS_DIR=/path/to/ods

# database params
MYSQLSERVERNAME=NAME
MYSQLUSERNAME=USERNAME
MYSQLDATABASE_NAME=DATABASE_NAME

mysql -u "${MYSQLSERVERNAME}" -p -h "${MYSQLSERVERNAME}" -D "${MYSQLDATABASE_NAME}"  < "${BACKUP_DIR}/mysql.sql"

cp -r "${BACKUP_DIR}/files" "${ODS_DIR}/server"
