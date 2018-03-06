#!/usr/bin/python
# -*- coding: utf-8 -*-

import mysql.connector
import time

from operator import itemgetter

def create_or_update(table, name, score, place, pm):
	cursor = cnx.cursor()
	cursor.execute("insert ignore into `{}` set name = '{}';".format(table, name.encode('utf-8')))
	if place == 1:
		cursor.execute("update `{}` set score = score + {}, first = first + {}, total = total + {} where name = '{}';".format(table, score / 1000 + 10, pm, pm, name.encode('utf-8')))
	elif place == 2:
		cursor.execute("update `{}` set score = score + {}, second = second + {}, total = total + {} where name = '{}';".format(table, score / 1000 - 20, pm, pm, name.encode('utf-8')))
	elif place == 3:
		cursor.execute("update `{}` set score = score + {}, third = third + {}, total = total + {} where name = '{}';".format(table, score / 1000 - 40, pm, pm, name.encode('utf-8')))
	elif place == 4:
		cursor.execute("update `{}` set score = score + {}, fourth = fourth + {}, total = total + {} where name = '{}';".format(table, score / 1000 - 50, pm, pm, name.encode('utf-8')))

	return

cnx = mysql.connector.connect(user = 'ubuntu', database = 'pmzero')
not_select = cnx.cursor()

# new records
new_record = cnx.cursor(buffered = True)
new_record.execute("SELECT * FROM Cache WHERE new = 1;")

for (gameID, gameTime, eastName, eastScore, southName, southScore, westName, westScore, northName, northScore, leftover, new, edited, deleted) in new_record:
	players = [
		["동", eastName, eastScore],
		["남", southName, southScore],
		["서", westName, westScore],
		["북", northName, northScore]
	]

	players_sorted = sorted(players, key = itemgetter(2), reverse = True)

	query = (
		"INSERT INTO Games SET "
		"gameID = %s, gameTime = %s, "
		"1stWind = %s, 1stName = %s, 1stScore = %s, "
		"2ndWind = %s, 2ndName = %s, 2ndScore = %s, "
		"3rdWind = %s, 3rdName = %s, 3rdScore = %s, "
		"4thWind = %s, 4thName = %s, 4thScore = %s, "
		"leftover = %s, valid = 1;"
	)
	not_select.execute(query, 
		(gameID, gameTime, 
		players_sorted[0][0], players_sorted[0][1], players_sorted[0][2], 
		players_sorted[1][0], players_sorted[1][1], players_sorted[1][2], 
		players_sorted[2][0], players_sorted[2][1], players_sorted[2][2], 
		players_sorted[3][0], players_sorted[3][1], players_sorted[3][2], leftover))

	create_or_update("Career_ranking", players_sorted[0][1], players_sorted[0][2], 1, 1)
	create_or_update("Career_ranking", players_sorted[1][1], players_sorted[1][2], 2, 1)
	create_or_update("Career_ranking", players_sorted[2][1], players_sorted[2][2], 3, 1)
	create_or_update("Career_ranking", players_sorted[3][1], players_sorted[3][2], 4, 1)

	year_month = "{:%Y%m}".format(gameTime)
	not_select.execute("create table if not exists Month_ranking_" + year_month + " like Career_ranking;")
	create_or_update("Month_ranking_" + year_month, players_sorted[0][1], players_sorted[0][2], 1, 1)
	create_or_update("Month_ranking_" + year_month, players_sorted[1][1], players_sorted[1][2], 2, 1)
	create_or_update("Month_ranking_" + year_month, players_sorted[2][1], players_sorted[2][2], 3, 1)
	create_or_update("Month_ranking_" + year_month, players_sorted[3][1], players_sorted[3][2], 4, 1) 
	
	not_select.execute("UPDATE Cache SET new = 0 WHERE gameID = %s;", (gameID,))
	not_select.execute("delete from Month_ranking_{} where total = 0;".format(year_month))

	cnx.commit()

#edited records
edited_record = cnx.cursor(buffered = True)
edited_record.execute("SELECT * FROM Cache WHERE edited = 1;")

