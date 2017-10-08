"""
Google Vision API Tutorial with a Raspberry Pi and Raspberry Pi Camera.  See more about it here:  https://www.dexterindustries.com/howto/use-google-cloud-vision-on-the-raspberry-pi/

Use Google Cloud Vision on the Raspberry Pi to take a picture with the Raspberry Pi Camera and classify it with the Google Cloud Vision API.   First, we'll walk you through setting up the Google Cloud Platform.  Next, we will use the Raspberry Pi Camera to take a picture of an object, and then use the Raspberry Pi to upload the picture taken to Google Cloud.  We can analyze the picture and return labels (what's going on in the picture), logos (company logos that are in the picture) and faces.

This script uses the Vision API's label detection capabilities to find a label
based on an image's content.

"""

import argparse
import base64
import picamera
import json
import re
import webbrowser
import urllib
import urllib2
import time

from time import sleep
from picamera import PiCamera
from googleapiclient import discovery
from oauth2client.client import GoogleCredentials

#url='http://www.latert.net/index.php'
#data = {}
#data['p3'] = '1234AVD'
#data['p4'] = 'Alespi12'
#url_values = urllib.urlencode(data)
#full_url = url + '?' + url_values
#data = urllib2.urlopen(full_url)
contador = 1


camera = PiCamera()
camera.rotation = 180
camera.start_preview()
credentials = GoogleCredentials.get_application_default()
service = discovery.build('vision', 'v1', credentials=credentials)

for i in range(10000):
    sleep(3)
    camera.capture('image%s.jpg'%i)

    

    with open('image%s.jpg'%i, 'rb') as image:
        image_content = base64.b64encode(image.read())
        service_request = service.images().annotate(body={
            'requests': [{
                'image': {
                    'content': image_content.decode('UTF-8')
                },
                'features': [{
                    'type': 'TEXT_DETECTION',
                    'maxResults': 1
                }]
            }]
        })
        response = service_request.execute()
        respuesta = json.dumps(response, indent=4, sort_keys=True)	#Print it out and make it somewhat pretty.
        print (respuesta)
        book = json.loads(respuesta)
        try:
            foundedtext = book["responses"][0]["textAnnotations"][0]["description"]
            texto = str(foundedtext)
            print (texto)
            try:
                placa = re.findall(r'[P|p][0-9O][0-9O][0-9O][A-Z][A-Z][A-Z]',texto)[0]
                print ("La placa encontrada es: "+placa)

                if placa:
                    url='http://www.latert.net/index.php'
                    data = {}
                    data['p4'] = 'Alespi_1'
                    data['p3'] = placa
                    url_values = urllib.urlencode(data)
                    full_url = url + '?' + url_values
                    data = urllib2.urlopen(full_url)
                
            except Exception:
                print(" La Imagen no contiene numeros de placa")
                
        except Exception:
            print ("No se existe texto en la imagen")

    
        print("taking photo num: %s " % (i+2))
    
camera.stop_preview()

