import xml.etree.ElementTree as ET
import mysql.connector
from math import radians, sin, cos, sqrt, atan2
import folium

# Function to check if a location is within 1km of any of the previous locations in road_locations
def is_within_1km(lat1, lon1, road_locations):
    if not road_locations:
        return False
    
    R = 6371  # radius of the earth in km
    
    for location in road_locations:
        lat2, lon2 = map(float, location.split(','))
        dLat = radians(lat2-lat1)
        dLon = radians(lon2-lon1)
        a = sin(dLat/2) * sin(dLat/2) + cos(radians(lat1)) * cos(radians(lat2)) * sin(dLon/2) * sin(dLon/2)
        c = 2 * atan2(sqrt(a), sqrt(1-a))
        distance = R * c
        
        if distance < 1:  # if the distance is less than 1 km, skip this location
            return True
    
    return False


# Load XML file
print('Loading XML file...')
tree = ET.parse('map2.xml')
print('XML file loaded.')

# Create a list to store road locations
road_locations = []

# Find latitude and longitude of road locations
ways = tree.findall(".//way/tag[@k='highway']/..")
count = 0
total = len(set(ways))
processed_ways = set()
for way in ways:
    if way in processed_ways:
        continue
    processed_ways.add(way)
    for nd in way.iter('nd'):
        for node in tree.iter('node'):
            count += 1
            if node.attrib['id'] == nd.attrib['ref']:
                lat1 = float(node.attrib['lat'])
                lon1 = float(node.attrib['lon'])
                
                # Check if the current location is at least 1 kilometer away from any of the previous locations in road_locations
                if is_within_1km(lat1, lon1, road_locations):
                    continue
                
                road_location = str(lat1) + ',' + str(lon1)
                road_locations.append(road_location)
                
                # Print the percentage of the loop that has been researched
                percentage = len(processed_ways) / total * 100
                print(f'{percentage:.2f}%')

# Create a map centered at the first location in road_locations
m = folium.Map(location=road_locations[0].split(','), zoom_start=15)

# Add markers for all locations in road_locations
for loc in road_locations:
    lat, lon = map(float, loc.split(','))
    folium.Marker(location=[lat, lon]).add_to(m)

# Save the map as an HTML file
m.save('road_locations_map2.html')



# สร้างลิสต์สำหรับเก็บข้อมูลแบบที่ต้องการ
data_send_locations = []
city = 'bangkok'

# วนลูปในรายการของตำแหน่งถนน
print('creating road_locations list')
for road_location in road_locations:
    data_send_locations.append([road_location, city])


# เชื่อมต่อ MySQL ด้วย mysql-connector-python
mydb = mysql.connector.connect(
  host="hostname",
  port="3306",
  user="user",
  password="passwd",
  database="bk_opnsrc_hac"
)

print('SQL DB Connected')
#connect
# สร้าง Cursor object เพื่อ query ข้อมูล
mycursor = mydb.cursor()


city = 'bangkok'

#send locations
# SQL statement สำหรับ INSERT ข้อมูลใน table locations
send_sql_locations = "INSERT IGNORE INTO locations (locations, city_details_name) VALUES (%s, %s)"

data_send_locations = list(set(map(tuple, data_send_locations)))

# Convert list to tuple for insertion
data_send_locations = tuple(data_send_locations)

print('locations Insert data genarated')
print('Inserting locations')
# Execute SQL statement for each location
for location in data_send_locations:
    mycursor.execute(send_sql_locations, location)
    
print('Inserted locations')

# Commit changes to database
mydb.commit()
print('locations table commited')


# loop through the road_locations list and insert each value into the 'details' table
print('Inserting details locations')
for location in road_locations:
    sql = "INSERT INTO details (locations) SELECT %s FROM DUAL WHERE NOT EXISTS (SELECT * FROM details WHERE locations = %s)"
    val = (location, location)
    try:
        mycursor.execute(sql, val)
    except mysql.connector.IntegrityError as err:
        if err.errno == 1062:  # handle duplicate entry error
            print(f"Duplicate entry '{location}' in details table")
            continue

# commit the changes to the database
mydb.commit()
print('details locations table commited')

#get
# Query ข้อมูลจาก table students
mycursor.execute("SELECT * FROM locations")

# ดึงผลลัพธ์ทั้งหมดแล้วแสดงผลลัพธ์ในรูปแบบ List of tuples
result = mycursor.fetchall()
for row in result:
  print(row)

# Query location data from table
mycursor.execute("SELECT * FROM locations")
result = mycursor.fetchall()

# Create a list to store location coordinates
location_coordinates = []

# Loop through each row of the query result and extract location coordinates
for row in result:
    coordinates = row[0]
    location_coordinates.append(coordinates)

# Create a map centered at the first location in location_coordinates
m = folium.Map(location=location_coordinates[0].split(','), zoom_start=15)

# Add markers for all locations in location_coordinates
for loc in location_coordinates:
    lat, lon = map(float, loc.split(','))
    folium.Marker(location=[lat, lon]).add_to(m)

# Save the map as an HTML file
m.save('locations_map.html')