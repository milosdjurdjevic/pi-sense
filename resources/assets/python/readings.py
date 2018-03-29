#!/usr/bin/python
# import sys

import Adafruit_DHT
import json

# Try to grab a sensor reading.  Use the read_retry method which will retry up
# to 15 times to get a sensor reading (waiting 2 seconds between each retry).
humidity, temperature = Adafruit_DHT.read_retry(11, 22)

if humidity is not None and temperature is not None:
	# print('Temp={0:0.1f}*C  Humidity={1:0.1f}%'.format(temperature, humidity))
	print json.dumps({"temperature": temperature, "humidity": humidity}, sort_keys=True)
else:
	print('Failed to get reading. Try again!')
	# sys.exit(1)
