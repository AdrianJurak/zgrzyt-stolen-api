# ZgoszeniaApi

All URIs are relative to *http://localhost*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**createTicket**](ZgoszeniaApi.md#createTicket) | **POST** /api/tickets | Zapisuje nowe zgłoszenie |
| [**deleteTicket**](ZgoszeniaApi.md#deleteTicket) | **DELETE** /api/tickets/{ticket} | Usuwa określone zgłoszenie |
| [**listTickets**](ZgoszeniaApi.md#listTickets) | **GET** /api/tickets | Wyświetla listę zgłoszeń |
| [**showTicket**](ZgoszeniaApi.md#showTicket) | **GET** /api/tickets/{ticket} | Wyświetla określone zgłoszenie |
| [**updateTicket**](ZgoszeniaApi.md#updateTicket) | **PUT** /api/tickets/{ticket} | Aktualizuje określone zgłoszenie |


<a name="createTicket"></a>
# **createTicket**
> Ticket createTicket(createTicket\_request)

Zapisuje nowe zgłoszenie

    Tworzy nowe zgłoszenie w imieniu zalogowanego użytkownika.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **createTicket\_request** | [**createTicket_request**](../Models/createTicket_request.md)|  | |

### Return type

[**Ticket**](../Models/Ticket.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

<a name="deleteTicket"></a>
# **deleteTicket**
> deleteTicket(ticket)

Usuwa określone zgłoszenie

    Trwale usuwa zgłoszenie z systemu. Dostępne w zależności od zdefiniowanej polityki autoryzacji (prawdopodobnie dla admina).

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **ticket** | **Integer**| ID zgłoszenia | [default to null] |

### Return type

null (empty response body)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

<a name="listTickets"></a>
# **listTickets**
> List listTickets()

Wyświetla listę zgłoszeń

    Zwraca listę zgłoszeń. Użytkownicy z rolą &#39;user&#39; widzą tylko swoje zgłoszenia. Użytkownicy &#39;it&#39; i &#39;admin&#39; widzą wszystkie.

### Parameters
This endpoint does not need any parameter.

### Return type

[**List**](../Models/TicketFull.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

<a name="showTicket"></a>
# **showTicket**
> TicketFull showTicket(ticket)

Wyświetla określone zgłoszenie

    Pobiera szczegółowe informacje o pojedynczym zgłoszeniu, w tym dane zgłaszającego, przypisanego pracownika IT oraz historię wiadomości.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **ticket** | **Integer**| ID zgłoszenia | [default to null] |

### Return type

[**TicketFull**](../Models/TicketFull.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

<a name="updateTicket"></a>
# **updateTicket**
> Ticket updateTicket(ticket, updateTicket\_request)

Aktualizuje określone zgłoszenie

    Aktualizuje status, priorytet lub przypisanie pracownika IT do zgłoszenia. Dostępne tylko dla ról &#39;it&#39; i &#39;admin&#39;.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **ticket** | **Integer**| ID zgłoszenia | [default to null] |
| **updateTicket\_request** | [**updateTicket_request**](../Models/updateTicket_request.md)| Pola do zaktualizowania. | [optional] |

### Return type

[**Ticket**](../Models/Ticket.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

