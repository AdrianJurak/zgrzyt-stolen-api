# WiadomociApi

All URIs are relative to *http://localhost*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**createMessage**](WiadomociApi.md#createMessage) | **POST** /api/tickets/{ticket}/messages | Dodaje nową wiadomość do zgłoszenia |


<a name="createMessage"></a>
# **createMessage**
> MessageFull createMessage(ticket, createMessage\_request)

Dodaje nową wiadomość do zgłoszenia

    Umożliwia zalogowanemu użytkownikowi dodanie nowej wiadomości (komentarza) do istniejącego zgłoszenia. Użytkownik musi mieć uprawnienia do interakcji ze zgłoszeniem.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **ticket** | **Integer**| ID zgłoszenia | [default to null] |
| **createMessage\_request** | [**createMessage_request**](../Models/createMessage_request.md)| Treść nowej wiadomości. | |

### Return type

[**MessageFull**](../Models/MessageFull.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

