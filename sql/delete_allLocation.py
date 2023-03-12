import mysql.connector

# เชื่อมต่อ MySQL ด้วย mysql-connector-python
mydb = mysql.connector.connect(
  host="hostname",
  port="3306",
  user="user",
  password="passwd",
  database="bk_opnsrc_hac"
)

# Create a cursor object to execute SQL queries
mycursor = mydb.cursor()

# Delete all records from the 'details' table
mycursor.execute("DELETE FROM details")

# Delete all records from the 'locations' table
mycursor.execute("DELETE FROM locations")

# Commit the changes to the database
mydb.commit()

# Close the database connection
mydb.close()
