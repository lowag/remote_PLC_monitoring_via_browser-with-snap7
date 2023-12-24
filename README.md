# Remote PLC monitoring via browser with snap7
For troubleshooting purpose.

Hardware: Orange Pi Zero, Orange Pi Zero2, Orange Pi PC Plus or any other single-board computer (or PC) which has an ethernet port (connect to Profinet) and a second network port (WIFI or ethernet) connected to the local network. If you prefer the industrial version you can use IOT2050 from Siemens.
Software:
OS: Armbian (Cli, fit for the used hardware), for IOT2050 the example image from Siemens
1. After the OS installation install snap7: https://python-snap7.readthedocs.io/en/latest/installation.html
2. Install the python wrapper and the json module:
  pip3 install python-snap7 json
3. Place all files from this repo to your webserver root (probably it is /var/www/htdocs or /var/www)
4. Set the PLC's address,slot number, rack number in the get_data.py
5. Change the absolute path to the json_dict in the index.php
6. Create json files with correct addresses to the json_dicts directory. You can find samples there.
7. Connect the (an) ethernet port to the PLC's network and set its IP address.
8. Connect the other port to your local network.
9. Try reaching the webserver on your device. If everything perfect you will see an ugly page with some clickable menu items on left.
10. With every click or reload you can update the info you see to the actual status.     


