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

#insert
# SQL statement สำหรับ INSERT ข้อมูลใน table city_details
insert_sql = "INSERT INTO city_details (name, governor, citizen_value, airport_name, airport_status, size, temp_avg, school_value, university_value, sea_status, flood_stats, land_price_avg, tourist_stats, employment_stats, citizen_income_avg) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"

name = 'test name'
governor = "test governor"
citizen_value = 100000
airport_name = "test airport name"
airport_status = True
size = 200
temp_avg = 27
school_value = 4.5
university_value = 3.8
sea_status = False
flood_stats = 2
land_price_avg = 1200000
tourist_stats = 8
employment_stats = 3
citizen_income_avg = 45000

# ข้อมูลที่ต้องการเพิ่มเข้าไปใน table city_details
data_insert = [(name, governor, citizen_value, airport_name, airport_status, size, temp_avg, school_value, university_value, sea_status, flood_stats, land_price_avg, tourist_stats, employment_stats, citizen_income_avg),]

# Execute SQL statement สำหรับแต่ละ record ใน data_insert
for val in data_insert:
  mycursor.execute(insert_sql, val)

# Commit การเปลี่ยนแปลงใน database
mydb.commit()


#get
# Query ข้อมูลจาก table city_details
mycursor.execute("SELECT * FROM city_details")

# ดึงผลลัพธ์ทั้งหมดแล้วแสดงผลลัพธ์ในรูปแบบ List of tuples
result = mycursor.fetchall()
for row in result:
  print(row)
