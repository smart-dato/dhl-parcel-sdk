# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Laravel SDK for the DHL Parcel DE Shipping v2 API. Built on **Saloon** (HTTP client) and **Spatie Laravel Data** (DTOs). Requires PHP 8.4+, Laravel 11/12.

## Commands

```bash
composer test          # Run Pest tests
composer test -- --filter=TestName  # Run a single test
composer analyse       # Run PHPStan (level 5)
composer format        # Fix code style with Laravel Pint
```

CI runs tests across PHP 8.3/8.4, Laravel 11/12, on Ubuntu and Windows.

## Architecture

```
DhlParcel (main service)
├── orders()    → OrdersResource    → create/validate/get/delete shipments
├── manifests() → ManifestsResource → get/create manifests
└── labels()    → LabelsResource    → download label PDFs
```

**Key layers:**

- **`Auth/DhlParcelAuthenticator`** — Supports API key (`dhl-api-key` header) or Basic Auth. Configured via `config/dhl-parcel-sdk.php`.
- **`Connectors/DhlParcelConnector`** — Saloon connector with sandbox/production base URLs. Throws `DhlParcelApiException` on errors.
- **`Resources/`** — Three resource classes wrapping API endpoints. All extend `BaseResource` which tracks last request/response for debugging.
- **`Requests/`** — Saloon request classes (6 total) organized by domain (Orders, Manifests, Labels). Each implements `createDtoFromResponse()`.
- **`Data/`** — 28 DTOs extending `Spatie\LaravelData\Data`. Request DTOs in `Data/Orders/` and `Data/Manifests/`, response DTOs in `Data/Responses/`.
- **`Enums/`** — Backed string enums for products, formats, units, etc.

**Multi-tenant support:** `DhlParcel::make(config)` creates instances with different credentials.

## Configuration

Environment variables: `DHL_PARCEL_API_KEY`, `DHL_PARCEL_USERNAME`, `DHL_PARCEL_PASSWORD`, `DHL_PARCEL_SANDBOX`, `DHL_PARCEL_BASE_URL`.

## Testing

- Pest 4.0 with Orchestra Testbench
- Architecture tests enforce no `dd`/`dump`/`ray` calls
- Base `TestCase` in `tests/TestCase.php` auto-registers the service provider

## Static Analysis

PHPStan level 5 via Larastan. Config ignores `env()` calls in config files.
