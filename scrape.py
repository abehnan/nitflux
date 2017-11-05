### not finished

import urllib2
req = urllib2.Request('https://www.netflix.com/ca/originals')
try:
    response = urllib2.urlopen(req)
    except URLError as e:
        print e.reason
page = response.read()
print page
