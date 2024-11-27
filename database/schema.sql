-- Alerim Cryptocurrency Database Schema

-- Users table
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Wallets table
CREATE TABLE wallets (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    address VARCHAR(255) NOT NULL UNIQUE,
    private_key_encrypted TEXT NOT NULL,
    balance DECIMAL(30,8) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Mining rewards table
CREATE TABLE mining_rewards (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    original_currency VARCHAR(10) NOT NULL,
    original_amount DECIMAL(30,8) NOT NULL,
    original_value_usd DECIMAL(20,2) NOT NULL,
    aim_amount DECIMAL(30,8) NOT NULL,
    gold_price_per_gram DECIMAL(20,2) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Transactions table
CREATE TABLE transactions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    from_wallet VARCHAR(255),
    to_wallet VARCHAR(255) NOT NULL,
    amount DECIMAL(30,8) NOT NULL,
    fee DECIMAL(30,8) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    FOREIGN KEY (from_wallet) REFERENCES wallets(address),
    FOREIGN KEY (to_wallet) REFERENCES wallets(address)
);

-- Mining workers table
CREATE TABLE mining_workers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    worker_name VARCHAR(255) NOT NULL,
    algorithm VARCHAR(50) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'inactive',
    last_seen TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
