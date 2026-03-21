# ZgoszeniaApi

All URIs are relative to *http://localhost*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**0082053c3590628e674a11ec0d1466e6**](ZgoszeniaApi.md#0082053c3590628e674a11ec0d1466e6) | **GET** /api/tickets | Wyświetla listę zgłoszeń |
| [**32c4911fd210af747ca91977ce7bde92**](ZgoszeniaApi.md#32c4911fd210af747ca91977ce7bde92) | **PUT** /api/tickets/{ticket} | Aktualizuje określone zgłoszenie |
| [**653dfec809dc77c94527ffba9c1a6a42**](ZgoszeniaApi.md#653dfec809dc77c94527ffba9c1a6a42) | **GET** /api/tickets/{ticket} | Wyświetla określone zgłoszenie |
| [**93882881cca9046d8c6ddbbab7309b4b**](ZgoszeniaApi.md#93882881cca9046d8c6ddbbab7309b4b) | **POST** /api/tickets | Zapisuje nowe zgłoszenie |
| [**bb7be4d54b9a05e0df84e30a5c97f18a**](ZgoszeniaApi.md#bb7be4d54b9a05e0df84e30a5c97f18a) | **DELETE** /api/tickets/{ticket} | Usuwa określone zgłoszenie |


<a name="0082053c3590628e674a11ec0d1466e6"></a>
# **0082053c3590628e674a11ec0d1466e6**
> List 0082053c3590628e674a11ec0d1466e6()

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

<a name="32c4911fd210af747ca91977ce7bde92"></a>
# **32c4911fd210af747ca91977ce7bde92**
> Ticket 32c4911fd210af747ca91977ce7bde92(ticket, \_32c4911fd210af747ca91977ce7bde92\_request)

Aktualizuje określone zgłoszenie

    Aktualizuje status, priorytet lub przypisanie pracownika IT do zgłoszenia. Dostępne tylko dla ról &#39;it&#39; i &#39;admin&#39;.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **ticket** | **Integer**| ID zgłoszenia | [default to null] |
| **\_32c4911fd210af747ca91977ce7bde92\_request** | [**_32c4911fd210af747ca91977ce7bde92_request**](../Models/_32c4911fd210af747ca91977ce7bde92_request.md)| Pola do zaktualizowania. | [optional] |

### Return type

[**Ticket**](../Models/Ticket.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

<a name="653dfec809dc77c94527ffba9c1a6a42"></a>
# **653dfec809dc77c94527ffba9c1a6a42**
> TicketFull 653dfec809dc77c94527ffba9c1a6a42(ticket)

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

<a name="93882881cca9046d8c6ddbbab7309b4b"></a>
# **93882881cca9046d8c6ddbbab7309b4b**
> Ticket 93882881cca9046d8c6ddbbab7309b4b(\_93882881cca9046d8c6ddbbab7309b4b\_request)

Zapisuje nowe zgłoszenie

    Tworzy nowe zgłoszenie w imieniu zalogowanego użytkownika.

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **\_93882881cca9046d8c6ddbbab7309b4b\_request** | [**_93882881cca9046d8c6ddbbab7309b4b_request**](../Models/_93882881cca9046d8c6ddbbab7309b4b_request.md)|  | |

### Return type

[**Ticket**](../Models/Ticket.md)

### Authorization

[bearerAuth](../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

<a name="bb7be4d54b9a05e0df84e30a5c97f18a"></a>
# **bb7be4d54b9a05e0df84e30a5c97f18a**
> bb7be4d54b9a05e0df84e30a5c97f18a(ticket)

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

