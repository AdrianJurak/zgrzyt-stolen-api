# AutoryzacjaApi

All URIs are relative to *http://localhost*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**loginUser**](AutoryzacjaApi.md#loginUser) | **POST** /api/login | Logowanie użytkownika |
| [**logoutUser**](AutoryzacjaApi.md#logoutUser) | **POST** /api/logout | Wylogowanie użytkownika (unieważnienie tokena API) |
| [**registerUser**](AutoryzacjaApi.md#registerUser) | **POST** /api/register | Tworzenie nowego użytkownika przez Admina/IT |
| [**requestAccount**](AutoryzacjaApi.md#requestAccount) | **POST** /api/request-account | Zażądaj utworzenia nowego konta użytkownika |


<a name="loginUser"></a>
# **loginUser**
> loginUser_200_response loginUser(loginUser\_request)

Logowanie użytkownika

    Uwierzytelnia użytkownika na podstawie loginu i hasła, a w odpowiedzi zwraca token dostępowy (Bearer Token) oraz rolę użytkownika. Ten endpoint jest publiczny i nie wymaga autoryzacji.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **loginUser\_request** | [**loginUser_request**](../Models/loginUser_request.md)| Dane logowania użytkownika. | |

### Return type

[**loginUser_200_response**](../Models/loginUser_200_response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

<a name="logoutUser"></a>
# **logoutUser**
> logoutUser_200_response logoutUser()

Wylogowanie użytkownika (unieważnienie tokena API)

    Unieważnia token dostępowy API (Bearer token), z którym zostało wykonane żądanie. Jest to metoda wylogowania dla klientów API (np. aplikacji frontendowej Vue).

### Parameters
This endpoint does not need any parameter.

### Return type

[**logoutUser_200_response**](../Models/logoutUser_200_response.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

<a name="registerUser"></a>
# **registerUser**
> registerUser_201_response registerUser(registerUser\_request)

Tworzenie nowego użytkownika przez Admina/IT

    Tworzy nowe konto użytkownika. Dostępne tylko dla uwierzytelnionych użytkowników z rolą &#39;admin&#39; lub &#39;it&#39;. Pozwala na zdefiniowanie roli nowego użytkownika.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **registerUser\_request** | [**registerUser_request**](../Models/registerUser_request.md)|  | |

### Return type

[**registerUser_201_response**](../Models/registerUser_201_response.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

<a name="requestAccount"></a>
# **requestAccount**
> registerUser_201_response requestAccount(requestAccount\_request)

Zażądaj utworzenia nowego konta użytkownika

    Umożliwia zalogowanemu użytkownikowi wysłanie prośby o utworzenie nowego konta (np. dla nowego pracownika). Tworzy **nieaktywne** konto i automatycznie generuje zgłoszenie do działu IT z prośbą o jego aktywację.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **requestAccount\_request** | [**requestAccount_request**](../Models/requestAccount_request.md)|  | |

### Return type

[**registerUser_201_response**](../Models/registerUser_201_response.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

