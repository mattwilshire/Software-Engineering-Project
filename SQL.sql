CREATE TABLE Users (
    id int AUTO_INCREMENT,
    username varchar(20) NOT NULL,
    email varchar(50) NOT NULL,
    password text NOT NULL,
    accId int,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (username),
    UNIQUE KEY (email),
    PRIMARY KEY (id)
);

CREATE TABLE Accounts (
    accId INT,
    balance int,
    cardNo varchar(30),
    expMonth int,
    expYear int,
    cvc int,
    PRIMARY KEY (accId)
);


ALTER TABLE Accounts
ADD disabled BOOLEAN NOT NULL DEFAULT 0;

ALTER TABLE Accounts
ADD USDBalance int NOT NULL DEFAULT 0;

ALTER TABLE Accounts
ADD GBPBalance int NOT NULL DEFAULT 0;

ALTER TABLE Accounts
ADD savings int NOT NULL DEFAULT 0;

CREATE TABLE Contacts (
    id int AUTO_INCREMENT,
    username varchar(30),
    usernameTo varchar(30),
    PRIMARY KEY (id)
);


CREATE TABLE Transactions (
    id int AUTO_INCREMENT,
    accId int,
    type boolean,
    message varchar(250),
    amount int,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);