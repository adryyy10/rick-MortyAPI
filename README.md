# rick-MortyAPI


This project consists in two parts:

- Consuming data from an external API (Rick&Morty API) 
  - Fetching the characters --> /api/characters
  - Fetching the locations  --> /api/locations
  - Fetching the episodes   --> /api/episodes
  - Fetching one specific character --> /api/character/{id}
  - Fetching one specific location  --> /api/location/{id}
  - Fetching one specific episode   --> /api/episode/{id}
- Creating my own API (Trivia Questionnaire) so that third parties can consume it


The Trivia Questionnaire is implemented in a way that not everyone can check the data, they must have a valid **x-api-token** in the headers, and this **x-api-token** must exist in the admin database to check if it is a valid one, so only the admin of the Trivia API can give access to others, in order to protect the privacy of the data.

Also for the user to not only get the data but modify it (Create, Update, Delete), the user must be **ROLE_SUPER_ADMIN**, if not, it only can Read.
