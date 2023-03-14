import mysql.connector
import os

print(os.getcwd())
os.chdir("./Input")

# เชื่อมต่อ MySQL ด้วย mysql-connector-python
mydb = mysql.connector.connect(
  host="",
  port="",
  user="",
  password="",
  database=""
)

#connect
# สร้าง Cursor object เพื่อ query ข้อมูล
mycursor = mydb.cursor()

#get
# Query ข้อมูลจาก table students
mycursor.execute("SELECT * FROM details")

# ดึงผลลัพธ์ทั้งหมดแล้วแสดงผลลัพธ์ในรูปแบบ List of tuples
open('Study-area.txt', 'w').close()

result = mycursor.fetchall()
for row in result:
  lat, lon = map(float, row[12].split(','))
  f = open("Study-area.txt", "a")
  f.write(str(lat) + "\t" + str(lon) + "\t" + str(0) + "\n")