# Changelog

## FORMGEN-L

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 1.0.1 - 24 FEBRUARY 2025
### Added
- Added database seeders for areas, banks, hloes, and incomes

### Changed
- Made minor UI updates
- Updated .env files to use APP_URL variable to handle dynamic routes

## 1.0.0 - 1 OCTOBER 2024
### Changed
- Updated routes to render form page from controller method instead of rendering the view directly
- Updated form to render areas from database
- Updated error redirects from `back()` to `redirect(...)` to work with route handling on apache
- Forced app to use https based on APP_URL in .env
- Updated .env files with ASSET_URL variable to prevent mixed content error on live environments

### Components
- Fixed error where date input would not render old values from redirect
- Changed helper text to be customizable for file input and multi-file input
- Added spacing to input link boxes for multi-text input
- Added Textarea component

