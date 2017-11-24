from bs4 import BeautifulSoup
import urllib
import json
x=1
with open("jsonEntries.txt", 'r') as source:
    with open('allInfo.json', 'w') as dest:

    # one film at a time
        for line in source:
            entry = json.loads(line)
            page = entry['page']
            siteHtml = urllib.urlopen(page)
            soup = BeautifulSoup(siteHtml, "html.parser")

            year = soup.find("span", { "class" : "year" })
            if (year != None):
                year = year.text
            rating = soup.find("span", { "class" : "maturity-number" })
            if (rating != None):
                rating = rating.text
            duration = soup.find("span", { "class" : "test_dur_str" })
            if (duration != None):
                duration = duration.text
            synopsis = soup.find("p", { "class" : "synopsis" })
            if (synopsis != None):
                synopsis = synopsis.text
            actors = soup.find("span", { "class" : "actors-list" })
            if (actors != None):
                actors = actors.text
            genres = soup.find("span", { "class" : "genre-list" })
            if (genres != None):
                genres = genres.text
        # print counter to show progress
            print x
            x += 1
            dct = {"year":year, "rating":rating, "duration":duration,
            "synopsis":synopsis, "actors":actors, "genres":genres}
            entry.update(dct)
            json.dump(entry, dest)
            dest.write('\n')
