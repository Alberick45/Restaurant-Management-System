CREATE DATABASE  IF NOT EXISTS g_fourestaurant ;
USE g_fourestaurant;

CREATE TABLE customers (
  customer_id int primary key AUTO_INCREMENT ,
  customer_name varchar(30) DEFAULT NULL,
  age int DEFAULT NULL,
  gender Enum('male','female') Not Null ,
  phone_number varchar(18) DEFAULT NULL,
  location varchar(50) DEFAULT NULL,
  allergy varchar(50) DEFAULT 'None',
  likes varchar(50) DEFAULT 'None',
  dislikes varchar(50) DEFAULT 'None',
  loyalty_points  int DEFAULT 0,
  registration_date DATE
);

create table department(
department_id varchar(7) primary key ,
department_name Varchar(60) Not NUll
);

CREATE TABLE staff (
  staff_id int primary key AUTO_INCREMENT,
  staff_name varchar(40) DEFAULT NULL,
  position_id varchar(6) DEFAULT NULL,
  age int DEFAULT NULL,
  phone_number varchar(18) DEFAULT NULL,
  location varchar(50) DEFAULT NULL,
  gender Enum('male','female') Not Null ,
  next_of_kin varchar(50) DEFAULT NULL,
  salary decimal(7,2) default 0,
  access_level int DEFAULT NULL,
  username varchar(50) DEFAULT NULL,
  password varchar(80) DEFAULT NULL,
  staff_points int default 0,
  employment_date date,
  
  constraint position foreign key(position_id) references department(department_id) on delete set NULL
) ;

create Table meal_category(
	category_id int primary key auto_increment,
    category_name varchar(30))
    ;

CREATE TABLE menu (
  dish_id int primary key AUTO_INCREMENT,
  dish_name varchar(30) ,
  dish_price decimal(4,2) ,
  dish_category int ,
  preparation_process text default null,
  dietary_restrictions varchar(50) DEFAULT 'None',
  
  constraint dish_category foreign key(dish_category) references meal_category(category_id) on delete set NULL
) ;


CREATE TABLE inventory (
  inventory_id int primary key AUTO_INCREMENT,
  ingredient_name varchar(30) DEFAULT NULL,
  price_per_unit decimal(6,2),
  total_quantity int DEFAULT NULL
) ;

CREATE TABLE preparations (
  preparation_id int primary key AUTO_INCREMENT,
  meal_id int ,
  ingredient_id int,
  quantity_used int DEFAULT 0,
  
  CONSTRAINT ingredient FOREIGN KEY (ingredient_id) REFERENCES inventory (inventory_id) on delete set NULL,
  CONSTRAINT meal FOREIGN KEY (meal_id) REFERENCES menu (dish_id) on delete set NULL
) ;

CREATE TABLE orders (
  order_id int primary key AUTO_INCREMENT,
  customer_id int DEFAULT NULL,
  item_id int DEFAULT NULL,
  order_date date DEFAULT NULL,
  order_status enum('pending','completed','cancelled') DEFAULT 'pending',
  payment_status enum('pending','completed') DEFAULT 'pending',
  order_quantity int default '1',
  total_price decimal(7,2),
  order_mode enum('dine-in','takeout','online') DEFAULT NULL,
  staff_id int DEFAULT NULL,
  update_status int default 0,
  
  CONSTRAINT fk_customer FOREIGN KEY (customer_id) REFERENCES customers (customer_id) on delete set NULL,
  CONSTRAINT fk_staff FOREIGN KEY (staff_id) REFERENCES staff (staff_id) on delete set NULL,
  CONSTRAINT fk_meal FOREIGN KEY (item_id) REFERENCES menu (dish_id) on delete set NULL
) ;

CREATE TABLE delivery (
  delivery_id int primary key AUTO_INCREMENT,
  order_id int DEFAULT NULL,
  delivery_location varchar(60) DEFAULT NULL,
  CONSTRAINT fk_orders FOREIGN KEY (order_id) REFERENCES orders (order_id) on delete set NULL
);


