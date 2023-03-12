import mysql.connector

# เชื่อมต่อ MySQL ด้วย mysql-connector-python
mydb = mysql.connector.connect(
  host="hostname",
  port="3306",
  user="user",
  password="passwd",
  database="bk_opnsrc_hac"
)

#connect
# สร้าง Cursor object เพื่อ query ข้อมูล
mycursor = mydb.cursor()

#send locations
# SQL statement สำหรับ INSERT ข้อมูลใน table locations
send_sql_locations = "INSERT INTO locations (locations, city_details_name) VALUES (%s, %s)"
# data_send_locations = ['13.8828627,100.6009245', 'bangkok'], ['13.8829059,100.6008174', 'bangkok'], ['13.8832653,100.5998393', 'bangkok']
# print(data_send_locations[0])

# # Execute SQL statement ส่่่งออก
# for i in range(len(data_send_locations)):
#     mycursor.execute(send_sql_locations, data_send_locations[i])

# # Commit การเปลี่ยนแปลงใน database
# mydb.commit()


#send locations in details
# SQL statement สำหรับ INSERT ข้อมูลใน table locations
send_sql_locations_details = "INSERT INTO details (locations) VALUES (%s)"
data_send_locations_details = ['13.8828627,100.6009245'], ['13.8829059,100.6008174'], ['13.8832653,100.5998393']
print(data_send_locations_details)
# # Execute SQL statement ส่่่งออก
# for i in range(len(data_send_locations_details)):
#     mycursor.execute(send_sql_locations_details, data_send_locations_details[i])

# # Commit การเปลี่ยนแปลงใน database
# mydb.commit()


# #get
# # Query ข้อมูลจาก table students
# mycursor.execute("SELECT * FROM locations")

# # ดึงผลลัพธ์ทั้งหมดแล้วแสดงผลลัพธ์ในรูปแบบ List of tuples
# result = mycursor.fetchall()
# for row in result:
#   print(row)