CREATE TABLE Users (
	UserID INTEGER AUTO_INCREMENT PRIMARY KEY,
	Name VARCHAR (20),
	Username VARCHAR (20) UNIQUE,
	userPassword VARCHAR (100),
	Gender VARCHAR (8),
	ContactNo INTEGER,
	Email CHAR(50),
	Country CHAR(25),
	UserType VARCHAR (8),
	ProfileImage VARCHAR (50)
);

CREATE TABLE Category (
	CatID INTEGER AUTO_INCREMENT PRIMARY KEY,
	Name VARCHAR(50)
);

CREATE TABLE Product (
	UserID INTEGER,
	CatID INTEGER,
	ProductID INTEGER AUTO_INCREMENT PRIMARY KEY,
	Name VARCHAR(100),
	Description longtext,
	Price INTEGER,
	Stock INTEGER,
	PCondition VARCHAR(20),
	City VARCHAR(50),
	PostedDate DATE,
	Approved BOOLEAN,
	CONSTRAINT FK1 FOREIGN KEY(UserID) REFERENCES Users(UserID) ON DELETE CASCADE,
	CONSTRAINT FK2 FOREIGN KEY(CatID) REFERENCES Category(CatID) ON DELETE CASCADE
);

CREATE TABLE Wishlist(
	ID INTEGER AUTO_INCREMENT PRIMARY KEY,
	UserID INTEGER,
	ProductID INTEGER,
	AddedDate DATE,
	CONSTRAINT FK3 FOREIGN KEY(UserID) REFERENCES Users(UserID) ON DELETE CASCADE,
	CONSTRAINT FK4 FOREIGN KEY(ProductID) REFERENCES Product(ProductID) ON DELETE CASCADE
	
);

CREATE TABLE Payment(
	UserID INTEGER,
	PaymentID INTEGER AUTO_INCREMENT PRIMARY KEY,
	PDATE  DATETIME DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT FK5 FOREIGN KEY(UserID) REFERENCES Users(UserID) ON DELETE CASCADE
);

CREATE TABLE PaymentDetail(
	PaymentID INTEGER,
	ProductID INTEGER,
	PName VARCHAR(100),
	Quantity INTEGER,
	Amount INTEGER
);

CREATE TABLE Images(
	ProductID INTEGER,
	imageURL VARCHAR (1000),
	CONSTRAINT FK6 FOREIGN KEY (ProductID) REFERENCES Product(ProductID) ON DELETE CASCADE
);