CREATE TABLE tables (
  table_id int primary key AUTO_INCREMENT,
  num_of_seats int NOT NULL,
  table_status enum('reserved','occupied','available') DEFAULT 'available'
) ;

CREATE TABLE reservations (
  reservation_id int primary key AUTO_INCREMENT,
  reservation_date datetime DEFAULT NULL,
  customer_id int DEFAULT NULL,
  table_id int DEFAULT NULL,
  table_status varchar(40) DEFAULT NULL,
  
  CONSTRAINT fktable FOREIGN KEY (table_id) REFERENCES tables (table_id) on delete set NULL,
  CONSTRAINT tbcustomers FOREIGN KEY (customer_id) REFERENCES customers (customer_id) on delete set NULL
) ;

CREATE TABLE review (
  review_id int primary key AUTO_INCREMENT,
  customer_id int DEFAULT NULL,
  review text,
  suggestion text default Null,
  CONSTRAINT fkcustomer_review FOREIGN KEY (customer_id) REFERENCES customers (customer_id) on delete set NULL
) ;


CREATE TABLE financial_category (
  category_id int primary key AUTO_INCREMENT,
  category_name varchar(20),
  category enum('expense','income') 
) ;

CREATE TABLE transactions (
  transaction_id int primary key AUTO_INCREMENT,
  transaction_item varchar(20) ,
  category_id int,
  transaction_officer_id int,
  transaction_quantity int default 1,
  total_price decimal(7,2),
  transaction_date date,
  CONSTRAINT fk_finance_category FOREIGN KEY (category_id) REFERENCES financial_category (category_id) on delete set NULL,
  CONSTRAINT transaction_handler FOREIGN KEY (transaction_officer_id) REFERENCES staff (staff_id) on delete set NULL
) ;


CREATE TABLE requests (
  request_id int primary key AUTO_INCREMENT,
  request text DEFAULT NULL,
  requester_id int DEFAULT NULL,
  approver_id int DEFAULT NULL,
  category_id int DEFAULT NULL,
  request_status enum('pending','approved','disapproved') DEFAULT 'pending',
  request_date date,
  CONSTRAINT fk_requests_category FOREIGN KEY (category_id) REFERENCES financial_category (category_id) on delete set NULL,
  CONSTRAINT request_sent_from FOREIGN KEY (requester_id) REFERENCES staff (staff_id) on delete set NULL,
  CONSTRAINT request_seen_by FOREIGN KEY (approver_id) REFERENCES staff (staff_id) on delete set NULL
) ;




use g_fourestaurant;
USE g_fourestaurant;



-- Insertions for department table needed
INSERT INTO department (department_id, department_name)
VALUES
('LEV999', 'Owner'),
('AC3-GM', 'General Manager'),
('AC3-AM', 'Assistant Manager'),
('AC1-DA', 'Delivery Agent'),
('AC1-S', 'Server'),
('AC1-H', 'Host'),
('AC2-SM', 'Stock Manager'),
('AC1-HC', 'Head Chef'),
('AC1-AC', 'Assistant Chef'),
('AC1-B', 'Bartender'),
('AC2-FM', 'Finance Manager'),
('AC2-AM', 'Advertising Manager');

-- Insertions for meal_category needed
INSERT INTO meal_category (category_name)
VALUES 
('Appetizer'),
('Dessert'),
('Side Dishes'),
('Salads'),
('Soups'),
('Beverages'),
('Soups'),
('Seafood'),
('Pasta'),
('Pizza'),
('Sandwiches'),
('Grilled Dishes'),
('Breakfast'),
('Vegan/Vegetarian'),
("Kids' Menu"),
('Gluten-Free'),
('Specialty Items'),
('Snacks'),
('BBQ'),
('Burgers'),
('Steaks'),
('Asian Cuisine'),
('Main Course');
                                                



