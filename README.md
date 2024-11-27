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
