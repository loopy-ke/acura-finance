# Acura Finance

Credit & Financing module for Acura ERP system.

## Features

- Credit application management
- Credit scoring and evaluation
- Automated approval workflows
- Credit products management
- Disbursement tracking
- Collection and recovery
- Comprehensive reporting
- Interest rate management

## Installation

```bash
composer require loopylabs/acura-finance
```

## Configuration

After installation, publish the configuration and migrations:

```bash
php artisan vendor:publish --provider="LoopyLabs\CreditFinancing\CreditFinancingServiceProvider"
php artisan migrate
```

## License

MIT License