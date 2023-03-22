import folium
from folium.plugins import HeatMap
import mysql.connector

# ปรับ column ที่จะอ่านและนำมาแสดงผล
name = "restaurant_value"

# เชื่อมต่อ MySQL ด้วย mysql-connector-python
mydb = mysql.connector.connect(
    host="8.8.8.6",
    port="3306",
    user="tsm_public",
    password="",
    database="bk_opnsrc_hac"
)

#connect
# สร้าง Cursor object เพื่อ query ข้อมูล
mycursor = mydb.cursor()

#get
# Query ข้อมูลจาก table students
mycursor.execute("SELECT locations, " + name + " FROM details")

# ดึงผลลัพธ์ทั้งหมดแล้วแสดงผลลัพธ์ในรูปแบบ List of tuples
result = mycursor.fetchall()
m = folium.Map(location=result[0][0].split(','))

list = []
for row in result:
    lat, long = row[0].split(',')

    # แก้ไขตามค่าที่จะนำมาแสดงผล
    val = row[1]
    if (val == 0):
        continue
    if(val == None):
        continue
        # val = 0
    #########################

    list.append([lat, long, val])

HeatMap(list).add_to(m)

m.save('map.html')
