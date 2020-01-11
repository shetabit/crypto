<p align="center"><img src="resources/images/crypto.png?raw=true"></p>




# Crypto

> This package can be used to **Encrypt**, **Decrypt** and **Sign** data using **Asymmetric** algorithms in php.

the below algoritms can be used:

- RSA
- DSA
- DH
- EC

## Install

Via Composer

``` bash
$ composer require shetabit/payment
```

## How to use

here is a simple encoding/decoding example.

```php
$crypto = new Crypto;

// generate private key
$privateKey = $crypto->createPrivateKey();
echo $privateKey;

// generate public key
$publicKey = $crypto->createPublicKey($privateKey);
echo $publicKey;

$data = 'a simple text';

// encrypt, plain data
$encryptedData = $crypto->encrypt($publicKey, $data);
echo $encryptedData;

// decrypt, encrypted data
$decryptedData = $crypto->decrypt($privateKey, $encryptedData);
echo $decryptedData;
```

#### Create private key

you can create a private key like the below

```php
$crypt = new Crypt;

$privateKey = $crypt->createPrivateKey();

echo $privatekey;
```

the below algorithms can be used:

- RSA: use **Crypto::OPENSSL_KEYTYPE_RSA**
- DSA: use **Crypto::OPENSSL_KEYTYPE_DSA** (not completely supported by PHP OpenSSL)
- DH:  use **Crypto::OPENSSL_KEYTYPE_DH** (not completely supported by PHP OpenSSL)
- EC: use **Crypto::OPENSSL_KEYTYPE_EC** (not completely supported by PHP OpenSSL)

```php
$crypt = new Crypt;

$privateKey = $crypt->createPrivateKey(Crypto::OPENSSL_KEYTYPE_RSA);

echo $privatekey;
```

#### Create public key:

a public key can be generated using a private key

```php
$privatekey = '-----BEGIN EC PRIVATE KEY-----
MIHuAgEBBEgC1SvKxAMTrXYmC9CV+euaL8KVemuuU6I9A5moUh4HgTzESYt35lgc
CiwMetwIaB9RHFM7869D4rClXvnxFy91nMklcY7IsCmgBwYFK4EEACehgZUDgZIA
BAHBdOduvUMAft3s3xq/70CyHtJTfbFAMmyE6rIOAXYlOcvCvwfLRTbAXkZ+PnU+
5SkSqpC036F02Hr8GNxToie+gLrEAsmjQwLImuN9o+1UPwYR3LdG8N4JsnFkIMYr
qTvrA+usw5pjfZmqE4hHlFVdIaIb7r2m8w2OEZTfsfxQjRzY6uE9P3711NWdZdP2
Rg==
-----END EC PRIVATE KEY-----';

$crypt = new Crypt;

$publicKey = $crypt->createPublicKey($privateKey);

echo $publicKey;
```

#### Encrypt data:

- data must be in string format.
- you need a **valid public key** to encrypt data.

```php
$publicKey = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzLBs9Y2+QSr8l5LV8beY
nidHPHhM0/zMy1V7CiTWQyQVyxsZKHQJZGP+zJNovSH+KG9wfUe5XnC7qVDU80Bi
ABfQFhLe+t7w8UnBbRnDxMnLCjoSrtG8ZlJBkfmvTMf4MdmvMUqzqUD+ssB76BOP
Cce7qGntIlhQOzj3crliLex6E4OmwUP9RgPtIz/GQuI+O/XSf6irkkRjE8Sq9J7S
zU7z/asXcSi9PMzql/3Z/K47azWBZJazpSf6rkfVQzsITcai+CaZvVItCrMq7z94
/poX24CX2MgOxWxv8thRG7jO7nNCT5Smc+wi1j3HXaxbnA3vcAt6yQ6ctXpf1rGI
FwIDAQAB
-----END PUBLIC KEY-----";

$data = 'this is a simple text';

$encryptedData = $crypto->encrypt($publicKey, $data);

echo $encryptedData;
```

#### Decrypt data:

- you need a **valid public key** to decrypt data.

```php
$privateKey='private key';

$encryptedData = 'encrypted data';

$decryptedData = $crypto->decrypt($privateKey, $encryptedData);

echo $decryptedData;
```

#### Sign data:

- data must be in string format.
- you need a **valid public key** to sign data.

```php
$privateKey = "-----BEGIN PRIVATE KEY-----
MIHuAgEBBEgC1SvKxAMTrXYmC9CV+euaL8KVemuuU6I9A5moUh4HgTzESYt35lgc
CiwMetwIaB9RHFM7869D4rClXvnxFy91nMklcY7IsCmgBwYFK4EEACehgZUDgZIA
BAHBdOduvUMAft3s3xq/70CyHtJTfbFAMmyE6rIOAXYlOcvCvwfLRTbAXkZ+PnU+
5SkSqpC036F02Hr8GNxToie+gLrEAsmjQwLImuN9o+1UPwYR3LdG8N4JsnFkIMYr
qTvrA+usw5pjfZmqE4hHlFVdIaIb7r2m8w2OEZTfsfxQjRzY6uE9P3711NWdZdP2
Rg==
-----END EC PRIVATE KEY-----";

$data = 'this is a simple text';

$signature = $crypto->sign($privateKey, $data);

echo $signature;
```

#### verify signature:

- you need a **valid public key** to verify data.

```php
$publicKey = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzLBs9Y2+QSr8l5LV8beY
nidHPHhM0/zMy1V7CiTWQyQVyxsZKHQJZGP+zJNovSH+KG9wfUe5XnC7qVDU80Bi
ABfQFhLe+t7w8UnBbRnDxMnLCjoSrtG8ZlJBkfmvTMf4MdmvMUqzqUD+ssB76BOP
Cce7qGntIlhQOzj3crliLex6E4OmwUP9RgPtIz/GQuI+O/XSf6irkkRjE8Sq9J7S
zU7z/asXcSi9PMzql/3Z/K47azWBZJazpSf6rkfVQzsITcai+CaZvVItCrMq7z94
/poX24CX2MgOxWxv8thRG7jO7nNCT5Smc+wi1j3HXaxbnA3vcAt6yQ6ctXpf1rGI
FwIDAQAB
-----END PUBLIC KEY-----";

$signature = 'this is a signature';

$verification = $crypto->encrypt($publicKey, $data);

echo $encryptedData ? 'true' : 'false';
```
