#!/usr/bin/python
# -*- coding: utf-8 -*-

import mysql.connector

from operator import itemgetter

cnx = mysql.connector.connect(user = 'ubuntu', database = 'pmzero')
new_record = cnx.cursor(buffered = True)
insert_update = cnx.cursor()

# new records
insert_games = (
  "INSERT INTO Games SET "
  "gameID = %s, gameTime = %s, "
  "1stWind = %s, 1stName = %s, 1stScore = %s, "
  "2ndWind = %s, 2ndName = %s, 2ndScore = %s, "
  "3rdWind = %s, 3rdName = %s, 3rdScore = %s, "
  "4thWind = %s, 4thName = %s, 4thScore = %s, "
  "leftover = %s, valid = 1;"
)

update_cache_new = ("UPDATE Cache SET new = 0 WHERE gameID = %s;")

query = ("SELECT * FROM Cache WHERE new = 1;")
new_record.execute(query)

for (gameID, gameTime, eastName, eastScore, southName, southScore, westName, westScore, northName, northScore, leftover, new, edited) in new_record:
  players = [
    ["동", eastName, eastScore],
    ["남", southName, southScore],
    ["서", westName, westScore],
    ["북", northName, northScore]
  ]

  players_sorted = sorted(players, key = itemgetter(2), reverse = True)

  insert_update.execute(insert_games, 
    (gameID, gameTime, 
    players_sorted[0][0], players_sorted[0][1], players_sorted[0][2], 
    players_sorted[1][0], players_sorted[1][1], players_sorted[1][2], 
    players_sorted[2][0], players_sorted[2][1], players_sorted[2][2], 
    players_sorted[3][0], players_sorted[3][1], players_sorted[3][2], leftover))
  insert_update.execute(update_cache_new, (gameID,))

  cnx.commit()

#edited records
update_games = (
  "UPDATE Games SET "
  "gameID = %s, gameTime = %s, "
  "1stWind = %s, 1stName = %s, 1stScore = %s, "
  "2ndWind = %s, 2ndName = %s, 2ndScore = %s, "
  "3rdWind = %s, 3rdName = %s, 3rdScore = %s, "
  "4thWind = %s, 4thName = %s, 4thScore = %s, "
  "leftover = %s, valid = 1;"
)

update_cache_edited = ("UPDATE Cache SET edited = 0 WHERE gameID = %s;")

edited_record = cnx.cursor(buffered = True)
query = ("SELECT * FROM Cache WHERE edited = 1;")
edited_record.execute(query)

for (gameID, gameTime, eastName, eastScore, southName, southScore, westName, westScore, northName, northScore, leftover, new, edited) in edited_record:
  players = [
    ["동", eastName, eastScore],
    ["남", southName, southScore],
    ["서", westName, westScore],
    ["북", northName, northScore]
  ]

  players_sorted = sorted(players, key = itemgetter(2), reverse = True)

  insert_update.execute(update_games, 
    (gameID, gameTime, 
    players_sorted[0][0], players_sorted[0][1], players_sorted[0][2], 
    players_sorted[1][0], players_sorted[1][1], players_sorted[1][2], 
    players_sorted[2][0], players_sorted[2][1], players_sorted[2][2], 
    players_sorted[3][0], players_sorted[3][1], players_sorted[3][2], leftover))

  insert_update.execute(update_cache_edited, (gameID,))

  cnx.commit()

cnx.close()