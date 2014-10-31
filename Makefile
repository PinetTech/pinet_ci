################################################################################
#
# The make file
#
# @author Jack
# @date Wed Sep 17 11:44:55 2014
# @version 1.0
#
################################################################################


################################################################################
#
# Constants
#
################################################################################

TEST_DB := pinet_php_test
DB := pinet_php

################################################################################
#
# Applications
#
################################################################################

SSH := ssh
ECHO := echo
PHP := php
MYSQL := mysql
MYSQL_USER := root
AWK := awk
DB_VERSION := $(shell ls application/migrations/ | sort -n | tail -n 1 | ${AWK} -F '_' '{print $$1}')

################################################################################
#
# Defines
#
################################################################################

define migrate_db
	@${ECHO} Doing the migrations...
	@PINET_WEB_ENV=$2 ${PHP} index.php migrate version $3
	@${ECHO} Showing the tables...
	@${MYSQL} -u ${MYSQL_USER} $1 -e "show tables"
endef

define recreate_db
	@${ECHO} Dropping the database $1...
	@${MYSQL} -u ${MYSQL_USER} -e "drop database if exists $1"
	@${ECHO} Recreate the database $1...
	@${MYSQL} -u ${MYSQL_USER} -e "create database $1"
	$(call migrate_db,$1,$2,${DB_VERSION})
endef

################################################################################
#
# Tasks
#
################################################################################

test:
	@PINET_WEB_ENV=testing ./phpunit .
test_db:
	@$(call recreate_db,${TEST_DB},"testing")
db:
	@$(call recreate_db,${DB},"default")
dep:
	@while read -r file; do \
		${PHP} tools/spark install $$file; \
	done < deps
tags:
	ctags -R .
c:
	${MYSQL} -u ${MYSQL_USER} ${DB}
ct:
	${MYSQL} -u ${MYSQL_USER} ${TEST_DB}
migrate:
	@$(call migrate_db,${DB},"default",${MV})
