<?php
$db = new SQLite3(__DIR__ . '/database.db');

// USERS
$db->exec('CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    first_name TEXT,
    last_name TEXT,
    password TEXT NOT NULL,
    billing_name TEXT,
    billing_address TEXT,
    billing_city TEXT,
    billing_postal_code TEXT,
    billing_country TEXT,
    billing_vat TEXT,
    created_at TEXT NOT NULL
)');

// ADMINS
$db->exec('CREATE TABLE IF NOT EXISTS admins (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    first_name TEXT,
    last_name TEXT,
    password TEXT NOT NULL,
    created_at TEXT NOT NULL
)');

// PAGES
$db->exec('CREATE TABLE IF NOT EXISTS pages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    language TEXT,
    description TEXT,
    keywords TEXT,
    content TEXT,
    created_at TEXT NOT NULL,
    updated_at TEXT
)');

// VIEWS
$db->exec('CREATE TABLE IF NOT EXISTS views (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    page_id INTEGER NOT NULL,
    ip_address TEXT,
    user_agent TEXT,
    viewed_at TEXT NOT NULL,
    FOREIGN KEY(page_id) REFERENCES pages(id)
)');

// MARKETING TOOLS
$db->exec('CREATE TABLE IF NOT EXISTS marketing_tools (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    google_tag TEXT,
    facebook_pixel TEXT,
    connected_at TEXT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id)
)');

// COOKIE AND POLICY TOOLS
$db->exec('CREATE TABLE IF NOT EXISTS cookie_policy_tools (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    provider TEXT NOT NULL,
    embed_code TEXT,
    status TEXT DEFAULT "disabled",
    created_at TEXT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id)
)');

echo "Database inizializzato con tutte le tabelle.";