# uses the BeautifulSoup web-scraping tool. Ways to get it:
#      apt-get install python-bs4
#      pip install beautifulsoup4
#      If your Python doesn't have 'pip':
#      sudo apt-get install python-pip
from bs4 import BeautifulSoup
import re

# ImageLinks I got from copying the html of the 'originals' class tag from
# https://www.netflix.com/ca/originals. urlopen methods did not provide the img links

page_info = open("ImageLinks", "r")
soup = BeautifulSoup(page_info.read(), "html.parser")

fp = open("jsonEntries.txt", 'w')

# the 'a' class tags contain the data of interest for each film.
# soup.findAll returns a list of all those 'a' tags
elements = soup.findAll('a')

for el in elements:

    # the only text in the 'a' tags is the film title
    entry = '{ "name":\"' + el.text + '\", "page":"https://www.netflix.com'

    # href is the link to the particular film's page
    entry += el.get('href') + '\", "img":"'

    # this regular expression extracts the image adress to use in <img src= ... >
    try: match = re.search('url\("(.+?)"\);', el.div.get('style')).group(1)
    except AttributeError: match = 'img url not found'

    # We have written our info in JSON object format
    entry += match + '\" }\n'

    # Write to textfile for storage. Newline between each object for clarity
    # had a problem with a superscript charater, fixed with encode()
    fp.write(entry.encode('ascii', 'ignore'))

fp.close()
