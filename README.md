# Pizzeria

## Instrukcja lokalnego uruchomienia projektu w środowisku developerskim

1. Zainstaluj Dockera na swoim systemie.

2. Sklonuj repozytorium 
```bash
git clone https://github.com/AdrianMatys/ProjektPizzeria.git
```

3. Przejdź do folderu z projektem
```bash
cd ProjektPizzeria
```

4. Stwórz plik .env i dostosuj jego konfigurację.
```bash
cp .env.example .env
```

5. Zbuduj obrazy Dockera
```bash
make init
```

6. Uruchom projekt
```bash
make dev
```

7. Po zakończeniu procesu uruchamiania projekt będzie dostępny pod adresem [http://localhost](http://localhost).
