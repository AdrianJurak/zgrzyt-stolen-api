# WiadomociApi

All URIs are relative to *http://localhost*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**68d601f01b8a354302c0fda10d5a6c27**](WiadomociApi.md#68d601f01b8a354302c0fda10d5a6c27) | **POST** /api/tickets/{ticket}/messages | Dodaje nową wiadomość do zgłoszenia |


<a name="68d601f01b8a354302c0fda10d5a6c27"></a>
# **68d601f01b8a354302c0fda10d5a6c27**
> MessageFull 68d601f01b8a354302c0fda10d5a6c27(ticket, \_68d601f01b8a354302c0fda10d5a6c27\_request)

Dodaje nową wiadomość do zgłoszenia

    Umożliwia zalogowanemu użytkownikowi dodanie nowej wiadomości (komentarza) do istniejącego zgłoszenia. Użytkownik musi mieć uprawnienia do interakcji ze zgłoszeniem.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **ticket** | **Integer**| ID zgłoszenia | [default to null] |
| **\_68d601f01b8a354302c0fda10d5a6c27\_request** | [**_68d601f01b8a354302c0fda10d5a6c27_request**](../Models/_68d601f01b8a354302c0fda10d5a6c27_request.md)| Treść nowej wiadomości. | |

### Return type

[**MessageFull**](../Models/MessageFull.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

