# AutoryzacjaApi

All URIs are relative to *http://localhost*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**2d6096a0adbcdcf576717ed3d1f85b6a**](AutoryzacjaApi.md#2d6096a0adbcdcf576717ed3d1f85b6a) | **POST** /api/request-account | Zażądaj utworzenia nowego konta użytkownika |
| [**8a56853624e025573120a09a4c75d468**](AutoryzacjaApi.md#8a56853624e025573120a09a4c75d468) | **POST** /api/register | Tworzenie nowego użytkownika przez Admina/IT |
| [**a3b306d14572d1f4bd6c064b3233e7b8**](AutoryzacjaApi.md#a3b306d14572d1f4bd6c064b3233e7b8) | **POST** /api/login | Logowanie użytkownika |
| [**fe8f3429cd6979b3b4517e186505f9f9**](AutoryzacjaApi.md#fe8f3429cd6979b3b4517e186505f9f9) | **POST** /api/logout | Wylogowanie użytkownika (unieważnienie tokena API) |


<a name="2d6096a0adbcdcf576717ed3d1f85b6a"></a>
# **2d6096a0adbcdcf576717ed3d1f85b6a**
> _8a56853624e025573120a09a4c75d468_201_response 2d6096a0adbcdcf576717ed3d1f85b6a(\_2d6096a0adbcdcf576717ed3d1f85b6a\_request)

Zażądaj utworzenia nowego konta użytkownika

    Umożliwia zalogowanemu użytkownikowi wysłanie prośby o utworzenie nowego konta (np. dla nowego pracownika). Tworzy **nieaktywne** konto i automatycznie generuje zgłoszenie do działu IT z prośbą o jego aktywację.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **\_2d6096a0adbcdcf576717ed3d1f85b6a\_request** | [**_2d6096a0adbcdcf576717ed3d1f85b6a_request**](../Models/_2d6096a0adbcdcf576717ed3d1f85b6a_request.md)|  | |

### Return type

[**_8a56853624e025573120a09a4c75d468_201_response**](../Models/_8a56853624e025573120a09a4c75d468_201_response.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

<a name="8a56853624e025573120a09a4c75d468"></a>
# **8a56853624e025573120a09a4c75d468**
> _8a56853624e025573120a09a4c75d468_201_response 8a56853624e025573120a09a4c75d468(\_8a56853624e025573120a09a4c75d468\_request)

Tworzenie nowego użytkownika przez Admina/IT

    Tworzy nowe konto użytkownika. Dostępne tylko dla uwierzytelnionych użytkowników z rolą &#39;admin&#39; lub &#39;it&#39;. Pozwala na zdefiniowanie roli nowego użytkownika.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **\_8a56853624e025573120a09a4c75d468\_request** | [**_8a56853624e025573120a09a4c75d468_request**](../Models/_8a56853624e025573120a09a4c75d468_request.md)|  | |

### Return type

[**_8a56853624e025573120a09a4c75d468_201_response**](../Models/_8a56853624e025573120a09a4c75d468_201_response.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

<a name="a3b306d14572d1f4bd6c064b3233e7b8"></a>
# **a3b306d14572d1f4bd6c064b3233e7b8**
> a3b306d14572d1f4bd6c064b3233e7b8_200_response a3b306d14572d1f4bd6c064b3233e7b8(a3b306d14572d1f4bd6c064b3233e7b8\_request)

Logowanie użytkownika

    Uwierzytelnia użytkownika na podstawie loginu i hasła, a w odpowiedzi zwraca token dostępowy (Bearer Token) oraz rolę użytkownika. Ten endpoint jest publiczny i nie wymaga autoryzacji.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **a3b306d14572d1f4bd6c064b3233e7b8\_request** | [**a3b306d14572d1f4bd6c064b3233e7b8_request**](../Models/a3b306d14572d1f4bd6c064b3233e7b8_request.md)| Dane logowania użytkownika. | |

### Return type

[**a3b306d14572d1f4bd6c064b3233e7b8_200_response**](../Models/a3b306d14572d1f4bd6c064b3233e7b8_200_response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

<a name="fe8f3429cd6979b3b4517e186505f9f9"></a>
# **fe8f3429cd6979b3b4517e186505f9f9**
> fe8f3429cd6979b3b4517e186505f9f9_200_response fe8f3429cd6979b3b4517e186505f9f9()

Wylogowanie użytkownika (unieważnienie tokena API)

    Unieważnia token dostępowy API (Bearer token), z którym zostało wykonane żądanie. Jest to metoda wylogowania dla klientów API (np. aplikacji frontendowej Vue).

### Parameters
This endpoint does not need any parameter.

### Return type

[**fe8f3429cd6979b3b4517e186505f9f9_200_response**](../Models/fe8f3429cd6979b3b4517e186505f9f9_200_response.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

