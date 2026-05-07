<?php

namespace SmartDato\DhlParcel;

use SmartDato\DhlParcel\Auth\DhlParcelAuthenticator;
use SmartDato\DhlParcel\Auth\OAuthConnector;
use SmartDato\DhlParcel\Connectors\DhlParcelConnector;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DhlParcelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('dhl-parcel-sdk')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(DhlParcelAuthenticator::class, function () {
            return new DhlParcelAuthenticator(
                apiKey: config('dhl-parcel-sdk.api_key'),
                username: config('dhl-parcel-sdk.username'),
                password: config('dhl-parcel-sdk.password'),
                clientSecret: config('dhl-parcel-sdk.client_secret'),
                oauthBaseUrl: OAuthConnector::resolveUrl(
                    config('dhl-parcel-sdk.oauth_base_url'),
                    config('dhl-parcel-sdk.sandbox', false),
                ),
            );
        });

        $this->app->singleton(DhlParcelConnector::class, function ($app) {
            return new DhlParcelConnector(
                authenticator: $app->make(DhlParcelAuthenticator::class),
                baseUrl: DhlParcelConnector::resolveUrl(
                    config('dhl-parcel-sdk.base_url'),
                    config('dhl-parcel-sdk.sandbox', false),
                ),
            );
        });

        $this->app->singleton(DhlParcel::class, function ($app) {
            return new DhlParcel(
                connector: $app->make(DhlParcelConnector::class),
            );
        });
    }
}