for (gameID, gameTime, eastName, eastScore, southName, southScore, westName, westScore, northName, northScore, leftover, new, edited, deleted) in edited_record:
	players = [
		["동", eastName, eastScore],
		["남", southName, southScore],
		["서", westName, westScore],
		["북", northName, northScore]
	]

	players_sorted = sorted(players, key = itemgetter(2), reverse = True)

	old_record = cnx.cursor(buffered = True)
	old_record.execute("SELECT * FROM Games WHERE gameID = %s;", (gameID,))
	for (old_gameID, old_gameTime, firstWind, firstName, firstScore, secondWind, secondName, secondScore,
		thirdWind, thirdName, thirdScore, fourthWind, fourthName, fourthScore, old_leftover, valid) in old_record:

		create_or_update("Career_ranking", firstName, 0 - firstScore, 1, -1)
		create_or_update("Career_ranking", secondName, 0 - secondScore, 2, -1)
		create_or_update("Career_ranking", thirdName, 0 - thirdScore, 3, -1)
		create_or_update("Career_ranking", fourthName, 0 - fourthScore, 4, -1)

		year_month = "{:%Y%m}".format(gameTime)
		not_select.execute("create table if not exists Month_ranking_" + year_month + " like Career_ranking;")
		create_or_update("Month_ranking_" + year_month, firstName, 0 - firstScore, 1, -1)
		create_or_update("Month_ranking_" + year_month, secondName, 0 - secondScore, 2, -1)
		create_or_update("Month_ranking_" + year_month, thirdName, 0 - thirdScore, 3, -1)
		create_or_update("Month_ranking_" + year_month, fourthName, 0 - fourthScore, 4, -1)    

	query = (
		"UPDATE Games SET "
		"gameID = %s, gameTime = %s, "
		"1stWind = %s, 1stName = %s, 1stScore = %s, "
		"2ndWind = %s, 2ndName = %s, 2ndScore = %s, "
		"3rdWind = %s, 3rdName = %s, 3rdScore = %s, "
		"4thWind = %s, 4thName = %s, 4thScore = %s, "
		"leftover = %s, valid = 1 WHERE gameID = %s;"
	)
	not_select.execute(query, 
		(gameID, gameTime, 
		players_sorted[0][0], players_sorted[0][1], players_sorted[0][2], 
		players_sorted[1][0], players_sorted[1][1], players_sorted[1][2], 
		players_sorted[2][0], players_sorted[2][1], players_sorted[2][2], 
		players_sorted[3][0], players_sorted[3][1], players_sorted[3][2],
		leftover, gameID))

	create_or_update("Career_ranking", players_sorted[0][1], players_sorted[0][2], 1, 1)
	create_or_update("Career_ranking", players_sorted[1][1], players_sorted[1][2], 2, 1)
	create_or_update("Career_ranking", players_sorted[2][1], players_sorted[2][2], 3, 1)
	create_or_update("Career_ranking", players_sorted[3][1], players_sorted[3][2], 4, 1)
	create_or_update("Month_ranking_" + year_month, players_sorted[0][1], players_sorted[0][2], 1, 1)
	create_or_update("Month_ranking_" + year_month, players_sorted[1][1], players_sorted[1][2], 2, 1)
	create_or_update("Month_ranking_" + year_month, players_sorted[2][1], players_sorted[2][2], 3, 1)
	create_or_update("Month_ranking_" + year_month, players_sorted[3][1], players_sorted[3][2], 4, 1)  

	not_select.execute("UPDATE Cache SET edited = 0 WHERE gameID = %s;", (gameID,))
	not_select.execute("delete from Month_ranking_{} where total = 0;".format(year_month))

	cnx.commit()

#deleted records
deleted_record = cnx.cursor(buffered = True)
deleted_record.execute("SELECT * FROM Cache WHERE deleted = 1;")

for (gameID, gameTime, eastName, eastScore, southName, southScore, westName, westScore, northName, northScore, leftover, new, edited, deleted) in deleted_record:
	create_or_update("Career_ranking", eastName, 0 - eastScore, 1, -1)
	create_or_update("Career_ranking", southName, 0 - southScore, 2, -1)
	create_or_update("Career_ranking", westName, 0 - westScore, 3, -1)
	create_or_update("Career_ranking", northName, 0 - northScore, 4, -1)

	year_month = "{:%Y%m}".format(gameTime)
	not_select.execute("create table if not exists Month_ranking_" + year_month + " like Career_ranking;")
	create_or_update("Month_ranking_" + year_month, eastName, 0 - eastScore, 1, -1)
	create_or_update("Month_ranking_" + year_month, southName, 0 - southScore, 2, -1)
	create_or_update("Month_ranking_" + year_month, westName, 0 - westScore, 3, -1)
	create_or_update("Month_ranking_" + year_month, northName, 0 - northScore, 4, -1)
	
	not_select.execute("update Games set valid = 0 where gameID = %s;", (gameID,))

	not_select.execute("UPDATE Cache SET deleted = 0 WHERE gameID = %s;", (gameID,))

	cnx.commit()

#delete members who played 0 games (after deletion)
not_select.execute("delete from Career_ranking where total = 0;")
not_select.execute("delete from Month_ranking_{} where total = 0;".format(year_month))

cnx.commit()

cnx.close()