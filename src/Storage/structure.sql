/*
   DBuser data: 'm3webshopping'@'localhost' IDENTIFIED BY 'wshm3';
*/
USE m3webshopping;

CREATE TABLE IF NOT EXISTS products(
    id VARCHAR(64) NOT NULL UNIQUE,
    name VARCHAR(196) NOT NULL,
    description TEXT(2048),
    price FLOAT(2),
    quantity INTEGER(4),
    visibility INT(1) DEFAULT 1,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS orders(
    id VARCHAR(64) NOT NULL UNIQUE,
    total FLOAT(2),
    completed_at DATETIME NOT NULL,
    visibility INT(1) DEFAULT 1,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS order_items(
    order_id VARCHAR(64) NOT NULL,
    product_id VARCHAR(64) NOT NULL,
    quantity INTEGER(4),
    price FLOAT(2),
    visibility INT(1) DEFAULT 1,
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
