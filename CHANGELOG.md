# Changelog

## [2.0.0] - 2025-04-02
### Feature
- Update plugin to PHP 7.2

## [1.5.0] - 2024-12-18
### Feature
- Added support for cart recovery for non-logged-in users

## [1.4.2] - 2024-10-31
### Feature
- Change storage from cookie to session

## [1.4.1] - 2024-07-26
### Feature
- Compatibility verified for Prestashop 8.1.7

## [1.4.0] - 2024-07-16
### Feature
- Added product_id in payload when sending product, order and customer

## [1.3.4] - 2024-07-02
### Fix
- Fixed: missing vendor catalog

## [1.3.3] - 2024-05-13
### Fix
- Fixed: newsletter name field getting from $_POST array

## [1.3.2] - 2024-02-27
### Feature
- Added prestashop 8 support

## [1.3.1] - 2024-01-15
### Fix
- Added TrackingCode events optimisation

## [1.3.0] - 2023-12-01
### Feature
- Added TrackingCode events: cart_updated & order_created
- 
## [1.2.0] - 2023-09-22
### Fix
- adjust hooks compatibility for Prestashop 1.7 and 8.1
- clean-up issues reported by Prestashop validator

## [1.1.5] - 2023-08-09
### Fix
- Handled subscriber name for callback 
- Added category id for view_item event

## [1.1.4] - 2023-06-12
### Feature
- Added Recostream events
- Added status and quantity import

## [1.1.3] - 2023-05-22
### Fix
- Added fixes for prestashop validator

## [1.1.2] - 2023-05-08
### Fix
- Fix for incompatibile function name (for Prestashop 1.6)

## [1.1.1] - 2023-03-06
### Fix
- Correct shop context in GetResponse plugin view

## [1.1.0] - 2023-01-30
### Feature
- Web events: view_items, view_category

## [1.0.12] - 2023-01-24
### Fix
- Archive file fixed

## [1.0.11] - 2023-01-24
### Feature
- Added deployment script

## [1.0.10] - 2023-01-09
### Fix
- Fix for yield from function

## [1.0.9] - 2022-10-04
### Fix
- Fix for hook cart
 
## [1.0.8] - 2022-08-23
### Fix
- Fix in unsubscription process

## [1.0.7] - 2022-04-25
### Fix
- Fix in override webservice

## [1.0.6] - 2022-03-23
### Fix
- Added fix for Prestashop validator

## [1.0.5] - 2022-02-21
### Fix
- Added fix for changing namespaces

## [1.0.4] - 2022-02-18
### Fix
- Changed orderNo name to order_name in payload when sending order

## [1.0.3] - 2022-02-01
### Fix
- Validator

## [1.0.2] - 2022-02-01
### Fix
- Added fix for missing cart url when sending cart

## [1.0.1] - 2022-01-20
### Fix
- Updated readme file

## [1.0.0] - 2022-01-18
### Release
- Released version 1.0.0