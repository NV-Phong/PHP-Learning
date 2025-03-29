
CREATE DATABASE MY_STORE;

USE MY_STORE;

CREATE TABLE CATEGORY (
   IDCategory				CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   CategoryName			VARCHAR (100) NOT NULL,
   CategoryDescription	TEXT,
	IsDeleted				BOOLEAN NOT NULL
)

CREATE TABLE PRODUCT(
	IDProduct				CHAR(36) PRIMARY KEY DEFAULT(UUID()),
	IDCategory 				CHAR(36),
	ProductName				VARCHAR (100) NOT NULL,
	ProductDescription	TEXT,
	Price 					DECIMAL(10,2) NOT NULL,
	ImageURL 				VARCHAR(255) DEFAULT NULL,
	IsDeleted				BOOLEAN NOT NULL,
	FOREIGN KEY (IDCategory) REFERENCES CATEGORY (IDCategory)
)

INSERT INTO CATEGORY (CategoryName, CategoryDescription, IsDeleted) VALUES
('Electronics', 'Electronic devices and gadgets', false),
('Clothing', 'Apparel and accessories', false),
('Chưa Được Phân Loại', 'Chưa được phân loại danh mục', false),
('Books', 'Reading materials and literature', false);

INSERT INTO PRODUCT (IDCategory, ProductName, ProductDescription, Price, ImageURL, IsDeleted) VALUES
((SELECT IDCategory FROM CATEGORY WHERE CategoryName = 'Electronics'), 'Smartphone', 'Latest model smartphone', 999.99, 'phone.jpg', false),
((SELECT IDCategory FROM CATEGORY WHERE CategoryName = 'Clothing'), 'T-Shirt', 'Cotton casual t-shirt', 19.99, 'tshirt.jpg', false),
((SELECT IDCategory FROM CATEGORY WHERE CategoryName = 'Books'), 'Programming Guide', 'Beginners guide to coding', 49.99, 'book.jpg', false);

