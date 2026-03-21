# Documentation for ZGRZYT API

<a name="documentation-for-api-endpoints"></a>
## Documentation for API Endpoints

All URIs are relative to *http://localhost*

| Class | Method | HTTP request | Description |
|------------ | ------------- | ------------- | -------------|
| *AutoryzacjaApi* | [**loginUser**](Apis/AutoryzacjaApi.md#loginUser) | **POST** /api/login | Logowanie użytkownika |
*AutoryzacjaApi* | [**logoutUser**](Apis/AutoryzacjaApi.md#logoutUser) | **POST** /api/logout | Wylogowanie użytkownika (unieważnienie tokena API) |
*AutoryzacjaApi* | [**registerUser**](Apis/AutoryzacjaApi.md#registerUser) | **POST** /api/register | Tworzenie nowego użytkownika przez Admina/IT |
*AutoryzacjaApi* | [**requestAccount**](Apis/AutoryzacjaApi.md#requestAccount) | **POST** /api/request-account | Zażądaj utworzenia nowego konta użytkownika |
| *SesjaApi* | [**checkAuthStatus**](Apis/SesjaApi.md#checkAuthStatus) | **GET** /auth-status | Sprawdzenie statusu autoryzacji |
*SesjaApi* | [**logoutSession**](Apis/SesjaApi.md#logoutSession) | **POST** /logout | Wylogowanie użytkownika (sesja webowa) |
*SesjaApi* | [**resetSession**](Apis/SesjaApi.md#resetSession) | **POST** /reset-session | Resetowanie sesji |
| *UytkownicyApi* | [**activateUser**](Apis/UytkownicyApi.md#activateUser) | **POST** /api/users/{user}/activate | Aktywacja konta użytkownika |
*UytkownicyApi* | [**banUser**](Apis/UytkownicyApi.md#banUser) | **POST** /api/users/{user}/ban | Banowanie konta użytkownika |
*UytkownicyApi* | [**getAuthenticatedUser**](Apis/UytkownicyApi.md#getAuthenticatedUser) | **GET** /api/user | Pobierz dane zalogowanego użytkownika |
*UytkownicyApi* | [**unbanUser**](Apis/UytkownicyApi.md#unbanUser) | **POST** /api/users/{user}/unban | Odblokowanie (unban) konta użytkownika |
| *WiadomociApi* | [**createMessage**](Apis/WiadomociApi.md#createMessage) | **POST** /api/tickets/{ticket}/messages | Dodaje nową wiadomość do zgłoszenia |
| *ZgoszeniaApi* | [**createTicket**](Apis/ZgoszeniaApi.md#createTicket) | **POST** /api/tickets | Zapisuje nowe zgłoszenie |
*ZgoszeniaApi* | [**deleteTicket**](Apis/ZgoszeniaApi.md#deleteTicket) | **DELETE** /api/tickets/{ticket} | Usuwa określone zgłoszenie |
*ZgoszeniaApi* | [**listTickets**](Apis/ZgoszeniaApi.md#listTickets) | **GET** /api/tickets | Wyświetla listę zgłoszeń |
*ZgoszeniaApi* | [**showTicket**](Apis/ZgoszeniaApi.md#showTicket) | **GET** /api/tickets/{ticket} | Wyświetla określone zgłoszenie |
*ZgoszeniaApi* | [**updateTicket**](Apis/ZgoszeniaApi.md#updateTicket) | **PUT** /api/tickets/{ticket} | Aktualizuje określone zgłoszenie |


<a name="documentation-for-models"></a>
## Documentation for Models

 - [Message](./Models/Message.md)
 - [MessageFull](./Models/MessageFull.md)
 - [Ticket](./Models/Ticket.md)
 - [TicketFull](./Models/TicketFull.md)
 - [User](./Models/User.md)
 - [activateUser_200_response](./Models/activateUser_200_response.md)
 - [banUser_200_response](./Models/banUser_200_response.md)
 - [checkAuthStatus_200_response](./Models/checkAuthStatus_200_response.md)
 - [createMessage_request](./Models/createMessage_request.md)
 - [createTicket_request](./Models/createTicket_request.md)
 - [loginUser_200_response](./Models/loginUser_200_response.md)
 - [loginUser_request](./Models/loginUser_request.md)
 - [logoutUser_200_response](./Models/logoutUser_200_response.md)
 - [registerUser_201_response](./Models/registerUser_201_response.md)
 - [registerUser_request](./Models/registerUser_request.md)
 - [requestAccount_request](./Models/requestAccount_request.md)
 - [unbanUser_200_response](./Models/unbanUser_200_response.md)
 - [unbanUser_request](./Models/unbanUser_request.md)
 - [updateTicket_request](./Models/updateTicket_request.md)


<a name="documentation-for-authorization"></a>
## Documentation for Authorization

<a name="bearerAuth"></a>
### bearerAuth

- **Type**: HTTP Bearer Token authentication (JWT)

