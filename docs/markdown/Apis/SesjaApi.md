# SesjaApi

All URIs are relative to *http://localhost*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**checkAuthStatus**](SesjaApi.md#checkAuthStatus) | **GET** /auth-status | Sprawdzenie statusu autoryzacji |
| [**logoutSession**](SesjaApi.md#logoutSession) | **POST** /logout | Wylogowanie użytkownika (sesja webowa) |
| [**resetSession**](SesjaApi.md#resetSession) | **POST** /reset-session | Resetowanie sesji |


<a name="checkAuthStatus"></a>
# **checkAuthStatus**
> checkAuthStatus_200_response checkAuthStatus()

Sprawdzenie statusu autoryzacji

    Zwraca informację, czy użytkownik jest aktualnie zalogowany, wraz z jego podstawowymi danymi.

### Parameters
This endpoint does not need any parameter.

### Return type

[**checkAuthStatus_200_response**](../Models/checkAuthStatus_200_response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

<a name="logoutSession"></a>
# **logoutSession**
> logoutSession()

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

<a name="resetSession"></a>
# **resetSession**
> resetSession()

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

