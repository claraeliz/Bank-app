# Bank App

A multi-account PHP banking app with persistent storage, supporting deposits from linked wallets, transfers between accounts, and debit card management.

## Features

- **3 accounts** — Clara, Bongo, and Alice, each with their own balance and debit card
- **Account picker** — select which account to manage before performing any operation
- **Wallet-based deposits** — each account has a linked external wallet (€5,000 starting balance); deposits draw from it, so money always has a real source
- **Transfers** — send money between accounts; both sender and receiver see the transaction in their history with the counterpart's name
- **Debit card** — freeze and unfreeze per account
- **Persistent storage** — operations survive server restarts via a local serialized data file

## Tech Stack

- PHP (OOP — classes, interfaces, inheritance)
- Tailwind CSS
- Docker / Docker Compose

## Run Locally

**With Docker:**
```bash
docker compose up
```
Then open [http://localhost:8080](http://localhost:8080).

**Without Docker:**

Serve the project root with any PHP server (e.g. XAMPP, WAMP, or `php -S localhost:8080`).

## Reset

Visit `/reset.php` to wipe all data and start fresh.
