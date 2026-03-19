# DHL Parcel DE Shipping SDK for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smart-dato/dhl-parcel-sdk.svg?style=flat-square)](https://packagist.org/packages/smart-dato/dhl-parcel-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/dhl-parcel-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/smart-dato/dhl-parcel-sdk/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/dhl-parcel-sdk/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/smart-dato/dhl-parcel-sdk/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/smart-dato/dhl-parcel-sdk.svg?style=flat-square)](https://packagist.org/packages/smart-dato/dhl-parcel-sdk)

A Laravel package for the [DHL Parcel DE Shipping v2 API](https://developer.dhl.com/api-reference/parcel-de-shipping-post-parcel-germany-v2). Create shipments, retrieve labels, manage manifests, and more. Built on [Saloon](https://docs.saloon.dev) and [Spatie Laravel Data](https://spatie.be/docs/laravel-data).

## Installation

```bash
composer require smart-dato/dhl-parcel-sdk
```

Publish the config file:

```bash
php artisan vendor:publish --tag="dhl-parcel-sdk-config"
```

Add your credentials to `.env`:

```env
DHL_PARCEL_API_KEY=your-api-key
# Or use Basic Auth instead:
# DHL_PARCEL_USERNAME=your-username
# DHL_PARCEL_PASSWORD=your-password

# Enable sandbox for testing:
# DHL_PARCEL_SANDBOX=true
```

## Usage

### Create a shipment

```php
use SmartDato\DhlParcel\Data\Orders\ContactAddressData;
use SmartDato\DhlParcel\Data\Orders\ShipmentData;
use SmartDato\DhlParcel\Data\Orders\ShipmentDetailsData;
use SmartDato\DhlParcel\Data\Orders\ShipmentOrderRequestData;
use SmartDato\DhlParcel\Data\Orders\ShipperData;
use SmartDato\DhlParcel\Data\Orders\WeightData;
use SmartDato\DhlParcel\Enums\DocFormat;
use SmartDato\DhlParcel\Enums\Product;
use SmartDato\DhlParcel\Enums\WeightUom;
use SmartDato\DhlParcel\Facades\DhlParcel;

$response = DhlParcel::orders()->create(
    data: new ShipmentOrderRequestData(
        profile: 'STANDARD_GRUPPENPROFIL',
        shipments: [
            new ShipmentData(
                product: Product::V01PAK,
                billingNumber: '33333333330102',
                details: new ShipmentDetailsData(
                    weight: new WeightData(WeightUom::Grams, 500),
                ),
                shipper: new ShipperData(
                    name1: 'My Online Shop GmbH',
                    addressStreet: 'Sträßchensweg 10',
                    city: 'Bonn',
                    country: 'DEU',
                    postalCode: '53113',
                ),
                consignee: new ContactAddressData(
                    name1: 'Maria Musterfrau',
                    addressStreet: 'Kurt-Schumacher-Str. 20',
                    city: 'Bonn',
                    country: 'DEU',
                    postalCode: '53113',
                ),
            ),
        ],
    ),
    docFormat: DocFormat::Pdf,
);

// Access the label
$label = $response->items[0]->label;
```

### Validate a shipment (dry run)

```php
$response = DhlParcel::orders()->validate(
    data: $shipmentOrderRequest,
);
```

### Retrieve existing labels

```php
$response = DhlParcel::orders()->get(
    shipments: ['340434310428091700'],
);
```

### Delete shipments

```php
$response = DhlParcel::orders()->delete(
    profile: 'STANDARD_GRUPPENPROFIL',
    shipments: ['340434310428091700'],
);
```

### Manifests

```php
use SmartDato\DhlParcel\Data\Manifests\ManifestRequestData;

// Get daily manifest
$manifest = DhlParcel::manifests()->get(date: '2025-01-15');

// Close out shipments
$response = DhlParcel::manifests()->create(
    data: new ManifestRequestData(
        profile: 'STANDARD_GRUPPENPROFIL',
        shipmentNumbers: ['340434310428091700'],
    ),
);
```

### Download a label PDF

```php
$pdfContent = DhlParcel::labels()->download(token: 'label-token-from-response');
```

### Multi-tenant usage

```php
use SmartDato\DhlParcel\DhlParcel;

$dhl = DhlParcel::make([
    'api_key' => 'tenant-specific-key',
    'sandbox' => true,
]);

$response = $dhl->orders()->create($data);
```

## Available products

| Enum | Product |
|------|---------|
| `Product::V01PAK` | DHL Paket |
| `Product::V53WPAK` | DHL Paket International |
| `Product::V54EPAK` | DHL Europaket |
| `Product::V62WP` | Warenpost |
| `Product::V62KP` | DHL Kleinpaket |
| `Product::V66WPI` | Warenpost International |

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [SmartDato](https://github.com/smart-dato)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
