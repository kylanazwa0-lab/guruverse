import mysql.connector
conn=mysql.connector.connect(host='localhost',user='root',password='',database='guruverse')
cursor=conn.cursor(dictionary=True)
cursor.execute('SELECT COUNT(*) as cnt FROM gb_modules')
print(cursor.fetchone())
cursor.execute('SELECT course_id, COUNT(*) as c FROM gb_modules GROUP BY course_id')
print(cursor.fetchall())
