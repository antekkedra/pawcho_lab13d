# Laboratorium 13d

## 1. Architektura

cztery kontenery:

- **nginx** – serwer HTTP, wystawiony na port 4001
- **php** – PHP-FPM obsługujący pliki PHP
- **mysql** – serwer bazy danych MySQL
- **phpmyadmin** – narzędzie administracyjne dostępne na porcie 6001

dwie sieci Docker:

- **frontend** – umożliwia dostęp z zewnątrz (nginx, phpMyAdmin)
- **backend** – sieć wewnętrzna do komunikacji PHP-MySQL

Kontenery PHP i MySQL są podłączone do sieci backend,
nginx oraz phpMyAdmin do backend i frontend.

Podłączenie phpMyAdmin do sieci frontend jest wymagane, aby umożliwić dostęp do interfejsu z poziomu przeglądarki użytkownika. 
Podłączeniedo sieci backend jest konieczne, ponieważ phpMyAdmin musi komunikować się z serwerem bazy danych MySQL, który działa wyłącznie w sieci backend

---

## 2. Docker secrets

Dane do bazy danych (hasła, użytkownik) zostały
skonfigurowane jako Docker secrets:

- `db_root_password`
- `db_user`
- `db_password`

Sekrety są montowane w kontenerach w katalogu `/run/secrets/`
i nie są przechowywane bezpośrednio w pliku docker-compose.yaml
ani w kodzie aplikacji PHP.

---

## 3. Użyte polecenia

### Zatrzymanie i usunięcie poprzednich kontenerów oraz wolumenów

```bash
docker compose down -v
```

### Budowa obrazów

```bash
docker compose build
```

<img width="998" height="534" alt="image" src="https://github.com/user-attachments/assets/1b9eb238-d7ab-4933-9550-f01bcc1d425a" />

### Uruchomienie

```bash
docker compose up -d
```

<img width="1002" height="267" alt="image" src="https://github.com/user-attachments/assets/3c73ec40-3505-4822-af4c-fbef2e1475e2" />

### Sprawdzenie statusu kontenerów

```bash
docker compose ps
```

<img width="1578" height="188" alt="image" src="https://github.com/user-attachments/assets/9e357773-5931-46f3-a9fa-68f6d9e5061b" />

### Lista sieci Docker

```bash
docker network ls
```

<img width="498" height="332" alt="image" src="https://github.com/user-attachments/assets/f94c4fa9-2902-4b6b-8d17-4448f9bc987e" />

## 4. Weryfikacja poprawności działania

### 4.1. Test działania PHP

Po wejściu w przeglądarce na adres:

http://localhost:4001

wyświetlana jest strona PHP (index.php), która wykonuje próbę
połączenia z bazą danych MySQL.

- W fazie uruchamiania możliwe jest chwilowe wyświetlenie komunikatu:
  „Błąd połączenia z DB”
- Po pełnym uruchomieniu MySQL wyświetlany jest komunikat:
  „Połączenie z bazą danych OK”

Potwierdza to poprawną integrację Nginx, PHP-FPM, MySQL.

### 4.2. phpMyAdmin i inicjalizacja bazy danych

phpMyAdmin dostępny jest pod adresem:

http://localhost:6001

- Logowanie możliwe jest przy użyciu danych zdefiniowanych w secrets
- Serwer bazy danych jest ustawiony automatycznie (`mysql`)
- Możliwe jest utworzenie testowej bazy danych oraz tabel

---
