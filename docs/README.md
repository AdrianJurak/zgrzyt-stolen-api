# Documentation for ZGRZYT API

<a name="documentation-for-api-endpoints"></a>
## Documentation for API Endpoints

All URIs are relative to *http://localhost*

| Class | Method | HTTP request | Description |
|------------ | ------------- | ------------- | -------------|
| *AutoryzacjaApi* | [**2d6096a0adbcdcf576717ed3d1f85b6a**](Apis/AutoryzacjaApi.md#2d6096a0adbcdcf576717ed3d1f85b6a) | **POST** /api/request-account | Zażądaj utworzenia nowego konta użytkownika |
*AutoryzacjaApi* | [**8a56853624e025573120a09a4c75d468**](Apis/AutoryzacjaApi.md#8a56853624e025573120a09a4c75d468) | **POST** /api/register | Tworzenie nowego użytkownika przez Admina/IT |
*AutoryzacjaApi* | [**a3b306d14572d1f4bd6c064b3233e7b8**](Apis/AutoryzacjaApi.md#a3b306d14572d1f4bd6c064b3233e7b8) | **POST** /api/login | Logowanie użytkownika |
*AutoryzacjaApi* | [**fe8f3429cd6979b3b4517e186505f9f9**](Apis/AutoryzacjaApi.md#fe8f3429cd6979b3b4517e186505f9f9) | **POST** /api/logout | Wylogowanie użytkownika (unieważnienie tokena API) |
| *SesjaApi* | [**47fe20490afc15b35cdb187abd89d83b**](Apis/SesjaApi.md#47fe20490afc15b35cdb187abd89d83b) | **POST** /logout | Wylogowanie użytkownika (sesja webowa) |
*SesjaApi* | [**679fb8cdc013f16541de7cdff8b091b5**](Apis/SesjaApi.md#679fb8cdc013f16541de7cdff8b091b5) | **POST** /reset-session | Resetowanie sesji |
*SesjaApi* | [**c53df93dc842bea4ec7b35fe22505eb9**](Apis/SesjaApi.md#c53df93dc842bea4ec7b35fe22505eb9) | **GET** /auth-status | Sprawdzenie statusu autoryzacji |
| *UytkownicyApi* | [**8829fd3de941175801836d9958447464**](Apis/UytkownicyApi.md#8829fd3de941175801836d9958447464) | **POST** /api/admin/users/{user}/activate | Aktywacja konta użytkownika |
*UytkownicyApi* | [**a522c0230639ee7c7f1204582b59b41a**](Apis/UytkownicyApi.md#a522c0230639ee7c7f1204582b59b41a) | **GET** /api/user | Pobierz dane zalogowanego użytkownika |
| *WiadomociApi* | [**68d601f01b8a354302c0fda10d5a6c27**](Apis/WiadomociApi.md#68d601f01b8a354302c0fda10d5a6c27) | **POST** /api/tickets/{ticket}/messages | Dodaje nową wiadomość do zgłoszenia |
| *ZgoszeniaApi* | [**0082053c3590628e674a11ec0d1466e6**](Apis/ZgoszeniaApi.md#0082053c3590628e674a11ec0d1466e6) | **GET** /api/tickets | Wyświetla listę zgłoszeń |
*ZgoszeniaApi* | [**32c4911fd210af747ca91977ce7bde92**](Apis/ZgoszeniaApi.md#32c4911fd210af747ca91977ce7bde92) | **PUT** /api/tickets/{ticket} | Aktualizuje określone zgłoszenie |
*ZgoszeniaApi* | [**653dfec809dc77c94527ffba9c1a6a42**](Apis/ZgoszeniaApi.md#653dfec809dc77c94527ffba9c1a6a42) | **GET** /api/tickets/{ticket} | Wyświetla określone zgłoszenie |
*ZgoszeniaApi* | [**93882881cca9046d8c6ddbbab7309b4b**](Apis/ZgoszeniaApi.md#93882881cca9046d8c6ddbbab7309b4b) | **POST** /api/tickets | Zapisuje nowe zgłoszenie |
*ZgoszeniaApi* | [**bb7be4d54b9a05e0df84e30a5c97f18a**](Apis/ZgoszeniaApi.md#bb7be4d54b9a05e0df84e30a5c97f18a) | **DELETE** /api/tickets/{ticket} | Usuwa określone zgłoszenie |


<a name="documentation-for-models"></a>
## Documentation for Models

 - [Message](./Models/Message.md)
 - [MessageFull](./Models/MessageFull.md)
 - [Ticket](./Models/Ticket.md)
 - [TicketFull](./Models/TicketFull.md)
 - [User](./Models/User.md)
 - [_2d6096a0adbcdcf576717ed3d1f85b6a_request](./Models/_2d6096a0adbcdcf576717ed3d1f85b6a_request.md)
 - [_32c4911fd210af747ca91977ce7bde92_request](./Models/_32c4911fd210af747ca91977ce7bde92_request.md)
 - [_68d601f01b8a354302c0fda10d5a6c27_request](./Models/_68d601f01b8a354302c0fda10d5a6c27_request.md)
 - [_8829fd3de941175801836d9958447464_200_response](./Models/_8829fd3de941175801836d9958447464_200_response.md)
 - [_8a56853624e025573120a09a4c75d468_201_response](./Models/_8a56853624e025573120a09a4c75d468_201_response.md)
 - [_8a56853624e025573120a09a4c75d468_request](./Models/_8a56853624e025573120a09a4c75d468_request.md)
 - [_93882881cca9046d8c6ddbbab7309b4b_request](./Models/_93882881cca9046d8c6ddbbab7309b4b_request.md)
 - [a3b306d14572d1f4bd6c064b3233e7b8_200_response](./Models/a3b306d14572d1f4bd6c064b3233e7b8_200_response.md)
 - [a3b306d14572d1f4bd6c064b3233e7b8_request](./Models/a3b306d14572d1f4bd6c064b3233e7b8_request.md)
 - [c53df93dc842bea4ec7b35fe22505eb9_200_response](./Models/c53df93dc842bea4ec7b35fe22505eb9_200_response.md)
 - [fe8f3429cd6979b3b4517e186505f9f9_200_response](./Models/fe8f3429cd6979b3b4517e186505f9f9_200_response.md)


<a name="documentation-for-authorization"></a>
## Documentation for Authorization

<a name="bearerAuth"></a>
### bearerAuth

- **Type**: HTTP Bearer Token authentication (JWT)

