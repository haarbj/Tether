-- Table Creation

CREATE TABLE Users (

    userID INT AUTO_INCREMENT,

    phoneNumber VARCHAR(15) NOT NULL,

    email VARCHAR(100) NOT NULL,

    password VARCHAR(255) NOT NULL,

    numberOfContacts INT DEFAULT 0,

    firstName VARCHAR(50) NOT NULL,

    middleName VARCHAR(50),

    lastName VARCHAR(50) NOT NULL,

    zip VARCHAR(10) NOT NULL,

    state VARCHAR(50) NOT NULL,

    city VARCHAR(50) NOT NULL,

    streetNumber VARCHAR(10) NOT NULL,

    streetName VARCHAR(100) NOT NULL,

    PRIMARY KEY (userID)

);



CREATE TABLE User_Social_Contact (

    userID INT NOT NULL,

    phoneNumber VARCHAR(15) NOT NULL,

    firstName VARCHAR(50) NOT NULL,

    middleName VARCHAR(50),

    lastName VARCHAR(50) NOT NULL,

    PRIMARY KEY (userID, phoneNumber),

    FOREIGN KEY (userID) REFERENCES Users(userID)

        ON DELETE CASCADE

        ON UPDATE CASCADE

);



CREATE TABLE Reminder (

    reminderID INT AUTO_INCREMENT,

    content TEXT NOT NULL,

    frequency VARCHAR(20) NOT NULL,

    PRIMARY KEY (reminderID)

);



CREATE TABLE Refers (

    reminderID INT NOT NULL,

    phoneNumber VARCHAR(15) NOT NULL,

    userID INT NOT NULL,

    PRIMARY KEY (reminderID, phoneNumber, userID),

    FOREIGN KEY (reminderID) REFERENCES Reminder(reminderID)

        ON DELETE CASCADE

        ON UPDATE CASCADE,

    FOREIGN KEY (userID, phoneNumber) REFERENCES User_Social_Contact(userID, phoneNumber)

        ON DELETE CASCADE

        ON UPDATE CASCADE

);



CREATE TABLE Reminds (

    userID INT NOT NULL,

    reminderID INT NOT NULL,

    format VARCHAR(20) NOT NULL,

    PRIMARY KEY (userID, reminderID),

    FOREIGN KEY (userID) REFERENCES Users(userID)

        ON DELETE CASCADE

        ON UPDATE CASCADE,

    FOREIGN KEY (reminderID) REFERENCES Reminder(reminderID)

        ON DELETE CASCADE

        ON UPDATE CASCADE

);



CREATE TABLE Payment (

    paymentID INT AUTO_INCREMENT,

    amount DECIMAL(10, 2) NOT NULL,

    invoiceNumber VARCHAR(50) NOT NULL,

    paymentDate DATE NOT NULL,

    cardAddress VARCHAR(200),

    type_of_card VARCHAR(50),

    cardName VARCHAR(100),

    CVV VARCHAR(4),

    cardNumber VARCHAR(20),

    cardExpDate DATE,

    echeckAddress VARCHAR(200),

    echeckAccNumber VARCHAR(20),

    echeckRoutingNumber VARCHAR(20),

    echeckName VARCHAR(100),

    echeckFlag BOOLEAN,

    cardFlag BOOLEAN,

    PRIMARY KEY (paymentID)

);



CREATE TABLE Assist (

    userID INT NOT NULL,

    paymentID INT NOT NULL,

    PRIMARY KEY (userID, paymentID),

    FOREIGN KEY (userID) REFERENCES Users(userID)

        ON DELETE CASCADE

        ON UPDATE CASCADE,

    FOREIGN KEY (paymentID) REFERENCES Payment(paymentID)

        ON DELETE CASCADE

        ON UPDATE CASCADE

);



-- Data Population



-- Insert into Users

INSERT INTO Users (

    phoneNumber, email, password, numberOfContacts, firstName, middleName, lastName, zip, state, city, streetNumber, streetName

) VALUES

    ('1234567890', 'user1@example.com', 'password123', 3, 'John', 'A.', 'Doe', '12345', 'TN', 'Nashville', '12', 'Main St'),

    ('0987654321', 'user2@example.com', 'password456', 5, 'Jane', 'B.', 'Smith', '54321', 'NY', 'New York', '34', 'Broadway');



-- Insert into Reminder

INSERT INTO Reminder (content, frequency) VALUES

    ('Meeting with client', 'Weekly'),

    ('Pay credit card bill', 'Monthly');



-- Insert into Reminds

INSERT INTO Reminds (userID, reminderID, format) VALUES

    (1, 1, 'Email Notification'),

    (2, 2, 'SMS Notification');



-- Insert into User_Social_Contact

INSERT INTO User_Social_Contact (userID, phoneNumber, firstName, middleName, lastName) VALUES

    (1, '6159876543', 'Michael', 'J.', 'Fox'),

    (2, '2125678943', 'Sarah', 'L.', 'Connor');



-- Insert into Refers

INSERT INTO Refers (reminderID, phoneNumber, userID) VALUES

    (1, '6159876543', 1),

    (2, '2125678943', 2);



-- Insert into Payment

INSERT INTO Payment (

    amount,

    invoiceNumber,

    paymentDate,

    cardAddress,

    type_of_card,

    cardName,

    CVV,

    cardNumber,

    cardExpDate,

    echeckAddress,

    echeckAccNumber,

    echeckRoutingNumber,

    echeckName,

    echeckFlag,

    cardFlag

) VALUES

    (150.75, 'INV12345', '2024-11-01', '123 Card St', 'Credit', 'Visa', '123', '4111111111111111', '2025-12-01', NULL, NULL, NULL, NULL, FALSE, TRUE),

    (200.50, 'INV67890', '2024-11-02', NULL, 'ECheck', NULL, NULL, NULL, NULL, '123 Echeck St', '987654321', '123456789', 'John Doe', TRUE, FALSE);



-- Insert into Assist

INSERT INTO Assist (userID, paymentID) VALUES

    (1, 1),

    (2, 2);



-- Sample Queries



-- 1. Query a single table

SELECT * FROM Users;



-- 2. Join query

SELECT u.firstName, r.content, p.amount

FROM Users u

JOIN Reminds rm ON u.userID = rm.userID

JOIN Reminder r ON rm.reminderID = r.reminderID

JOIN Assist a ON u.userID = a.userID

JOIN Payment p ON a.paymentID = p.paymentID;



-- 3. Aggregation query

SELECT SUM(amount) AS TotalPayments FROM Payment;



-- 4. Insert operation

INSERT INTO Users (

    phoneNumber, email, password, numberOfContacts, firstName, middleName, lastName, zip, state, city, streetNumber, streetName

) VALUES

    ('1231231234', 'newuser@example.com', 'newpassword', 2, 'Alice', 'C.', 'Brown', '67890', 'CA', 'Los Angeles', '56', 'Sunset Blvd');



-- 5. Update operation

UPDATE Payment SET amount = 175.00 WHERE paymentID = 1;



-- 6. Delete operation

DELETE FROM Reminder WHERE reminderID = 2;



-- 7. Total Payments Per User

SELECT 

    u.userID,

    u.firstName,

    u.lastName,

    COUNT(p.paymentID) AS totalPaymentsMade,

    SUM(p.amount) AS totalPaymentAmount

FROM 

    Users u

JOIN 

    Assist a ON u.userID = a.userID

JOIN 

    Payment p ON a.paymentID = p.paymentID

GROUP BY 

    u.userID, u.firstName, u.lastName;