-- Insertions for tables table needed
INSERT INTO tables (num_of_seats)
VALUES 
(4),
(2),
(6);



-- Insertions for financial_category table needed
INSERT INTO financial_category (category_name, category)
VALUES 
('utilities', 'expense'), -- for bills
('advertisements', 'expense'),
('revenue', 'income'), -- so like capital or others
('salaries', 'expense'),
('food_sales', 'income'),
('equipment', 'expense'),
('maintenance', 'expense'),
('supplies', 'expense'),
('miscellaneous', 'expense');



use g_fourestaurant;


																/* Procedures for customers*/
                                                                
/* procedure for viewing customers*/
DELIMITER //

create procedure view_customers(in in_customerid int, out out_customer_name varchar(30),out out_age int, out out_gender Enum('male','female'), 
								out out_phone_number  varchar(18), out out_location varchar(50), out out_allergy varchar(50), out out_likes varchar(50), out out_dislikes varchar(50))
	BEGIN
		select * from customers where customer_id = in_customerid;

END //

DELIMITER ;


/* procedure for inserting customers*/
DELIMITER //

CREATE PROCEDURE add_customers(in in_customer_name varchar(30) ,in in_age int , in in_gender Enum('male','female') ,in in_phone_number varchar(18) ,in in_location varchar(50) ,
in in_allergy varchar(50) ,in in_likes varchar(50),in in_dislikes varchar(50) )
BEGIN
	INSERT INTO customers (customer_name, age, gender, phone_number, location, allergy, likes,dislikes,registration_date) 
                    VALUES (in_customer_name, in_age, in_gender, in_phone_number, in_location, in_allergy, in_likes, in_dislikes, curdate());
END //

DELIMITER ;

/* procedure for Updating customers text based*/
DELIMITER //

CREATE PROCEDURE update_customers_text(
    IN in_dataname VARCHAR(30),
    IN in_value VARCHAR(30),
    IN in_customerid INT
)
BEGIN
    -- Construct the SQL query as a string, with proper quoting for the value
    SET @sql = CONCAT('UPDATE customers SET ', in_dataname, ' = "', in_value, '" WHERE customer_id = ', in_customerid);

    -- Prepare the SQL statement
    PREPARE stmt FROM @sql;

    -- Execute the prepared statement
    EXECUTE stmt;

    -- Deallocate the prepared statement
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;


/* procedure for Updating customers int based*/
DELIMITER //

CREATE PROCEDURE update_customers_int(
    IN in_dataname VARCHAR(30),
    IN in_value INT,
    IN in_customerid INT
)
BEGIN
    -- Construct the SQL query as a string without quotes around the integer value
    SET @sql = CONCAT('UPDATE customers SET ', in_dataname, ' = ', in_value, ' WHERE customer_id = ', in_customerid);

    -- Prepare the SQL statement
    PREPARE stmt FROM @sql;

    -- Execute the prepared statement
    EXECUTE stmt;

    -- Deallocate the prepared statement
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;

/* procedure for deleting customers*/
DELIMITER //

CREATE PROCEDURE delete_customers(in in_customer_id int)
BEGIN
	delete FROM customers where customer_id = in_customer_id;
END //

DELIMITER ;



																/*End of  Procedures for customers*/
																
                                                                
                                                                
                                                                
                                                                /*Procedure for staff */
/* procedure for inserting staff*/
DELIMITER //

CREATE PROCEDURE add_staff(in in_staff_name varchar(30) , in in_staff_postion varchar(18) , in in_staff_age int , in in_phone_number varchar(18) ,in in_gender varchar(50) ,
in in_username varchar(50) ,in in_access int,in in_password varchar(80))
BEGIN
	INSERT INTO staff (staff_name, position_id, age, phone_number, gender, username, access_level, password, employment_date) 
                    VALUES (in_staff_name, in_staff_postion, in_staff_age, in_phone_number, in_gender, in_username, in_access, in_password, curdate());
END //

DELIMITER ;

