# UytkownicyApi

All URIs are relative to *http://localhost*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**8829fd3de941175801836d9958447464**](UytkownicyApi.md#8829fd3de941175801836d9958447464) | **POST** /api/admin/users/{user}/activate | Aktywacja konta użytkownika |
| [**a522c0230639ee7c7f1204582b59b41a**](UytkownicyApi.md#a522c0230639ee7c7f1204582b59b41a) | **GET** /api/user | Pobierz dane zalogowanego użytkownika |


<a name="8829fd3de941175801836d9958447464"></a>
# **8829fd3de941175801836d9958447464**
> _8829fd3de941175801836d9958447464_200_response 8829fd3de941175801836d9958447464(user)

Aktywacja konta użytkownika

    Aktywuje nieaktywne konto użytkownika. Dostępne tylko dla ról &#39;admin&#39; lub &#39;it&#39;.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **user** | **Integer**| ID użytkownika do aktywacji | [default to null] |

### Return type

[**_8829fd3de941175801836d9958447464_200_response**](../Models/_8829fd3de941175801836d9958447464_200_response.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

<a name="a522c0230639ee7c7f1204582b59b41a"></a>
# **a522c0230639ee7c7f1204582b59b41a**
> User a522c0230639ee7c7f1204582b59b41a()

Pobierz dane zalogowanego użytkownika

    Zwraca dane użytkownika powiązanego z użytym tokenem API. Służy do weryfikacji tokena i pobrania podstawowych informacji (np. rola, nazwa). Jeśli token jest nieprawidłowy lub wygasł, serwer zwróci błąd 401 Unauthenticated.

### Parameters
This endpoint does not need any parameter.

### Return type

[**User**](../Models/User.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

