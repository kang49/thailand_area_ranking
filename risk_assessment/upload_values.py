import mysql.connector
import pandas as pd
import os

os.chdir("./")

df = pd.read_excel("Output.xlsx", usecols=[0,1,3])

# เชื่อมต่อ MySQL ด้วย mysql-connector-python
mydb = mysql.connector.connect(
  host="8.8.8.6",
  port="3306",
  user="kang49",
  password="kang49",
  database="bk_opnsrc_hac"
)

#connect
# สร้าง Cursor object เพื่อ query ข้อมูล
mycursor = mydb.cursor()

print(len(df))
for i in range(len(df)):
    #update
    # SQL statement สำหรับ UPDATE ข้อมูลใน table details
    update_sql = "UPDATE details SET earthquake = %s WHERE locations = %s"  #ใช้ Where <fix ที่คนนั้น>

    earthquake = int(df.iat[i, 2])
    locations = str(df.iat[i, 0]) + "," + str(df.iat[i, 1])

    # ข้อมูลที่ต้องการแก้ไขเข้าไปใน table details
    data_update = [(earthquake, locations),]

    # Execute SQL statement สำหรับแต่ละ record ใน data_update
    for val in data_update:
        mycursor.execute(update_sql, val)

    # Commit การเปลี่ยนแปลงใน database
    mydb.commit()