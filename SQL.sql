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