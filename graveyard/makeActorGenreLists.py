# Depends on 'allInfo.json' for having updated information.
# Writes new json documents, actors.json and genres.json.
# The json files can be converted to xml and put into our database.

# This was not used, ultimately. Alex found a way to fill the database
# from allInfo.json, not needing these new tables to link together.

import json

dctA = {}
dctG = {}
with open('allInfo.json', 'r') as src:
    # one film is one line
    for line in src:
        entry = json.loads(line)

    # the ".encode('ascii', 'ignore')" gets rid of pesky unicode style
        name = entry['name'].encode('ascii', 'ignore')

        aActors = entry['actors']
        if aActors != None:
            bActors = aActors.encode('ascii', 'ignore').split(', ')
            for a in bActors:
                if a not in dctA:
                    dctA[a] = [name]
                else:
                    dctA[a].append(name)

        aGenres = entry['genres']
        if aGenres != None:
            bGenres = aGenres.encode('ascii', 'ignore').split(', ')
            for g in bGenres:
                if g not in dctG:
                    dctG[g] = [name]
                else:
                    dctG[g].append(name)

with open('genres.json', 'w') as genres:
    for key in dctG.keys():
        genres.write("{" + '"' + key + '"' + ": [")
        x=0
        while x != len(dctG[key])-1:
            genres.write('"' + dctG[key][x]+ '",')
            x += 1
        genres.write('"' + dctG[key][x] + '"]}\n')

with open('actors.json', 'w') as actors:
    for key in dctA.keys():
        actors.write("{" + '"' + key + '"' + ": [")
        x=0
        while x != len(dctA[key])-1:
            actors.write('"' + dctA[key][x]+ '",')
            x += 1
        actors.write('"' + dctA[key][x] + '"]}\n')
