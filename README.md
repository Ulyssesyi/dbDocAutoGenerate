# dbDocAutoGenerate
This project is used to auto generate db doc.   

Now it only supported mysql.  For mysql, you need input dbDriver, address, username, password, database name,  port(I will use default port like 3306 if i did not get it), language (default english) when use it.
It seems like  
```php index.php -dmysql -hlocalhost -uroot -proot -Ddb_test -Len -P3306```  
or  
```php index.php --driver mysql --host localhost --user root --pwd root --database db_test --language en --port 3306```  

All options:  
- -d driver name
- -h database address
- -u username
- -p password
- -D database name
- -P database port
- -L language
- --driver driver name
- --host database address
- --username username
- --pwd password
- --database database name
- --port database port
- --language language

All doc will output to the directory doc and it's name will be db name + '.md'