/* Pocedure for deleting staff */
DELIMITER //

create procedure delete_staff(in in_staff_id int)
BEGIN
	delete from staff where staff_id = in_staff_id;

END //

DELIMITER ;

																/* End of procedure for staff*/






																/* Procedure for meals */
                                                                
/* procedure for inserting meals*/
 DELIMITER //

CREATE PROCEDURE add_meals(in in_dish_name varchar(30) ,in in_dish_price decimal(7,2) , in in_dish_category int ,in in_dish_preparation text ,in in_dietary_restrictions varchar(50) )
BEGIN
	INSERT INTO menu (dish_name, dish_price, dish_category, preparation_process, dietary_restrictions)
                    VALUES (in_dish_name, in_dish_price, in_dish_category, in_dish_preparation, in_dietary_restrictions);
END //

DELIMITER ;


/* procedure for linking ingredients to meals*/
 DELIMITER //

CREATE PROCEDURE meal_ingredient_add(IN in_meal_id int ,IN in_ingredient_used int ,IN in_quantity_used int )
BEGIN
	INSERT INTO preparations (meal_id, ingredient_id, quantity_used)
                    VALUES (in_meal_id, in_ingredient_used, in_quantity_used);
END //

DELIMITER ;


/* procedure for updating meals that have decimal*/
 DELIMITER //

CREATE PROCEDURE update_meals_decimal(IN in_datatype varchar(30) ,IN in_datavalue decimal(7,2) , IN in_dish_id int )
BEGIN
	SET @sql = concat("UPDATE menu set ",in_datatype," = ",in_datavalue,"where dish_id = ", in_dish_id);
    
	PREPARE stmt from @sql;
    
    EXECUTE stmt;
    
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;

/* procedure for updating meals that have integers*/

 DELIMITER //

CREATE PROCEDURE update_meals_int(IN in_datatype varchar(30) ,IN in_datavalue int , IN in_dish_id int)
BEGIN

	SET @sql = concat("UPDATE menu set ",in_datatype, " = ", in_datavalue," where dish_id = ",in_dish_id);
    
	PREPARE stmt from @sql;
    
    EXECUTE stmt;
    
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;

/* procedure for updating meals that have text*/
 DELIMITER //

CREATE PROCEDURE update_meals_text(IN in_datatype varchar(30) ,IN in_datavalue Varchar(30) , IN in_dish_id int )
BEGIN
	SET @sql = concat("UPDATE menu set ",in_datatype," = '",in_datavalue,"' where dish_id = ",in_dish_id);
    
	PREPARE stmt from @sql;
    
    EXECUTE stmt;
    
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;


/* Pocedure for deleting meals */
DELIMITER //

create procedure delete_meal(IN meal_id int)
BEGIN
	DELETE FROM menu WHERE dish_id = meal_id;

END //

DELIMITER ;
																/* End of procedures for meals */
                                                                
                                                                
                                                                
                                                                
                                                                
                                                                





																	/* procedure for Orders*/
/* procedure for placing orders*/
DELIMITER //

CREATE PROCEDURE place_orders(in in_customer_id int ,in in_item_id int ,in in_order_mode enum('dine-in','takeout','online'),IN in_order_quantity int,in in_staff_id int )

BEGIN

			/* Getting total price*/
            
            set @price = (SELECT in_order_quantity *
            (SELECT dish_price from menu where dish_id = in_item_id));
            
			/* insertions */
			INSERT INTO orders (customer_id ,item_id ,order_date ,order_status ,order_mode, order_quantity, total_price, staff_id) 
			VALUES (in_customer_id, in_item_id, CURDATE(), "pending",in_order_mode, in_order_quantity, @price, in_staff_id);
            
            

END //

DELIMITER ;





/* procedures for updating orders text*/
DELIMITER //

create procedure update_order_text(IN in_datatype varchar(30), IN in_datavalue varchar(30), IN in_order_id int)
BEGIN
set @sql = concat("UPDATE orders set ", in_datatype, " = '", in_datavalue, "' where order_id = ", in_order_id);

