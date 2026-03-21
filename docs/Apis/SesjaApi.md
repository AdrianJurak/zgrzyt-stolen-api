# SesjaApi

All URIs are relative to *http://localhost*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**47fe20490afc15b35cdb187abd89d83b**](SesjaApi.md#47fe20490afc15b35cdb187abd89d83b) | **POST** /logout | Wylogowanie użytkownika (sesja webowa) |
| [**679fb8cdc013f16541de7cdff8b091b5**](SesjaApi.md#679fb8cdc013f16541de7cdff8b091b5) | **POST** /reset-session | Resetowanie sesji |
| [**c53df93dc842bea4ec7b35fe22505eb9**](SesjaApi.md#c53df93dc842bea4ec7b35fe22505eb9) | **GET** /auth-status | Sprawdzenie statusu autoryzacji |


<a name="47fe20490afc15b35cdb187abd89d83b"></a>
# **47fe20490afc15b35cdb187abd89d83b**
> 47fe20490afc15b35cdb187abd89d83b()

Wylogowanie użytkownika (sesja webowa)

    Kończy sesję użytkownika w aplikacji webowej (unieważnia sesję).

### Parameters
This endpoint does not need any parameter.

### Return type

null (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

<a name="679fb8cdc013f16541de7cdff8b091b5"></a>
# **679fb8cdc013f16541de7cdff8b091b5**
> 679fb8cdc013f16541de7cdff8b091b5()

Resetowanie sesji

    Wymusza wyczyszczenie całej sesji i tokenów po stronie serwera.

### Parameters
This endpoint does not need any parameter.

### Return type

null (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

<a name="c53df93dc842bea4ec7b35fe22505eb9"></a>
# **c53df93dc842bea4ec7b35fe22505eb9**
> c53df93dc842bea4ec7b35fe22505eb9_200_response c53df93dc842bea4ec7b35fe22505eb9()

Sprawdzenie statusu autoryzacji

    Zwraca informację, czy użytkownik jest aktualnie zalogowany, wraz z jego podstawowymi danymi.

### Parameters
This endpoint does not need any parameter.

### Return type

[**c53df93dc842bea4ec7b35fe22505eb9_200_response**](../Models/c53df93dc842bea4ec7b35fe22505eb9_200_response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

