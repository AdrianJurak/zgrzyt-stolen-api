# UytkownicyApi

All URIs are relative to *http://localhost*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**activateUser**](UytkownicyApi.md#activateUser) | **POST** /api/users/{user}/activate | Aktywacja konta użytkownika |
| [**banUser**](UytkownicyApi.md#banUser) | **POST** /api/users/{user}/ban | Banowanie konta użytkownika |
| [**getAuthenticatedUser**](UytkownicyApi.md#getAuthenticatedUser) | **GET** /api/user | Pobierz dane zalogowanego użytkownika |
| [**unbanUser**](UytkownicyApi.md#unbanUser) | **POST** /api/users/{user}/unban | Odblokowanie (unban) konta użytkownika |


<a name="activateUser"></a>
# **activateUser**
> activateUser_200_response activateUser(user)

Aktywacja konta użytkownika

    Aktywuje nieaktywne konto użytkownika. Dostępne tylko dla ról &#39;admin&#39; lub &#39;it&#39;.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **user** | **Integer**| ID użytkownika do aktywacji | [default to null] |

### Return type

[**activateUser_200_response**](../Models/activateUser_200_response.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

<a name="banUser"></a>
# **banUser**
> banUser_200_response banUser(user)

Banowanie konta użytkownika

    Banuje konto użytkownika. Dostępne tylko dla ról &#39;admin&#39; lub &#39;it&#39;.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **user** | **Integer**| ID użytkownika do zbanowania | [default to null] |

### Return type

[**banUser_200_response**](../Models/banUser_200_response.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

<a name="getAuthenticatedUser"></a>
# **getAuthenticatedUser**
> User getAuthenticatedUser()

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

<a name="unbanUser"></a>
# **unbanUser**
> unbanUser_200_response unbanUser(user, unbanUser\_request)

Odblokowanie (unban) konta użytkownika

    Odblokowuje zbanowane konto użytkownika. Dostępne tylko dla ról &#39;admin&#39; lub &#39;it&#39;. Wymaga potwierdzenia hasłem osoby wykonującej akcję.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **user** | **Integer**| ID użytkownika do odbanowania | [default to null] |
| **unbanUser\_request** | [**unbanUser_request**](../Models/unbanUser_request.md)| Hasło użytkownika wykonującego operację w celu potwierdzenia. | |

### Return type

[**unbanUser_200_response**](../Models/unbanUser_200_response.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

