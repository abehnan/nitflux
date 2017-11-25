import json
with open('allInfo.json', 'r') as src:
    num = 0
    for line in src:
        entry = json.loads(line)
        gs = entry["genres"]
        if gs != None:
            arr = gs.split(',')
            if len(arr) > num:
                num = len(arr)
    print "Max genres: "
    print num
