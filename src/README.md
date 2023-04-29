# Glady API PHP client

Bibliothèque d'accès à l'API Glady (ex Wedoogift)

## Pré-requis

- PHP 7
- client_id
- client_secret

## Installation

`composer require wassa/glady-api-client-php`

## Utilisation

Créer une instance de la classe `GladyClient` et appeler les méthodes correspondantes aux API que vous voulez utiliser.

Exemple :

```php
<?php

use Wassa\GladyApiClient\GladyClient;

$client = new GladyClient(
    $_ENV['CLIENT_ID'], // client_id
    $_ENV['CLIENT_SECRET'], // client_secret
    true // demo mode
);

$res = $client->beneficiariesList([
    'invited' => true,
    'pageSize' => 10,
    'pageIndex' => 0]);
var_dump($res);
```

## Méthodes disponibles

La classe `GladyClient` exporte les méthodes suivantes :

- `ssoCreateToken` : https://glady.docs.apiary.io/#reference/0/autoconnexion-sso/creation-d'un-token-sso
- `beneficiariesGetById` : https://glady.docs.apiary.io/#reference/0/beneficiaires/detail-d'un-beneficiaire-par-id
- `beneficiariesGetByLogin` : https://glady.docs.apiary.io/#reference/0/beneficiaires/detail-d'un-beneficiaire-par-login
- `beneficiariesGetBalance` : https://glady.docs.apiary.io/#reference/0/beneficiaires/soldes-d'un-beneficiaire
- `beneficiariesList` : https://glady.docs.apiary.io/#reference/0/beneficiaires/lister-des-beneficiaires
- `beneficiariesAdd` : https://glady.docs.apiary.io/#reference/0/beneficiaires/ajout-de-beneficiaires
- `beneficiariesUpdate` : https://glady.docs.apiary.io/#reference/0/beneficiaires/modification-d'un-beneficiaire
- `beneficiariesDelete` : https://glady.docs.apiary.io/#reference/0/beneficiaires/suppression-de-beneficiaires
- `walletsList` : https://glady.docs.apiary.io/#reference/0/wallets/liste-des-wallets-et-des-motifs-de-distribution
- `walletsCreateReason` : https://glady.docs.apiary.io/#reference/0/wallets/creation-d'un-motif-de-distribution
- `walletsUpdateReason` : https://glady.docs.apiary.io/reference/0/wallets/modification-d'un-motif-de-distribution
- `walletsDeleteReason` : https://glady.docs.apiary.io/reference/0/wallets/suppression-d'un-motif-de-distribution
- `organisationsListDeposits` : https://glady.docs.apiary.io/reference/0/organisations/deposits-de-l'organisation
- `organisationsGetDeposit` : https://glady.docs.apiary.io/reference/0/organisations/recuperer-un-deposit-de-l'organisation
- `campaignsCreate` : https://glady.docs.apiary.io/reference/0/campagnes/creer-une-campagne-de-distribution

# Tests

Test en cours