---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#Currency Conversion


<!-- START_05f1f7d89e45949d9cfc26dd5dc355bd -->
## Currency Conversion

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/currency-conversion?origin_currency=TWD&target_currency=USD&amount=500.2" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/currency-conversion"
);

let params = {
    "origin_currency": "TWD",
    "target_currency": "USD",
    "amount": "500.2",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (400):

```json
{
    "message": {
        "origin_currency": [
            "The origin currency field is required."
        ],
        "target_currency": [
            "The target currency field is required."
        ],
        "amount": [
            "The amount field is required."
        ]
    }
}
```
> Example response (200):

```json
{
    "convert_amount": "16.41"
}
```

### HTTP Request
`GET api/currency-conversion`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `origin_currency` |  required  | The origin_currency of origin currency enum('TWD', 'USD', 'JPY').
    `target_currency` |  required  | The target_currency of target currency enum('TWD', 'USD', 'JPY').
    `amount` |  required  | The amount of conversion amount.

<!-- END_05f1f7d89e45949d9cfc26dd5dc355bd -->


