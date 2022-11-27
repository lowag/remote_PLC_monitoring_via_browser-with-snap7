import snap7
import json
import sys
from sys import argv
from snap7.util import *
client=snap7.client.Client()
client.connect('169.254.100.200',0,0)

#Siemens datatypes
datatypes={"db_real":4,"db_int":2,"db_dint":4,"word":2,"int":2}

request=json.loads(argv[1])


for types in request:
        if types=="dig_input":
            for element in request[types]:
                address = element.split(".")
                mbyte=client.read_area(snap7.types.Areas.PE,0,int(address[0]),1)
                request[types][element]["value"]=get_bool(mbyte,0,int(address[1]))
        if types=="dig_output":
            for element in request[types]:
                address = element.split(".")
                mbyte=client.read_area(snap7.types.Areas.PA,0,int(address[0]),1)
                request[types][element]["value"]=get_bool(mbyte,0,int(address[1]))
        if types=="an_output":
            for element in request[types]:
                address = element.split(".")
                mbyte=client.read_area(0x80,0,int(address[0]),2)
                request[types][element]["value"]=get_int(mbyte,0,int(address[1]))

        if types=="marker":
            for element in request[types]:
                address = element.split(".")
                mbyte=client.read_area(snap7.types.Areas.MK,0,address[0],1)
                request[types][element]["value"]=get_bool(mbyte,0,int(address[1]))
        if types=="db":
            for element in request[types]:
                address = element.split(".")
                
                if request[types][element]["type"]=="db_real":
                    get_curr_data=client.db_read(int(address[0]),int(address[1]),4)
                    request[types][element]["value"]=round(snap7.util.get_real(get_curr_data,0)*int(request[types][element]["rescale"]),int(request[types][element]["precision"]))
                elif request[types][element]["type"]=="db_int":
                    get_curr_data=client.db_read(int(address[0]),int(address[1]),2)
                    request[types][element]["value"]=round(snap7.util.get_int(get_curr_data,0)*int(request[types][element]["rescale"]),int(request[types][element]["precision"]))
                elif request[types][element]["type"]=="db_dint":
                    get_curr_data=client.db_read(int(address[0]),int(address[1]),6)
                    request[types][element]["value"]=get_dint(get_curr_data,0)*float(request[types][element]["rescale"])
                elif request[types][element]["type"]=="int":
                    get_curr_data=client.db_read(int(address[0]),int(address[1]),2)
                    request[types][element]["value"]=round(struct.unpack('!H', get_curr_data)[0]*int(request[types][element]["rescale"]),int(request[types][element]["precision"]))
print(json.dumps(request))

def get_dint(_bytearray, byte_index):
    data = _bytearray[byte_index:byte_index + 4]
    dint = struct.unpack('>i', struct.pack('4B', *data))[0]
    return dint