PREPARE stmt from @sql;

EXECUTE stmt;

DEALLOCATE PREPARE stmt;
END //

DELIMITER ;



/* procedures for updating orders integer */
DELIMITER //

create procedure update_order_int(IN in_datatype varchar(30), IN in_datavalue int, IN in_order_id int)
BEGIN
set @sql = concat("UPDATE orders set ", in_datatype, " = ", in_datavalue, " where order_id = ", in_order_id);

PREPARE stmt from @sql;

EXECUTE stmt;

DEALLOCATE PREPARE stmt;
END //

DELIMITER ;




/* procedures for cancelling orders */

DELIMITER //

create procedure cancel_order(IN in_order_id int)
BEGIN
	Update orders set order_status = "cancelled" where order_id = in_order_id;
END //

DELIMITER ;

/* procedure for viewing inventory status*/
DELIMITER //

create procedure reload_inventory()
BEGIN

	select * from orders where order_status = "completed" and update_status = 0
		FOR EACH ROW 
	IF order_status = "completed" and update_status = 0 THEN
		-- Update inventory by subtracting the quantity used for each ingredient
			UPDATE inventory i
			JOIN (
				-- Select the sum of all ingredients used in the items of the order
				SELECT p.ingredient_id, SUM(p.quantity_used) AS quantity_used
				FROM preparations p
				WHERE p.meal_id = NEW.item_id
				GROUP BY p.ingredient_id
			) AS used
			ON used.ingredient_id = i.inventory_id
			SET i.total_quantity = i.total_quantity - IFNULL(used.quantity_used, 0);
		
            update orders set update_status = 1 WHERE order_id = order_id;
	END IF;
    
    
    
END //

DELIMITER ;

/* Trigger on updated order*/
DELIMITER //

CREATE TRIGGER ingredient_update
AFTER UPDATE ON orders
FOR EACH ROW
BEGIN

		-- Only execute if the order_status is 'completed'
	IF NEW.update_status = 0 AND  NEW.order_status = 'completed' THEN
			
            
            update orders set update_status = 1 WHERE order_id = NEW.order_id;
		END IF;
END //

DELIMITER ;


																	/* End of procedures for orders */
															
                                                            
                                                            
																	/*  Procedures for ingredients */
/* procedure for inserting ingredients */
DELIMITER //

CREATE PROCEDURE add_ingredient(IN in_ingredient_name varchar(30) ,IN in_ingredient_price decimal(7,2) , IN in_ingredient_quantity int )
BEGIN
	INSERT INTO inventory (ingredient_name, price_per_unit, total_quantity) 
                    VALUES (in_ingredient_name, in_ingredient_price, in_ingredient_quantity);
END //

DELIMITER ;
																	
                                                                    /* End of procedures for ingredients */
                                                                    
                                                                    
                                                                    
                                                                    
                                                                    

DELIMITER //

CREATE PROCEDURE get_customer_feedback()
BEGIN
	select customer_name,review 
	from review right join customers
	on review.customer_id = customers.customer_id;
END //

DELIMITER ;



DELIMITER //

CREATE PROCEDURE get_daily_sales()
BEGIN
	SELECT 
		customers.customer_name, 
		menu.dish_price, 
		menu.dish_name
	FROM 
		orders 
		LEFT JOIN customers ON orders.customer_id = customers.customer_id
		LEFT JOIN menu ON orders.item_id = menu.dish_id
	WHERE 
		DATE(orders.order_date) = CURDATE();
END //

DELIMITER ;



DELIMITER //

CREATE PROCEDURE get_popular_dish()
BEGIN
	SELECT
		COUNT(item_id) AS number, dish_name
	FROM
		orders
		LEFT JOIN menu ON item_id = dish_id
	GROUP BY
		dish_name
	ORDER BY
		number DESC
	LIMIT 1;
END //

DELIMITER ;


