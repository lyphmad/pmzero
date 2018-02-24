#!/usr/bin/python
# -*- coding: utf-8 -*-

import mysql.connector

from operator import itemgetter

cnx = mysql.connector.connect(user = 'ubuntu', database = 'pmzero')
cache = cnx.cursor(buffered = True)
insert_update = cnx.cursor()
cursor_written = cnx.cursor()

query = ("SELECT * FROM Cache WHERE written = 0;")
cache.execute(query)

for (gameID, gameTime, eastName, eastScore, southName, southScore, westName, westScore, northName, northScore, leftover, written) in cache:
  players = [
    ["동", eastName, eastScore],
    ["남", southName, southScore],
    ["서", westName, westScore],
    ["북", northName, northScore]
  ]

  players_sorted = sorted(players, key = itemgetter(2), reverse = True)

  insert_games = (
    "INSERT INTO Games SET "
    "gameID = %s, gameTime = %s, "
    "1stWind = %s, 1stName = %s, 1stScore = %s, "
    "2ndWind = %s, 2ndName = %s, 2ndScore = %s, "
    "3rdWind = %s, 3rdName = %s, 3rdScore = %s, "
    "4thWind = %s, 4thName = %s, 4thScore = %s, "
    "leftover = %s, valid = 1;"
  )

  insert_update.execute(insert_games, 
    (gameID, gameTime, 
    players_sorted[0][0], players_sorted[0][1], players_sorted[0][2], 
    players_sorted[1][0], players_sorted[1][1], players_sorted[1][2], 
    players_sorted[2][0], players_sorted[2][1], players_sorted[2][2], 
    players_sorted[3][0], players_sorted[3][1], players_sorted[3][2], leftover))

  update_written = ("UPDATE Cache SET written = 1 WHERE gameID = %s;")
  cursor_written.execute(update_written, (gameID,))

  cnx.commit()

cnx.commit()
cnx.close()