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
