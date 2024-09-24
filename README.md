To initialise this project install wampserver and run it.

Place the code in 'C:\wamp64\www\shoppingcart'

Go to http://localhost/phpmyadmin/index.php?route=/server/databases

Create a database called 'shoppingcart'

Within the created database execute this SQL query:

```sql
CREATE TABLE tblCart(
	id int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    cartName varchar(50) NOT NULL
);

CREATE TABLE tblItem(
	id int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
  	cartID int NOT NULL,
    FOREIGN KEY (cartID) REFERENCES tblCart(id),
    itemName varchar(50) NOT NULL,
    quantity int DEFAULT(1)
);
```

You can now go to http://localhost/shoppingCart
